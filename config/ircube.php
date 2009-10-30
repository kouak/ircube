<?php
/* IRCube configuration file */

/* Comments configuration */

Configure::write('Comments.default', array(
	'limit' => 5,
	'order' => array('Comment.created' => 'desc'), /* New comments up */
	)
);

Configure::write('Comments.News', array(
	//'limit' => 3,
	'order' => array('Comment.created' => 'asc'), /* New comments at the end, but show last page */
	'page' => 'last',
	)
);

Configure::write('Comments.UserProfile', array(
	//'limit' => 3,
	'order' => array('Comment.created' => 'desc'),
	)
);

/* UserPictures configuration */

/* See plugins/media configuration file */
Configure::write('UserPictures.defaultsize', 's');

Configure::write('UserPictures.maxpictures', 3);

?>