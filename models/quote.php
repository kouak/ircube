<?php
class Quote extends AppModel {

	var $name = 'Quote';
	
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Author' => array(
			'className' => 'UserProfile',
			'foreignKey' => 'author_id',
		),
	);
	
	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'validateNotBlank',
				'message' => 'Le titre est obligatoire',
				'required' => true,
			),
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'Le titre doit faire 50 caractères au maximum'
			),
		),
		'content' => array(
			'notEmpty' => array(
				'rule' => 'validateNotBlank',
				'message' => 'Impossible d\'ajouter une news vide !',
				'required' => true
				),
			'maxLines' => array(
				'rule' => array('validateMaxLines', 12),
				'message' => 'Votre quote doit faire 12 lignes au maximum',
			),
				
		),
	);

}
?>