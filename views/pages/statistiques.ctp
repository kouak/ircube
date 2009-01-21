<?php
$javascript->link('statistiques', false);
$html->css(array('statistiques'), null, array(), false);
?>
<h1>Statistiques du r&eacute;seau</h1>
<a href="#" id="refresh-stats">Rafraîchir</a>
<br />
	<h2>Graphique quotidien</h2>
<div class="loader loading">
	<img class="stats" src="http://stats.ircube.org/irc-day.png" alt="Graphique journalier" />
</div>
	<h2>Graphique hebdomadaire</h2>
<div class="loader loading">
	<img class="stats" src="http://stats.ircube.org/irc-week.png" alt="Graphique semaine" />
</div>
	<h2>Graphique mensuel</h2>
<div class="loader loading">
	<img class="stats" src="http://stats.ircube.org/irc-month.png" alt="Graphique mois" />
</div>
	<h2>Graphique annuel</h2>
<div class="loader loading">
	<img class="stats" src="http://stats.ircube.org/irc-year.png" alt="Graphique ann&eacute;e" />
</div>
<br />