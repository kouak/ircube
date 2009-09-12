<?php
/* News Fixture generated on: 2009-09-12 16:09:40 : 1252765840 */
class NewsFixture extends CakeTestFixture {
	var $name = 'News';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'newstype_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'permalink' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'content' => array('type'=>'text', 'type' => 'text', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'user_profile_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'news_comment_count' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'published' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id' => 225,
			'newstype_id' => 4,
			'title' => 'Une soirée surprise',
			'permalink' => 'Une_soiree_surprise',
			'content' => '<p>Bonsoir &agrave; tous !<br />Je dois absolument vous mettre dans la confidence, mais il ne faut surtout pas que vous alliez en parler ...<br />Vous &ecirc;tes ok pour garder un secret donc ? S&ucirc;r ?<br /><br />Bon ok, je me lance !<br />kouak f&ecirc;tera ses 21 ans <strong>mercredi 20 septembre 2006</strong><br />Nous tous, membres du r&eacute;seau, d&eacute;sirons lui f&eacute;ter honorablement cet anniversaire, et nous vous convions donc &agrave; une soir&eacute;e surprise sur le salon <strong>#IRCube</strong> &agrave; partir de 21h ce m&ecirc;me jour.<br /><br />Mais chut surtout ! kouak n\'est au courant de rien.<br /><a href=\"http://ircube.org/forum/viewtopic.php?id=225\">Venez en discuter sur le forum</a>.</p>',
			'created' => '2006-09-15 23:45:31',
			'modified' => '2009-08-10 22:21:20',
			'user_profile_id' => 3,
			'news_comment_count' => 17,
			'published' => 1
		),
		array(
			'id' => 223,
			'newstype_id' => 3,
			'title' => 'Et ... encore 3 !',
			'permalink' => 'Et_encore_3',
			'content' => 'Un jeune homme pour deux jeunes filles ! Apr&egrave;s, il ne faudra plus dire que le staff IRCube n\'est constitu&eacute; que d\'hommes !!!<br />Nous souhaitons donc la bienvenue &agrave; Cinaee, Cleopatre et Shmolt (l\'homme) qui int&egrave;grent le pole communication, afin de tous nous faire vibrer dans des animations du tonnerre.<br /><br />Mais je ne vous en dit pas plus ! :)',
			'created' => '2006-08-23 00:53:46',
			'modified' => '2009-06-17 01:33:49',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
		array(
			'id' => 224,
			'newstype_id' => 2,
			'title' => 'Quizz multi-réseaux',
			'permalink' => 'Quizz_multi_reseaux',
			'content' => 'F&ecirc;tons la rentr&eacute;e ensemble !! (hey toi le cancre au fond, je t\'ai vu !)<br />Nous r&eacute;viserons donc tous ensemble notre culture g&eacute;n&eacute;rale lors d\'un quizz ... Oui, j\'ai bien dit tous ensemble, et pas seulement vous, IRCubiens. Tout le monde s\'y colle (d&eacute;j&agrave; coll&eacute;s moins d\'une semaine apr&egrave;s la rentr&eacute;e, vous abusez quand m&ecirc;me)<br /><br />Le <strong>15 septembre 2006</strong>, &agrave; partir de <strong>21h</strong>, se d&eacute;roulera donc, sur le salon <strong>#IRCube</strong>, et sur les salons principaux des r&eacute;seaux <a href=\"http://www.epiknet.org/\">EpikNet</a> et <a href=\"http://www.wanascape.com/\">Wanascape</a> un quizz multi r&eacute;seaux de plus de 150 questions ...<br /><br />Alors, d&eacute;pechez vous de r&eacute;viser vos le&ccedil;ons, seul ou <a href=\"http://ircube.org/forum/viewtopic.php?id=220\">&agrave; plusieurs sur le forum</a>, et c\'est partiiii !!!!!',
			'created' => '2006-09-11 19:19:49',
			'modified' => '2009-06-17 01:25:16',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
		array(
			'id' => 222,
			'newstype_id' => 3,
			'title' => 'Le grand retour ...',
			'permalink' => 'Le_grand_retour',
			'content' => 'Depuis quelques mois vous les attendiez ... le temps passe, mais la motivation est rest&eacute;e. Et apr&egrave;s un long travail de Cl&eacute;opatre et du reste de l\' &eacute;quipe, les <strong>Z\'infos</strong> reviennent ce mois-ci sur <em>IRCube</em> !<br /><br />Un nouveau design, de nouvelles rubriques ... tout pour vous donner du plaisir &agrave; la lecture.<br /><br />Jettez vous vite sur le 1er num&eacute;ro des <a href=\"http://www.gaaaaaz.com/ircube/zinfos0806/zinfos.php\">Z\'infos</a> et bonne lecture !<br /><br />\r\n<div align=\"center\"><a href=\"http://www.gaaaaaz.com/ircube/zinfos0806/zinfos.php\"><img align=\"middle\" src=\"http://animation.ircube.org/zinfos/zinfos.jpg\" alt=\"\" /></a></div>',
			'created' => '2006-08-07 22:36:57',
			'modified' => '2009-06-17 01:33:54',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
		array(
			'id' => 221,
			'newstype_id' => 2,
			'title' => 'C\'est l\'été: respirez, chattez, votez !',
			'permalink' => 'C_est_l_ete_respirez_chattez_votez',
			'content' => 'Apr&egrave;s une dure ann&eacute;e de travail ou de cours, les vacances sont enfin l&agrave;!  Certains partent se ressourcer ... mais bien s&ucirc;r tout le monde passera quelques bons moments sur le  r&eacute;seau, qui respire bon le soleil tout au long de l\'&eacute;t&eacute;.<br /><br />Suite aux derni&egrave;res animations Ircubiennes, 5 noms sont sortis du grand chapeau  (de Tata Yoyo?) pour l\'&eacute;lection du <strong>Chatteur de l\'&eacute;t&eacute;</strong>. <br minmax_bound=\"true\" /><br minmax_bound=\"true\" />Les 5 nomm&eacute;s sont donc: <em>eusebus42</em>,  <em>Nakara</em>, <em>Gyfla</em>, <em>Sakoo</em>, et <em>Mog_Jaune</em>.<br minmax_bound=\"true\" />Vous pouvez voir&nbsp;  leur photo, ainsi que la description de leur &eacute;t&eacute; 2006 <a href=\"http://animation.ircube.org/chatteurdumois/ete/\">ici</a><br /><br />Pour voter? rien de plus simple! il suffit de vous identifier sur le r&eacute;seau et  d\'utiliser la commande /z voter (suivie du num&eacute;ro du participant). Vous pouvez aussi r&eacute;agir sur le <a href=\"http://ircube.org/forum/viewtopic.php?id=168\">forum</a><br minmax_bound=\"true\" /><br minmax_bound=\"true\" />Bon vote &agrave; tous ... et Bonnes  Vacances !<br minmax_bound=\"true\" />',
			'created' => '2006-07-20 13:47:42',
			'modified' => '2009-06-17 01:32:44',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
		array(
			'id' => 219,
			'newstype_id' => 1,
			'title' => 'A la recherche du Bac perdu ...',
			'permalink' => 'A_la_recherche_du_Bac_perdu',
			'content' => 'Aujourd\'hui, le jour tant attendu est arriv&eacute;. Mais une mauvaise nouvelle est &agrave;  d&eacute;plorer ... un dipl&ocirc;me du bac a disparu ! Saurez vous le retrouver?<br minmax_bound=\"true\" /><br minmax_bound=\"true\" />Pour vous aider dans cette t&acirc;che, nous afficherons sur le site une &eacute;nigme par jour, et ce jusqu\'&agrave; vendredi. De plus, notre partenaire  <a href=\"http://zikosport.org\">Zik\'o\'Sport</a> vous donnera tous les soirs, entre 17h et 20h, un indice afin de  r&eacute;soudre l\'&eacute;nigme.<br minmax_bound=\"true\" /><br minmax_bound=\"true\" />Mais que faire  de ces &eacute;nigmes? ... Pour ne pas tout d&eacute;voiler ce jour (Surpriiiiiise), l\'&eacute;quipe  IRCube vous donne rendez vous ce <em><strong>Vendredi </strong></em>&agrave; <em><strong>21h </strong></em>sur <em><strong>#ircube</strong></em> pour la suite du jeu  ...<br /><br />Le gagnant se verra offrir une vhost par le r&eacute;seau ainsi qu\'un alias @zikosport.org par la webradio du m&ecirc;me nom.<br /><br />Pour toute question, vous pouvez rejoindre le <a href=\"http://ircube.org/forum/viewtopic.php?id=151\">forum</a>',
			'created' => '2006-07-02 00:49:32',
			'modified' => '2008-09-26 22:35:38',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
		array(
			'id' => 220,
			'newstype_id' => 3,
			'title' => 'Ils l\'ont retrouvé !',
			'permalink' => 'Ils_l_ont_retrouve',
			'content' => 'Vous les connaissez sous les pseudos de <em><strong>eusebus42</strong></em> et <strong><em>Mog_Jaune</em></strong> ....<br /><br />Ce soir, nos deux aventuriers nous ont montr&eacute; tout leur courage et leur force au cours de cette chasse au Bac Perdu .... et ils l\'ont retrouv&eacute; !<br /><br />Ce dipl&ocirc;me tant convoit&eacute; est d&eacute;sormais entre les mains de notre ami <strong><em>eusebus42</em></strong> (<a href=\"http://animation.ircube.org/diplome.html\">ici</a>). Nos deux gagnants ont aussi re&ccedil;u la vhost de leur choix, ainsi qu\'un alias mail @zikosport.org (Merci &agrave; eux pour leur aide).<br /><br />Un Grand Bravo &agrave; tous les deux, mais aussi &agrave; tous les participants pour avoir mis de la bonne humeur tout au long de cette belle soir&eacute;e.',
			'created' => '2006-07-07 23:00:40',
			'modified' => '2009-06-17 01:33:55',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
		array(
			'id' => 218,
			'newstype_id' => 2,
			'title' => '3 juillet: le grand jour !',
			'permalink' => '3_juillet_le_grand_jour',
			'content' => 'Pour certains d\'entre vous, cette date est famili&egrave;re, elle co&iuml;ncide avec les  r&eacute;sultats du bac. Bien s&ucirc;r nous esp&eacute;rons que tou(te)s les IRCubien(ne)s  d&eacute;crocheront ce dipl&ocirc;me, et pour cette date tant attendue, nous vous avons  r&eacute;serv&eacute; une petite surprise ...<br minmax_bound=\"true\" /><br minmax_bound=\"true\" />Alors rendez-vous le <em><strong>lundi 3 juillet</strong></em> &agrave; cette adresse pour en  savoir plus ...',
			'created' => '2006-06-26 20:14:40',
			'modified' => '2008-09-26 22:35:38',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
		array(
			'id' => 1,
			'newstype_id' => 3,
			'title' => '1er janvier 2006 : nous repartons !',
			'permalink' => '1er_janvier_2006_nous_repartons',
			'content' => 'Il nous aura fallu un peu de temps pour repartir sur de bonnes bases, mais apr&egrave;s un travail de longue haleine, nous pouvons &agrave; nouveau vous offrir un site stable. <br /><br />Parmi les bonnes nouvelles :<br />\r\n<ul>\r\n    <li>nous avons restaur&eacute; une partie de notre base de donn&eacute;es : les utilisateurs actifs peuvent donc se reconnecter avec leur compte, les autres ont &eacute;t&eacute; supprim&eacute;s. Vous retrouvez donc tous les commentaires que vous avez post&eacute;s, ou ceux qui ont &eacute;t&eacute; post&eacute;s sur votre fiche par des utilisateurs actifs ;</li>\r\n    <li>les pages, ainsi qu\'une partie de la m&eacute;canique ont &eacute;t&eacute; optimis&eacute;es, les chargements devraient &ecirc;tre plus rapides ;</li>\r\n    <li>nous sommes d&eacute;finitivement deux &agrave; travailler dessus, ce qui signifie que tout va aller beaucoup plus vite ;</li>\r\n</ul>\r\n<br />C&ocirc;t&eacute; &quot;mauvaises nouvelles&quot;, nous n\'avons pas eu le temps de terminer le nouveau module de Citations, et nous ne voulions pas perdre de temps &agrave; remettre l\'ancien en &eacute;tat, donc pour le moment vous devrez garder vos quotes pour vous. De m&ecirc;me, les aides n\'ont malheureusement pas encore &eacute;t&eacute; migr&eacute;es.<br /><br />Dans tous les cas, nous voici repartis de plus belle : nous avons de nombreux projets pour cette ann&eacute;e, et croyez bien que vous serez les premiers &agrave; en b&eacute;n&eacute;ficier !<br /><br /><strong>Merci &agrave; tous pour votre soutien, et excellente ann&eacute;e 2006 !</strong>',
			'created' => '2005-12-21 23:16:42',
			'modified' => '2009-06-29 18:20:57',
			'user_profile_id' => 1,
			'news_comment_count' => 0,
			'published' => 1
		),
	);
}
?>