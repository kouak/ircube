<?php
/**
 * MeioUpload Behavior
 *
 * This behavior is based on Vincius Mendes'  MeioUpload Behavior
 *  (http://www.meiocodigo.com/projects/meioupload/)
 * Which is in turn based upon Tane Piper's improved uplaod behavior
 *  (http://digitalspaghetti.tooum.net/switchboard/blog/2497:Upload_Behavior_for_CakePHP_12)
 *
 * @author Jose Diaz-Gonzalez (support@savant.be)
 * @package app
 * @subpackage app.models.behaviors
 * @filesource http://github.com/josegonzalez/MeioUpload/tree/master
 * @version 2.0.1
 * @lastmodified 2009-08-16
 */
App::import('Core', 'File');
App::import('Core', 'Folder');
class MeioUploadBehavior extends ModelBehavior {
/**
 * The default options for the behavior
 */
	var $defaultOptions = array(
		'useTable' => true,
		'createDirectory' => true,
		'dir' => 'uploads{DS}{ModelName}',
		'folderAsField' => null, // Can be the name of any field in $this->data
		'uploadName' => null, // Can also be the tokens {ModelName} or {fieldName}
		'maxSize' => 2097152, // 2MB
		'allowedMime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon'),
		'allowedExt' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico'),
		'default' => false, // Not sure what this does
		'zoomCrop' => false, // Whether to use ZoomCrop or not with PHPThumb
		'thumbnails' => true,
		'thumbsizes' => array(
			'small'  => array('width' => 100, 'height' => 100, 'thumbnailQuality' => 75),
			'medium' => array('width' => 220, 'height' => 220, 'thumbnailQuality' => 75),
			'large'  => array('width' => 800, 'height' => 600, 'thumbnailQuality' => 75)
		),
		'thumbnailQuality' => 75, // Global Thumbnail Quality
		'maxDimension' => null, // Can be null, h, or w
		'useImageMagick' => false,
		'imageMagickPath' => '/usr/bin/convert', // Path to imageMagick on your server
		'fields' => array(
			'dir' => 'dir',
			'filesize' => 'filesize',
			'mimetype' => 'mimetype'
		),
		'length' => array(
			'minWidth' => 0, // 0 for not validates
			'maxWidth' => 0,
			'minHeight' => 0,
			'maxHeight' => 0
		),
		'validations' => array()
	);

	var $defaultValidations = array(
		'FieldName' => array(
			'rule' => array('uploadCheckFieldName'),
			'check' => true,
			'last' => true
		),
		'Dir' => array(
			'rule' => array('uploadCheckDir'),
			'check' => true,
			'last' => true
		),
		'Empty' => array(
			'rule' => array('uploadCheckEmpty'),
			'check' => true,
			'on' => 'create',
			'last' => true
		),
		'UploadError' => array(
			'rule' => array('uploadCheckUploadError'),
			'check' => true,
			'last' => true
		),
		'MaxSize' => array(
			'rule' => array('uploadCheckMaxSize'),
			'check' => true,
			'last' => true
		),
		'InvalidMime' => array(
			'rule' => array('uploadCheckInvalidMime'),
			'check' => true,
			'last' => true
		),
		'InvalidExt' => array(
			'rule' => array('uploadCheckInvalidExt'),
			'check' => true,
			'last' => true
		),
		'MinWidth' => array(
			'rule' => array('uploadCheckMinWidth'),
			'check' => true,
			'last' => true
		),
		'MaxWidth' => array(
			'rule' => array('uploadCheckMaxWidth'),
			'check' => true,
			'last' => true
		),
		'MinHeight' => array(
			'rule' => array('uploadCheckMinHeight'),
			'check' => true,
			'last' => true
		),
		'MaxHeight' => array(
			'rule' => array('uploadCheckMaxHeight'),
			'check' => true,
			'last' => true
		),
	);

/**
 * The array that saves the $options for the behavior
 */
	var $__fields = array();

/**
 * Patterns of reserved words
 */
	var $patterns = array(
		'thumb',
		'default'
	);

/**
 * Words to replace the patterns of reserved words
 */
	var $replacements = array(
		't_umb',
		'd_fault'
	);

/**
 * Array of files to be removed on the afterSave callback
 */
	var $__filesToRemove = array();

/**
 * Array of all possible images that can be converted to thumbnails
 *
 * @var array
 **/
var $_imageTypes = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon');

