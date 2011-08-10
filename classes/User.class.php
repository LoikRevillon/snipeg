<?php

class User {

	private $_id;
	private $_admin;
	private $_name;
	private $_email;
	private $_password;
	private $_locked;
	private $_theme;
	private $_font;
	private $_colorScheme;
	private $_language;
	private $_favoriteLang;

	public function __construct ($userInformations) {

		if (isset($userInformations['id']))
			$this->_id= $userInformations['id'];
			
		$this->_admin= $userInformations['admin'];
		$this->_name= $userInformations['name'];
		$this->_email= $userInformations['email'];
		$this->_password= $userInformations['password'];
		$this->_locked= $userInformations['locked'];		
		$this->_theme= $userInformations['theme'];
		$this->_font= $userInformations['font'];
		$this->_colorScheme= $userInformations['color_scheme'];
		$this->_language= $userInformations['language'];
		$this->_favoriteLang= $userInformations['favorite_lang'];
		
	}

	public function __get($varName) {

		if (isset($this->$varName))
			return $this->{$varName};

	}

	public function addNewUser() {

		$manager= UsersManager::getReference();
		
		if ($manager->userExistInDB($this->_name))
			return false;

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('INSERT INTO users VALUES(:admin, :name, :email, :password, :locked, :theme, :font, :color_scheme, :language, :favorite_lang)');
		$request->bindParam(':admin', $this->_admin, PDO::PARAM_INT, 1);
		$request->bindParam(':name', $this->_name, PDO::PARAM_STR, 30);
		$request->bindParam(':email', $this->_email, PDO::PARAM_STR, 80);
		$request->bindParam(':password', $this->_password, PDO::PARAM_STR, 64);
		$request->bindParam(':locked', $this->_locked, PDO::PARAM_INT, 1);
		$request->bindParam(':theme', $this->_theme, PDO::PARAM_STR, 50);
		$request->bindParam(':font', $this->_font, PDO::PARAM_STR, 30);
		$request->bindParam(':color_scheme', $this->_colorScheme, PDO::PARAM_STR, 20);
		$request->bindParam(':language', $this->_language, PDO::PARAM_STR, 5);
		$request->bindParam(':favorite_lang', $this->_favoriteLang, PDO::PARAM_STR);
		$updatedRow= $request->execute();

		if ($updatedRow == 1)
			return true;
		else
			return false;

	}

	public function deleteUser() {

		if (!empty($this->_id)) {

			$db= PDOSQLite::getDBLink();
			$request= $db->prepare('DELETE FROM users WHERE rowid = :id');
			$request->bindParam(':id', $this->_id, PDO::PARAM_INT, 1);

			if ($request->execute();)
				return true;
			else
				return false;
		}

		return false;
			
	}

}