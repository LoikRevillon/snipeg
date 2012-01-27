<?php

class User {

	private $_id;

	private $_admin;

	private $_name;

	private $_email;

	private $_avatar;

	private $_password;

	private $_locked;

	private $_theme;

	private $_language;

	private $_favoriteLang;

	public function __construct($userInformations) {

		if(isset($userInformations['id']))
			$this->_id = $userInformations['id'];

		$this->_admin = $userInformations['admin'];
		$this->_name = $userInformations['name'];
		$this->_email = $userInformations['email'];
		$this->_avatar = $userInformations['avatar'];
		$this->_password = $userInformations['password'];
		$this->_locked = $userInformations['locked'];
		$this->_theme = $userInformations['theme'];
		$this->_language = $userInformations['language'];
		$this->_favoriteLang = $userInformations['favorite_lang'];

	}

	public function __get($varName) {

		if(isset($this->$varName))
			return $this->$varName;

	}

	public function __set($varName, $value) {

		if(isset($this->$varName))
			$this->$varName = $value;

	}

	public function toStdObject() {

		$userStd = new stdClass();

		$userStd->id = intval($this->_id);
		$userStd->isadmin = ($this->_admin == 1);
		$userStd->name = $this->_name;
		$userStd->email = $this->_email;
		$userStd->avatar = ($this->_avatar == 1) ? HTTP_ROOT . AVATAR_DIR . $this->id . '.png' : HTTP_ROOT . DEFAULT_AVATAR;
		$userStd->islocked = ($this->_locked == 1);
		$userStd->theme = $this->_theme;
		$userStd->language = $this->_language;
		$userStd->favorite_lang = ( !empty( $this->_favoriteLang ) ) ? explode( ',', $this->_favoriteLang ) : array();

		return $userStd;
	}

	public function is_admin() {

		return $this->_admin;
	}

	public function addNewUser() {

		$manager = UsersManager::getReference();

		if($manager->userExistInDB($this->_name))
			return false;

		try {
			$db = PDOSQLite::getDBLink();
			$request = $db->prepare('INSERT INTO `users` VALUES(:admin, :name, :email, :avatar, :password, :locked, :theme, :language, :favorite_lang)');
			$request->bindParam(':admin', $this->_admin, PDO::PARAM_INT, 1);
			$request->bindParam(':name', $this->_name, PDO::PARAM_STR, 30);
			$request->bindParam(':email', $this->_email, PDO::PARAM_STR, 80);
			$request->bindParam(':password', $this->_password, PDO::PARAM_STR, 64);
			$request->bindParam(':avatar', $this->_avatar, PDO::PARAM_INT, 1);
			$request->bindParam(':locked', $this->_locked, PDO::PARAM_INT, 1);
			$request->bindParam(':theme', $this->_theme, PDO::PARAM_STR, 50);
			$request->bindParam(':language', $this->_language, PDO::PARAM_STR, 10);
			$request->bindParam(':favorite_lang', serialize($this->_favoriteLang), PDO::PARAM_STR);
			return $request->execute();
		} catch(Exception $e) {
			return false;
		}

	}

	public function deleteUser() {

		if(empty($this->_id))
			return false;

		try {
			$db = PDOSQLite::getDBLink();
			$request = $db->prepare('DELETE FROM `users` WHERE rowid = :id');
			$request->bindParam(':id', $this->_id, PDO::PARAM_INT, 1);
			return $request->execute();
		} catch(Exception $e) {
			return false;
		}

	}

}
