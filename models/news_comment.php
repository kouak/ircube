<?php
class NewsComment extends AppModel {
	var $name = 'NewsComment';
	var $actsAs = array('Containable');

	var $belongsTo = array(
			'Author' => array('className' => 'UserProfile', /* Comment author */
							'foreignKey' => 'user_profile_id',
							'conditions' => '',
							'fields' => '',
							'order' => ''
			),
			'News' => array('className' => 'News',
							'foreignKey' => 'news_id',
							'conditions' => '',
							'fields' => '',
							'dependant' => true,
							'counterCache' => true /* Cache newscount */
			), 
	);
	
	var $validate = array(
					'id' => array(
						'dontExist' => array(
							'rule' => 'validateDontExist', /* If save() comes from edit form, do not accept if does not exist */
							),
						),
					'news_id' => array(
						'notEmpty' => array(
							'rule' => 'numeric', /* We want a numeric newstype */
							'message' => 'Wrong news_id',
							'required' => true,
							),
						 'parentExists' => array(
							'rule' => 'validateParentExists',
							'message' => 'Cette news n\'existe pas',
							),	
						),
					'user_profile_id' => array(
						'notEmpty' => array(
							'rule' => 'numeric', /* We want a numeric newstype */
							'message' => 'Wrong user_id',
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
							'message' => 'Impossible d\'ajouter une news vide !',
							'required' => true
							),
						),
					);
	
	function updateCache()
	{
		$r = $this->find('all', array('recursive' => -1));
		foreach($r as $data)
		{
			$nc = & new NewsComment();
			$nc->data = $data;
			$nc->updateCounterCache();
			unset($nc);
		}
		return true;
	}
}