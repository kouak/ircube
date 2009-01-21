var chatter = {
                 '#bloc_chat label' : function(el) {
                         el.onclick = function() {
                                    showtip(this.id);
                         }
                 },
                 
                 '#generer' : function(el) {
                         el.onclick = function() {
                                    generate();
                         }
                 },
                 
                 '#bloc_chat3 input' : function(el) {
                         el.onclick = function() {
                                    if (this.value == "IRCube") {
                                        this.value = "";
                                    }
                         }
                 }
}
Behaviour.register(chatter);

function showtip(identifiant) {
         i = 1;
         k = 0;
         while (k == 0) {
              if (!document.getElementById("tip"+i+"-")) {
                 k = 1;
              } else {
                 document.getElementById("tip"+i+"-").className = "tips hidden";
                 i = i + 1;
              }
         }
         
         document.getElementById(identifiant+"-").className = "tips visible";
}

function generate() {
         for (var i=0; i<document.chatterbox.skin.length;i++) {
              if (document.chatterbox.skin[i].checked) {
				  var skin = document.chatterbox.skin[i].value ;
			  }
         }
         if (!skin) { 
                alert('Veuillez choisir un skin');
                return 0;
         }
         
         for (var i=0; i<document.chatterbox.applet.length;i++) {
              if (document.chatterbox.applet[i].checked) {
				  var applet = document.chatterbox.applet[i].value ;
			  }
	     }
         
         if (!applet) { 
                alert('Veuillez choisir un applet');
                return 0;
         }
         
         
         for (var i=0; i<document.chatterbox.affichage.length;i++) {
              if (document.chatterbox.affichage[i].checked) {
				  var affichage = document.chatterbox.affichage[i].value;
			  }
         }
         if (!affichage) { 
                alert('Veuillez choisir un mode d\'affichage');
                return 0;
         }
            
         if (document.chatterbox.salon.value.length == 0) {
                alert('Veuillez choisir un salon');
                return 0;
         } else {
         	var salon = document.chatterbox.salon.value;
         }
         if (affichage == 1) {
                var resu = "<script language=\"javascript\" src=\"http://ircube.org/webmasters/box/?chan="+salon+"&amp;version="+applet+"&amp;skin="+skin+"\"></script>";
         } else if(affichage == 2) {
                var resu = "<iframe src=\"http://ircube.org/modules/webmasters/box/?chan="+salon+"&amp;version="+applet+"&amp;skin="+skin+"&amp;type=frame\" name=\"chat\" frameborder=no></iframe>"
         } else if(affichage == 3) {
                document.location.href = "?chan="+salon+"&version="+applet+"&skin="+skin;
                return 0;
         }
         
         document.code.code.value = resu;
         return 0;
}