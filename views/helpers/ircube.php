<?php
class IrcubeHelper extends AppHelper {


	var $helpers = array('Html');
	
	var $boxDefaults = array(
		'header' => 'h1', /* false, h1, h2, h3 */
		'color' => '', /* Blue, orange, green */
		'span' => '', /* blueprint class */
		'style' => false, /* style="" */
		'id' => false, /* maindiv id */
	);
	
	var $__boxHasTitle = false;
	
	var $__boxCurrent = array();
	
	
	/* UserProfile part */
	
	function isLoggedIn($UserProfile=array()) {
		return !empty($UserProfile);
	}
	
	function avatar($UserProfile, $options = array()) {
		$defaults = array(
			'size' => 's',
		);
		$options = array_merge($defaults, $options);
		if(is_string($UserProfile)) {
			$username = $UserProfile;
		} elseif(isset($UserProfile['username'])) {
			$username = $UserProfile['username'];
		} elseif(isset($UserProfile['UserProfile']['username'])) {
			$username = $UserProfile['UserProfile']['username'];
		}
		return Router::url(array('controller' => 'user_pictures', 'action' => 'avatar', $options['size'], $username . '.jpg'));
	}

	function link($options = array(), $htmlAttributes = array()) {
		
		if(is_string($options)) {
			$options = array('UserProfile' => array('username' => $options));
		}
		
		$defaults = array('UserProfile' => array(), 'title' => null);
		$options = array_merge($defaults, $options);
		$UserProfile = $options['UserProfile'];
		
		if(empty($UserProfile['username'])) {
			if($options['title'] === null) {
				return __('Invité', true);
			} else {
				return $options['title'];
			}
		}
		if($options['title'] === null) {
			$options['title'] = $UserProfile['username'];
		}
		
		if(isset($UserProfile['active']) && isset($UserProfile['user_id']) && $UserProfile['active'] == 1 && $UserProfile['user_id'] != 0) { /* Returns link to profile */
			return $this->Html->link($options['title'], array('controller' => 'user_profiles', 'action' => 'view', $UserProfile['username']), $htmlAttributes);
		}
		return $options['title'];
    }
	
	/**
	 * Wrapper for $html->image
	 * Used for galleries
	 *
	 */
	function image($url, $options = array()) {
		return $this->thumbnailWrap($this->Html->image($url, $options));
	}

	function thumbnailWrap($str, $htmlAttributes = array()) {
		$defaults = array(
			'class' => 'thumbnail',
		);
		$htmlAttributes = array_merge($defaults, $htmlAttributes);
		$class = $htmlAttributes['class'];
		unset($htmlAttributes['class']);
		
		return $this->Html->div($class, '<span>' . $str . '</span>', $htmlAttributes, false);
	}
	
	function thumbnailCenterWrap($str, $htmlAttributes = array()) { /* We want it to be centered, add thumbnail-center class */
		$class = 'thumbnail-center';
		if(!empty($htmlAttributes['class'])) {
			$class .= ' '. $htmlAttributes['class'];
		}
		$htmlAttributes['class'] = $class;
		
		return $this->thumbnailWrap($str, $htmlAttributes);
	}
	
	function channelProfileUrl($channel) {
		if($channel[0] == '#') {
			$channel = substr($channel, 1);
		}
		return Router::url(array('controller' => 'channel_profiles', 'action' => 'view', 'channel' => $channel));
		
	}
	
	/* Box Helper */
	
	function startBox($options = array()) {
		$this->__boxCurrent = array_merge($this->boxDefaults, $options);
		$this->__boxHasTitle = false;
		$return = '<div';
		if($this->__boxCurrent['id'] != false) { 
			$return .= ' id="' . $this->__boxCurrent['id'] . '"'; 
		} 
		if($this->__boxCurrent['style'] !== false) {
			$return .= ' style="' . $this->__boxCurrent['style'] . '"';
		}
		$return .= ' class="';
		$return .= $this->__boxCurrent['span'];
		$return .= ' ircube-box">' . "\n";
		return $return;
	}
	
	function boxTitle($content = null) {
		if($content == null) {
			return;
		}
		$this->__boxHasTitle = true;
		$return = '<' . $this->__boxCurrent['header'] . ' class="' . $this->__boxCurrent['color'] . '">' . "\n";
		$return .= '	' . $content . "\n";
		$return .= '</' . $this->__boxCurrent['header'] . ">\n";
		return $return;
	}
	
	function startBoxContent() {
		$return = '	<div class="box ' . $this->__boxCurrent['color'];
		if($this->__boxHasTitle === false) {
			$return .= ' noheader';
		}
		$return .= '">' . "\n";
		return $return;
	}
	
	function endBox() {
		$return = '	</div>' .
			'</div>';
		$this->__boxCurrent = array();
		$this->__boxHasTitle = false;
		return $return;
	}
}


?>