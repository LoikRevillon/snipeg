<?php

class Users {

	private $_id;
	private $_admin;
	private $_name;
	private $_email;
	private $_password;
	private $_theme;
	private $_font;
	private $_colorScheme;
	private $_language;

	public function __construct ($userInformations) {

		if (isset($userInformations['id']))
			$this->_id= $userInformations['id'];
			
		$this->_admin= $userInformations['admin'];
		$this->_name= $userInformations['name'];
		$this->_email= $userInformations['email'];
		$this->_password= $userInformations['password'];
		$this->_theme= $userInformations['theme'];
		$this->_font= $userInformations['font'];
		$this->_colorScheme= $userInformations['color_scheme'];
		$this->_language= $userInformations['language'];

	}

/*
	public function getAllUserInformations($name) {
		
		$request= PDOSQLite::getDbLink()->prepare('SELECT * FROM'.$this->_tableName.' WHERE name = :name');
		$request->prepare(array( 'name' => $name));

		#$user= $request->fetch(PDO::FETCH_OBJ);
		

		return $user;

	}
*/

	public function addNewUser() {

		$userExist= new UsersManager($this->_name);
		if (!empty($userExist)) {
			return false;
		}
		
		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('INSERT INTO users VALUES (:admin,
														:name,
														:email,
														:password,
														:theme,
														:font,
														:color_scheme,
														:language)');

		$request->bindParam(':admin', $this->_admin, PDO::PARAM_INT, 1);
		$request->bindParam(':name', $this->_name, PDO::PARAM_STR, 30);
		$request->bindParam(':email', $this->_email, PDO::PARAM_STR, 80);
		$request->bindParam(':password', $this->_password, PDO::PARAM_STR, 64);
		$request->bindParam(':theme', $this->_theme, PDO::PARAM_STR, 50);
		$request->bindParam(':font', $this->_font, PDO::PARAM_STR, 50);
		$request->bindParam(':color_scheme', $this->_colorScheme, PDO::PARAM_STR, 10);
		$request->bindParam(':language', $this->_language, PDO::PARAM_STR, 5);
		$request->execute();
		
/*
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
*/

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
		$request->bindParam(':id', $this->_id, PDO::PARAM_STR);
		$request->execute();

/*
		$request->execute(array('id' => $this->_id);
*/

		return true;

	}

}