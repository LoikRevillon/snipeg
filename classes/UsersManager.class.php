<?php

class UsersManager {

	private static $_instance;

	private function __construct() {}

	public static function getReference() {

		if(!isset(self::$_instance))
			self::$_instance = new self();

		return self::$_instance;

	}

	public function userExistInDB($name) {

		$db = PDOSQLite::getDBLink();
		$request = $db->prepare('SELECT rowid as id, * FROM users WHERE name = :name');
		$request->bindParam(':name', $name, PDO::PARAM_STR, 30);
		$request->execute();

		$result = $request->fetch(PDO::FETCH_ASSOC);

		if(!empty($result)) {
			$result['favorite_lang'] = unserialize($result['favorite_lang']);
			$userMatched = new User($result);
		} else {
			$userMatched = false;
		}

		return $userMatched;

	}

	public function getAllUsers($pageNumber) {

		$db = PDOSQLite::getDBLink();
		$request = $db->prepare('SELECT rowid as id, * FROM users ORDER BY name ASC LIMIT :limit_down , :limit_up');
		$request->bindValue(':limit_down', ($pageNumber - 1) * NUM_USER_PER_PAGE, PDO::PARAM_INT);
		$request->bindValue(':limit_up', $pageNumber * NUM_USER_PER_PAGE, PDO::PARAM_INT);
		$request->execute();

		$usersList = array();

		while($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$result['favorite_lang']= unserialize($result['favorite_lang']);
			$usersList[] = new User($result);
		}

		return $usersList;

	}

	public function getUserInformations($userId) {

		$db = PDOSQLite::getDBLink();
		$request = $db->prepare('SELECT rowid as id, * FROM users WHERE rowid = :id');

		$request->bindParam(':id', $userId, PDO::PARAM_INT, 1);
		$request->execute();

		$result = $request->fetch(PDO::FETCH_ASSOC);
		$result['favorite_lang']= unserialize($result['favorite_lang']);
		$matchedUser = new User($result);

		return $matchedUser;

	}

	public function updateUserInfos($userId, $newInfos) {

		if($this->userExistInDB($newInfos->_name))
			return false;

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('UPDATE users SET admin = :admin, name = :name, email = :email, password = :password, locked = :locked, theme = :theme, language = :language, favorite_lang = :favorite_lang WHERE rowid = :id');

		$request->bindValue(':id', $userId, PDO::PARAM_INT);
		$request->bindValue(':admin', $newInfos->_admin, PDO::PARAM_INT);
		$request->bindValue(':name', $newInfos->_name, PDO::PARAM_STR);
		$request->bindValue(':email', $newInfos->_email, PDO::PARAM_STR);
		$request->bindValue(':avatar', $newInfos->_avatar, PDO::PARAM_INT);
		$request->bindValue(':password', $newInfos->_password, PDO::PARAM_STR);
		$request->bindValue(':locked', $newInfos->_locked, PDO::PARAM_INT);
		$request->bindValue(':theme', $newInfos->_theme, PDO::PARAM_STR);
		$request->bindValue(':language', $newInfos->_language, PDO::PARAM_STR);
		$request->bindValue(':favorite_lang', $newInfos->_favoriteLang, PDO::PARAM_STR);

		return $request->execute();

	}

}