/**
 * Constructor
 *
 * @author Juan Basso
 */
	function __construct() {
		$messages = array(
			'FieldName' => array(
				'message' => __d('meio_upload', 'This field has not been defined between the parameters of MeioUploadBehavior.', true)
			),
			'Dir' => array(
				'message' => __d('meio_upload', 'The directory where the file would be placed there or is protected against writing.', true)
			),
			'Empty' => array(
				'message' => __d('meio_upload', 'The file can not be empty.', true)
			),
			'UploadError' => array(
				'message' => __d('meio_upload', 'There were problems in uploading the file.', true)
			),
			'MaxSize' => array(
				'message' => __d('meio_upload', 'The maximum file size is exceeded.', true)
			),
			'InvalidMime' => array(
				'message' => __d('meio_upload', 'Invalid file type.', true)
			),
			'InvalidExt' => array(
				'message' => __d('meio_upload', 'Invalid file extension.', true)
			)
		);
		$this->defaultValidations = $this->_arrayMerge($this->defaultValidations, $messages);
		$this->defaultOptions['validations'] = $this->defaultValidations;
	}

/**
 * Setup the behavior. It stores a reference to the model, merges the default options with the options for each field, and setup the validation rules.
 *
 * @param $model Object
 * @param $settings Array[optional]
 * @return null
 * @author Vinicius Mendes
 */
	function setup(&$model, $settings = array()) {
		$this->__model = $model;
		$this->__fields = array();
		foreach ($settings as $field => $options) {
			// Check if they even PASSED IN parameters
			if (!is_array($options)) {
				// You jerks!
				$field = $options;
				$options = array();
			}

			// Inherit model's lack of table use if not set in options
			// regardless of whether or not we set the table option
			if (!$model->useTable) {
				$options['useTable'] = false;
			}

			// Merge given options with defaults
			$options = $this->_arrayMerge($this->defaultOptions, $options);

			// Check if given field exists
			if ($options['useTable'] && !$model->hasField($field)) {
				trigger_error(sprintf(__d('meio_upload', 'MeioUploadBehavior Error: The field "%s" doesn\'t exists in the model "%s".', true), $field, $model->alias), E_USER_WARNING);
			}

			// Including the default name to the replacements
			if ($options['default']) {
				if (!preg_match('/^.+\..+$/', $options['default'])) {
					trigger_error(__d('meio_upload', 'MeioUploadBehavior Error: The default option must be the filename with extension.', true), E_USER_ERROR);
				}
				$this->_includeDefaultReplacement($options['default']);
			}

			// Verifies if the thumbsizes names is alphanumeric
			foreach ($options['thumbsizes'] as $name => $size) {
				if (empty($name) || !ctype_alnum($name)) {
					trigger_error(__d('meio_upload', 'MeioUploadBehavior Error: The thumbsizes names must be alphanumeric.', true), E_USER_ERROR);
				}
			}

			// Process the max_size if it is not numeric
			$options['maxSize'] = $this->_sizeToBytes($options['maxSize']);

			// Replace tokens of the dir and field, check it doesn't have a DS on the end
			$tokens = array('{ModelName}', '{fieldName}', '{DS}', '/', '\\');
			$options['dir'] = rtrim($this->_replaceTokens($options['dir'], $field, $tokens), DS);
			$options['uploadName'] = rtrim($this->_replaceTokens($options['uploadName'], $field, $tokens), DS);

			// Replace tokens in the fields names
			if ($options['useTable']) {
				foreach ($options['fields'] as $fieldToken => $fieldName) {
					$options['fields'][$fieldToken] = $this->_replaceTokens($fieldName, $field, $tokens);
				}
			}
			$this->__fields[$field] = $options;
		}
	}

/**
 * Sets the validation rules for each field.
 *
 * @param $model Object
 * @return true
 */
	function beforeValidate(&$model) {
		if(isset($model->data[$model->alias]['filename'])) {
			if(isset($model->data[$model->alias]['filename']['tmp_name']) && isset($model->data[$model->alias]['filename']['type']) && $model->data[$model->alias]['filename']['type'] == 'application/octet-stream' && class_exists('finfo')) {
				/* kouak : hack swfupload application/octet-stream issue */
				$finfo = new finfo(FILEINFO_MIME);
				$model->data[$model->alias]['filename']['type'] = strtok($finfo->file($model->data[$model->alias]['filename']['tmp_name']), ';');
			}
		}
		foreach ($this->__fields as $fieldName => $options) {
			$this->_setupValidation($fieldName, $options);
		}
		return true;
	}

