<?php
class AppModel extends Model {

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
		if(!$this->exists()) /* This record does not exist though it's an update, return false */
			return false;
		
		return true;
	}

}
?>