<?php
/* IRCube configuration file */

/* Comments configuration */

	Configure::write('Comments.default', array(
		'limit' => 5,
		'order' => array('Comment.created' => 'desc'), /* New comments up */
		)
	);
	
	Configure::write('Comments.UserProfile', array(
		'limit' => 3,
		'order' => array('Comment.created' => 'desc'),
		)
	);

?>