/**
 * Initializes the upload
 *
 * @param $model Object
 * @return boolean Whether the upload completed
 * @author Jose Diaz-Gonzalez
 **/
	function beforeSave(&$model) {
		$result = $this->_uploadFile($model);
		if (is_bool($result)) {
			return $result;
		} elseif (is_array($result)) {
			if ($result['return'] === false) {
				// Upload failed, lets see why
				switch($result['reason']) {
					case 'validation':
						$model->validationErrors[$result['extra']['field']] = $result['extra']['error'];
						break;
				}
				return false;
			} else {
				$model->data = $result['data'];
				return true; 
			}
		} else {
			return false;
		}
	}

/**
 * Deletes the files marked to be deleted in the save method.
 * A file can be marked to be deleted if it is overwriten by
 * another or if the user mark it to be deleted.
 *
 * @param $model Object
 * @author Vinicius Mendes
 */
	function afterSave(&$model) {
		foreach ($this->__filesToRemove as $file) {
			if ($file['name']) {
				$this->_deleteFiles($file['name'], $file['dir']);
			}
		}
		// Reset the filesToRemove array
		$this->__filesToRemove = array();
	}

/**
 * Performs a manual upload
 *
 * @param $model Object
 * @param $data Array data to be saved
 * @return boolean Whether the upload completed
 * @author Jose Diaz-Gonzalez
 **/
	function upload(&$model, $data) {
		$result = $this->_uploadFile($model, $data);
		if (is_bool($result)) {
			return $result;
		} elseif (is_array($result)) {
			if ($result['return'] === false) {
				// Upload failed, lets see why
				switch($result['reason']) {
					case 'validation':
						$model->validationErrors[$result['extra']['field']] = $result['extra']['error'];
						break;
				}
				return false;
			} else {
				$this->data = $result['data'];
				return true;
			}
		} else {
			return false;
		}
	}

/**
 * Deletes all files associated with the record beforing delete it.
 *
 * @param $model Object
 * @author Vinicius Mendes
 */
	function beforeDelete(&$model) {
		$model->read(null, $model->id);
		if (isset($model->data)) {
			foreach ($this->__fields as $field => $options) {
				$file = $model->data[$model->alias][$field];
				if ($file && $file != $options['default']) {
					$this->_deleteFiles($file, $options['dir']);
				}
			}
		}
		return true;
	}

/**
 * Checks if the field was declared in the MeioUpload Behavior setup
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Vinicius Mendes
 */
	function uploadCheckFieldName(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['FieldName']['check']) {
				return true;
			}
			if (isset($this->__fields[$fieldName])) {
				return true;
			} else {
				$this->log(sprintf(__d('meio_upload', 'MeioUploadBehavior Error: The field "%s" wasn\'t declared as part of the MeioUploadBehavior in model "%s".', true), $fieldName, $model->alias));
				return false;
			}
		}
		return true;
	}

/**
 * Checks if the folder exists or can be created or writable.
 *
 * @return boolean
 * @param $model Object
 * @param $data Array
 * @author Vinicius Mendes
 */
	function uploadCheckDir(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['Dir']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (empty($field['remove']) || empty($field['name'])) {
				// Check if directory exists and create it if required
				if (!is_dir($options['dir'])) {
					if ($options['createDirectory']) {
						$folder = &new Folder();
						if (!$folder->mkdir($options['dir'])) {
							trigger_error(sprintf(__d('meio_upload', 'MeioUploadBehavior Error: The directory %s does not exist and cannot be created.', true), $options['dir']), E_USER_WARNING);
							return false;
						}
					} else {
						trigger_error(sprintf(__d('meio_upload', 'MeioUploadBehavior Error: The directory %s does not exist.', true), $options['dir']), E_USER_WARNING);
						return false;
					}
				}

				// Check if directory is writable
				if (!is_writable($options['dir'])) {
					trigger_error(sprintf(__d('meio_upload', 'MeioUploadBehavior Error: The directory %s isn\'t writable.', true), $options['dir']), E_USER_WARNING);
					return false;
				}
			}
		}
		return true;
	}

/**
 * Checks if the filename is not empty.
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Vinicius Mendes
 */
	function uploadCheckEmpty(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['Empty']['check']) {
				return true;
			}
			if (empty($field['remove'])) {
				if (!is_array($field) || empty($field['name'])) {
					return false;
				}
			}
		}
		return true;
	}

