<?php

class PDOSQLite {

	private static $_dbLink;

	private static $_instance;

	private function __construct($checkExists, $dbfile) {

		global $Lang;

		try {
			if($checkExists AND !file_exists($dbfile) AND !is_dir($dbfile))
				throw new Exception($Lang->warning_no_database_initialized);
			self::$_dbLink = new PDO('sqlite:' . $dbfile);
			self::$_dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(Exception $e) {
			die('Error :' . $e->getMessage());
		}

	}

	public static function getDBLink($checkExists = true, $dbfile = DB_NAME) {

		if(!isset(self::$_instance) OR !isset($_dbLink))
			self::$_instance = new self($checkExists, $dbfile);

		return self::$_dbLink;

	}

}