<?php
class Image extends AppModel {
    var $name = 'Image';
    var $actsAs = array(
        'MeioUpload' => array('filename')
    );
	var $belongsTo = array(
		'UserProfile'
	);
}
?>