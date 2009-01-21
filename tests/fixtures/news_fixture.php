<?php 
/* SVN FILE: $Id$ */
/* News Fixture generated on: 2008-09-26 00:09:57 : 1222382997*/

class NewsFixture extends CakeTestFixture {
	var $name = 'News';
	var $table = 'news';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'newstype_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
			'title' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
			'content' => array('type'=>'text', 'null' => false, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
			'indexes' => array('0' => array())
			);
	var $records = array(array(
			'id'  => 1,
			'newstype_id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
									phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,
									vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,
									feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
									Orci aliquet, in lorem et velit maecenas luctus, wisi nulla at, mauris nam ut a, lorem et et elit eu.
									Sed dui facilisi, adipiscing mollis lacus congue integer, faucibus consectetuer eros amet sit sit,
									magna dolor posuere. Placeat et, ac occaecat rutrum ante ut fusce. Sit velit sit porttitor non enim purus,
									id semper consectetuer justo enim, nulla etiam quis justo condimentum vel, malesuada ligula arcu. Nisl neque,
									ligula cras suscipit nunc eget, et tellus in varius urna odio est. Fuga urna dis metus euismod laoreet orci,
									litora luctus suspendisse sed id luctus ut. Pede volutpat quam vitae, ut ornare wisi. Velit dis tincidunt,
									pede vel eleifend nec curabitur dui pellentesque, volutpat taciti aliquet vivamus viverra, eget tellus ut
									feugiat lacinia mauris sed, lacinia et felis.',
			'created'  => '2008-09-26 00:49:57',
			'modified'  => '2008-09-26 00:49:57',
			'user_id'  => 1
			));
}
?>