function FormatNickname(nick) {
    var i, c, outnick = '';
    for (i = 0; i < nick.length; i++) {
	    c = nick.substring(i,i+1);
	    if (c == ' ') c = '_'; if ((c == 'é') || (c == 'è')) c = 'e';
	    if (c == 'à') c = 'a'; outnick += c;
    }
    return outnick;
}

var chat = {
	'#form_nickname' : function(el) {
		el.onload = function() {
			alert("test");
			el.focus();
		}
	},
	'#chat_form' : function(el) {
		el.onsubmit = function() {
			if (!formValidator.validate()) {
                return false;
            } else {
                //Le formulaire est ok
                 //On recupere les salons
                var  i = 0;
                var j = 0;
                var chans = '';
                while (document.getElementById("form_chans"+i)) {
                    if (document.getElementById("form_chans"+i).checked && document.getElementById("form_chans"+i).type == "checkbox") {
                        if (j > 0) { chans = chans+','; }
                        chans = chans+document.getElementById("form_chans"+i).value;
                        j++;
					} else if (document.getElementById("form_chans"+i).value != "" && document.getElementById("form_chans"+i).type == "text") {
						if (j > 0) { chans = chans+','; }
                        chans = chans+document.getElementById("form_chans"+i).value;
                        j++;
					}
                    i++; 
                }
                
                nickname = document.chat_form.form_nickname.value;
                
                //Preparation des dimensions du popup
		        var yes = 1;
	            var no = 0;
	            var menubar = no;
	            var scrollbars = no;
	            var locationbar = no;
	            var directories = no;

	            if (navigator.userAgent.indexOf("MSIE") != -1) {
		            var resizable = yes;
	            } else {
		            var resizable = no;
	            }

	            var statusbar = no;
	            var toolbar = no;

	            if (navigator.appVersion.substring(0,1) >= 4) {
		            var wid2 = (screen.width-11);
		            var hei2 = (screen.height-80);
		            if (wid2 > 1013) {var wid2 = 1013;}
		            if (hei2 > 690) {var hei2 = 690;}
		            windowprops = "width=" + wid2 + ",height=" + hei2 + ",top=0,left=0";
	            } else {
		            windowprops = "width=620,height=400,top=0,left=0";
	            }
	            windowprops += (menubar ? ",menubars" : "") +
	            (scrollbars ? ",scrollbars" : "") +
	            (locationbar ? ",location" : "") +
	            (directories ? ",directories" : "") +
	            (resizable ? ",resizable" : "") +
	            (statusbar ? ",status" : "") +
	            (toolbar ? ",toolbar" : "");

	            //formatage de l'url
	            url ='/applet/?nick='+escape(FormatNickname(nickname))+'&chan='+chans+'&version=2';

                if (document.getElementById("open_type") && document.getElementById("open_type").value == 'same') {
                    document.location = url;
                } else {
                    win = window.open(url, "ircube_chat", windowprops);
                }
	
	            return false;
            }
		}
	}
}
Behaviour.register(chat);

/* Validation du formulaire */
formValidator.addValidation(
	"form_nickname",
	{ requested: true },	
	{ message_id: "msg_name_sex",
	  message_content: "Vous devez saisir un pseudonyme pour vous connecter au chat." }
	);
	
formValidator.addValidation(
	"form_age",
	{ numeric: true ,
	  maxlength: 3 },	
	{ message_id: "msg_localisation_age",
	  message_content: "L'âge que vous avez saisi n'est pas valide. Veuillez saisir un nombre." }
	);