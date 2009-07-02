<?php
App::import('Helper', 'Form');
 
class UniFormHelper extends FormHelper
{
	var $_fieldsetOpen;
	
	function __construct() {
		$this->_fieldsetOpen = false;
		parent::__construct();
	}
	
	function divWrap($string) {
		return '<div class="ctrlHolder">' . $string . "</div>\n";
	}
	
	function input($fieldName, $options = array()) {
		return $this->divWrap(parent::input($fieldName, $options));
	}
	
	/* Add fieldset to options
	 * set 'fieldset' to false to remove
	 * see function fieldset
	 */
	
	function create($model = null, $options = array()) {
		$options = array_merge(array('fieldset' => true), $options);
		if($options['fieldset'] !== false) {
			$append = $this->fieldset($options['fieldset']);
		}
		if(isset($options['class'])) {
			$options['class'] .= ' uniForm';
		}
		else {
			$options['class'] = 'uniForm';
		}
		unset($options['fieldset']);
		return parent::create($model, $options) . $append;
	}
	
	function end($options = null) {
		if($this->_fieldsetOpen === true) {
			return "</fieldset>\n" . parent::end($options);
		}
		return parent::end($options);
	}
	
	/*  Options :
	 * - 'blockLabels', if true, use class blockLabels, use class inlineLabels otherwise
	 * - 'legend', if set, display a legend
	 * Note : if $options is a string, use it as legend option
	 */
	
	function fieldset($options = array()) {
		$defaults = array(
			'blockLabels' => false,
			'legend' => false,
			);
		if(!is_array($options)) {
			if(is_string($options)) {
				$options = array('legend' => $options);
			}
			else {
				$options = array();
			}
		}
		$options = array_merge($defaults, $options);
		
		if($options['blockLabels'] === true) {
			$class = 'blockLabels';
		}
		else {
			$class = 'inlineLabels';
		}
		
		$r = '';
		
		if($this->_fieldsetOpen === true) {
			$r .= "</fieldset>\n";
		}
		
		$r .= '<fieldset class="'. $class . '">' . "\n";
		if($options['legend'] !== false) {
			$r .= '<legend>' . $options['legend'] . '</legend>' . "\n";
		}
		$this->_fieldsetOpen = true;
		
		return $r;
	}
}
?>