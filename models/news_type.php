<?php
class NewsType extends AppModel {
	var $name = 'NewsType';
	var $actsAs = array('Containable');
	
	var $displayField = 'titre';
	
	var $hasMany = array(
			'News' => array('className' => 'News',
									'foreignKey' => 'newstype_id',
									'conditions' => '',
									'fields' => '',
									)
						);
}
?>