<?php 
/* SVN FILE: $Id$ */
/* News Test cases generated on: 2008-09-26 00:09:57 : 1222382997*/
App::import('Model', 'News');

class TestNews extends News {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class NewsTestCase extends CakeTestCase {
	var $News = null;
	var $fixtures = array('app.news', 'app.newstype', 'app.user');

	function start() {
		parent::start();
		$this->News = new TestNews();
	}

	function testNewsInstance() {
		$this->assertTrue(is_a($this->News, 'News'));
	}

	function testNewsFind() {
		$results = $this->News->recursive = -1;
		$results = $this->News->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('News' => array(
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
		$this->assertEqual($results, $expected);
	}
}
?>