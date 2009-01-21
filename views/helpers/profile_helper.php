<?php 
class ProfileHelperHelper extends AppHelper  
{  
    var $helpers = array('Html');

	function isLoggedIn($UserProfile=array()) {
		return !empty($UserProfile);
	}

    function link($title, $UserProfile, $htmlAttributes = array())  
    {
        if(empty($UserProfile['username'])) {
			return __('Invité', true);
		}
		if($UserProfile['active'] == 1 && $UserProfile['user_id'] != 0) { /* Returns link to profile */
			return $this->Html->link(($title === null) ? $UserProfile['username'] : $title, array('controller' => 'user_profiles', 'action' => 'view', $UserProfile['username']), $htmlAttributes);
		}
		return $UserProfile['username'];
    }  
}
?>