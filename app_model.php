<?php
class AppModel extends Model {
	
	var $recursive = -1;

	/* Polymorphic + Comment */
	function __construct($id = false, $table = null, $ds = null) { 
		parent::__construct($id, $table, $ds);
		if(isset($this->Polymorphic)) {
			debug('caca');
		}
		if (isset($this->hasMany) && isset($this->hasMany['Comment'])) { 
			$this->hasMany['Comment']['conditions']['Comment.model'] = $this->name; 
			$this->hasMany['Comment']['foreignKey'] = 'model_id'; 
		} 
	}

	/* Custom find types (pseudocoder.com) */
	function find($type, $options = array()) {
		$method = null;
		if(is_string($type)) {
			$method = sprintf('__find%s', Inflector::camelize($type));
		}

		if($method && method_exists($this, $method)) {
			return $this->{$method}($options);
		} else {
			$args = func_get_args();
			return call_user_func_array(array('parent', 'find'), $args);
		}
	}
	
	
	function invalidate($field, $value = null) 
	{
		if (!is_array($this->validationErrors)) {
			$this->validationErrors = array();
		}
		if(empty($value)) {
			$value = true;
		}
		$this->validationErrors[$field] = __($value, true);
	}
	
	
	public function validateNotBlank($value) 
	{
	    if (!isset($value) || trim($value[key($value)]) === '') {
	        return false;
	    } else {
	        return true;
	    }
	}
	
	/*
	 * We have a foreign_key field, we want to check if a parent record exists in the database 
	 * Note : works only with belongsTo
	 * TODO : Same with HABTM relationship
	 */
	
	public function validateParentExists($data) 
	{
		$field = key($data);
		$value = current($data); /* We assume this is an integer value */

		if (!empty($this->belongsTo))
		{
			foreach ($this->belongsTo as $m => $d) 
			{
				if($field == $d['foreignKey'])
				{
					break;
				}
			}
			$this->$m->id = $value;
			return $this->$m->exists();
		}
		return false;
	}
	/*
	 * Returns false if a record exists in the database
	 * Useful if we don't want to update deleted records
	 *
	 */
	
	public function validateDontExist($data)
	{
		/* Empty id means create, we want to save the record return true */
		if(empty($this->id))
			return true;
		if(!$this->exists()) /* This record does not exist although it's an update, return false */
			return false;
		
		return true;
	}
	
	function validateMaxLines($data, $lines = 12) {
		if (sizeof(explode("\n", current($data))) > 12) {
			return false;
		}
		return true;

	}
	
	
	public function equalsField($data, $field = '') {
		return (isset($this->data[$this->name][$field]) && (current($data) == $this->data[$this->name][$field]));
	}
	

}
?>