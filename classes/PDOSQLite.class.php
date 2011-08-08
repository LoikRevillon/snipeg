<?php

class PDOSQLite {

	const DB_NAME='stanislas.sqlite';

	protected static $_dbLink;
	private static $_instance;

	private function __construct ($dbName) {

		try {
			self::$_dbLink= new PDO('sqlite:'.$dbName);
			self::$_dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e) {
			die (' Erreur :'.$e->getMessage());
		}

		self::$_dbLink->query('CREATE TABLE IF NOT EXISTS snippets (name VARCHAR(255), owner VARCHAR(30), content TEXT, last_update BIGINT(32), comment VARCHAR(100), category INT, policy INT(1))');
		self::$_dbLink->query('CREATE TABLE IF NOT EXISTS users (admin INT(1), name VARCHAR(30), email VARCHAR(80), password VARCHAR(64), theme VARCHAR(50), font VARCHAR(50), color_scheme VARCHAR(10), language VARCHAR(5))');

	}

	final private function __clone() {}

	public static function getDbLink() {

		if (!isset(self::$_instance))
			self::$_instance= new self(self::DB_NAME);

		return self::$_dbLink;

	}

}