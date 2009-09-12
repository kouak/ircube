<?php
/* Channel Fixture generated on: 2009-09-12 16:09:12 : 1252765512 */
class ChannelFixture extends CakeTestFixture {
	var $name = 'Channel';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'channel' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'created' => array('type'=>'timestamp', 'type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'flag' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'defmodes' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80),
		'deftopic' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'welcome' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'theme' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80),
		'url' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80),
		'motd' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'banlevel' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6),
		'chmodelevel' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'bantype' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'limit_inc' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'limit_min' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'bantime' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id' => 2,
			'channel' => '#iserv',
			'modified' => '0000-00-00 00:00:00',
			'created' => '2004-01-06 18:01:42',
			'flag' => 2,
			'defmodes' => 'nts',
			'deftopic' => 'iServ : Service d\'information IRC - Demandes et documentation : n/a Forum : http://ircube.org/forum/',
			'welcome' => '',
			'theme' => 'Adminreg',
			'url' => '',
			'motd' => '',
			'banlevel' => 300,
			'chmodelevel' => 300,
			'bantype' => 4,
			'limit_inc' => 0,
			'limit_min' => 0,
			'bantime' => 0
		),
		array(
			'id' => 5,
			'channel' => '#lemondedethaanis',
			'modified' => '0000-00-00 00:00:00',
			'created' => '2007-05-07 08:42:58',
			'flag' => 1,
			'defmodes' => 'nt',
			'deftopic' => 'Bienvenue dans la Taverne du Tumu\'rau Farceur ! tapez !tumuhelp pour plus d\'infos.',
			'welcome' => 'Bienvenue dans la Taverne du Tumu\'rau Farceur ! tapez !tumuhelp pour plus d\'infos.',
			'theme' => 'Le channel du monde de thaanis',
			'url' => '',
			'motd' => '',
			'banlevel' => 100,
			'chmodelevel' => 300,
			'bantype' => 4,
			'limit_inc' => 0,
			'limit_min' => 0,
			'bantime' => 32767
		),
		array(
			'id' => 6,
			'channel' => '#',
			'modified' => '0000-00-00 00:00:00',
			'created' => '2003-12-21 21:27:20',
			'flag' => 0,
			'defmodes' => 'nts',
			'deftopic' => 'Si vous êtes arrivé(e) ici directement via une page web, veuillez le signaler sur #aide ou #IRCube . Bon chat :)',
			'welcome' => 'Si vous êtes arrivé(e) ici directement via une page web, veuillez le signaler sur #aide ou #jeux.fr. Bon chat :)',
			'theme' => 'Erreur Applet.',
			'url' => '',
			'motd' => '',
			'banlevel' => 300,
			'chmodelevel' => 300,
			'bantype' => 1,
			'limit_inc' => 0,
			'limit_min' => 0,
			'bantime' => 0
		),
		array(
			'id' => 8,
			'channel' => '#leplat',
			'modified' => '0000-00-00 00:00:00',
			'created' => '0000-00-00 00:00:00',
			'flag' => 64,
			'defmodes' => 'ntscC',
			'deftopic' => '15x7x1x TIC-Entraide 7x Le canal des étudiants de la fac virtuelle de Limoges 1x7x15x',
			'welcome' => '',
			'theme' => 'Adminreg',
			'url' => 'http://www-tic.unilim.fr',
			'motd' => '',
			'banlevel' => 100,
			'chmodelevel' => 0,
			'bantype' => 4,
			'limit_inc' => 3,
			'limit_min' => 3,
			'bantime' => 600
		),
		array(
			'id' => 10,
			'channel' => '#Zik\'o\'Sport',
			'modified' => '0000-00-00 00:00:00',
			'created' => '2006-02-02 23:22:21',
			'flag' => 516,
			'defmodes' => 'ntk bla',
			'deftopic' => '12ZIKOSPORT.ORG 1- 14Bienvenue sur le salon de Zik\'o\'Sport 1- 12www.zikosport.org',
			'welcome' => '[21:03] 01(dd3201): moi je veux le slip de Ben !!',
			'theme' => 'Salon officiel de la WebRadio Zik\'o\'Sport www.zikosport.org',
			'url' => 'www.zikosport.org',
			'motd' => 'Zik\'o\'Sport --> Music & Sport !!',
			'banlevel' => 200,
			'chmodelevel' => 300,
			'bantype' => 4,
			'limit_inc' => 4,
			'limit_min' => 2,
			'bantime' => 32767
		),
	);
}
?>