/**
 * Checks if ocurred erros in the upload.
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Vinicius Mendes
 */
	function uploadCheckUploadError(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['UploadError']['check']) {
				return true;
			}
			if (!empty($field['name']) && $field['error'] > 0) {
				return false;
			}
		}
		return true;
	}

/**
 * Checks if the file isn't bigger then the max file size option.
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Vinicius Mendes
 */
	function uploadCheckMaxSize(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['MaxSize']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (!empty($field['name']) && $field['size'] > $options['maxSize']) {
				return false;
			}
		}
		return true;
	}

/**
 * Checks if the file is of an allowed mime-type.
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Vinicius Mendes
 */
	function uploadCheckInvalidMime(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['InvalidMime']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (!empty($field['name']) && count($options['allowedMime']) > 0 && !in_array($field['type'], $options['allowedMime'])) {
				return false;
			}
		}
		return true;
	}

/**
 * Checks if the file has an allowed extension.
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Vinicius Mendes
 */
	function uploadCheckInvalidExt(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['InvalidExt']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (!empty($field['name'])) {
				if (count($options['allowedExt']) > 0) {
					$matches = 0;
					foreach ($options['allowedExt'] as $extension) {
						if (strtolower(substr($field['name'], -strlen($extension))) == strtolower($extension)) {
							$matches++;
						}
					}

					if ($matches == 0) {
						return false;
					}
				}
			}
		}
		return true;
	}

/**
 * Checks if the min width is allowed
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Juan Basso
 */
	function uploadCheckMinWidth(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['MinWidth']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (!empty($field['name']) && $options['length']['minWidth'] > 0 && imagesx($field['tmp_name']) < $options['length']['minWidth']) {
				return false;
			}
		}
		return true;
	}

/**
 * Checks if the max width is allowed
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Juan Basso
 */
	function uploadCheckMaxWidth(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['MaxWidth']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (!empty($field['name']) && $options['length']['maxWidth'] > 0 && imagesx($field['tmp_name']) > $options['length']['maxWidth']) {
				return false;
			}
		}
		return true;
	}

/**
 * Checks if the min height is allowed
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Juan Basso
 */
	function uploadCheckMinHeight(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['MinHeight']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (!empty($field['name']) && $options['length']['minHeight'] > 0 && imagesy($field['tmp_name']) < $options['length']['minHeight']) {
				return false;
			}
		}
		return true;
	}

/**
 * Checks if the max height is allowed
 *
 * @param $model Object
 * @param $data Array
 * @return boolean
 * @author Juan Basso
 */
	function uploadCheckMaxHeight(&$model, $data) {
		foreach ($data as $fieldName => $field) {
			if (!$this->__model->validate[$fieldName]['MaxHeight']['check']) {
				return true;
			}
			$options = $this->__fields[$fieldName];
			if (!empty($field['name']) && $options['length']['maxHeight'] > 0 && imagesy($field['tmp_name']) > $options['length']['maxHeight']) {
				return false;
			}
		}
		return true;
	}

