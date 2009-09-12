<?php
/* NewsComment Fixture generated on: 2009-09-12 16:09:12 : 1252765872 */
class NewsCommentFixture extends CakeTestFixture {
	var $name = 'NewsComment';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'published' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'user_profile_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'news_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'content' => array('type'=>'text', 'type' => 'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'news_id' => array('column' => 'news_id', 'unique' => 0))
	);

	var $records = array(
		array(
			'id' => 7,
			'published' => 1,
			'created' => '2009-06-18 14:54:15',
			'modified' => '2009-06-18 19:55:51',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'pouet pouet'
		),
		array(
			'id' => 8,
			'published' => 1,
			'created' => '2009-06-18 14:55:57',
			'modified' => '2009-06-18 19:55:49',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'pouet pouet'
		),
		array(
			'id' => 9,
			'published' => 1,
			'created' => '2009-06-18 14:56:09',
			'modified' => '2009-06-18 19:55:48',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'pouet pouet'
		),
		array(
			'id' => 10,
			'published' => 1,
			'created' => '2009-06-18 14:56:42',
			'modified' => '2009-06-18 19:55:48',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'pouet pouet'
		),
		array(
			'id' => 11,
			'published' => 1,
			'created' => '2009-06-18 14:59:05',
			'modified' => '2009-06-18 18:58:17',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'pouet pouet'
		),
		array(
			'id' => 12,
			'published' => 1,
			'created' => '2009-06-18 15:27:35',
			'modified' => '2009-06-18 18:58:16',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'blabla'
		),
		array(
			'id' => 18,
			'published' => 1,
			'created' => '2009-06-19 01:44:52',
			'modified' => '2009-08-09 19:14:39',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'Ceci est un test !'
		),
		array(
			'id' => 20,
			'published' => 1,
			'created' => '2009-08-10 00:25:08',
			'modified' => '2009-08-10 21:57:48',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'Un essai de commentaire ....'
		),
		array(
			'id' => 21,
			'published' => 1,
			'created' => '2009-08-10 21:56:01',
			'modified' => '2009-08-10 21:57:49',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'Encore un test ...'
		),
		array(
			'id' => 22,
			'published' => 1,
			'created' => '2009-08-10 21:57:11',
			'modified' => '2009-08-10 21:57:50',
			'user_profile_id' => 1,
			'news_id' => 225,
			'content' => 'Blablabla'
		),
	);
}
?>