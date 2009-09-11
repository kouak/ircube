<?php
class IrcubeHelper extends AppHelper {


	var $helpers = array('Html');
	
	
	/**
	 * Wrapper for $html->image
	 * Used for galleries
	 *
	 */
	function image($url, $options = array()) {
		return $this->thumbnailWrap($this->Html->image($url, $options));
	}

	function thumbnailWrap($str, $class='thumbnail') {
		return '<div class="'.$class.'"><span>' . $str . '</span></div>';
	}
	
	function thumbnailCenterWrap($str) {
		return $this->thumbnailWrap($str, 'thumbnail-center');
	}
	
	function channelProfileUrl($channel) {
		if($channel[0] == '#') {
			$channel = substr($channel, 1);
		}
		return Router::url(array('controller' => 'channel_profiles', 'action' => 'view', 'channel' => $channel));
		
	}

}


?>