/**
 * Uploads the files
 *
 * @param $model Object
 * @param $data Array Optional Containing data to be saved
 * @return array
 * @author Vinicius Mendes
 */
	function _uploadFile($model, $data = null) {
		if (!isset($data) || !is_array($data)) {
			$data =& $model->data;
		}
		foreach ($this->__fields as $fieldName => $options) {
			if (empty($data[$model->alias][$fieldName]['name'])) {
				unset($data[$model->alias][$fieldName]);
				$result = array('return' => true, 'data' => $data);
				continue;
			}
			$pos = strrpos($data[$model->alias][$fieldName]['type'], '/');
			$sub = substr($data[$model->alias][$fieldName]['type'], $pos+1);

			// Put in a subfolder if the user wishes it
			if (isset($options['folderAsField']) && !empty($options['folderAsField']) && is_string($options['folderAsField'])) {
				$options['dir'] = $options['dir'] . DS . $data[$model->alias][$options['folderAsField']];
			}

			// Check whether or not the behavior is in useTable mode
			if ($options['useTable'] == false) {
				$this->_includeDefaultReplacement($options['default']);
				$this->_fixName($fieldName, false);
				$saveAs = $options['dir'] . DS . $data[$model->alias][$options['uploadName']] . '.' . $sub;

				// Attempt to move uploaded file
				$copyResults = $this->_copyFileFromTemp($data[$model->alias][$fieldName]['tmp_name'], $saveAs);
				if ($copyResults !== true) {
					$result = array('return' => false, 'reason' => 'validation', 'extra' => array('field' => $field, 'error' => $copyResults));
					continue;
				}

				// If the file is an image, try to make the thumbnails
				if ($options['thumbnails'] && count($options['allowedExt']) > 0 && in_array($data[$model->alias][$fieldName]['type'], $this->_imageTypes)) {
					foreach ($options['thumbsizes'] as $key => $value) {
						// Create the directory if it doesn't exist
						$this->_createThumbnailFolders($options['dir'], $key);
						// Generate the name for the thumbnail
						$thumbSaveAs = $this->_getThumbnailName($saveAs, $options['dir'], $key, $data[$model->alias][$options['uploadName']], $sub);
						$params = array(
							'thumbWidth' => $value['width'],
							'thumbHeight' => $value['height']
						);
						if (isset($value['maxDimension'])) {
							$params['maxDimension'] = $value['maxDimension'];
						}
						if (isset($value['thumbnailQuality'])) {
							$params['thumbnailQuality'] = $value['thumbnailQuality'];
						}
						if (isset($value['zoomCrop'])) {
							$params['zoomCrop'] = $value['zoomCrop'];
						}
						$this->_createThumbnail($saveAs, $thumbSaveAs, $fieldName, $params);
					}
				}
				$data = $this->_unsetDataFields($model->alias, $fieldName, $model->data, $options);
				$result = array('return' => true, 'data' => $data);
				continue;
			} else {
				// if the file is marked to be deleted, use the default or set the field to null
				if (!empty($data[$model->alias][$fieldName]['remove'])) {
					if ($options['default']) {
						$data[$model->alias][$fieldName] = $options['default'];
					} else {
						$data[$model->alias][$fieldName] = null;
					}
					//if the record is already saved in the database, set the existing file to be removed after the save is sucessfull
					if (!empty($data[$model->alias][$model->primaryKey])) {
						$this->_setFileToRemove($fieldName);
					}
				}

				// If no file has been upload, then unset the field to avoid overwriting existant file
				if (!isset($data[$model->alias][$fieldName]) || !is_array($data[$model->alias][$fieldName]) || empty($data[$model->alias][$fieldName]['name'])) {
					if (!empty($data[$model->alias][$model->primaryKey]) || !$options['default']) {
						unset($data[$model->alias][$fieldName]);
					} else {
						$data[$model->alias][$fieldName] = $options['default'];
					}
				}

				//if the record is already saved in the database, set the existing file to be removed after the save is sucessfull
				if (!empty($data[$model->alias][$model->primaryKey])) {
					$this->_setFileToRemove($fieldName);
				}

				// Fix the filename, removing bad characters and avoiding from overwriting existing ones
				if ($options['default'] == true) {
					$this->_includeDefaultReplacement($options['default']);
				}
				$this->_fixName($fieldName);
				$saveAs = $options['dir'] . DS . $data[$model->alias][$fieldName]['name'];

				// Attempt to move uploaded file
				$copyResults = $this->_copyFileFromTemp($data[$model->alias][$fieldName]['tmp_name'], $saveAs);
				if ($copyResults !== true) {
					$result = array('return' => false, 'reason' => 'validation', 'extra' => array('field' => $field, 'error' => $copyResults));
					continue;
				}

				// If the file is an image, try to make the thumbnails
				if ($options['thumbnails'] && count($options['allowedExt']) > 0 && in_array($data[$model->alias][$fieldName]['type'], $this->_imageTypes)) {
					foreach ($options['thumbsizes'] as $key => $value) {
						// Create the directory if it doesn't exist
						$this->_createThumbnailFolders($options['dir'], $key);
						// Generate the name for the thumbnail
						if (isset($options['uploadName']) && !empty($options['uploadName'])) {
							$thumbSaveAs = $this->_getThumbnailName($saveAs, $options['dir'], $key, $data[$model->alias][$options['uploadName']], $sub);
						} else {
							$thumbSaveAs = $this->_getThumbnailName($saveAs, $options['dir'], $key, $data[$model->alias][$fieldName]['name']);
						}
						$params = array(
							'thumbWidth' => $value['width'],
							'thumbHeight' => $value['height']
						);
						if (isset($value['maxDimension'])) {
							$params['maxDimension'] = $value['maxDimension'];
						}
						if (isset($value['thumbnailQuality'])) {
							$params['thumbnailQuality'] = $value['thumbnailQuality'];
						}
						if (isset($value['zoomCrop'])) {
							$params['zoomCrop'] = $value['zoomCrop'];
						}
						$this->_createThumbnail($saveAs, $thumbSaveAs, $fieldName, $params);
					}
				}

				// Update model data
				$data[$model->alias][$options['fields']['dir']] = $options['dir'];
				$data[$model->alias][$options['fields']['mimetype']] = $data[$model->alias][$fieldName]['type'];
				$data[$model->alias][$options['fields']['filesize']] = $data[$model->alias][$fieldName]['size'];
				$data[$model->alias][$fieldName] = $data[$model->alias][$fieldName]['name'];
				$result = array('return' => true, 'data' => $data);
				continue;
			}
		}
		if (isset($result)) {
			return $result;
		} else {
			return true;
		}
	}

