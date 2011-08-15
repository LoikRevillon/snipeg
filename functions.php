<?php

function __autoload($className) {

	$classPath = 'classes/' . $className . '.class.php';

	if(file_exists($classPath))
		require $classPath;
}

function load_page() {

	$pageRequested= $_GET['action'];

	if (isset($_SESSION['user'])) {
		if(isset($Theme->$pageRequested) AND !empty($Theme->$pageRequested))
			if ($pageRequested == 'admin' AND $_SESSION['user']['admin'] !== 1)  {
				Tool::appendMessage($Lang->notenoughrights, M_ERROR);
				$includeFile= 'home';
			} else {
				$includeFile= $pageRequested;
			}
		else
			Tool::appendMessage($Lang->filenotexist, Tool::M_ERROR);
			$includeFile= 'home';
	} else {
		if (isset($_GET['id']) AND SnippetsManager::isPublic($_GET['id'])) {
			$includeFile= 'single';
		} else {
			Tool::appendMessage($Lang->notenoughrights, Tool::M_ERROR);
			$includeFile= 'login';
		}
	}
}

function lang_of_theme() {

	$listLang= array();

	foreach(glob(ROOT . $Theme->dirname . LANGUAGE_DIR . '*.json') as $languageFile) {
		$listLang[] = pathinfo($languageFile, PATHINFO_FILENAME);		
	}
	
	return $listLang;
}

function is_admin() {

	return isset($_SESSION['user']->_admin);

}

function do_login() {

	unset($_POST['dologin']);

	$manager = UsersManager::getReference();
	$login = $_POST['signin-login'];
	unset($_POST['signin-login'])
	$passwd = $_POST['signin-password'];
	unset($_POST['signin-password'];

	if ($user = $manager->userExistinDB($login)) {
		if ($user->password === hash('sha256', $passwd)) {
			$_SESSION['user']= $user;
		}
	}

	if (empty($_SESSION['user']))
		Tool::appendMessage($Lang->wrongsignin, M_ERROR);

	header ('location : ' . ROOT);

}

function do_signUp() {

	unset($_POST['dosignup']);

	$manager= UsersManager::getReference();

	if (!$manager->userExistInDB($_POST['signup-login'])) {
		Tool::appendMessage($Lang->failsignup-login, M_ERROR);
		
	} else if ($_POST['signup-password1'] !== $_POST['signup-password2']) {
		Tool::appendMessage($Lang->failsignup-passwd, M_ERROR);
		
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		Tool::appendMessage($Lang->failsignup-email, M_ERROR);
		
	} else {
		$userInformations= array();
		$userInformations['admin'] = 0;
		$userInformations['name'] = $_POST['signup-login'];
		$userInformations['email'] = $_POST['signup-email'];
		$userInformations['password'] = hash('sha256', $_POST['signup-password']);
		$userInformations['locked'] = 0;
		$userInformations['theme'] = DEFAULT_THEME;
		$userInformations['language'] = DEFAULT_LANG;
		$userInformations['favorite_lang'] = array();

		$newUser= new User ($userInformations);
		$newUser->addNewUser();

		$_SESSION['user']= $newUser;
	}

	header('location : ' . ROOT);

}

function do_reset() {

	unset($_POST['doreset']);

	$manager= UsersManager::getReference();

	if (!$user= $manager->userExistInDB($_POST['reset-login']) OR $user->_email !== $_POST['reset-email']) {
		Tool::appendMessage($Lang->failreset, M_ERROR);
		
	} else {
		$newPassword= Tool::generatePassword(8);
		$mail= $Lang->emailreset;
		Tool::appendMessage($Lang->emailresetsent, M_INFO);
	}

	header('location : ' . ROOT);

}
		
function do_admin () {

	unset($_POST['doadmin']);

	$manager= UsersManager::getReference();
/*
	$userUpdated= array();
*/

	if (isadmin() AND !$user= $manager->getUserInformations($_POST['id'])) {
		Tool::appendMessage($Lang->usernotexist, M_ERROR);
	} else {
		if (!empty($_POST['delete'])) {
			$user->deleteUser();
			Tool::appendMessage($Lang->userdeletesuccess, M_SUCCESS);
		} else {
			$newUser= new stdClass();
			if (!empty($_POST['isadmin']))
/*
				$userUpdated['admin'] = 1;
*/
				$newUser->_admin = 1;
			else
/*
				$userUpdated['admin'] = $user->_admin;
*/
				
			if (!empty($_POST['islocked']))
/*
				$userUpdated['locked'] = 1;
*/
				$newUser->_locked = 1;
			else
/*
				$userUpdated['locked'] = $user->_locked;
*/

			$updatedUser = new Compositor ($user, $newUser);

/*
			$userUpdated['name'] = $user->_name;
			$userUpdated['email'] = $user->_email;
			$userUpdated['password'] = $user->_password;
			$userUpdated['theme'] = $user->_theme;
			$userUpdated['language'] = $user->_language;
			$userUpdated['favorite_lang'] = $user->_favoriteLang;

			$userUpdated = new User ($userUpdated);
*/

			$manager->updateUserInfos($user->_id, $updatedUser);
			Tool::appendMessage($Lang->userupdatedsuccess, M_SUCCESS);
		}
	}

	header('location : ' . ROOT);

}

function add_snippet () {

	unset($_POST['addsnippet'];

	if ($_POST['tags'] )
	$currentUser= $_SESSION['user'];

	$snippetArray= array();

	$snippetArray['name'] = $_POST['name'];
	$snippetArray['id_user'] = $currentUser->_id;
	$snippetArray['last_update'] = time();
	$snippetArray['content'] = $_POST['content'];
	$snippetArray['language'] = $_POST['language'];
	$snippetArray['comment'] = $_POST['comment'];
	$snippetArray['category'] = $_POST['category'];
	$snippetArray['tags'] = $_POST['tags'];
	$snippetArray['policy'] = $_POST['policy'];

	$snippet = new Snippet ($snippetArray);
	$snippet->addNewSnippet();
	Tool::appendMessage($Lang->snippetaddingsuccess, M_SUCCESS);

	header('location : ' . ROOT);

}

function delete_snippet() {

	unset($_GET['delete']);

	$manager = SnippetsManager::getReference();
	$snippet = $manager->getSnippetById($_GET['id']);
	$snippetOwner = $_SESSION['user'];

	if (!empty($snippetOwner) AND !empty($snippet)) {
		if ($snippetOwner->_id === $snippet->_userId) {
			$snippet->deleteSnippet();
			Tool::appendMessage($Lang->snippetdeletedsuccess, M_SUCCESS);
		} else {
			Tool::appendMessage($Lang->snippetdeletedfailed, M_ERROR);
		}
	} else {
		Tool::appendMessage($Lang->snippetdeletedfailed, M_ERROR);
	}

	header('location : ' . ROOT);

}

function do_search() {

	unset($_GET['dosearch']);

	$manager = 

}

function update_account() {

	unset($_POST['updateaccount']);

	$curentUser= $_SESSION['user'];

	if (!empty($_POST['email'])) {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$currentUser->_email = $_POST['email'];
	}
	if (!empty($_POST['language'])) {
		$langOfTheme= lang_of_theme();

		if (in_array($_POST['language'], $langOfTheme))
			$currentUser->_language = $_POST['language'];
	}
	if (!empty
			

				