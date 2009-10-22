<?php
/**
 * TODO Don't use me yet
 *
 * PHP versions 5
 *
 * Copyright (c) 2008, Andy Dawson
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright (c) 2008, Andy Dawson
 * @link          www.ad7six.com
 * @package       base
 * @subpackage    base.models.behaviors
 * @since         v 1.0
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * UploadBehavior class
 *
 * A behavior adding validation and automatic processing for file uploads, aswell as acting as a library
 * class for file manipulations
 * The design of the behavior is to store meta data for uploaded files in a database table (can just be a file
 * field in your products table, or a dedicated media table) although the behavior can be used with a
 * table-less model. Unmodified uploaded files are by default stored OUTSIDE the webroot. This allows the
 * application to use the original file as input to generate any different 'versions' that might be required.
 * and also to allow the application to protect and serve files
 * Assuming that generating versions will fail if the file type is not what is expected; this helps defend against
 * malicious intentions such as pishing
 *
 * Suggested setup would be:
 * app
 * 	controllers
 * 	models
 * 	views
 * 	uploads <- destination for pristine uploaded files
 * 		Post
 * 			PostId
 * 				uploadedFile.jpg
 * 				uploadedFile_small.jpg
 * 				uploadedFile.pdf
 * 				uploadedFile.zip
 *
 * Serving files via the media view.
 *
 *
 * @uses          AppBehavior
 * @package       base
 * @subpackage    base.models.behaviors
 */
