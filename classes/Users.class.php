<?php

class Users {

	private $_admin;
	private $_name;
	private $_email;
	private $_password;
	private $_theme;
	private $_font;
	private $_colorScheme;
	private $_language;

	public function __construct ($userInformations) {

		if (isset($userInformations)) {
			$this->_init= true;
			$this->_admin= $userInformations['admin'];
			$this->_name= $userInformations['name'];
			$this->_email= $userInformations['email'];
			$this->_password= $userInformations['password'];
			$this->_theme= $userInformations['theme'];
			$this->_font= $userInformations['font'];
			$this->_colorScheme= $userInformations['colorScheme'];
			$this->_language= $userInformations['language'];
		}

	}

/*
	public function getAllUserInformations($name) {
		
		$request= PDOSQLite::getDbLink()->prepare('SELECT * FROM'.$this->_tableName.' WHERE name = :name');
		$request->prepare(array( 'name' => $name));

		#$user= $request->fetch(PDO::FETCH_OBJ);
		

		return $user;

	}
*/

	public function addNewUser($user) {

		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('INSERT INTO '.$this->_tableName.' VALUES (
														:admin,
														:name,
														:email,
														:password,
														:theme,
														:font,
														:color_scheme,
														:language)');
		$request->execute(array(
					'admin' => $user->admin,
					'name' => $user->name,
					'email' => $user->email,
					'password' => $user->password,
					'theme' => $user->theme,
					'font' => $user->font,
					'color_scheme' => $user->colorScheme,
					'language' => $user->language
					));

		return true;

	}

/*
	public function updateUserInformations($user) {

		$request= $this->_dbLink;
		$request->prepare('UPDATE '.$this->_tableName.' SET :admin, :name, :email, :password, :ui-style, :font, :color_scheme, :language WHERE rowid = :id');
		$changes= $request->execute(array(
					'id' => $user->id,
					'admin' => $user->admin,
					'name' => $user->name,
					'email' => $user->email,
					'password' => $user->password,
					'theme' => $user->theme,
					'font' => $user->font,
					'color_scheme' => $user->colorScheme,
					'language' => $user->language));

		if ($changes == 1)
			return true;
		else
			return false;

	}
*/

	public function deleteThisUser() {

		$request= PDOSQLite::getDbLink();
		$request->prepare('DELETE FROM users WHERE rowid = :id');
		$request->execute(array('id' => $this->_id);

		return true;

	}