//Gestion de l'affichage des données
function show(id) {
	var i = 1;
	while (document.getElementById('edit'+i)) {
		if (i == id) {
			if (document.getElementById('normal'+i)) {
				document.getElementById('normal'+i).className = 'hidden';
			}
			document.getElementById('edit'+i).className = 'show';
		}
		i++;
	}
	if (document.getElementById('submit')) {
		document.getElementById('submit').className = 'show';
	}
	return true;
}