<?php

class SearchUser {

	private $_user= false;

	public function __construct($userName= false) {

		if (isset($userName))
			return findMatchesSnippetsNames($userName);
			
	}

	public function getAllUserInformations($userName) {
		
		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('SELECT * FROM users WHERE name = :name');
		$request->prepare(array( 'name' => $userName));

		$this->_user= new Users($request(PDO::FETCH_ASSOC));		

		return $this->_user;

	}

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

}