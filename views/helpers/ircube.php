<?php
class IrcubeHelper extends AppHelper {


	var $helpers = array('Html');
	
	var $boxDefaults = array(
		'header' => 'h1', /* false, h1, h2, h3 */
		'color' => '', /* Blue, orange, green */
		'span' => '', /* blueprint class */
		'id' => false, /* maindiv id */
	);
	
	var $__boxHasTitle = false;
	
	var $__boxCurrent = array();
	
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
	
	function startBox($options = array()) {
		$this->__boxCurrent = array_merge($this->boxDefaults, $options);
		$this->__boxHasTitle = false;
		echo '<div';
		if($this->__boxCurrent['id'] != false) { 
			echo ' id="' . $this->__boxCurrent['id'] . '"'; 
		} 
		echo ' class="';
		echo $this->__boxCurrent['span'];
		echo ' ircube-box">' . "\n";
		return;
	}
	
	function boxTitle($content = null) {
		if($content == null) {
			return;
		}
		$this->__boxHasTitle = true;
		echo '<' . $this->__boxCurrent['header'] . ' class="' . $this->__boxCurrent['color'] . '">' . "\n";
		echo '	' . $content . "\n";
		echo '</' . $this->__boxCurrent['header'] . ">\n";
		return;
	}
	
	function startBoxContent() {
		echo '	<div class="box ' . $this->__boxCurrent['color'];
		if($this->__boxHasTitle === false) {
			echo ' noheader';
		}
		echo '">' . "\n";
	}
	
	function endBox() {
		echo '	</div>' .
			'</div>';
		$this->__boxCurrent = array();
		$this->__boxHasTitle = false;
	}
}


?>