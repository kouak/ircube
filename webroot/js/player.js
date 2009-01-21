/* Objet */
function Player(id) {
	this.streamUrl = "http://stream4.gshebergement.net:8800";
	this.playlistUrl = "http://ircube.org/misc/zikosport.pls";
	this.titleUrl = "/misc/zostitle.php";
	this.title = "<strong>Actuellement sur Zikosport :</strong> Chargement en cours ...";
  	this.os = "" ;
  	this.browser = "" ;
  	this.plugins = new Array() ;
	if (id)	{
		this.id = id ;
	} else {
		this.id = null ;
	}
}

/* Détection du système d'exploitation */
Player.prototype.detectOS = function() {
  this.os ="Unknown";
  if (navigator.appVersion.indexOf("Win")!=-1) this.os ="Windows";
  if (navigator.appVersion.indexOf("Mac")!=-1) this.os ="MacOS";
  if (navigator.appVersion.indexOf("X11")!=-1) this.os ="UNIX";
  if (navigator.appVersion.indexOf("Linux")!=-1) this.os ="Linux";
}

/* Détection du navigateur */
Player.prototype.detectBrowser = function() {
	var agt=navigator.userAgent.toLowerCase();
	if (agt.indexOf("msie") != -1) this.browser = "ie" ;
	else if (navigator.appName.indexOf("Netscape") != -1) this.browser = "netscape" ;
}

/* Détection des plugins */
function detectIE(ClassID,name) { result = false; document.write('<SCRIPT LANGUAGE=VBScript>\n on error resume next \n result = IsObject(CreateObject("' + ClassID + '"))</SCRIPT>\n'); if (result) return name+','; else return ''; }
function detectNS(ClassID,name) { n = ""; if (nse.indexOf(ClassID) != -1) if (navigator.mimeTypes[ClassID].enabledPlugin != null) n = name+","; return n; }
Player.prototype.setPlugin = function() {
	if (this.browser == "ie" && this.os == "Windows") {
		this.plugins = detectIE("Adobe.SVGCtl","SVG Viewer") + detectIE("SWCtl.SWCtl.1","Shockwave Director") + detectIE("ShockwaveFlash.ShockwaveFlash.1","Shockwave Flash") + detectIE("rmocx.RealPlayer G2 Control.1","RealPlayer") + detectIE("QuickTimeCheckObject.QuickTimeCheck.1","QuickTime") + detectIE("MediaPlayer.MediaPlayer.1","Windows Media Player") + detectIE("PDF.PdfCtrl.5","Acrobat Reader"); }
	if (this.browser == "netscape" || this.os != "Windows" ) {
		nse = "";
		for (var i=0;i<navigator.mimeTypes.length;i++) nse += navigator.mimeTypes[i].type.toLowerCase();
		this.plugins = detectNS("image/svg-xml","SVG Viewer") + detectNS("application/x-director","Shockwave Director") + detectNS("application/x-shockwave-flash","Shockwave Flash") + detectNS("audio/x-pn-realaudio-plugin","RealPlayer") + detectNS("video/quicktime","QuickTime") + detectNS("application/x-mplayer2","Windows Media Player") + detectNS("application/pdf","Acrobat Reader");
	}
	this.plugins += navigator.javaEnabled() ? "Java," : "";
	if (this.plugins.length > 0) this.plugins = this.plugins.substring(0,this.plugins.length-1);

    /* Sélection du plugin le plus approprié */
	if (this.plugins.indexOf("Windows Media Player")) {
		this.pluginName = "Windows Media Player" ;
	} else if (this.plugins.indexOf("Quicktime")) {
		this.pluginName = "Quicktime" ;
	/*
	} else if (this.plugins.indexOf("Realplayer")) {
		this.pluginName = "Realplayer" ;*/
	} else {
		this.pluginName = "None" ;
	}
}