/**
 * Function to create Thumbnail images
 *
 * @author Jose Diaz-Gonzalez
 * @param String source file name (without path)
 * @param String target file name (without path)
 * @param String path to source and destination (no trailing DS)
 * @param Array
 * @return void
 */
	function _createThumbnail($source, $target, $fieldName, $params = array()) {
		$params = array_merge(
			array(
				'thumbWidth' => 150,
				'thumbHeight' => 225,
				'maxDimension' => '',
				'thumbnailQuality' => $this->__fields[$fieldName]['thumbnailQuality'],
				'zoomCrop' => false
			),
			$params);

		// Import phpThumb class
		App::import('Vendor','phpthumb', array('file' => 'phpThumb'.DS.'phpthumb.class.php'));

		// Configuring thumbnail settings
		$phpThumb = new phpthumb;
		$phpThumb->setSourceFilename($source);

		if ($params['maxDimension'] == 'w') {
			$phpThumb->w = $params['thumbWidth'];
		} else if ($params['maxDimension'] == 'h') {
			$phpThumb->h = $params['thumbHeight'];
		} else {
			$phpThumb->w = $params['thumbWidth'];
			$phpThumb->h = $params['thumbHeight'];
		}

		$phpThumb->setParameter('zc', $this->__fields[$fieldName]['zoomCrop']);
		if (isset($params['zoomCrop'])){
			$phpThumb->setParameter('zc', $params['zoomCrop']);
		}
		$phpThumb->q = $params['thumbnailQuality'];

		$imageArray = explode(".", $source);
		$phpThumb->config_output_format = $imageArray[1];
		unset($imageArray);

		$phpThumb->config_prefer_imagemagick = $this->__fields[$fieldName]['useImageMagick'];
		$phpThumb->config_imagemagick_path = $this->__fields[$fieldName]['imageMagickPath'];

		// Setting whether to die upon error
		$phpThumb->config_error_die_on_error = true;
		// Creating thumbnail
		if ($phpThumb->GenerateThumbnail()) {
			if (!$phpThumb->RenderToFile($target)) {
				$this->_addError('Could not render image to: '.$target);
			}
		}
	}

/**
 * Merges two arrays recursively
 *
 * @param $arr Array
 * @param $ins Array
 * @return array
 * @author Vinicius Mendes
 */
	function _arrayMerge($arr, $ins) {
		if (is_array($arr)) {
			if (is_array($ins)) {
				foreach ($ins as $k => $v) {
					if (isset($arr[$k]) && is_array($v) && is_array($arr[$k])) {
						$arr[$k] = $this->_arrayMerge($arr[$k], $v);
					} else {
						$arr[$k] = $v;
					}
				}
			}
		} elseif (!is_array($arr) && (strlen($arr) == 0 || $arr == 0)) {
			$arr = $ins;
		}
		return $arr;
	}

/**
 * Replaces some tokens. {ModelName} to the underscore version of the model name
 * {fieldName} to the field name, {DS}. / or \ to DS constant value.
 *
 * @param $string String
 * @param $fieldName String
 * @return string
 * @author Vinicius Mendes
 */
	function _replaceTokens($string, $fieldName, $tokens = array()) {
		return str_replace(
			$tokens,
			array(Inflector::underscore($this->__model->name), $fieldName, DS, DS, DS),
			$string
		);
	}

