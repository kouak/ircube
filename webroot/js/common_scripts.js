// Gestion du menu principal dynamique
var menu = {
	'ul#mainmenu li.submenu': function(el) {
		el.onclick = function() {
			var id;
			if (this.id.length != 0)
			{ /* On a un click sur un item a sous-menu */
				id = this.id.charAt(this.id.length - 1);
				var elem = null;
				for (i=1;(elem = document.getElementById('subitem'+i));i++) /* first is : subitem1 */
				{
					if((id * 1) == i) /* On rend le bon visible */
					{
						elem.className = elem.className + " visible";
					}
					else
					{
						/* On enleve la classe visible sur les autres*/
						var s = elem.className.split(' ');
						elem.className = "";
						for(k=0;k<s.length;k++)
						{
							if(s[k] == "visible")
							{
								continue;
							}
							elem.className = elem.className + " " + s[k];
						}
					}
				}
			}
			/* Ajout classe clicked sur li */
			for (i=0;this.parentNode.childNodes[i];i++)
			{
				var j = id ? id : 0;
				if(this.parentNode.childNodes[i].nodeName == "LI")
				{
					if(this.parentNode.childNodes[i].id == "submenu"+j) /* On vient de clicker sur ce LI */
					{
						this.parentNode.childNodes[i].className = this.parentNode.childNodes[i].className + " clicked";
					}
					else
					{
						var s = this.parentNode.childNodes[i].className.split(' ');
						this.parentNode.childNodes[i].className = "";
						for(k=0;k<s.length;k++)
						{
								if(s[k] == "clicked")
								{
									continue;
								}
								this.parentNode.childNodes[i].className = this.parentNode.childNodes[i].className + " " + s[k];
						}
					}
				}
			}
			
		}
	},
}

Behaviour.register(menu);

function montre(id) {
	if (document.getElementById) {
		  document.getElementById(id).style.visibility="visible";
	} else if (document.all) {
		  document.all[id].style.visibility="visible";
	} else if (document.layers) {
		  document.layers[id].visibility="visible";
	} 
} 
		
function cache(id) {
	if (document.getElementById) {
		  document.getElementById(id).style.visibility="hidden";
	} else if (document.all) {
		  document.all[id].style.visibility="hidden";
	} else if (document.layers) {
		  document.layers[id].visibility="hidden";
	} 
}

function refresh_menu(id,nb) {
	for (var i=1; i<=nb;i++) {
		if ( i != id ) { cache("menu"+i) ; }
		else { 
			if ( id != 0 ) { 
				montre("menu"+i) ; 
			} 
		}
	}
}

function popup(param, width,height)
{
x = (1024 - width)/2, y = (768 - height)/2;
if (screen) {
	y = (screen.availHeight - height)/2;
	x = (screen.availWidth - width)/2;
}
var w=window.open(param, 'ouverture', 'toolbar=no, status=no, scrollbars=yes, resizable=yes, width='+width+', height='+height+',screenX='+x+',screenY='+y+',top='+y+',left='+x);
//w.document.close();
w.focus();
}

function pop_full(url)
{
	var yes = 1;
	var no = 0;
	var menubar = no;
	var scrollbars = no;
	var locationbar = no;
	var directories = no;

	if (navigator.userAgent.indexOf("MSIE") != -1)
	{
		var resizable = yes;
	}
	else
	{
		var resizable = no;
	}

	var statusbar = no;
	var toolbar = no;

	if (navigator.appVersion.substring(0,1) >= 4)
	{
		var wid2 = (screen.width-11);
		var hei2 = (screen.height-80);
		if (wid2 > 1013) {var wid2 = 1013;}
		if (hei2 > 690) {var hei2 = 690;}
		windowprops = "width=" + wid2 + ",height=" + hei2 + ",top=0,left=0";
	}
	else
	{
		windowprops = "width=620,height=400,top=0,left=0";
	}
	windowprops += (menubar ? ",menubars" : "") +
	(scrollbars ? ",scrollbars" : "") +
	(locationbar ? ",location" : "") +
	(directories ? ",directories" : "") +
	(resizable ? ",resizable" : "") +
	(statusbar ? ",status" : "") +
	(toolbar ? ",toolbar" : "");

	win = window.open(url, "chat", windowprops);
}


