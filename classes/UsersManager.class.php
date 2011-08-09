<?php

class UsersManager {

	private $_userName= false;

	public function __construct($userName) {
		
			$this->_userName= $userName;
			
	}

	public function getAllUserInformations($userName= false) {

		if (!empty($userName))
			$this->_userName= $userName;
		
		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('SELECT rowid as id, * FROM users
										WHERE name = :name');
										
		$request->bindParam(':name', $this->_userName, PDO::PARAM_STR, 30);
		$request->execute();

		$arrayOfMatchedUsers= array();

		while ($oneOfMatchedUser= $request->fetch(PDO::FETCH_ASSOC)) {
			$user= new Users($oneOfMatchedUser);
			$arrayOfMatchedUsers[]=$user;
		}
		unset($matchedUser);

		return $arrayOfMatchedUsers;

	}

	public function updateUserInformations($user) {

		$request= $this->_dbLink;
		$request->prepare('UPDATE users SET
								admin = :admin,
								name = :name,
								email = :email,
								password = :password,
								theme = :theme,
								font = :font,
								color_scheme = :color_scheme,
								language = :language
								WHERE rowid = :id');
								
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