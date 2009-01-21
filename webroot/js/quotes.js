function vote(quote, note) {
	var i = 1;
	
	while (i <= 5) {
		if (document.getElementById('vote'+quote+'-'+i)) {
			if (i <= note) {
				document.getElementById('vote'+quote+'-'+i).src = '/images/two_stars.png';
			} else {
				document.getElementById('vote'+quote+'-'+i).src = '/images/star.png';
			}
			i = i + 1;
		}
	}
	send_data('q='+escape(quote)+'&n='+escape(note), '/quotes/vote/');
	if (document.getElementById('voted'+quote)) {
		document.getElementById('voted'+quote).className = 'show voted';
	}
	if (document.getElementById('tovote'+quote)) {
		document.getElementById('tovote'+quote).className = 'hidden';
	}
}

function send_data(data, page) {
	 if (window.ActiveXObject) {
	//Internet Explorer
	 var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
	 } else {
		var XhrObj = new XMLHttpRequest();
	 }
	
	  //définition de l'endroit d'affichage:
	  //var content = document.getElementById(id);
	
	  //Ouverture du fichier en methode POST
	  XhrObj.open("POST", page);
	
	  //Ok pour la page cible
	  //XhrObj.onreadystatechange = function() {
		//if (XhrObj.readyState == 4 && XhrObj.status == 200)
			//alert(XhrObj.responseText);
	 //}   
	
	  XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	  XhrObj.send(data);
}

function fenetre(type, id, title, text, chan) {
	closefenetre();
	if (document.getElementById('popup')) {
			
		switch(type) {
			case 'move': {
				document.getElementById('popup').className = 'popup show';
				document.getElementById('mpopup').className = 'mpopup';
				document.getElementById('move').className = 'show';
				document.getElementById('moveid').value = id;
				document.getElementById('titre').value = 'Déplacement de catégorie';
				break;
			}
			case 'edit': {
				document.getElementById('popup').className = 'popup2 show';
				document.getElementById('mpopup').className = 'mpopup2';
				document.getElementById('edit').className = 'show';
				document.getElementById('editid').value = id;
				
				document.getElementById('title').value = title;
				document.getElementById('message').value = text.replace(/{ali}/g, "\r\n");
				document.getElementById('chan').value = chan;
				document.getElementById('titre').value = 'Edition d\'une quote';
				break;
			}
			case 'add': {
				document.getElementById('popup').className = 'popup2 show';
				document.getElementById('mpopup').className = 'mpopup2';
				document.getElementById('add').className = 'show';
				document.getElementById('titre').value = 'Ajout d\'une nouvelle quote';
				break;
			}
			default: {
				alert('type inexistant '+type);
				break;
			}
		}
	}
}
function closefenetre() {
	if (document.getElementById('popup')) {
		document.getElementById('popup').className = 'hidden';
		if (document.getElementById('move')) {
			document.getElementById('move').className = 'hidden';
		}
		if (document.getElementById('edit')) {
			document.getElementById('edit').className = 'hidden';
		}
		if (document.getElementById('add')) {
			document.getElementById('add').className = 'hidden';
		}
	}
}

var clic = false;
var topFenetre = 150			// Distance du haut de la fenetre
var leftFenetre= 300		// Distance du bord gauche de la fenetre
function clicDown(tab) {
	abscisse = abs-leftFenetre;
	ordonne = ord-topFenetre;
	clic=true;
}
function clicUp() {
		clic=false;
}