<?php
/* Handle the resizing of images, data validation is done in the swfupload component (I know this is SOOOOOO wrong !) */
class PhpThumbBehavior extends ModelBehavior {

	/** 
	* Array of errors 
	*/ 
	public $errors = array(); 

	/** 
	* Default settings (set in __construct)
	*/ 
	private $__defaults = array();
	
	public $settings = array();

	function __construct() {
		$this->__defaults = array(
			/* Image resizing default */
			'default' => array(
				'width' => 500,
				'height' => 500,
				'zoomcrop' => false,
				'folder' => IMAGES . 'upload' . DS,
			),
			/* Thumbnails settings */
			'thumb' => array(
				'folder' => IMAGES . 'upload' . DS . 'thmb' . DS,
				'width' => 150,
				'height' => 150,
				'zoomcrop' => false,
			),
			/* Avatars settings */
			'avatar' => array(
				'folder' => IMAGES . 'upload' . DS . 'avatar' . DS,
				'width' => 100,
				'height' => 100,
				'zoomcrop' => false,
				'sx' => 0,
				'sy' => 0,
				'sw' => 0,
				'sh' => 0,
				'aoe' => 1, /* authorize zooming */
				'f' => 'png', /* output type */
			),
		);
	}
	function setup(&$Model, $settings = array()) {
        $options = am($this->__defaults, $settings);
        $this->settings[$Model->name] = $options;
		$this->errors[$Model->name] = array();
	}
	
	/**
	* Resize an image
	*
	* Looks like a private function to me, but could be used as it is
	* 
	* @param $filename String Nom du fichier
	* @param $options Array Can override $settings and add these options :
	*				output : relative to 'folder' output image filename (default : $filename (overwrite))
	*				delete_source : if output is different from input, this set to true will delete the source file (default : false)
	* @return Returns true in case of success, false otherwise ($this->errors[$Model->name] gets populated)
	*/
	function resizeImage(&$Model, $filepath, $options = array()) {
		if(!file_exists($filepath)) {
			$this->errors[$Model->name][] = __('PhpThumb behavior : le fichier ', true) . $filepath . __(' n\'existe pas.', true);
			return false;
		}
		$settings = am(am($this->settings[$Model->name]['default'], array('output' => $filepath, 'delete_source' => false)), $options);
		
		App::import('Vendor', 'phpThumb', array('file' => 'phpThumb'.DS.'phpthumb.class.php'));
		
		$phpThumb = new phpThumb();
		$phpThumb->setSourceFilename($filepath);
		$phpThumb->setParameter('w', $settings['width']);
		$phpThumb->setParameter('h', $settings['height']);
		if($settings['zoomcrop'] === true) {
			//$phpThumb->setParameter('zc', 1);
		}
		
		if(!(0 == $settings['sx'] && 0 == $settings['sy'] && 0 == $settings['sw'] && 0 == $settings['sh'])) {
			$phpThumb->setParameter('sx', $settings['sx']);
			$phpThumb->setParameter('sy', $settings['sy']);
			$phpThumb->setParameter('sw', $settings['sw']);
			$phpThumb->setParameter('sh', $settings['sh']);
			if($settings['aoe']) {
				$phpThumb->setParameter('aoe', 1);
			}
		}
		
		if(isset($settings['f'])) {
			$phpThumb->setParameter('f', $settings['f']);
		}
		
		if(!$phpThumb->generateThumbnail()) { /* Woopsy, the image couldn't be resized */
			debug($phpThumb->debugmessages);
			$this->errors[$Model->name][] = __('PhpThumb behavior : le fichier ', true) . $filepath . __(' n\'a pas pu être resizé', true);
			return false;
		}
		
		if(!$phpThumb->RenderToFile($settings['output'])) { /* File couldn't be created */
			$this->errors[$Model->name][] = __('PhpThumb behavior : le fichier ', true) . $settings['folder'] . $settings['output'] . __(' n\'a pas pu être créé', true);
			return false;
		}
		
		if($settings['delete_source'] && $settings['output'] != $filepath) {
			if(!unlink($filepath)) {
				$this->errors[$Model->name][] = __('PhpThumb behavior : le fichier ', true) . $filepath . __(' n\'a pas pu être supprimé', true);
				return false;
			}
		}
		return true;
	}
	

	
	static function __getFileExtension($fullpath) {
		$path_info = pathinfo($fullpath);
	    return $path_info['extension'];
	}
	
