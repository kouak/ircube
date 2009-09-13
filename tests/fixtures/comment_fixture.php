<?php
/* Comment Fixture generated on: 2009-09-13 15:09:39 : 1252848219 */
class CommentFixture extends CakeTestFixture {
	var $name = 'Comment';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'status' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'author_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'model' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'model_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'content' => array('type'=>'text', 'type' => 'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'news_id' => array('column' => 'model_id', 'unique' => 0))
	);

	var $records = array(
		array(
			'id' => 7,
			'status' => 1,
			'created' => '2009-06-18 14:54:15',
			'modified' => '2009-06-18 19:55:51',
			'author_id' => 1,
			'model' => 'UserProfile',
			'model_id' => 1,
			'content' => 'pouet pouet userprofile'
		),
		array(
			'id' => 8,
			'status' => 1,
			'created' => '2009-06-18 14:55:57',
			'modified' => '2009-06-18 19:55:49',
			'author_id' => 1,
			'model' => 'News',
			'model_id' => 225,
			'content' => 'pouet pouet'
		),
		array(
			'id' => 9,
			'status' => 1,
			'created' => '2009-06-18 14:56:09',
			'modified' => '2009-06-18 19:55:48',
			'author_id' => 1,
			'model' => 'News',
			'model_id' => 225,
			'content' => 'pouet pouet'
		),
	);
}
?>