<?php

class PDOSQLite {

	private static $_dbLink;
	private static $_instance;

	private function __construct ($dbName) {

		try {
			self::$_dbLink= new PDO('sqlite:'.$dbName);
			self::$_dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e) {
			die (' Erreur :'.$e->getMessage());
		}

		self::$_dbLink->query('CREATE TABLE IF NOT EXISTS snippets (name VARCHAR(255), id_user INT(1), last_update BIGINT(32), content TEXT, language INT(1), comment TEXT, category VARCHAR(80), tags TEXT, private INT(1))');
		
		self::$_dbLink->query('CREATE TABLE IF NOT EXISTS users (admin INT(1), name VARCHAR(30), email VARCHAR(80), avatar INT(1), password VARCHAR(64), locked INT(1), theme VARCHAR(50), language VARCHAR(10), favorite_lang TEXT)');

	}

	final private function __clone() {}

	public static function getDBLink() {

		if (!isset(self::$_instance) OR !isset($_dbLink))
			self::$_instance= new self(self::DB_NAME);

		return self::$_dbLink;

	}

}