	function __getUniqueFileName($folder) {
		if($folder[strlen($folder)-1] != '/') {
			$folder .= '/';
		}
		do {
			$filename = md5(rand());
		} while(file_exists($folder . $filename));
		return $filename;
	}
	
	
	/**
	 * Resize image and create thumb with random filename
	 *
	 * @param $data Mixed Filedata array (with key 'fspath' set) or string representing image full path
	 *
	 * @return String : new file name or false in case of failure
	 */
	
	function resizeAndThumb(&$Model, $fullpath) {
		if(!file_exists($fullpath)) {
			$this->errors[$Model->name][] = __('PhpThumb behavior : le fichier ', true) . $filepath . __(' n\'existe pas', true);
			return false;
		}
		$directory = dirname($fullpath);
		$outputdir = $this->settings[$Model->name]['default']['folder'];
		$filename = $this->__getUniqueFileName($outputdir) . '.' . $this->__getFileExtension($fullpath);
		if(!$this->resizeImage($Model, $fullpath, array('output' => $outputdir . $filename, 'delete_source' => false))) {
			return false;
		}
		
		/* Create thumb */
		$outputthumbdir = $this->settings[$Model->name]['thumb']['folder'];
		if(!$this->createThumb(&$Model, $fullpath, array('output' => $outputthumbdir . $filename, 'delete_source' => true))) {
			return false;
		}
		return $outputdir . $filename;
	}
	
	function createThumb(&$Model, $filepath, $options = array()) {
		if(!file_exists($filepath)) {
			$this->errors[$Model->name][] = __('PhpThumb behavior : le fichier ', true) . $filepath . __(' n\'existe pas.', true);
			return false;
		}
		$settings = am(am($this->settings[$Model->name]['thumb'], array('output' => $this->settings[$Model->name]['thumb']['folder'] . basename($filepath))), $options);
		
		return $this->resizeImage($Model, $filepath, $settings);
	}
	
	function createAvatar(&$Model, $filepath, $options = array()) {
		if(!file_exists($filepath)) {
			$this->errors[$Model->name][] = __('PhpThumb behavior : le fichier ', true) . $filepath . __(' n\'existe pas.', true);
			return false;
		}
		$settings = am(am($this->settings[$Model->name]['avatar'], array('output' => $this->settings[$Model->name]['avatar']['folder'] . basename($filepath))), $options);
		
		return $this->resizeImage($Model, $filepath, $settings);

		
	}
	
	function avatarPath(&$Model, $filename = null) {
		return $this->settings[$Model->name]['avatar']['folder'] . basename($filename);
	}
	
	function uploadPath(&$Model, $filename = null) {
		return $this->settings[$Model->name]['default']['folder'] . basename($filename);
	}
	
	function getPhpThumbErrors(&$Model) {
		$toreturn = $this->errors[$Model->name];
		$this->errors[$Model->name] = array();
		return $toreturn;
	}

	/* Let's remove all linked files */
	
	function beforeDelete(&$Model) {
		$Model->read(null, $model->id);
		if(isset($Model->data)) {
				$filename = $Model->data[$Model->name]['filename'];
				foreach($this->settings[$Model->name] as $s) {
					if(file_exists($s['folder'] . $filename)) {
						@unlink($s['folder'] . $filename);
					}
				}
		}
		return true;
	}
}

?>