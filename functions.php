<?php

function __autoload($className) {

	$classPath = 'classes/' . $className . '.class.php';

	if(file_exists($classPath))
		require $classPath;

}

function load_page($includeFile) {

	global $Theme;

	$pageRequested = $_GET['action'];

	if(!empty($Theme->$pageRequested)) {
		if($pageRequested === 'admin' AND $_SESSION['user']['admin'] !== 1)  {
			Tool::appendMessage($Lang->error_not_enough_right, M_ERROR);
			$includeFile = 'default';
		} else {
			$includeFile = $pageRequested;
		}
	} elseif($pageRequested === 'logout' ){
		session_destroy();
		$includeFile = 'login';
	} else {
		Tool::appendMessage($Lang->error_file_not_found . ' : ' . $pageRequested , Tool::M_ERROR);
		$includeFile = 'default';
	}

}

function lang_of_theme() {

	$listLang = array();
	$languagesFiles = glob(ROOT . $Theme->dirname . LANGUAGE_DIR . '*.json');

	foreach($languagesFiles as $languageFile) {
		$listLang[] = pathinfo($languageFile, PATHINFO_FILENAME);
	}

	return $listLang;

}

// TODO : FIX
function is_admin() {

	return isset($_SESSION['user']->_admin);

}

function remind_post($param) {

	if(!empty($_POST) AND isset($_POST[$param]))
		echo htmlspecialchars($_POST[$param]);

}

function do_login() {

	global $Lang;

	$manager = UsersManager::getReference();

	if(!empty($_POST['signin-login']) AND !empty($_POST['signin-password'])) {
		if($user = $manager->userExistinDB($_POST['signin-login'])
			AND $user->_password === hash('sha256', $_POST['signin-password'])) {
			$_SESSION['user'] = $user;
		} else {
			Tool::appendMessage($Lang->error_wrong_sign_in, Tool::M_ERROR);
		}
	} else {
		Tool::appendMessage($Lang->error_missing_sign_in, Tool::M_ERROR);
	}

}

function do_sign_up() {

	global $Lang;

	$manager = UsersManager::getReference();

	if($manager->userExistInDB($_POST['signup-login'])) {
		Tool::appendMessage($Lang->error_username_already_in_use . ' : ' . $_POST['signup-login'], Tool::M_ERROR);
	} elseif($_POST['signup-password-1'] !== $_POST['signup-password-2']) {
		Tool::appendMessage($Lang->error_password_are_different, Tool::M_ERROR);
	} elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { // TODO : Check if email already in use
		Tool::appendMessage($Lang->error_email_is_not_a_valid_email . ' : ' . $_POST['email'], Tool::M_ERROR);
	} else {
		$userInformations = array();
		$userInformations['admin'] = 0;
		$userInformations['name'] = $_POST['signup-login'];
		$userInformations['email'] = $_POST['signup-email'];
		$userInformations['password'] = hash('sha256', $_POST['signup-password1']);
		$userInformations['locked'] = 0;
		$userInformations['theme'] = DEFAULT_THEME;
		$userInformations['language'] = DEFAULT_LANG;
		$userInformations['favorite_lang'] = array();
		$newUser = new User($userInformations);

		if($newUser->addNewUser())
			Tool::appendMessage($Lang->success_sign_in, Tool::M_SUCCESS);
	}

}

function do_reset() {

	global $Lang;

	$manager = UsersManager::getReference();

	if(!$user = $manager->userExistInDB($_POST['reset-login']) OR $user->_email !== $_POST['reset-email']) {
		Tool::appendMessage($Lang->error_account_reset, M_ERROR);
	} else {
		$newPassword = Tool::generatePassword(8);
		$mail = $Lang->emailreset; // FIX IT
		Tool::appendMessage($Lang->info_reset_email_send, M_INFO);
	}

}

function do_admin() {

	global $Lang;

	$manager = UsersManager::getReference();

	if(isadmin() AND !$user = $manager->getUserInformations($_POST['id'])) {
		Tool::appendMessage($Lang->usernotexist, M_ERROR);
	} else {
		if(!empty($_POST['delete'])) {
			$user->deleteUser();
			Tool::appendMessage($Lang->userdeletesuccess, M_SUCCESS);
		} else {
			$newUser = new stdClass();

			if(!empty($_POST['isadmin']))
				$newUser->_admin = 1;
			if(!empty($_POST['islocked']))
				$newUser->_locked = 1;

			$updatedUser = new Compositor($user, $newUser);
			$manager->updateUserInfos($user->_id, $updatedUser);
			Tool::appendMessage($Lang->userupdatedsuccess, M_SUCCESS);
		}
	}

}

function add_snippet() {

	global $Lang;

	$currentUser = $_SESSION['user'];
	$snippetArray = array();

	if(empty($_POST['name'])) {
		Tool::appendMessage($Lang->newsnippetfailedname, M_ERROR);
		return false;
	}

	$snippetArray['name'] = $_POST['name'];
	$snippetArray['id_user'] = $currentUser->_id;
	$snippetArray['last_update'] = time();
	$snippetArray['content'] = $_POST['content'];
	$snippetArray['language'] = $_POST['language'];
	$snippetArray['comment'] = $_POST['comment'];
	$snippetArray['category'] = $_POST['category'];
	$snippetArray['tags'] = $_POST['tags'];
	$snippetArray['policy'] = $_POST['policy'];

	$snippet = new Snippet($snippetArray);
	$snippet->addNewSnippet();

	Tool::appendMessage($Lang->snippetaddingsuccess, M_SUCCESS);

}

function delete_snippet() {

	global $Lang;

	$manager = SnippetsManager::getReference();

	if(empty($_GET['id']) OR !$snippet = $manager->getSnippetById($_GET['id'])) {
		Tool::appendMessage($Lang->snippetdeletedfailed, M_ERROR);
		return false;
	}

	$snippetOwner = $_SESSION['user'];

	if($snippetOwner->_id === $snippet->_userId) {
		$snippet->deleteSnippet();
		Tool::appendMessage($Lang->snippetdeletedsuccess, M_SUCCESS);
	} else {
		Tool::appendMessage($Lang->snippetdeletedfailed, M_ERROR);
	}

}

function do_search() {

	global $Snippets;

	if(!empty($_GET['query'])) {
		if(empty($_GET['page']))
			$page = 1;
		else
			$page = $_GET['page']; // SECURITY ISSUE

		$manager = SnippetManager::getReference();
		$user = $_SESSION['user'];

		if(isset($_GET['category']))
			$Snippets = $manager->instantSearch_GetSnippetsByCategory($user->_id, $_SESSION['query'], $page);
		else
			$Snippets = $manager->instantSearch_GetSnippets($user->_id, $_SESSION['query'], $page);
	}

}

function update_account() {

	$currentUser = $_SESSION['user'];

	if(!empty($_POST['email'])) {
		// Need fix : email already used ?
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$currentUser->_email = $_POST['email'];
	}
	if(!empty($_POST['language'])) {
		$langOfTheme = lang_of_theme();
		if(in_array($_POST['language'], $langOfTheme))
			$currentUser->_language = $_POST['language'];
	}

	//if(file_exists(AVATAR)) {} # FIT IT

	if(!empty($_POST['oldpassword']) AND $currentUser->_password !== hash('sha256', $_POST['oldpassword'])) {
		if($_POST['newpassword-1'] === $_POST['newpassword-2'])
			$currentUser->_password = $_POST['newpassword-1']; // NEED FIX ? Not my code, need check.
	}

	//if (!empty(code_geshi)) {} # FIX IT

}