function form_chatter_verif(doc)
{
	if (document.chat.pseudo.value.length == 0)
	{ 
		alert ("Vous devez spécifier un pseudo"); 
		return false;	
	}

	var yes = 1;
	var no = 0;
	var menubar = no;
	var scrollbars = no;
	var locationbar = no;
	var directories = no;

	if (navigator.userAgent.indexOf("MSIE") != -1)
	{
		var resizable = yes;
	}
	else
	{
		var resizable = no;
	}

	var statusbar = no;
	var toolbar = no;

	if (navigator.appVersion.substring(0,1) >= 4)
	{
		var wid2 = (screen.width-11);
		var hei2 = (screen.height-80);
		if (wid2 > 1013) {var wid2 = 1013;}
		if (hei2 > 690) {var hei2 = 690;}
		windowprops = "width=" + wid2 + ",height=" + hei2 + ",top=0,left=0";
	}
	else
	{
		windowprops = "width=620,height=400,top=0,left=0";
	}
	windowprops += (menubar ? ",menubars" : "") +
	(scrollbars ? ",scrollbars" : "") +
	(locationbar ? ",location" : "") +
	(directories ? ",directories" : "") +
	(resizable ? ",resizable" : "") +
	(statusbar ? ",status" : "") +
	(toolbar ? ",toolbar" : "");

	//récupération du sexe

	if (document.chat.Sexe[0].checked) { var radio_sexe = "H"; }
	else { var radio_sexe = "F" ; }

	//récupération du salon
	for (var i=0; i<document.chat.salon.length;i++) {
              if (document.chat.salon[i].checked) {
				  if( document.chat.salon[i].value != "autre" ) { var chan = document.chat.salon[i].value ; }
				  else { 
					  if ( document.chat.autrechan.value.length != 0 ) {
						  var chan = document.chat.autrechan.value ;
					  }
					  else { 
						  alert ( "Vous devez saisir un nom de salon.");
						  return false;
					  }
				  }
			}
	}

	//sélection de l'applet
	if ( document.chat.vapplet.checked) { var version = "1" }
	else { var version = "2" }
	
	//sélection du port
	if ( document.chat.proxy.checked) { var port = "1080" }
	else { var port = "6667" }

	//verifications
	if (document.chat.age.value.length == 0 ) { 
		var age = "?" ; 
	} else { 
		if (isNaN(document.chat.age.value)) { 
			alert ( "L'âge saisi n'est pas valide."); 
		} else { var age = document.chat.age.value ; }
	}
	
	if (document.chat.ville.value.length == 0 ) { 
		var ville = "?" ; 
	} else { var ville = document.chat.ville.value ; }

	win = window.open("chatter.php?nick="+escape(document.chat.pseudo.value)+"&age="+age+"&sexe="+radio_sexe+"&ville="+ville+"&chan="+escape(chan)+"&version="+version+"&port="+port, "chat", windowprops);
	document.chat.submit();
	return true;
}

function form_chatter_accueil(doc)
{
	if (document.chat.pseudo.value.length == 0)
	{ 
		alert ("Vous devez spécifier un pseudo"); 
		return false;	
	}

	var yes = 1;
	var no = 0;
	var menubar = no;
	var scrollbars = no;
	var locationbar = no;
	var directories = no;

	if (navigator.userAgent.indexOf("MSIE") != -1)
	{
		var resizable = yes;
	}
	else
	{
		var resizable = no;
	}

	var statusbar = no;
	var toolbar = no;

	if (navigator.appVersion.substring(0,1) >= 4)
	{
		var wid2 = (screen.width-11);
		var hei2 = (screen.height-80);
		if (wid2 > 1013) {var wid2 = 1013;}
		if (hei2 > 690) {var hei2 = 690;}
		windowprops = "width=" + wid2 + ",height=" + hei2 + ",top=0,left=0";
	}
	else
	{
		windowprops = "width=620,height=400,top=0,left=0";
	}
	windowprops += (menubar ? ",menubars" : "") +
	(scrollbars ? ",scrollbars" : "") +
	(locationbar ? ",location" : "") +
	(directories ? ",directories" : "") +
	(resizable ? ",resizable" : "") +
	(statusbar ? ",status" : "") +
	(toolbar ? ",toolbar" : "");

	
	win = window.open("./modules/chatter/chatter.php?nick="+escape(document.chat.pseudo.value)+"&chan="+escape(document.chat.salon.value), "chat", windowprops);
	document.chat.submit();
	return true;
}

