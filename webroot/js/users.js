var delphoto = {
	'.photo': function(el) {
		el.onmouseover = function() {
			if (document.getElementById('del'+el.id)) {
				document.getElementById('del'+el.id).style.display = 'inline';
			}
		}
		el.onmouseout = function() {
			if (document.getElementById('del'+el.id)) {
				document.getElementById('del'+el.id).style.display = 'none';
			}
		}
	},
	
	'.champ': function(el) {
		el.onclick = function() {
			divTarget = el.id.replace('normal', 'edit');
			if ($(divTarget)) {
				$(divTarget).style.display = 'block';
				el.style.display = 'none';
				document.getElementById('submit').className = 'show';
			}
		}
	},
	
	'.delphoto': function(el) {
		el.onclick = function() {
			if (confirm('Etes vous sur de vouloir supprimer cette photographie ?')) {
				divTarget = el.parentNode;
				
				if (document.getElementsByClassName('photo')[0].id == divTarget.id && document.getElementsByClassName('photo')[1]) {
					document.getElementsByClassName('photo')[1].className = 'photo avatar';
				} else if (document.getElementsByClassName('photo')[1] == undefined) {
					//On a plus aucune photo
					text = Builder.node('p', {style:'text-align: center;display: none;', id:'nophoto'}, 'Aucune photo a afficher');
					document.getElementById('cphotos').appendChild(text);
				}
				new Ajax.Request('/users/supprphoto/', {
					method:'post',
					postBody:'id=' + divTarget.id ,
					onLoading:function(request) {
						$('loading').style.display='block';
					},
					onComplete:function(request) {
						$('loading').style.display='none';
					}
				});
				new Effect.SwitchOff(divTarget, {duration: 0.5});
				
				if (document.getElementById('nophoto')) {
					new Effect.Appear(document.getElementById('nophoto'), {duration: 0.5})
				}
			}
		}
	}
}
Behaviour.register(delphoto);

function createInfoMarker(point, address) {
	var marker = new GMarker(point);
	GEvent.addListener(marker, "click",
		function() {
			marker.openInfoWindowHtml(address);
		}
	);
  return marker;
}

function openimage(name) {
		if (name != undefined && document.getElementById('imagereelle')) {
				$('imagereelle').src = name;
		}
		if (document.getElementById('photoreelle')) {
			new Effect.Appear('photoreelle');
		}
}
function closeimage() {
		if (document.getElementById('photoreelle')) {
			new Effect.Fade('photoreelle');
		}
}
function updateReorderField() {
	var sections = document.getElementsByClassName('photo');
	var order = '' ;
	for(var i=0; i<sections.length; i++) {
		if (i == 0) {
			sections[i].className = 'photo avatar';
		} else {
			sections[i].className = 'photo';
		}
		order += sections[i].id + "|" ;
	}
	new Ajax.Request('/users/reorderphotos/', {method:'post', postBody:'photos='+order, onLoading:function(request){$('loading').style.display='block';}, onComplete:function(request){$('loading').style.display='none'}, asynchronus:true});
}

