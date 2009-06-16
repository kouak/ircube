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

}


?>