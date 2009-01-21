<?php 
/* SVN FILE: $Id$ */
/* Channel Fixture generated on: 2008-09-24 21:09:47 : 1222284227*/

class ChannelFixture extends CakeTestFixture {
	var $name = 'Channel';
	var $table = 'channels';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'channel' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 300),
			'flag' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 6),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'created' => array('type'=>'timestamp', 'null' => true, 'default' => NULL),
			'defmodes' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 300),
			'deftopic' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 600),
			'welcome' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 600),
			'description' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 600),
			'url' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 600),
			'motd' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 600),
			'banlevel' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 6),
			'chmodelevel' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 6),
			'bantype' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 6),
			'limit_inc' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 6),
			'limit_min' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 6),
			'bantime' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 6),
			'indexes' => array('0' => array())
			);
	var $records = array(array(
			'id'  => 1,
			'channel'  => 'Lorem ipsum dolor sit amet',
			'flag'  => 1,
			'modified'  => '2008-09-24 21:23:47',
			'created'  => '2008-09-24 21:23:47',
			'defmodes'  => 'Lorem ipsum dolor sit amet',
			'deftopic'  => 'Lorem ipsum dolor sit amet',
			'welcome'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet',
			'url'  => 'Lorem ipsum dolor sit amet',
			'motd'  => 'Lorem ipsum dolor sit amet',
			'banlevel'  => 1,
			'chmodelevel'  => 1,
			'bantype'  => 1,
			'limit_inc'  => 1,
			'limit_min'  => 1,
			'bantime'  => 1
			));
}
?>