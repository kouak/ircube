<?php  
/** 
 * ChildCount Behavior class file. 
 * 
 */

class ChildCountBehavior extends ModelBehavior 
{
	
	/* This array contains settings */
	var $__settings = array();
	
	/** 
	 * Settings can be set with the following: 
	 * 
	 * countchild_enabled		Enable child count (default false)
	 * 
	 * count_field_suffix		Count field suffix (User hasMany Post, count_field_suffix set to '_count' will populate $data['User']['post_count']          
	 *  
	 */     
    var $__defaults = array( 
        'countchild_enabled' => false,
        'count_field_suffix' => '_count',
    );

	function setup(&$Model, $settings = array()) 
	{
        $options = am($this->__defaults, $settings);
        $this->__settings[$Model->name] = $options;
	}
	
	
	/* Enables childCount for the next find */
	
	function childCount(&$Model)
	{
		$this->__settings[$Model->name]['countchild_enabled'] = true;
	}
	
	
	function afterFind(&$Model, $results, $primary)
	{
		
		
		if($this->__settings[$Model->name]['countchild_enabled'] === false)
		{
			return $results;
		}
		
		foreach ($results as $key => $val) { /* Loop results */
			if(!is_array($val)) {
				continue; /* Should never happen */
			}
			foreach ($val as $k => $v) /* Loop each result for models */
			{
				if($k == $Model->name) { /* This is the parent dataset to populate, so skip */
					continue;
				}
				if(empty($v)) {
					$results[$key][$Model->name][low($k) . $this->__settings[$Model->name]['count_field_suffix']] = 0;
				}
				elseif(!isset($v[0])) { /* HasOne relationship */
					$results[$key][$Model->name][low($k) . $this->__settings[$Model->name]['count_field_suffix']] = 1;
				}
				else { /* HasMany relationship */
					$results[$key][$Model->name][low($k) . $this->__settings[$Model->name]['count_field_suffix']] = count($v);
				}
				
			}
	    }
		$this->__settings[$Model->name]['countchild_enabled'] = false;
		return $results;
	}
	
	
}