// Génération du script Chatterbox
function chatter_box() {
	url = "http://www.irc.jeux.fr/modules/chatterbox/" ;
	if (document.chatterbox.affichage[0].checked)
	{
		url += "box.js.php?" ;
	} else {
		url += "iframe.php?" ;
	}
		
	//recuperation et verification du salon
	if (document.chatterbox.salon.value.length != 0)
	{
		if (document.chatterbox.salon.value.charAt(0) == "#")
		{
			chan = document.chatterbox.salon.value.substring(1,document.chatterbox.salon.value.length);
		} else {
			chan = document.chatterbox.salon.value ;
		}
		if (chan.length == 0)
		{
			alert("Vous devez saisir un nom de salon !");
			return ;
		}
	} else {
		alert("Vous devez saisir un nom de salon !");
		return ;
	}
	url += "chan=" + chan ;
	
	//récupération du skin sélectionné
	for (var i=0; i<document.chatterbox.skin.length;i++) {
		if (document.chatterbox.skin[i].checked) {
			  var skin = document.chatterbox.skin[i].value ;
		}
	}
	url += "&skin=" + skin ;

	//recuperation de la version de l'applet selectionnée
	if (document.chatterbox.applet[0].checked) { version = 2 ; }
	else { version = 1 ; }
	url += "&version=" + version ;

	//alert(url);

	//On affiche le résultat dans la textarea

	if (document.chatterbox.affichage[0].checked)
	{
		result = "<SCRIPT Language=\"Javascript\" SRC =\"" + url + "\"></SCRIPT>" ;
	} else {
		result = "<iframe src=\"" + url + "\" name=\"chatter\" frameborder=\"0\" " ;
		result += "scrolling=\"no\" width=\"170\" height=\"114\" marginwidth=\"0\" " ; 
		result += "marginheight=\"0\" hspace=\"0\" align=\"middle\"></iframe>" ;
	}
	
	document.chatterbox.soluce.value = result ;
	location.href = "#result";

}

function chatter_verif()
{
	if (document.chat.pseudo.value.length == 0)
	{ 
		//alert ("Vous devez spécifier un pseudo");
		document.getElementById('nopseudo').className = "visible";
		scroll(0,0);
		document.chat.pseudo.focus();
		return false;
	} else {
		document.getElementById('nopseudo').className = "hidden"
	}
	
	if (document.chat.salon.length == 0 && document.chat.salonperso.value == undefined)
	{
		document.getElementById('nochan').className = "visible";
		scroll(0,0);
		document.chat.salonperso.focus();
		return false;
	} else {
		document.getElementById('nochan').className = "hidden"
	}

	var yes = 1;
	var no = 0;
	var menubar = no;
	var scrollbars = no;
	var locationbar = no;
	var directories = no;

	if (navigator.userAgent.indexOf("MSIE") != -1)
	{
		var resizable = yes;
	}
	else
	{
		var resizable = no;
	}

	var statusbar = no;
	var toolbar = no;

	if (navigator.appVersion.substring(0,1) >= 4)
	{
		var wid2 = (screen.width-11);
		var hei2 = (screen.height-80);
		if (wid2 > 1013) {var wid2 = 1013;}
		if (hei2 > 690) {var hei2 = 690;}
		windowprops = "width=" + wid2 + ",height=" + hei2 + ",top=0,left=0";
	}
	else
	{
		windowprops = "width=620,height=400,top=0,left=0";
	}
	windowprops += (menubar ? ",menubars" : "") +
	(scrollbars ? ",scrollbars" : "") +
	(locationbar ? ",location" : "") +
	(directories ? ",directories" : "") +
	(resizable ? ",resizable" : "") +
	(statusbar ? ",status" : "") +
	(toolbar ? ",toolbar" : "");

	//récupération du sexe

	if (document.chat.Sexe[0].checked) { var radio_sexe = "H"; }
	else { var radio_sexe = "F" ; }

	
	//récupération du salon
	if (document.chat.salonperso.value != undefined) {
		chan = document.chat.salonperso.value;
		document.getElementById('nochan').className = "hidden";
	} else {
		for (var i=0; i<document.chat.salon.length;i++) {
			if (document.chat.salon[i].checked) {
				if( document.chat.salon[i].value != "autre" ) { var chan = document.chat.salon[i].value ; }
				else { 
					if ( document.chat.autrechan.value.length != 0 ) {
						var chan = document.chat.autrechan.value ;
						document.getElementById('nochan').className = "hidden";
					}
					else { 
						document.getElementById('nochan').className = "visible";
						scroll(0,0);
						document.chat.salonperso.focus();
						return false;
					}
				}
			}
		}
	}
	
	//sélection du port
	if ( document.chat.proxy.checked) { var port = "1080" }
	else { var port = "6667" }

	//verifications
	if (document.chat.age.value.length == 0 ) { 
		var age = "?" ; 
	} else { 
		if (isNaN(document.chat.age.value)) { 
			alert ( "L'âge saisi n'est pas valide."); 
		} else { var age = document.chat.age.value ; }
	}
	
	if (document.chat.ville.value.length == 0 ) { 
		var ville = "?" ; 
	} else { var ville = document.chat.ville.value ; }

	win = window.open("chatter.php?nick="+escape(document.chat.pseudo.value)+"&age="+age+"&sexe="+radio_sexe+"&ville="+ville+"&chan="+escape(chan)+"&port="+port, "chat", windowprops);
	//document.chat.submit();
	return false;
}
function valid(msg, url1, url2) {
	if (confirm(msg)) {
		document.location.href = url1;
	} else {
		document.location.href = url2;
	}
}