class UploadBehavior extends ModelBehavior {

/**
 * name property
 *
 * @var string 'Upload'
 * @access public
 */
	var $name = 'Upload';

/**
 * errors property
 *
 * Array of (system-type) errors encountered when processing an upload
 *
 * @var array
 * @access public
 */
	var $errors = array();

/**
 * defaultSettings property
 *
 * For no behavior-enforced size limit, set allowedSize to '*'. This only takes effect if it is less than php's own
 * 	settings which this behavior cannot modify
 * dirFormat defines the path used to store the uploaded file. include $baseDir to store absolute directory paths
 * 	(not recommended)
 * fileFormat defines the filename for the uploaded file, can be a full path, or just the filename
 * versions define what other permutations of this file exist or should be created. if a callback is specified,
 * 	this will be run on uploaded/processed files to generate the different version. The default version points
 * 	only at a file type image
 *
 * @var array
 * @access protected
 */
	var $_defaultSettings = array(
		'dirField' => 'dir',
		'fileField' => 'filename',
		'extField' => 'ext',
		'checksumField' => 'checksum',
		'mustUploadFile' => false,
		'allowedMime' => '*',
		'allowedExt' => '*',
		'allowedSize' => '8',
		'allowedSizeUnits' => 'MB',
		'overwriteExisting' => true,
		'baseDir' => '{APP}uploads',
		'dirFormat' => '{$model}/{$foreign_key}',
		'fileFormat' => '{$filename}',
		'pathReplacements' => array(),
		'quarantinePath' => null,
	);

/**
 * behaviorMap property
 *
 * Map of which more specific upload behaviors exist
 * Used to automatically load the more specific behavior if a match is found based on the data
 *
 * @var array
 * @access private
 */
	var $__behaviorMap = array(
		'pdf' => array('extension' => 'pdf'),
		'archive' => array(
			'extension' => array('bz2', 'gz', 'tar', 'zip'),
			//'mime' => array('application/zip', 'application/x-tar', 'application/gzip')
		),
		'image' => array('mime' => 'image/*'),
		'movie' => array('extension' => array('swf', 'mp4', 'mov'))
	);

/**
 * setup method
 *
 * Initialize the component, setup validation rules/messages and check that the base directory is writable
 * If the base directory is not writable an error is triggered and the behavior is disabled
 * The quarantine path is set to a pseudo random folder path for storing temporary uploaded files.
 *
 * @param mixed $Model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$Model, $config = array()) {
		$this->settings[$Model->alias] = am($this->_defaultSettings, $config);
	}

/**
 * uploadErrors method
 *
 * Return the current error stack
 *
 * @return void
 * @access public
 */
	function uploadErrors(&$Model, $clear = false) {
		$return = array();
		foreach($Model->Behaviors->attached() as $behavior) {
			if (strpos($behavior, 'Upload') !== false) {
				$return = am($return, $Model->Behaviors->$behavior->errors);
				if ($clear) {
					$Model->Behaviors->$behavior->errors = array();
				}
			}
		}
		return $return;
	}

/**
 * absolutePath method
 *
 * Convenience method
 *
 * @see path
 * @param mixed $Model
 * @param mixed $id
 * @return void
 * @access public
 */
	function absolutePath(&$Model, $id = null) {
		if (!$id) {
			if (!empty($Model->data[$Model->alias][$Model->primaryKey])) {
				$id = $Model->data[$Model->alias][$Model->primaryKey];
			} elseif ($Model->id) {
				$id = $Model->id;
			}
		}
		if ($id === $Model->id && !isset($Model->data[$Model->alias]['original'])) {
			return $Model->data[$Model->alias]['original'];
		}
		if (!$id) {
			return false;
		}
		extract ($this->settings[$Model->alias]);
		if (empty($Model->data[$Model->alias][$fileField])) {
			$Model->data = $Model->findById($id);
		}
		$return = $baseDir . DS;
		if ($dirField && $Model->hasField($dirField)) {
			if (isset($Model->data[$Model->alias][$dirField])) {
				$return .= $Model->data[$Model->alias][$dirField];
			} else {
				$return .= $Model->field($dirField);
			}
		} else {
			$return .= $this->_replacePseudoConstants($Model, $dirFormat);
		}
		if ($fileField && isset($Model->data[$Model->alias][$fileField])) {
			if (is_string($Model->data[$Model->alias][$fileField])) {
				$return .= DS . $Model->data[$Model->alias][$fileField];
			} else {
				$return .= $Model->data[$Model->alias][$fileField]['name'];
			}
		} else {
			$return .= DS . $Model->field($fileField);
		}
		return $Model->data[$Model->alias]['original'] = $this->__normalizePaths($return);
	}

/**
 * afterSave method
 *
 * Clean up any temp files
 *
 * @param mixed $Model
 * @return void
 * @access public
 */
	function afterSave(&$Model) {
		$data = $Model->data[$Model->alias];
		if (isset($data['tempFile']) && $data['tempFile'] != $data['original'] && file_exists($data['original'])) {
			$this->__unlink($data['tempFile']);
			$dir = dirname($data['tempFile']);
			$Dir = new Folder($dir);
			if ($Dir->path && $Dir->read() == array(array(), array())) {
				$Dir->delete();
			}
		}
	}

/**
 * beforeDelete method
 *
 * Before deleting the record, delete the associated file(s)
 *
 * @param mixed $Model
 * @access public
 * @return void
 */
	function beforeDelete(&$Model) {
		return $Model->deleteFiles();
	}

/**
 * beforeSave method
 *
 * Call process, indicating that it was not called directly
 *
 * @param mixed $Model
 * @access public
 * @return void
 */
	function beforeSave(&$Model) {
		return $this->process($Model, $Model->data, false);
	}

/**
 * beforeValidate method
 *
 * If the associated model is tableless setup the model schema to allow validation errors to be used
 *
 * @param mixed $Model
 * @return void
 * @access public
 */
	function beforeValidate(&$Model) {
		$this->_setupSchema($Model);
		$this->_setupValidation($Model);
		return true;
	}

/**
 * deleteFiles method
 *
 * Delete the files for this row - $which can either be 'all', 'original' or 'versions'
 * Will automatically delete empty folders after processing if permissions allow ( will not
 * raise an error if not possible to delete empty folders)
 *
 * @param mixed $Model
 * @param mixed $id
 * @return boolean True on success, false on failure
 * @access public
 */
	function deleteFiles(&$Model, $id = null) {
		if (!$id) {
			$id = $Model->id;
		}
		$file = $this->absolutePath($Model, $id);
		if (!file_exists($file)) {
			return true;
		}
		return $this->__unlink($file);
	}

/**
 * factoryMode method
 *
 * @param mixed $Model
 * @param mixed $data null
 * @param array $settings array()
 * @return void
 * @access public
 */
	function factoryMode(&$Model, &$data = null, $settings = array()) {
		$behavior = $this->__detectBehavior($Model, $data);
		if (isset($settings[$behavior])) {
			$settings = $settings[$behavior];
		}
		if ($behavior && $behavior !== $this->name && $Model->Behaviors->attach($behavior, $settings)) {
			$Model->Behaviors->disable($this->name);
			$Model->Behaviors->$behavior->setup($Model);
			return $behavior;
		}
		return false;
	}

/**
 * checkUploadedAFile method
 *
 * Prevent saving a record if no file was uploaded
 *
 * @param mixed $Model
 * @param mixed $fieldData
 * @return void
 * @access public
 */
	function checkUploadedAFile(&$Model, $fieldData) {
		extract ($this->settings[$Model->alias]);
		if (!empty($fieldData[$fileField]) &&
			is_array($fieldData[$fileField]) &&
			$fieldData[$fileField]['error'] != 4) {
			return true;
		}
		return false;
	}

/**
 * copy method
 *
 * Copy a file from one location to another. Valid syntax can be any of:
 * 	$Model->id = x;
 * 	$Model->copy($absoluteTo);
 * 	.. OR ..
 * 	$Model->copy($ModelId, $absoluteTo);
 * 	.. OR ..
 * 	$Model->copy($absoluteFrom, $absoluteTo);
 * 	.. OR ..
 * 	If $irrelevant does not contain a slash
 * 	$Model->copy($irrelevant, $absoluteFrom, $absoluteTo);
 *
 * @param mixed $Model
 * @param mixed $id
 * @param mixed $from
 * @param mixed $to
 * @return void
 * @access public
 */
	function copy(&$Model, $id = null, $from = null, $to = null) {
		if (!$to && !$from) {
			$from = $this->absolutePath($Model);
			$to = $id;
		} elseif(!$to && strpos($id, DS) !== false) {
			$to = $from;
			$from = $id;
		}
		$path = dirname($to);
		new Folder($path, true);
		if (Configure::read()) {
			AppModel::log("copying $from to $to", $this->name);
		}
		copy($from, $to);
		return file_exists($to);
	}

/**
 * checkUploadError method
 *
 * @param mixed $Model
 * @param mixed $fieldData
 * @return boolean true if a file was uploaded successfully, false if an error was encountered
 * @access public
 */
	function checkUploadError(&$Model, $fieldData) {
		extract ($this->settings[$Model->alias]);
		if (isset($fieldData[$fileField]) && is_array($fieldData[$fileField])) {
			$fieldData = $fieldData[$fileField];
		} else {
			return true;
		}
		if ($fieldData['size'] && $fieldData['error'] && $fieldData['error'] != 4) {
			return false;
		}
		return true;
	}

/**
 * checkUploadMime method
 *
 * Based on the config settings, check the uploaded mime type and reject if not an allowed mime type
 * Warning: the mimetype is set by the browser and may be inaccurate/manipulated
 *
 * @param mixed $Model
 * @param mixed $fieldData
 * @return boolean true if a file is an acceptable mime type, false otherwise
 * @access public
 */
	function checkUploadMime(&$Model, $fieldData) {
		extract ($this->settings[$Model->alias]);
		list($field) = array_keys($fieldData);
		if (!$fieldData[$field]['size'] || $allowedMime == '*') {
			return true;
		}
		list($field) = array_keys($fieldData);
		$data = array_values($fieldData);
		$mime = $this->mime($Model, $data[0]['tmp_name']);
		if ($mime) {
			$fieldData[$field]['type'] = $mime;
			$Model->data[$Model->alias][$field]['type'] = $mime;
		}
		if (is_array($allowedMime)) {
			if (in_array($fieldData[$field]['type'], $allowedMime)) {
				return true;
			}
			foreach($allowedMime as $test) {
				if (!strpos($test, '/*')) {
					continue;
				}
				$test = str_replace('*', '', $test);
				if (strpos($fieldData[$field]['type'], $test) !== false) {
					return true;
				}

			}
		} elseif ($fieldData[$field]['type'] == $allowedMime) {
			return true;
		}
		return false;
	}

/**
 * checkUploadSize method
 *
 * If the uploaded file exceeds the config settings - reject.
 * Note that file uploads are limited primarily by php's settings
 *
 * @param mixed $Model
 * @param mixed $fieldData
 * @return boolean true if a file is smaller than the max file size, false otherwise
 * @access public
 */
	function checkUploadSize(&$Model, $fieldData) {
		extract ($this->settings[$Model->alias]);
		if (isset($fieldData[$fileField]) && is_array($fieldData[$fileField]) && $fieldData[$fileField]['error'] != 4) {
			$fieldData = $fieldData[$fileField];
		} else {
			return true;
		}
		if (!$fieldData['size']) {
			return false;
		} elseif( $allowedSize == '*') {
			return true;
		}
		$factor = 1;
		switch ($allowedSizeUnits) {
		case 'KB':
			$factor = 1024;
		case 'MB':
			$factor = 1024 * 1024;
		}
		if ($fieldData['size'] < ($allowedSize * $factor)) {
			return true;
		}
		return false;
	}

/**
 * hasChanged method
 *
 * Check if the file changed since it was uploaded - by checking if it exists and whether the checksum
 * still matches
 *
 * @param mixed $Model
 * @param mixed $id
 * @return void
 * @access public
 */
	function hasChanged(&$Model, $id = null) {
		extract ($this->settings[$Model->alias]);
		if (!$id) {
			$id = $Model->id;
		}
		if (!$Model->hasField($checksumField)) {
			return false;
		}
		$file = $this->absolutePath($Model, $id);
		if (!file_exists($file)) {
			return true;
		}
		return (md5_file($file) != $Model->field($checksumField));
	}

/**
 * metadata method
 *
 * Get the metadata directly from the file
 *
 * @param mixed $Model
 * @param mixed $id
 * @param mixed $file
 * @param mixed $data
 * @return void
 * @access public
 */
	function metadata(&$Model, $id = null, $filename = null, &$data = array()) {
		extract ($this->settings[$Model->alias]);
		if (!$id) {
			$id = $Model->id;
		}
		if (!$filename) {
			$filename = $this->absolutePath($Model, $id);
		}
		$bits = explode('.', $filename);
		if (count($bits) > 1) {
			$ext = low(array_pop($bits));
			$data[$Model->alias][$extField] = $ext;
		} else {
			$ext = false;
		}
		$data[$Model->alias]['extension'] = $ext;
		$data[$Model->alias]['mimetype'] = $this->mime($Model, $filename);
		if (file_exists($filename)) {
			$data[$Model->alias]['filesize'] = filesize($filename);
			$data[$Model->alias]['checksum'] = md5_file($filename);
			$data[$Model->alias][$fileField] = basename($filename);
		}
		$this->size($Model, $id, $filename, $data);
		return $data[$Model->alias];
	}

/**
 * mime method
 *
 * Determine and return the mime type for the passed filepath based on inspection
 *
 * @TODO consider resurrecting the mime map for types that can't be auto-detected such as doc
 * @param mixed $Model
 * @param mixed $filepath null
 * @return void
 * @access public
 */
	function mime(&$Model, $filepath = null) {
		if (!$filepath) {
			if (!$Model->id) {
				return false;
			}
			$filepath = $this->absolutePath($Model);
		}
		$return = $this->__system('file --mime ' . escapeshellarg($filepath));

		if (!strpos($return, ':')) {
			return false;
		}
		list($file, $mime) = explode(':', $return);
		return trim($mime);
	}

/**
 * process method
 *
 * Check there is a file or upload to process and if not return - return false if process was called
 * directly, return true if called as part of save (no file uploaded, nothing to do)
 *
 * @param mixed $Model
 * @param array $data
 * @param bool $direct
 * @return void
 * @access public
 */
	function process(&$Model, &$data = array(), $direct = true) {
		extract ($this->settings[$Model->alias]);
		if ($data) {
			$Model->data = $data;
		}
		if ($direct) {
			$Model->data[$Model->alias][$fileField] = $Model->data[$Model->alias]['tempFile'];
			if (!$Model->validates()) {
				return false;
			}
		}
		if (!isset($Model->data[$Model->alias]['tempFile'])) {
			if (!isset($Model->data[$Model->alias][$fileField])) {
				return true;
			} elseif (is_array($Model->data[$Model->alias][$fileField]) && $Model->data[$Model->alias][$fileField]['error'] == 4) {
				unset ($Model->data[$Model->alias][$fileField]);
				return true;
			} elseif (!is_array($Model->data[$Model->alias][$fileField])) {
				return true;
			} elseif (!$Model->data[$Model->alias][$fileField]['size']) {
				return false;
			}
		}
		if (!$this->_beforeProcessUpload($Model, $Model->data)) {
			if ($this->errors && !$Model->validationErrors) {
				$Model->invalidate($fileField, implode(',', $this->errors));
			}
			return false;
		}

		if ($Model->data[$Model->alias]['tempFile'] !== $Model->data[$Model->alias]['original']) {
			if (!$this->copy(
				$Model, $Model->data[$Model->alias]['tempFile'],
				$Model->data[$Model->alias]['original'])) {
				$this->errors[] = 'Couldn\'t move the temporary file to the target location';
				return false;
			}
		}
		$this->_afterProcessUpload($Model, $Model->data);

		if ($this->errors && Configure::read()) {
			foreach ($this->errors as $error) {
				AppModel::log("	" . $error, $this->name);
			}
		}
		return !$this->errors;
	}

/**
 * relativePath method
 *
 * Convenience method
 *
 * @see path
 * @param mixed $Model
 * @param mixed $id
 * @return void
 * @access public
 */
	function relativePath(&$Model, $id = null) {
		return str_replace($this->settings[$Model]['basePath'], $this->absolutePath($Model, $id));
	}

/**
 * reprocess method
 *
 * Does not affect the original upload file
 * If $clearFolders is true, will delete the containing folder for versions before processing
 * 	useful only if files are organized such that all versions for one file are in the same
 * 	folder, and that folder only contains files for the same upload
 * Using the original upload file as the input, regenerate versions and reset size and checksum values
 * Useful if behavior settings change (e.g. image thumb size is changed system wide) or the original file
 * is overwritten with an updated version
 *
 * @param mixed $Model
 * @param mixed $id
 * @param boolean $clearFolder
 * @return void
 * @access public
 */
	function reprocess(&$Model, $id = null, $clearFolders = false) {
		if ($id && !is_int($id)) {
			$idSchema = $Model->schema($Model->primaryKey);
			if (!is_numeric($id) &&  $idSchema['length'] != 36) {
				$clearFolders = $id;
				$id = null;
			} elseif (is_array($id)) {
				extract (array_merge(array('id' => null), $id));
			}
		}
		if (!$id) {
			$id = $Model->id;
		}
		if (!$id) {
			return false;
		}
		if (Configure::read()) {
			AppModel::log('Reprocessing id ' . $id, $this->name);
		}

		extract ($this->settings[$Model->alias]);
		$Model->read(null, $id);
		$paths = $Model->absolutePath('all');
		if ($clearFolders) {
			$folders = array_unique($paths['versionDir']);
			foreach ($folders as $path) {
				if (!file_exists($path)) {
					continue;
				}
				$folder = new Folder($path, false);
				$folder->delete();
			}
		}
		$import = $paths['original'];
		if (file_exists($import)) {
			if (!$this->hasChanged($Model)) {
				$this->_clearReplace($Model);
				list($filenameOnly, $extension, $filename) = $this->__filename($Model, $fileFormat);
				$dir = $this->__path($Model, $dirFormat);
				$relativePath = $dir . DS . $filename;
				$path = $baseDir . DS . $relativePath;
				if ($path === $import) {
					$path = Debugger::trimPath($path);
					if (Configure::read()) {
						$this->errors[] = "file $path exists, and hasn't changed. nothing to do";
					}
					AppModel::log("	file $path exists, and hasn't changed. nothing to do", $this->name);
					return true;
				}
			}
		} else {
			$dir = dirname($import);
			$files = glob($dir . '/*');
			if (count($files) === 1) {
				$import = $files[0];
			} else {
				$match = false;
				foreach ($files as $file) {
					if (filesize($file) == $Model->data[$Model->alias]['filesize']) {
						$import = $file;
						$match = true;
						break;
					}
				}
				if (!$match) {
					$this->errors[] = 'No matching file found in reprocess method. All files shown below';
					$this->errors[] = 'dir ' . Debugger::trimPath($dir);
					foreach ($files as $file) {
						$this->errors[] = '	' . $file;
					}
					return false;
				}
			}
		}
		$Model->create();
		$Model->id = $id;
		if (file_exists($import)) {
			if (!$Model->save(array('tempFile' => $import))) {
				$this->errors[] = "Save failed";
			}
			$Model->read();
		} else {
			$this->errors[] = "The original file $import doesn't exist";
		}

		if ($this->errors && Configure::read()) {
			foreach ($this->errors as $error) {
				AppModel::log("	" . $error, $this->name);
			}
		}
		return !$this->errors;
	}

/**
 * size method
 *
 * Stub/abstract/ override me
 *
 * @param mixed $Model
 * @param mixed $id null
 * @param mixed $filename null
 * @param array $data array()
 * @return void
 * @access public
 */
	function size(&$Model, $id = null, $filename = null, &$data = array()) {
		if (!$id) {
			$id = $Model->id;
		}
		if (!$filename) {
			$filename = $this->absolutePath($Model, $id);
		}
		return filesize($filename);
	}

/**
 * afterProcessUpload method
 *
 * If the temporary file is in quarantine, delete it and attempt to delete the containing temporary folder - this will
 * fail if the folder isn't empty (desired!)
 * Add the path info to the data array and process any configured versions
 *
 * @param mixed $Model
 * @param mixed $data
 * @return boolean
 * @access protected
 */
	function _afterProcessUpload(&$Model, &$data) {
		extract($this->settings[$Model->alias]);
		$this->_clearReplace($Model);
		if (isset($data[$Model->alias]['original'])) {
			$original = $data[$Model->alias]['original'];
		} else {
			$original = $Model->absolutePath();
		}
		if (file_exists($original)) {
			if ($checksumField) {
				$data[$Model->alias][$checksumField] = md5_file($original);
			}
		} else {
			$this->errors[] = 'Couldn\'t open the original file ' . $original;
		}

		if ($this->errors && Configure::read()) {
			foreach ($this->errors as $error) {
				AppModel::log("	" . $error, $this->name);
			}
		}
		return !$this->errors;
	}

/**
 * Anything to do before processing a file
 *
 * First thing: if it /is/ an uploaded file as opposed to a direct call to process with a path, move the uploaded file
 * to a temporary location and set meta data in the model's data array. This will allow users to upload a file once,
 * and avoid, for example,  validation errors meaning the upload must be repeated. (It also means it is possible to
 * write test cases for uploading files). Otherwise set meta data based on the file's contents.
 * Check if the destination file already exists, if it is, overwrite if configured to do so and the existing file can
 * be deleted, or assign a sequncial filename otherwise.
 *
 * @param mixed $Model
 * @param mixed $data
 * @access protected
 * @return void
 */
	function _beforeProcessUpload(&$Model, &$data) {
		$this->_setup($Model);
		$this->errors = array();
		extract ($this->settings[$Model->alias]);
		if (!isset($data[$Model->alias][$fileField])) {
			$this->metaData($Model, null, $data[$Model->alias]['tempFile'], $data);
			list($_, $_, $filename) = $this->__filename($Model, basename($data[$Model->alias]['tempFile']));
		} elseif (is_array($data[$Model->alias][$fileField])) {
			$this->_clearReplace($Model);
			if (!$this->__path($Model, $quarantinePath)) {
				$this->errors[] = 'Couldn\'t create temporary storage folder';
				return false;
			}
			list($filenameOnly, $extension, $filename) = $this->__filename($Model, $fileFormat);
			$data[$Model->alias]['tempFile'] = $baseDir . DS . $quarantinePath . DS . $filename;
			if(!move_uploaded_file($data[$Model->alias][$fileField]['tmp_name'], $data[$Model->alias]['tempFile'])) {
				if (Configure::read()) {
					$this->errors[] = 'Couldn\'t move uploaded file to temporary storage ' . $data[$Model->alias]['tempFile'];
				} else {
					$this->errors[] = 'Couldn\'t move uploaded file to temporary storage';
				}
				return false;
			}
			$data[$Model->alias]['mimetype'] = $data[$Model->alias][$fileField]['type'];
			$data[$Model->alias]['filesize'] = $data[$Model->alias][$fileField]['size'];
			$data[$Model->alias][$fileField] = $filename;
		} else {
			$this->metaData($Model, null, $data[$Model->alias]['tempFile'], $data);
			$filename = $data[$Model->alias][$fileField];
		}

		$this->_clearReplace($Model);
		list($filenameOnly, $extension, $filename) = $this->__filename($Model, $fileFormat);
		$dir = $this->__path($Model, $dirFormat);
		$relativePath = $dir . DS . $filename;
		$path = $baseDir . DS . $relativePath;
		if(file_exists($path) && $path !== $this->absolutePath($Model) && $path !== $data[$Model->alias]['tempFile']) {
			if($overwriteExisting) {
				if(is_dir($path)) {
					$this->errors[] = 'The file ' . $relativePath . ' is a directory and cannot be deleted.';
				} elseif ($path !== $data[$Model->alias]['tempFile']) {
					if(!$this->__unlink($path)) {
						$this->errors[] = 'The file ' . $relativePath . ' already exists and cannot be deleted.';
					}
				}
			} else {
				$count = 2;
				while(file_exists($baseDir . $dir . DS . $filenameOnly . '_' . $count . '.' . $extension)) {
					$count++;
				}
				$filename = $filenameOnly .= '_' . $count;
				if ($extension) {
					$filename .= '.' . $extension;
				}
				list($filenameOnly, $extension, $filename) = $this->__filename($Model, $filename);
				$relativePath = $dir . DS . $filename;
				$path = $baseDir . DS . $relativePath;
			}
		}
		$conditions = array();
		if ($Model->hasField($dirField)) {
			$conditions[$dirField] = $dir;
		}
		if ($fileField) {
			$conditions[$fileField] = $filename;
		}
		if ($conditions && $id = $Model->field($Model->primaryKey, $conditions)) {
			if($overwriteExisting || $id == $Model->id) {
				$Model->id = $id;
				unset($Model->data[$Model->alias][$Model->primaryKey]);
			}
		}
		$folder = dirname($path);
		if (!new Folder($folder, true)) {
			$this->errors[] = 'Could not create the folder ' . $folder;
		}
		if ($dirField) {
			$data[$Model->alias][$dirField] = $dir;
		}
		if ($fileField) {
			$data[$Model->alias][$fileField] = $filename;
		}
		if ($extField) {
			$data[$Model->alias][$extField] = $extension;
		}

		$data[$Model->alias]['relativePath'] = $relativePath;
		$data[$Model->alias]['original'] = $path;

		if ($this->errors && Configure::read()) {
			foreach ($this->errors as $error) {
				AppModel::log("	" . $error, $this->name);
			}
		}
		return !$this->errors;
	}

/**
 * clearReplace method
 *
 * Remove existing path replacements in preparation for the next (if any) request or upload
 *
 * @param mixed $Model
 * @return void
 * @access protected
 */
	function _clearReplace(&$Model) {
		$this->settings[$Model->alias]['pathReplacements'] = array();
		extract ($this->settings[$Model->alias]);
		if (!empty($baseDir)) {
			$this->settings[$Model->alias]['baseDir'] = $this->_replacePseudoConstants($Model, $baseDir);
		}
		$original = $this->absolutePath($Model);
		if ($original) {
			$this->__addReplace($Model, '{$original}', $original);
			$this->__addReplace($Model, '{$filename}', basename($original));
			$bits = explode('.', basename($original));
			if (count($bits) > 1) {
				$extension = low(array_pop($bits));
				$this->__addReplace($Model, '{$extension}', $extension);
				$this->__addReplace($Model, '{$filenameOnly}', implode('.', $bits));
			} else {
				$this->__addReplace($Model, '{$extension}', '');
				$this->__addReplace($Model, '{$filenameOnly}', '');
			}
		}
	}

/**
 * replacePseudoConstants method
 *
 * for the passed string look for and replace any pseudo constants.
 * {CONSTANT} will be replaced with the defined CONSTANT (if it's defined)
 * {$dataVariable} will be replaced with $this->data['ModelAlias']['dataVariable'] if it is set
 * {$databaseField} will be replaced with $Model->field('databaseField');
 * {$random} will be replaced with a random 5 digit number, regenerated each time this method is called
 * any undefined pseudoConstant will otherwise be replaced with the variable name and generate an error
 *
 * @param mixed $Model
 * @param mixed $string
 * @return boolean true on success, false on error
 * @access protected
 */
	function _replacePseudoConstants(&$Model, $string) {
		extract($this->settings[$Model->alias]);
		if (is_array($string)) {
			foreach ($string as $i => $str) {
				$string[$i] = $this->_replacePseudoConstants($Model, $str);
			}
			return $string;
		}
		$_replacements = $this->settings[$Model->alias]['pathReplacements'];
		$random = uniqid('');
		$random = substr($random, strlen($random) -5, strlen($random));
		preg_match_all('@{\$?([^{}]*)}@', $string, $r);
		foreach ($r[1] as $i => $match) {
			$_found = false;
			if (!isset($this->settings[$Model->alias]['pathReplacements'][$r[0][$i]])) {
				if (up($match) == $match) {
					$constants = get_defined_constants();
					if (isset($constants[$match])) {
						$this->__addReplace($Model, $r[0][$i], $constants[$match]);
						$_found = true;
					}
					if (!$_found) {
						$this->errors[] = 'Cannot replace ' . $match . ' as the constant ' . $match . ' is not defined.';
					}
				} else {
					if (isset($$match)) {
						$this->__addReplace($Model, $r[0][$i], $$match);
						$_found = true;
					} elseif (isset($Model->data[$Model->alias][$match])) {
						$this->__addReplace($Model, $r[0][$i], $Model->data[$Model->alias][$match]);
						$_found = true;
					} elseif ($Model->id && $Model->hasField($match)) {
						$this->__addReplace($Model, $r[0][$i], $Model->field($match));
						$_found = true;
					} elseif (in_array($match, array('alias'))) {
						$this->__addReplace($Model, $r[0][$i], $Model->alias);
						$_found = true;
					} elseif (in_array($match, array('model', 'class'))) {
						$this->__addReplace($Model, $r[0][$i], $Model->name);
						$_found = true;
					}
					if (!$_found) {
						$this->errors[] = 'Cannot replace ' . $match . ' as the variable $' . $match . ' cannot be determined.';
						if (Configure::read()) {
							$this->errors[] = Debugger::trace();
							$this->errors[] = var_export($Model->data);
						}
					}
				}
			}
		}
		$markers = array_keys($this->settings[$Model->alias]['pathReplacements']);
		$replacements = array_values($this->settings[$Model->alias]['pathReplacements']);
		$this->settings[$Model->alias]['pathReplacements'] = $_replacements;
		return str_replace ($markers, $replacements, $string);
	}
	function _setup(&$Model, $reset = false) {
		static $alreadyRun = false;
		if ($reset || $alreadyRun) {
			return;
		}
		$alreadyRun = true;

		extract ($this->settings[$Model->alias]);
		$baseDir = $this->_replacePseudoConstants($Model, $baseDir);
		$this->settings[$Model->alias]['baseDir'] = $baseDir;
		if (Configure::read()) {
			uses('Folder');
			if (!file_exists($baseDir)) {
				new Folder($baseDir, true);
				if (!file_exists($baseDir)) {
					trigger_error('UploadBehavior::setup Base directory ' . $baseDir . ' doesn\'t exist and cannot be created.');
					$Model->Behaviors->disable($this->name);
					return;
				}
			} elseif(!is_writable($baseDir)) {
				trigger_error('UploadBehavior::setup Base directory ' . $baseDir . ' is not writable.');
				$Model->Behaviors->disable($this->name);
				return;
			}
		}
		if (!$quarantinePath) {
			$this->settings[$Model->alias]['quarantinePath'] = 'quarantine';
			if (!class_exists('Security')) {
				require LIBS . 'security.php';
			}

			if (isset($_SERVER['REQUEST_URI'])) {
				$this->settings[$Model->alias]['quarantinePath'] .= DS . Security::hash($_SERVER['REQUEST_URI']);
			}
		}
	}

/**
 * setupSchema method
 *
 * @TODO How to do this without directly accessing the _schema field
 * @param mixed $Model
 * @return void
 * @access protected
 */
	function _setupSchema($Model) {
		$schema = $Model->schema();
		extract ($this->settings[$Model->alias]);
		if (!$schema) {
			$Model->_schema = $schema[$fileField] = array(
				'type' => 'string',
				'null' => null,
				'default' => null,
				'length' => 100
			);
		}
	}

/**
 * setupValidation method
 *
 * Add validation rules specific to this behavior. Prepend the behaviors validation rules
 * To allow the behavior to modify the model's data for any other validation rules
 *
 * @param mixed $Model
 * @return void
 * @access protected
 */
	function _setupValidation(&$Model) {
		if (empty($Model->data[$Model->alias])) {
			return;
		}
		extract ($this->settings[$Model->alias]);
		if (isset($Model->validate[$fileField])) {
			$existingValidations = $Model->validate[$fileField];
			if (!is_array($existingValidations)) {
				$existingValidations = array($existingValidations);
			}
		} else {
			$existingValidations = array();
		}
		if ($mustUploadFile) {
			$validations['uploadAFile'] = array(
				'on' => 'create',
				'rule' => 'checkUploadedAFile',
				'message' => 'Please select a file to upload.',
				'last' => true
			);
		} elseif (!$this->checkUploadedAFile($Model, $Model->data[$Model->alias])) {
			if (!empty($Model->data[$Model->alias][$fileField]) && is_array($Model->data[$Model->alias][$fileField])) {
				unset ($Model->data[$Model->alias][$fileField]);
			}
			return;
		}
		$validations['uploadError'] = array(
			'rule' => 'checkUploadError',
			'message' => 'An error was generated during the upload.',
			'last' => true
		);
		if (is_array($allowedMime)) {
			$allowedMimes = implode(',', $allowedMime);
		} else {
			$allowedMimes = $allowedMime;
		}
		$validations['uploadMime'] = array(
			'rule' => 'checkUploadMime',
			'message' => 'The submitted mime type is not permitted, only ' . $allowedMimes . ' permitted.',
			'last' => true
		);
		if ($allowedExt != '*') {
			if (is_array($allowedExt)) {
				$allowedExts = implode(',', $allowedExt);
			} else {
				$allowedExts = $allowedExt;
				$allowedExt = array($allowedExt);
			}
			$validations['uploadExt'] = array(
				'rule' => array('extension', $allowedExt),
				'message' => 'The submitted file extension is not permitted, only ' . $allowedExts . ' permitted.',
				'last' => true
			);
		}
		$validations['uploadSize'] = array(
			'rule' => 'checkUploadSize',
			'message' => 'The file uploaded is too big, only files less than ' . $allowedSize . ' ' . $allowedSizeUnits .' permitted.',
			'last' => true
		);
		$Model->validate[$fileField] = Set::merge($validations, $existingValidations);
	}

/**
 * addReplace method
 *
 * @final
 * @param mixed $Model
 * @param mixed $find
 * @param string $replace ''
 * @return void
 * @access protected
 */
	function __addReplace(&$Model, $find, $replace = '') {
		if (is_array($find)) {
			foreach ($find as $f => $r) {
				$this->__addReplace($Model, $f, $r);
			}
			return;
		}
		if (is_array($replace)) {
			$replace = array_shift($replace);
		}
		$replace = $this->_replacePseudoConstants($Model, $replace);
		$this->settings[$Model->alias]['pathReplacements'][$find] = $replace;
	}

/**
 * filename method
 *
 * Clean the string and return something suitable to use as a filename, allow double file extensions (.tar.gz).
 * returns an ascii filename. For example "filename with 'quote' and (brackets).windblows.zip" would become
 * "filename_with_quote_and_brackets.windblows.zip"
 *
 * @final
 * @param mixed $Model
 * @param mixed $string
 * @return array  a 'filename safe' string, the extension, the full filename
 * @access private
 */
	function __filename(&$Model, $string) {
		extract ($this->settings[$Model->alias]);
		if (strpos($string,'{') !== false) {
			$string = low($this->_replacePseudoConstants($Model, $string));
		}
		$string = str_replace(array('.'), array('__dot__'), $string);
		$string = preg_replace('/_*dot_*/', '.', Inflector::slug($string));
		$string = preg_replace('/[^a-zA-Z0-9\._\-]/', '_', $string);
		$string = str_replace('_.', '.', $string);
		$bits = explode('.', $string);
		if (count($bits) > 1) {
			$ext = low(array_pop($bits));
		} else {
			$ext = false;
		}
		$filename = $full = implode('.', $bits);
		if($ext) {
			$full .= '.' . $ext;
		}
		$this->__addReplace($Model, '{$filenameOnly}', $filename);
		$this->__addReplace($Model, '{$extension}', $ext);
		$this->__addReplace($Model, '{$filename}', $full);
		return array($filename, $ext, $full);
	}

/**
 * normalizePaths method
 *
 * Normalize dir seperators so that:
 * 	path//subfolder/image.png becomes path/subfolder/image.png
 *  OR
 *  	path/\subfolder\image.png becomes path/subfolder/image.png
 *  OR
 *  	/path/\subfolder\image.png becomes /path/subfolder/image.png
 *  EXCEPT for windows where..
 *  	c:\path/\subfolder\image.png becomes c:\path\subfolder\image.png
 *
 * @final
 * @param mixed $path
 * @return void
 * @access private
 */
	function __normalizePaths(&$path) {
		if (is_array($paths)) {
			foreach ($paths as &$path) {
				$path = $this->__normalizePaths($path);
			}
			return $paths;
		}
		if ($absolute) {
			if (DS == '\\') { // TODO For testing only
				$DS = '\\';
			} else {
				$DS = '/';
			}
			//return preg_replace('@(?!:)[\\/]+@', $DS, $paths);
			return preg_replace('@[\\/]+@', $DS, $path);
		}
		//return preg_replace('@(?!:)[\\/]+@', '/', $paths);
		return preg_replace('@[\\/]+@', '/', $path);
	}

/**
 * path method
 *
 * Replace any pseudo constants and create the folder
 *
 * @final
 * @param mixed $Model
 * @param mixed $path
 * @return string the path to the folder
 * @access private
 */
	function __path(&$Model, $path) {
		extract ($this->settings[$Model->alias]);
		if (strpos($path,'{') !== false) {
			$path = $this->_replacePseudoConstants($Model, $path);
		}
		if (!$path) {
			$this->errors[] = 'Couldn\'t determine the path ' . $dir;
			return false;
		} else {
			if (!(new Folder ($baseDir . DS . $path, true))) {
				$this->errors[] = 'Couldn\'t create the path ' . $dir;
				return false;
			};
		}
		$this->__addReplace($Model, '{$dir}', $path);
		return $path;
	}

/**
 * system method
 *
 * Common entry point for system calls.
 *
 * @final
 * @param mixed $command
 * @param mixed $output
 * @return bool
 * @access private
 */
	function __system($command, &$output = null) {
		if (Configure::read()) {
			AppModel::log($command, $this->name);
		}
		$return = exec($command, $output, $returnValue);
		if ($return) {
			return $return;
		}
		return !$returnValue;
	}

/**
 * unlink method
 *
 * @param mixed $file
 * @return void
 * @access private
 */
	function __unlink($file, $links2 = false) {
		if (!file_exists($file)) {
			return false;
		}
		if (Configure::read()) {
			AppModel::log('unlink ' . $file, $this->name);
		}
		if (is_link($file) && !$links2) {
			chmod($file, 0700);
		}
		return unlink($file);
	}

/**
 * detectBehavior method
 *
 * Based on the passed data, check if a more specific behavior exists and if so return its name
 *
 * @param mixed $Model
 * @param mixed $data
 * @return mixed false if no behavior matches, the name of the matched behavior otherwise
 * @access private
 */
	function __detectBehavior(&$Model, &$data = null) {
		extract ($this->settings[$Model->alias]);
		if (!$data) {
			if ($Model->data) {
				$data = $Model->data;
			} elseif ($Model->id) {
				$_data = $Model->data;
				$data = $Model->read();
				$Model->data = $_data;
			} else {
				return false;
			}
		}
		$mime = false;
		if (isset($data[$Model->alias][$fileField]) && is_array($data[$Model->alias][$fileField])) {
			$mime = $data[$Model->alias][$fileField]['type'];
		} elseif (isset($data[$Model->alias]['mimetype'])) {
			$mime = $data[$Model->alias]['mimetype'];
		}
		if (!$mime || !strpos($mime, '/')) {
			$mime = $this->mime($Model);
		}

		$extension = false;
		if (isset($data[$Model->alias][$fileField]) && is_array($data[$Model->alias][$fileField])) {
			$file = $data[$Model->alias][$fileField]['name'];
		} elseif (isset($data[$Model->alias][$fileField])) {
			$file = $data[$Model->alias][$fileField];
		} else {
			return false;
		}
		$bits = explode('.', $file);
		if (count($bits) > 1) {
			$extension = low(array_pop($bits));
		}
		$behavior = false;
		foreach ($this->__behaviorMap as $type => $tests) {
			$match = 0;
			foreach ($tests as $field => $value) {
				switch ($field) {
				case 'mime':
					$value = str_replace('*', '', $value);
					if (strpos($mime, $value) !== false) {
						$match++;
					}
				case 'extension':
					if (is_string($value)) {
						if ($extension == $value) {
							$match++;
						}
					} elseif (in_array($extension, $value)) {
						$match++;
					}
				}
			}
			if ($match == count($tests)) {
				$behavior = $type;
				break;
			}
		}
		if ($behavior) {
			$behavior = Inflector::classify($behavior) . 'Upload';
		} else {
			return false;
		}
		$behaviors = Configure::listObjects('behavior');
		if (in_array($behavior, $behaviors)) {
			return $behavior;
		}
		return false;
	}
}