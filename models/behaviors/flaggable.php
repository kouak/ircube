<?php  
/** 
 * Flaggable Behavior class file. 
 * Replaces a flag field with a readable string
 * Remaps original flag integer to a different field called 'int_flag'
 * 
 */

class FlaggableBehavior extends ModelBehavior 
{
	
	/* This array contains settings */
	var $__settings = array();
	
	/** 
	 * Settings can be set with the following: 
	 * 
	 * flags					Array full of flags. Exemple array('SUSPEND', array('name' => 'POKACCESS', 'explicit' => 'Access(Accept)', 'hidden' => false) by ascending bits
	 * 
	 * flag_field				flag field to process
	 *                 
	 * int_flag_field 			field containing raw flag integer
	 * 
	 * int_flag_field_enabled	Enable raw flag field
	 *
	 * show_hidden				Set to true, will show all flags, hidden or not (see methods showHiddenFlags and hideHiddenFlags)             
	 *  
	 */     
    var $__defaults = array( 
        'flags' => array(),
        'flag_field' => 'flag',
        'int_flag_field' => 'int_flag',
        'int_flag_field_enabled' => true,
		'show_hidden' => false,
    );

	
	var $showHidden;
	
	var $conditions;


	function setup(&$Model, $settings = array()) 
	{
		/* Let's process $settings['flags'] */
		$f = array();
		$i = 0;
		foreach($settings['flags'] as $key => $value) {
			$f_value = pow(2, $i); /* Calculate default flag value */
			if(!is_array($value)) { /* Flag name only, add default values */
				$f[$i] = array('name' => $value, 'explicit' => $value, 'hidden' => false, 'value' => $f_value);
			}
			else {
				if(!isset($value['name'])) { /* This flag has no name, skip it */
					debug('Invalid flag : ' . $key);
					debug($value);
					$i++;
					continue;
				}
				if(isset($value['value'])) { /* We assume that if one value is set, then all values are set */
					$f_index = $this->__flag2index($value['value']);
					if(isset($f[$f_index])) {
						debug('Flag already set : ' . $key);
						debug($value);
						$i++;
						continue;
					}
					$f[$f_index] = am(array('explicit' => $value['name'], 'hidden' => false), $value);
				}
				else { /* We don't check for duplicates here */
					$f[$i] = am(array('explicit' => $value['name'], 'hidden' => false, 'value' => $f_value), $value);
				}
			}
			$i++;
		}
		$settings['flags'] = $f;
        $options = am($this->__defaults, $settings);
		$this->showHidden[$Model->name] = $options['show_hidden'];
		$this->conditions[$Model->name] = array();
        $this->__settings[$Model->name] = $options;
	}
	
	/* Converts a flag to array index (e.g __flag2index(0x8) should return 3) */
	
	function flag2index(&$Model, $f) {
		/* Add some validation here */
		return intval(log($f, 2));
	}
	
	function __flag2index($f) {
		return $this->flag2index($this, $f);
	}
	
	/* Reciprocal function */
	
	function index2flag(&$Model, $index) {
		/* Add validation */
		return intval(pow(2, $index));
	}
	
	function __index2flag($index) {
		return $this->index2flag($this, $index);
	}
	
	/* Usage : $this->Model->hasAllFlags($data, array('FLAG_NAME1', 'FLAG_NAME2'));
	 * Check if Model data has all specified flags
	 */
	
	function hasAllFlags(&$Model, $data, $flags) {
		if (empty($data) || empty($flags)) {
			debug('hasFlags : wrong arguments');
			return false;
		}
		if(!isset($data[$Model->name][$this->__settings[$Model->name]['int_flag_field']]) && !is_numeric($data[$Model->name][$this->__settings[$Model->name]['flag_field']])) {
			debug('Unable to find flag integer');
			return false;
		}
		if(isset($data[$Model->name][$this->__settings[$Model->name]['int_flag_field']])) {
			$int_flag = $data[$Model->name][$this->__settings[$Model->name]['int_flag_field']];
		}
		else {
			$int_flag = $data[$Model->name][$this->__settings[$Model->name]['flag_field']];
		}
		
		if(is_string($flags)) {
			$flags = array($flags);
		}
		
		foreach($flags as $k => $v) {
			if(!($int_flag & $this->__findFlagByName($this->__settings[$Model->name]['flags'], $v))) { /* Found a flag which is not set, return false */
				return false;
			}
		}
		/* Loop is successful, we have all flags */
		return true;
	}
	
	/* Usage : $this->Model->hasOneOfFlags($data, array('FLAG_NAME1', 'FLAG_NAME2'));
	 * Check if Model data has one of the specified flags
	 */
	
