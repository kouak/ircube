<?php
class Comment extends AppModel {
	var $name = 'Comment';
	var $actsAs = array(
		'Containable',
		'Polymorphic',
	);
	
	var $belongsTo = array(
		'Author' => array('className' => 'UserProfile', /* Comment author */
						'foreignKey' => 'author_id',
						'conditions' => '',
						'fields' => '',
						'order' => ''
		),
		'News' => array('className' => 'News',
						'foreignKey' => 'model_id',
						'conditions' => array('Comment.model' => 'News'),
						'fields' => '',
						'dependant' => true,
						'counterCache' => true, /* Cache newscount */
						'counterScope' => array('Comment.status' => 1, 'Comment.model' => 'News')
		),
		'UserProfile' => array(
			'className' => 'UserProfile',
			'foreignKey' => 'model_id',
			'conditions' => array('Comment.model' => 'UserProfile'),
			'fields' => '',
			'dependant' => true,
			'counterCache' => true, /* Cache commentcount */
			'counterScope' => array('Comment.status' => 1, 'Comment.model' => 'UserProfile')
		),
	);
	
	var $validate = array(
		'id' => array(
			'dontExist' => array(
				'rule' => 'validateDontExist', /* If save() comes from edit form, do not accept if does not exist */
				),
			),
		'model_id' => array(
			'notEmpty' => array(
				'rule' => 'numeric', /* We want a numeric newstype */
				'message' => 'Wrong news_id',
				'required' => true,
				),
			),
		'model' => array(
			'notEmpty' => array(
				'rule' => 'validateModelAssociated', /* We want a numeric newstype */
				'message' => 'Wrong model',
				'required' => true,
				),
			),
		'author_id' => array(
			'notEmpty' => array(
				'rule' => 'numeric', /* We want a numeric author */
				'message' => 'Wrong author_id',
				'required' => true,
				),
			 'parentExists' => array(
				'rule' => 'validateParentExists',
				'message' => 'Cet auteur n\'existe pas', /* Should never happen */
				),
			),
		'content' => array(
			'notEmpty' => array(
				'rule' => 'validateNotBlank',
				'message' => 'Impossible d\'ajouter un commentaire vide !',
				'required' => true
				),
			),
	);
	
	function validateModelAssociated($data) {
		$model = current($data);
		if(!empty($this->belongsTo)) {
			foreach($this->belongsTo as $assoc => $val) {
				if(isset($val['className'])) {
					if($val['className'] == $model) {
						return true;
					}
				} else {
					if($assoc == $model) {
						return true;
					}
				}
			}
		}
		return false;
	}
	
	function publish($id) {
		return $this->save(array('Comment' => array('id' => $id, 'status' => 1)), true, array('id', 'published'));
	}

	function unpublish($id) {
		return $this->save(array('Comment' => array('id' => $id, 'status' => 0)), true, array('id', 'published'));
	}
	
	function updateCache()
	{
		/* Not working */
		foreach($this->belongsTo as $model => $options) {
			if(isset($options['counterCache']) && $options['counterCache'] == true) {
				$this->{$model}->updateCounterCache();
			}
		}
	}
}