/* Vérification du niveau de sécurité du mot de passe */
function check_pass_security(password)
{
	var score = 0;
	var result;

	/* Test de la longueur */
	/* C'est inférieur à 7 : on ne va pas plus loin => low */
	if(password.length < 7){
		return "faible" ;
	} else {
	/* 1 point par nombre de caractère au dessus de 7 */
		score = score + (password.length / 1.2) ;
	}

	/* Récupération des caractères normaux */
	var normal_chars = password.match(/[a-z]/g) ;
	if (!normal_chars) var normal_chars = new Array();
	//else console.log ("Normaux : " + normal_chars.length);

	/* Récupération des chiffres */
	var numbers = password.match(/[0-9]/g) ;
	if (!numbers) var numbers = new Array();
	//else console.log ("Chiffres : " + numbers.length);

	/* Récupération des majuscules (1/2 point par maj) */
	var uppers = password.match(/[A-Z]/g) ;
	if (!uppers) var uppers = new Array();
	//else console.log ("Majuscules : " + uppers.length);

	/* Récupération des caractères spéciaux */
	var special_chars = password.match(/\W/g);
	if (!special_chars) var special_chars = new Array();
	//else console.log ("Spéciaux : " + special_chars.length);

	/* Cas particulier : moins de 10 chars, et que des lettres ou que des chiffres */
	if (password.length < 10 && (normal_chars.length == password.length || numbers.length == password.length)) {
		//console.log("Moins de 10 chars, et que des lettres ou que des chiffres");
		return "faible" ;
	}

	/* Cas normal : système de points */
	/* Majuscules (1/2 point sauf s'il n'y a que des majuscules : dans ce cas pas de points) */
	if (uppers.length && (normal_chars.length || numbers.length || special_chars.length)) {
		//console.log("Bonus majuscules (+" + ( uppers.length / 2 ) + ")");
		score = score + ( uppers.length / 2 ) ;
	}

	/* Caractères spéciaux (2 points)*/
	if (special_chars.length) {
		//console.log("Bonus caractères spéciaux (+" + ( special_chars.length * 2 ) + ")");
		score = score + (special_chars.length * 2) ;
	}

	/* Chiffres (1 point par chiffre sauf s'il n'y a que des chiffres : dans ce cas pas de points)*/
	if (numbers.length && (normal_chars.length || uppers.length || special_chars.length)) {
		//console.log("Bonus chiffres (+" +  numbers.length + ")");
		score = score + numbers.length ;
	}

	/* Pénalités spéciales */
	/* Seulement des lettres normales ou seulement des chiffres  */
	if ((normal_chars && !special_chars && !numbers && !uppers) || (numbers && !normal_chars && !special_chars && !uppers) || (uppers && !normal_chars && !special_chars && !numbers)) {
		//console.log("Pénalité un seul type (-" + (password.length * 0.7) + ")" );
		score = score - (password.length * 0.7) ;
	} else {
		/* On a ni caractères spéciaux, ni majuscules */
		if (!special_chars.length && !uppers.length) {
			//console.log("Pénalité ni caractères spéciaux, ni majuscules (-" + (password.length * 0.3) + ")" );
			score = score - (password.length * 0.3) ;
		} else if ((!special_chars.length && !numbers.length) || (!numbers.length && !uppers.length)) {
			//console.log("Pas de spec ni chiffres, ou pas de chiffres ni majs (-" + (password.length * 0.2) + ")");
			score = score - (password.length * 0.2) ;
		}
	}
	
	//console.log("Total : " + score);
	/* Transformation en niveau */
	if (score < 5) return "faible" ;
	else if (score < 10) return "moyenne" ;
	else if (score < 14) return "forte"
	else return "très forte" ;
}

function update_security() {
	//console.log('Password : ' + $('NewUserPassword').value);
	var password = $('NewUserPassword').value;
	if (password) {
		var security_level = check_pass_security(password);
		//console.log(security_level);

		/* Mise à jour du libellé */
		$('pass_security_label').innerHTML = security_level ;
		/* Mise à jour des classes */
		switch (security_level) {
			case 'faible' : {
				//console.log("Sécurité basse : mise à jour de la barre");
				$('pass_security_low').className = 'faible';
				$('pass_security_medium').className = 'defaut';
				$('pass_security_high').className = 'defaut';
				break ;
			}
			case 'moyenne' : {
				//console.log("Sécurité moyenne : mise à jour de la barre");
				$('pass_security_low').className = 'moyenne';
				$('pass_security_medium').className = 'moyenne';
				$('pass_security_high').className = 'defaut';
				break ;
			}
			default : {
				//console.log("Sécurité forte : mise à jour de la barre");
				$('pass_security_low').className = 'forte';
				$('pass_security_medium').className = 'forte';
				$('pass_security_high').className = 'forte';
				break ;
			}			
		}
	} else {
		$('pass_security_label').innerHTML = "" ;
		$('pass_security_low').className = 'defaut';
		$('pass_security_medium').className = 'defaut';
		$('pass_security_high').className = 'defaut';
	}
}

function is_pseudo_available() {
	if ($('NewUserPseudo').value != $('last_pseudo_verification').value) {
		var link = '/users/ispseudoavailable/' + escape($('NewUserPseudo').value) + '/' ;
		new Ajax.Updater('is_pseudo_available_message',link);
		$('last_pseudo_verification').value = $('NewUserPseudo').value ;
	}
}

function rastapopoulos() {
	if(!$('partenaireparticulier')) {
		hidden = Builder.node('input', {type:'hidden',id:'partenaireparticulier', name:'data[NewUser][Cettefille]',value:'alorsjechercheetjetrouverai'});
		$('zone_login').appendChild(hidden);
	}
}