/* Initialisation du player */
Player.prototype.init = function() {
	switch (this.pluginName) {
		case "Windows Media Player" : {
			if (this.browser == "ie") {
				this.htmlCode = '<OBJECT style="display:none;" id="object_player" name="object_player" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" width="0" heigh="0" <param name="uiMode" value="none"><param name="autoStart" value="true"><param name="showcontrols" value="false"><param name="URL" value="'+this.streamUrl+'"></OBJECT>';
			} else {
				this.htmlCode = '<embed type="video/x-ms-asf-plugin" pluginspage="http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/" src="'+this.streamUrl+'" name="embedded_player" id="embedded_player" autostart="1" showcontrols="0" animationatstart="0" transparentatstart="1" AllowChangeDisplaySize="1" enableContextMenu="1" ShowStatusBar="1" height="0" width="0">';
			}
			break ;
		}
        case "Quicktime" : {
			if (this.browser == "ie") {
				this.htmlCode = '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="0" height="0" codebase="http://www.apple.com/qtactivex/qtplugin.cab"><param name="src" value="'+this.playlistUrl+'"><param name="autoplay" value="true"><param name="controller" value="true"></object>';
			} else {
				this.htmlCode = '<embed src="'+this.playlistUrl+'" autoplay="true" controller="false" type="audio/mpeg" height="0" width="0"/>';
			}
			break ;
		}
        /*case "Realplayer" : {
			break;
		}*/
		case "None" : {
			break;
		}
	}
	$(this.id).style.display = "inline";
	return true ;
}

/* Ecriture du plugin dans la div */
Player.prototype.writePlugin = function() {
	if (!this.id) {
		document.write("<div id='zosplayer'><div id='player'></div></div>");
		this.id = "zosplayer" ;
	} else {
		new Insertion.Bottom(this.id,"<div id='player'></div>");
	}
}

/* Ecriture du controller personnalisé */
Player.prototype.writeControl = function() {
	new Insertion.Bottom(this.id, "<div id='control'></div>");
}

/* Ecriture de la zone de titrage */
Player.prototype.writeTitle = function() {
	new Insertion.Bottom(this.id, "<div id='title'><div id='title_text'>Chargement en cours...</div></div>");
}

/* Lance la lecture */
Player.prototype.play = function() {
	switch (this.pluginName) {
		case "Windows Media Player" : {
			if (this.browser != "ie") {
				$("player").innerHTML =  this.htmlCode ;
			} else {
				if (!$("object_player")) {
                	$("player").innerHTML =  this.htmlCode ;
				} else {
					$("object_player").controls.play() ;
				}
			}
			break;
		}
		default : {
			$("player").innerHTML =  this.htmlCode ;
			break;
		}
	}
	if (this.pluginName != "None") {
		$("control").innerHTML = "<a href='#' onclick='javascript:Player.stop();'><img src='/themes/normal/images/pause.gif' /></a>" ;
	} else {
		$("control").innerHTML = "<a href='"+this.playlistUrl+"'><img src='/themes/normal/images/play.gif' /></a>" ;
	}
	$("title_text").innerHTML = "Chargement en cours..." ;
}

/* Arrête la lecture (vide la div) */
Player.prototype.stop = function() {
	switch (this.pluginName) {
		case "Windows Media Player" : {
			if (this.browser != "ie") {
				$("player").innerHTML =  "" ;
			} else {
				document.getElementById("object_player").controls.stop() ;
			}
			break;
		}
		default : {
			$("player").innerHTML =  "" ;
			break;
		}
	}
	if (this.pluginName != "None") {
		$("control").innerHTML = "<a href='#' onclick='javascript:Player.play();'><img src='/themes/normal/images/play.gif' /></a>" ;
	}
	$("title_text").innerHTML = "Pause ..." ;
}

/* Lance la boucle de récupération du titrage */
Player.prototype.echoTitlesLoop = function() {
		$("title_text").innerHTML = Player.title ;
		setTimeout("Player.echoTitlesLoop();",7000);
}

/* Boucle de récupération du titrage */
Player.prototype.updateTitlesLoop = function() {
    new Ajax.Request(
		this.titleUrl,
        { asynchronous:true,
          method:'get',
          evalScripts:true,
          onComplete:function(request){
          		Player.title = request.responseText.split('\n');
          		setTimeout("Player.updateTitlesLoop();",8000);
          }
		}
	);
}