/**
 * Removes the bad characters from the $filename and replace reserved words. It updates the $model->data.
 *
 * @param $fieldName String
 * @return void
 * @author Vinicius Mendes
 */
	function _fixName($fieldName, $checkFile = true) {
		// TODO : random generated filenames */
		// updates the filename removing the keywords thumb and default name for the field.
		list ($filename, $ext) = $this->_splitFilenameAndExt($this->__model->data[$this->__model->name][$fieldName]['name']);
		$filename = str_replace($this->patterns, $this->replacements, $filename);
		$filename = Inflector::slug($filename);
		$i = 0;
		$newFilename = $filename;
		if ($checkFile) {
			while (file_exists($this->__fields[$fieldName]['dir'] . DS . $newFilename . '.' . $ext)) {
				$newFilename = $filename . $i++;
			}
		}
		$this->__model->data[$this->__model->name][$fieldName]['name'] = $newFilename . '.' . $ext;
	}

/**
 * Include a pattern of reserved word based on a filename, and it's replacement.
 *
 * @param $default String
 * @return void
 * @author Vinicius Mendes
 */
	function _includeDefaultReplacement($default) {
		$replacements = $this->replacements;
		list ($newPattern, $ext) = $this->_splitFilenameAndExt($default);
		if (!in_array($newPattern, $this->patterns)) {
			$this->patterns[] = $newPattern;
			$newReplacement = $newPattern;
			if (isset($newReplacement[1])) {
				if ($newReplacement[1] != '_') {
					$newReplacement[1] = '_';
				} else {
					$newReplacement[1] = 'a';
				}
			} elseif ($newReplacement != '_') {
				$newReplacement = '_';
			} else {
				$newReplacement = 'a';
			}
			$this->replacements[] = $newReplacement;
		}
	}

/**
 * Splits a filename in two parts: the name and the extension. Returns an array with it respectively.
 *
 * @param $filename String
 * @return array
 * @author Vinicius Mendes
 */
	function _splitFilenameAndExt($filename) {
		$parts = explode('.', $filename);
		$ext = $parts[count($parts) - 1];
		unset($parts[count($parts) - 1]);
		$filename = implode('.', $parts);
		return array($filename, $ext);
	}

/**
 * Generate the name for the thumbnail
 * If a 'normal' thumbnail is set, then it will overwrite the original file
 *
 * @param $saveAs String name for original file
 * @param $dir String directory for all uploads
 * @param $key String thumbnail size
 * @param $fieldToSaveAs String field in model to save as
 * @param $sub String substring to append to directory for naming
 * @return string
 * @author Jose Diaz-Gonzalez
 **/
function _getThumbnailName($saveAs, $dir, $key, $fieldToSaveAs, $sub = null) {
	$result = '';
	if($key == 'normal'){
		$result = $saveAs;
	// Otherwise, set the thumb filename to thumb.$key.$filename.$ext
	} else {
		$result = $dir . DS . 'thumb' . DS . $key . DS . $fieldToSaveAs;
		if (isset($sub)) {
			$result .= '.' . $sub;
		}
	}
	return $result;
}

/**
 * Convert a size value to bytes. For example: 2 MB to 2097152.
 *
 * @param $size String
 * @return int
 * @author Vinicius Mendes
 */
	function _sizeToBytes($size) {
		if (is_numeric($size)) {
			return $size;
		}
		if (!preg_match('/^([1-9][0-9]*) (kb|mb|gb|tb)$/i', $size, $matches)) {
			trigger_error(__d('meio_upload', 'MeioUploadBehavior Error: The max_size option format is invalid.', true), E_USER_ERROR);
			return 0;
		}
		switch (strtolower($matches[2])) {
			case 'kb':
				return $matches[1] * 1024;
			case'mb':
				return $matches[1] * 1048576;
			case 'gb':
				return $matches[1] * 1073741824;
			case 'tb':
				return $matches[1] * 1099511627776;
			default:
				trigger_error(__d('meio_upload', 'MeioUploadBehavior Error: The max_size unit is invalid.', true), E_USER_ERROR);
		}
		return 0;
	}

/**
 * Sets the validation for each field, based on the options.
 *
 * @param $fieldName String
 * @param $options Array
 * @return void
 * @author Vinicius Mendes
 */
	function _setupValidation($fieldName, $options) {
		$options = $this->__fields[$fieldName];

		if (isset($this->__model->validate[$fieldName])) {
			if (isset($this->__model->validate[$fieldName]['rule'])) {
				$this->__model->validate[$fieldName] = array(
					'oldValidation' => $this->__model->validates[$fieldName]
				);
			}
		} else {
			$this->__model->validate[$fieldName] = array();
		}
		$this->__model->validate[$fieldName] = $this->_arrayMerge($this->defaultValidations, $this->__model->validate[$fieldName]);
		$this->__model->validate[$fieldName] = $this->_arrayMerge($options['validations'], $this->__model->validate[$fieldName]);
	}

