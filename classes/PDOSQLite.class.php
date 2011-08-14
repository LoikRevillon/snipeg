<?php

class PDOSQLite {

	private static $_dbLink;

	private static $_instance;

	private function __construct() {

		try {
			self::$_dbLink = new PDO('sqlite:' . DB_NAME);
			self::$_dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(Exception $e) {
			die('Error :' . $e->getMessage());
		}

	}

	public static function getDBLink() {

		if(!isset(self::$_instance) OR !isset($_dbLink))
			self::$_instance = new self();

		return self::$_dbLink;

	}

}