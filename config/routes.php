<?php
/* SVN FILE: $Id: routes.php 7296 2008-06-27 09:09:03Z gwoo $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app.config
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 7296 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2008-06-27 02:09:03 -0700 (Fri, 27 Jun 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.thtml)...
 */
	Router::parseExtensions('rss', 'json', 'xml');
	
	Router::connect('/', array('controller' => 'home', 'action' => 'index'));
	Router::connect('/statistiques', array('controller' => 'pages', 'action' => 'display', 'statistiques'));
	
	Router::connect(
	    // E.g. /actualites/3-CakePHP_Rocks
	    '/actualites/:id-:slug',
	    array('controller' => 'news', 'action' => 'view'),
	    array(
	        // news_controller.php method view($id, $slug)
	        'pass' => array('id', 'slug'),
	        'id' => '[0-9]+'
	    )
	); 
	Router::connect('/actualites', array('controller' => 'news', 'action' => 'index'));
	Router::connect('/actualites/*', array('controller' => 'news', 'action' => 'index'));
	Router::connect(
	    '/actualites/:cat/*',
	    array('controller' => 'news', 'action' => 'index'),
	    array(
			'pass' => array('cat'),
	    )
	);
	
	Router::connect('/news/add', array('controller' => 'news', 'action' => 'edit'));
	
	//Router::connect('/actualites/getNewsByMonth/*', array('controller' => 'news', 'action' => 'getNewsByMonth'));
	
	
	Router::connect('/trombinoscope', array('controller' => 'user_profiles', 'action' => 'index'));
	Router::connect('/trombinoscope/:filter', array('controller' => 'user_profiles', 'action' => 'index'), array('pass' => array('filter')));
	Router::connect('/viewgallery/:username', array('controller' => 'user_pictures', 'action' => 'gallery'), array('pass' => array('username')));
	Router::connect('/viewprofile/:username', array('controller' => 'user_profiles', 'action' => 'view'), array('pass' => array('username')));
	Router::connect('/editprofile', array('controller' => 'user_profiles', 'action' => 'editprofile'));
	Router::connect('/dashboard', array('controller' => 'user_profiles', 'action' => 'dashboard'));
	
	Router::connect('/avatarify/:id', array('controller' => 'user_pictures', 'action' => 'avatarify'), array('pass' => array('id')));
	
	/* Admin routing */
	Router::connect('/login', array('controller' => 'user_profiles', 'action' => 'login'));
	Router::connect('/logout', array('controller' => 'user_profiles', 'action' => 'logout'));
	
	Router::connect('/admin', array('controller' => 'news', 'action' => 'index', 'admin' => true)); 
	
	/* Channel Profiles */
	Router::connect('/viewchannel/:channel', array('controller' => 'channel_profiles', 'action' => 'view'), array('pass' => array('channel')));
	Router::connect('/channel/createprofile/:channel', array('controller' => 'channel_profiles', 'action' => 'create'), array('pass' => array('channel')));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
/**
 * Then we connect url '/test' to our test controller. This is helpful in
 * developement.
 */
	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
?>