/**
 * Creates thumbnail folders if they do not already exist
 *
 * @param $dir string Path to uploads
 * @param $key string Name for particular thumbnail type
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function _createThumbnailFolders($dir, $key) {
		$folder = new Folder();
		if (!$folder->cd(APP . "webroot" . DS . $dir)) {
			$folder->mkdir(APP . "webroot" . DS . $dir);
		}
		if (!$folder->cd(APP . "webroot" . DS . $dir. DS . 'thumb')) {
			$folder->mkdir(APP . "webroot" . DS . $dir . DS . 'thumb');
		}
		if (!$folder->cd(APP . "webroot" . DS . $dir . DS .'thumb' . DS . $key)) {
			$folder->mkdir(APP . "webroot" . DS . $dir . DS . 'thumb' . DS . $key);
		}
	}

/**
 * Copies file from temporary directory to final destination
 *
 * @param $tmpName string full path to temporary file
 * @param $saveAs string full path to move the file to
 * @return mixed true is successful, error message if not
 * @author Jose Diaz-Gonzalez
 **/
function _copyFileFromTemp($tmpName, $saveAs) {
	$results = true;
	$file = new File($tmpName, $saveAs);
	$temp = new File($saveAs, true);
	if (!$temp->write($file->read())) {
		$results = __d('meio_upload', 'Problems in the copy of the file.', true);
	}
	$file->close();
	$temp->close();
	return $results;
}

/**
 * Set a file to be removed in afterSave() callback
 *
 * @param $fieldName String
 * @return null
 * @author Vinicius Mendes
 */
	function _setFileToRemove($fieldName) {
		$filename = $this->__model->field($fieldName);
		if (!empty($filename) && $filename != $this->__fields[$fieldName]['default']) {
			$this->__filesToRemove[] = array(
				'dir' => $this->__fields[$fieldName]['dir'],
				'name' => $filename
			);
		}
	}

/**
 * Marks files for deletion in the beforeSave() callback
 *
 * @param $modelName string name of the Model
 * @param $modelPrimaryKey string field of the Model that is the primary key
 * @param $fieldName string name of field that holds a reference to the file
 * @param $data array
 * @param $default
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function _markForDeletion($modelName, $modelPrimaryKey, $fieldName, $data, $default) {
		if (!empty($data[$modelName][$fieldName]['remove'])) {
			if ($default) {
				$data[$modelName][$fieldName] = $default;
			} else {
				$data[$modelName][$fieldName] = '';
			}
			//if the record is already saved in the database, set the existing file to be removed after the save is sucessfull
			if (!empty($data[$modelName][$modelPrimaryKey])) {
				$this->_setFileToRemove($fieldName);
			}
		}
	}

/**
 * Delete the $filename inside the $dir and the thumbnails.
 * Returns true if the file is deleted and false otherwise.
 *
 * @param $filename Object
 * @param $dir Object
 * @return boolean
 * @author Vinicius Mendes
 */
	function _deleteFiles($filename, $dir) {
		$saveAs = $dir . DS . $filename;
		if (is_file($saveAs) && !unlink($saveAs)) {
			return false;
		}
		/* kouak : remove thumbnails */
		foreach($this->__fields as $f) {
			foreach ($f['thumbsizes'] as $name => $size) {
				$this->log('Removing : ' . $dir . DS . 'thumb' . DS . $name . DS . $filename);
				if(is_file($dir . DS . 'thumb' . $name . DS . $filename) && !unlink($dir . DS . 'thumb' . $name . DS . $filename)) {
					return false;
				}
			}
		}
		return true;
	}

/**
 * Unsets data from $data
 * Useful for no-db upload
 *
 * @param $modelName string name of the Model
 * @param $fieldName string name of field that holds a reference to the file
 * @param $data array
 * @param $options array
 * @return array
 * @author Jose Diaz-Gonzalez
 **/
	function _unsetDataFields($modelName, $fieldName, $data, $options) {
		unset($data[$modelName][$fieldName]);
		unset($data[$modelName][$options['fields']['dir']]);
		unset($data[$modelName][$options['fields']['filesize']]);
		unset($data[$modelName][$options['fields']['mimetype']]);
		return $data;
	}

/**
 * Adds an error, legacy from the component
 *
 * @param $msg string error message
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function _addError($msg) {
		$this->errors[] = $msg;
	}
}
?>