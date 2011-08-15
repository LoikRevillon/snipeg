<?php

class AvatarGenerator {

	private $_oFile;
	private $_oExtension;
	private $_oHeight;
	private $_oWidth;

	private $_directory;
	private $_filename;
	private $_height;
	private $_width;

	private $_authorizedMime = array(
		'image/gif', 'image/jpeg', 'image/png'
	);

	public function __construct($filearray, $filename, $directory = AVATAR_DIR, $width = AVATAR_WIDTH, $height = AVATAR_HEIGHT) {

		global $Lang;

		if(!extension_loaded('gd'))
			throw new AvatarGeneratorException($Lang->error_extension_gd_not_found);

		$this->_oFile = $filearray['tmp_name'];
		$this->_oExtension = pathinfo($this->_oFile, PATHINFO_EXTENSION);
		$type = $filearray['type'];
		$errors = $filearray['error'];

		if(!in_array($type, $this->_authorizedMime))
			throw new AvatarGeneratorException($Lang->error_unauthorized_filetype . ' : ' . $type);
		if(!file_exists($this->_oFile))
			throw new AvatarGeneratorException($Lang->error_uploaded_file_not_found . ' : ' . $tmp_file);
		if(!file_exists($directory) OR !is_dir($directory))
			throw new AvatarGeneratorException($Lang->error_is_not_a_valid_dir . ' : ' . $dir);

		switch($errors) {
			case 1 :
			case 2 :
				throw new AvatarGeneratorException($Lang->error_file_size_exceeds_php_limits);
			break;
			case 3 :
				throw new AvatarGeneratorException($Lang->error_upload_interrupted);
			break;
			case 4 :
				throw new AvatarGeneratorException($Lang->error_uploaded_file_is_empty);
			break;
		}

		list($this->_oWidth, $this->_oHeight) = getimagesize($this->_oFile);

		$this->_directory = $directory;
		$this->_filename = $filename;
		$this->_height = $height;
		$this->_width = $width;

		return $this->_generate();

	}

	private function _generate() {

		$imagecreatefrom = $this->_imagecreatefrom();
		$source = $imagecreatefrom($this->_oFile);
		$destination = imagecreatetruecolor($this->_width, $this->_height);

		$tmpHeight = floor($this->_width * $this->_oHeight / $this->_oWidth);
		$tmpWidth = floor($this->_oWidth * $this->_height / $this->_oHeight);

		if($tmpWidth >= $tmpHeight AND $tmpWidth >= $this->_width) {
			$semi_diff = floor(($tmpWidth - $this->_width ) /2);
			imagecopyresampled($destination, $source, -$semi_diff, 0, 0,0, $tmpWidth, $this->_height, $this->_oWidth, $this->_oHeight);
		} else {
			$semi_diff = floor(($tmpHeight - $this->_height )/2);
			imagecopyresampled($destination, $source, 0, -$semi_diff, 0, 0, $this->_width, $tmpHeight, $this->_oWidth, $this->_oHeight);
		}

		if(imagepng($destination, $this->_directory . $this->_filename . '.png', 98)) {
			imagedestroy($source);
			imagedestroy($destination);
			return true;
		}

		return false;

	}

	private function _imagecreatefrom() {

		switch($this->_oExtension) {
			case 'png':
				return 'imagecreatefrompng';
			break;
			case 'gif':
				return 'imagecreatefromgif';
			break;
			default:
				return 'imagecreatefromjpeg';
			break;
		}

	}

}

class AvatarGeneratorException extends Exception {}