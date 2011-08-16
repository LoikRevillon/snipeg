<?php

class PDOSQLite {

	private static $_dbLink;

	private static $_instance;

	private function __construct($checkExists = true) {

		global $Lang;

		try {
			if($checkExists AND !file_exists(DB_NAME) AND !is_dir(DB_NAME))
				throw new Exception($Lang->warning_no_database_initialized);
			self::$_dbLink = new PDO('sqlite:' . DB_NAME);
			self::$_dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(Exception $e) {
			die('Error :' . $e->getMessage());
		}

	}

	public static function getDBLink($checkExists = true) {

		if(!isset(self::$_instance) OR !isset($_dbLink))
			self::$_instance = new self($checkExists);

		return self::$_dbLink;

	}

}