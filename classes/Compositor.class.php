<?php

class Compositor {

	private $_object = null;

	public function __construct() {

		$args = func_get_args();
		$objects = array();

		foreach($args AS $arg) {
			if(is_object($arg))
				$objects[] = $arg;
		}

		$this->_object = new stdClass;

		if(empty($objects))
			return;

		foreach($objects AS $object) {
			$attributes = get_object_vars($object);
			if(!empty($attributes)) {
				foreach($attributes AS $key => $value) {
					$this->_object->{$key} = $value;
				}
			}
		}

	}

	public function __get($attr) {

		if(isset($this->_object->$attr))
			return $this->_object->$attr;

	}

	public function __set($attr, $value) {

		$this->_object->$attr = $value;

	}

}