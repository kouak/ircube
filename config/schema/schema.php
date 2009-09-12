<?php 
/* SVN FILE: $Id$ */
/* Ircube schema generated on: 2009-09-12 02:09:07 : 1252714027*/
class IrcubeSchema extends CakeSchema {
	var $name = 'Ircube';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $accesses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'flag' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'lastseen' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'channel_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'channel_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'user_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'level' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'info' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'chan_id' => array('column' => 'channel_id', 'unique' => 0))
	);
	var $acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $aros = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $aros_acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'aro_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'aco_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'_create' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_read' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_update' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_delete' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ARO_ACO_KEY' => array('column' => array('aro_id', 'aco_id'), 'unique' => 1))
	);
	var $channel_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'channel_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'description' => array('type' => 'binary', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $channels = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'channel' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'created' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
		'flag' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'defmodes' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80),
		'deftopic' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'welcome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'theme' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80),
		'url' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80),
		'motd' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'banlevel' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6),
		'chmodelevel' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'bantype' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'limit_inc' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'limit_min' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'bantime' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $channels_user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'channel_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'user_profile_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'channel_id' => array('column' => array('channel_id', 'user_profile_id'), 'unique' => 0))
	);
	var $datas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'flag' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'expire' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'sender' => array('type' => 'string', 'null' => false, 'length' => 30),
		'object_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'raison' => array('type' => 'string', 'null' => false, 'length' => 300),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $memos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'flag' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'sender' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'content' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $news = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'newstype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'permalink' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'content' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'user_profile_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'news_comment_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'published' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $news_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'user_profile_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'news_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'content' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'news_id' => array('column' => 'news_id', 'unique' => 0))
	);
	var $news_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'titre' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'inurl' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'classe' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $quotes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'author_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'channel' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'titre' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'texte' => array('type' => 'binary', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_profile_id' => array('column' => 'author_id', 'unique' => 0))
	);
	var $user_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $user_pictures = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_profile_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'filename' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'is_avatar' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_profile_id' => array('column' => 'user_profile_id', 'unique' => 0))
	);
	var $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'synched' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 300),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'unique'),
		'user_group_id' => array('type' => 'integer', 'null' => false, 'default' => '2', 'key' => 'index'),
		'avatar_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'mail' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'lastseen' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'birthday' => array('type' => 'date', 'null' => false, 'default' => '0000-00-00'),
		'sex' => array('type' => 'string', 'null' => false, 'default' => 'u', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 1), 'user_group_id' => array('column' => 'user_group_id', 'unique' => 0))
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_group_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'level' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 6),
		'flag' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'lastseen' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'mail' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
		'lang' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 15),
		'lastlogin' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>