	function hasOneOfFlags(&$Model, $data, $flags) {
		if (empty($data) || empty($flags)) {
			debug('hasFlags : wrong arguments');
			return false;
		}
		if(!isset($data[$Model->name][$this->__settings[$Model->name]['int_flag_field']]) && !is_numeric($data[$Model->name][$this->__settings[$Model->name]['flag_field']])) {
			debug('Unable to find flag integer');
			return false;
		}
		if(isset($data[$Model->name][$this->__settings[$Model->name]['int_flag_field']])) {
			$int_flag = $data[$Model->name][$this->__settings[$Model->name]['int_flag_field']];
		}
		else {
			$int_flag = $data[$Model->name][$this->__settings[$Model->name]['flag_field']];
		}
		
		if($int_flag & $this->__buildBitMask($this->__settings[$Model->name]['flags'], $flags)) {
			return true;
		}
		return false;
	}
	
	/* Takes an array of selected flags (e.g array('FLAG_NAME1', 'FLAG_NAME2')) as argument and build a bitwise mask (e.g (0x2|0x4)) out of $flags base flags array */
	function __buildBitMask($flags, $selected)
	{
		if(!is_array($flags) || empty($flags)){
			return 0;
		}
		if(is_string($selected)) {
			$selected = array($selected);
		}
		if(!is_array($selected) || empty($selected)){
			return 0;
		}
		$mask = 0;
		foreach($selected as $k => $v) {
			$mask |= $this->__findFlagByName($flags, $v);
		}
		return $mask;
	}
	
	/* Usage : $this->__findFlagByName($this->__settings[$Model->name]['flags'], 'FLAG_NAME1');
	 * Returns integer value of the flag
	 * Returns 0 if flag not found, with debug
	 */
	function __findFlagByName($flags, $name) {
		if(!is_array($flags) || strlen($name) == 0) {
			debug('__findFlagByName : wrong arguments');
			return 0;
		}
		foreach ($flags as $v) { /* Loop flag array */
			if($v['name'] == $name) { /* Flag found */
				return $v['value'];
			}
		}
		debug('__findFlagByName : flag ' . $name . ' not found');
		return 0;
	}
	
	/* show hidden flags for the next find */
	
	function showHiddenFlags(&$Model)
	{
		$this->showHidden[$Model->name] = true;
	}
	
	/* hide hidden flags for the next find */
	
	function hideHiddenFlags(&$Model)
	{
		$this->showHidden[$Model->name] = false;
	}
	
	function filterFlags(&$Model, $selected=array())
	{
		if(!isset($selected) || empty($selected))
		{
			unset($this->conditions[$Model->name]);
			return false; /* Remove conditions */
		}
		$filter = $this->__buildBitMask($this->__settings[$Model->name]['flags'], $selected);
		if($filter === 0)
		{
			debug('filterFlags : Warning, empty filter');
		}
		$this->conditions[$Model->name] = $Model->name . '.' . $this->__settings[$Model->name]['flag_field'] . ' & ' . $filter;
		return $this->conditions[$Model->name];
	}
	
	function __processIntFlag($m, $data)
	{
		if (isset($this->__settings[$m]) && isset($data[$this->__settings[$m]['flag_field']])) { /* This model is flaggable */
			if($this->__settings[$m]['int_flag_field_enabled'] === true) { /* We requested a raw flag field, init field*/
				$data[$this->__settings[$m]['int_flag_field']] = 0;
			}
			$flag = $data[$this->__settings[$m]['flag_field']];
            $data[$this->__settings[$m]['flag_field']] = ''; /* String init */
			$firstNoSpace = true;
			foreach($this->__settings[$m]['flags'] as $k => $v) /* Get flags list */
			{
				if($this->showHidden[$m] === false && $v['hidden'] === true) { /* If this flag is hidden, skip it */
					continue;
				}
				if($flag & $this->__index2flag($k)) { /* Flag is active */
					if($this->__settings[$m]['int_flag_field_enabled'] === true) { /* We requested a raw flag field */
						$data[$this->__settings[$m]['int_flag_field']] |= $this->__index2flag($k); /* Add current flag */
					}
					$data[$this->__settings[$m]['flag_field']] .= (($firstNoSpace === true) ? '' : ' ') . $v['explicit'];
					$firstNoSpace = false;
				}
			}
        }
		return $data;
	}
	
	function afterFind(&$Model, $results, $primary)
	{
		
		if(!isset($results[0])) {
			/* We have a single result */
			$results = $this->__processIntFlag($Model->name, $results);
		}
		else {
			/* We have a set of results */
			foreach ($results as $key => $val) { /* Loop results */
				foreach($val as $m => $data) { /* Loop models */
					$results[$key][$m] = $this->__processIntFlag($m, $results[$key][$m]);
				}
		    }
		}
		/* Reset showHidden state */
		$this->showHidden[$Model->name] = $this->__settings[$Model->name]['show_hidden'];
		return $results;
	}
	
	
	function beforeFind(&$Model, $queryData)
	{
		if(!empty($this->conditions[$Model->name])) {
			$queryData['conditions'] = am($queryData['conditions'], $this->conditions[$Model->name]);
		}
		return $queryData;
	}
	
	
}