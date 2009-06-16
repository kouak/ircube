<?php
class News extends AppModel {
	var $name = 'News';
	var $actsAs = array('Containable');
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'NewsType' => array('className' => 'NewsType',
								'foreignKey' => 'newstype_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Author' => array('className' => 'UserProfile',
								'foreignKey' => 'user_profile_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	
	var $hasMany = array(
			'NewsComment' => array('className' => 'NewsComment',
									'foreignKey' => 'news_id',
									'conditions' => '',
									'fields' => '',
									'order' => 'NewsComment.created DESC',
									'dependant' => true /* Delete comments when we delete a news */
									)
						);
						
	/* Errors messages are handled in here thanks to the fix in app_model */
	var $validate = array(
						'id' => array(
							'dontExist' => array(
								'rule' => 'validateDontExist', /* If save() comes from edit form, do not accept if does not exist */
								),
							),
						'newstype_id' => array(
							'notEmpty' => array(
								'rule' => 'numeric', /* We want a numeric newstype */
								'message' => 'Wrong newstype',
								'required' => true,
								),
							 'parentExists' => array(
								'rule' => 'validateParentExists',
								'message' => 'Cette catégorie n\'existe pas',
								),	
							),
						'title' => array(
							'notEmpty' => array(
								'rule' => 'validateNotBlank',
								'message' => 'Le titre est obligatoire',
								'required' => true
								),
							'maxLength' => array(
								'rule' => array('maxLength', 50),
								'message' => 'Le titre doit faire 50 caractères maximum'
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

	function pretty_url($str)
	{
		return Inflector::slug($str);
	}
	
	function publish($id) {
		return $this->save(array('News' => array('id' => $id, 'published' => 1)), true, array('id', 'published'));
	}
	
	function unpublish($id) {
		return $this->save(array('News' => array('id' => $id, 'published' => 0)), true, array('id', 'published'));
	}
	
	function beforeSave()
	{
		if(isset($this->data['News']['title']) && !isset($this->data['News']['permalink'])) {
			$this->data['News']['permalink'] = $this->pretty_url($this->data['News']['title']);
			return true;
		}
		return true;
	}
	
	
	/* Create slugs for news without it */
	function createAllPermalinks() {
		$this->contain(array());
		$news = $this->find('all', array('fields' => array('id', 'title', 'permalink'), 'conditions' => array('News.permalink' => '')));
		$i = 0;
		foreach($news as $n) {
			if($this->__createPermalink($n['News'])) {
				$i++;
			}
			else {
				return false;
			}
		}
		return $i;
	}
	
	function __createPermalink($news) {
		if(isset($news['id']) && isset($news['title'])) {
			return $this->save(array('News' => array('id' => $news['id'], 'permalink' => $this->pretty_url($news['title']))), false);
		}
		return false;
	}
	
	function afterFind($r, $primary=false) {
		foreach($r as &$n) {
			/* Autofill permalink field in the DB */
			if(isset($n['News']['id']) && isset($n['News']['title']) && $n['News']['permalink'] == '') { /* No permalink yet */
				$this->__createPermalink($n['News']);
				$n['News']['permalink'] = $this->pretty_url($n['News']['title']);
			}
		}
		return $r;
	}
}
?>