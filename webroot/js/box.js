function FormatNickname(nick)
{
	var i, c, outnick = '';
	for (i = 0; i < nick.length; i++)
	{
		c = nick.substring(i,i+1);
		if (c == ' ') c = '_'; if ((c == 'é') || (c == 'è')) c = 'e';
		if (c == 'à') c = 'a'; outnick += c;
	}
	return outnick;
}

function Chat()
{
	//nickname = prompt('Choisissez votre pseudo (votre nom sur le Chat) : ','');
	if (document.chat.nickname.value.length == 0)
	{ 
		alert ("Vous devez spécifier un pseudo"); 
		return false;	
	}
	else
	{
		nickname = document.chat.nickname.value;
		chan = document.getElementById('ircube_chan').value;
		version = document.getElementById('ircube_version').value;

		//Preparation des dimensions du popup
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

		//formatage de l'url
		 url ='http://ircube.org/applet/?nick='+escape(FormatNickname(nickname))+'&chan='+chan+'&version=2';

		win = window.open(url, "ircube_chat", windowprops);
		
		return true
	}
}

function Chat2()
{
	if ( !Chat() ) {}
}