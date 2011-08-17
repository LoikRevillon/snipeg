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
		if($pageRequested === 'admin' AND $_SESSION['user']->_admin !== 1)  {
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

	global $Theme;

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
	global $User;

	$manager = UsersManager::getReference();

	if(!empty($_POST['signin-login']) AND !empty($_POST['signin-password'])) {
		if($user = $manager->userExistinDB($_POST['signin-login'])
			AND $user->_password === hash('sha256', $_POST['signin-password'])) {

			$_SESSION['user'] = $user;

			// Set Global variable $User
			$User = Tool::formatUser($_SESSION['user']);

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
	} elseif(!filter_var($_POST['signup-email'], FILTER_VALIDATE_EMAIL)) { // TODO : Check if email already in use
		Tool::appendMessage($Lang->error_email_is_not_a_valid_email, Tool::M_ERROR);
	} else {
		$userInformations = array();
		$userInformations['admin'] = 0;
		$userInformations['name'] = $_POST['signup-login'];
		$userInformations['email'] = $_POST['signup-email'];
		$userInformations['avatar'] = 0;
		$userInformations['password'] = hash('sha256', $_POST['signup-password-1']);
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
			Tool::appendMessage($Lang->success_delete_user, M_SUCCESS);
		} else {
			$newUser = new stdClass();

			if(!empty($_POST['isadmin']))
				$newUser->_admin = 1;
			if(!empty($_POST['islocked']))
				$newUser->_locked = 1;

			$updatedUser = new Compositor($user, $newUser);
			$manager->updateUserInfos($user->_id, $updatedUser);
			Tool::appendMessage($Lang->success_update_user, M_SUCCESS);
		}
	}

}

function add_snippet() {

	global $Lang;

	$currentUser = $_SESSION['user'];
	$snippetArray = array();

	if(empty($_POST['name'])) {
		Tool::appendMessage($Lang->error_missing_snippet_name, Tool::M_ERROR);
		return false;
	}

	if (!empty($_POST['newcategory']))
		$category = $_POST['newcategory'];
	else
		$category = $_POST['category'];		

	$snippetArray['name'] = $_POST['name'];
	$snippetArray['id_user'] = $currentUser->_id;
	$snippetArray['last_update'] = time();
	$snippetArray['content'] = $_POST['content'];
	$snippetArray['language'] = $_POST['language'];  ## FIX IT (geshi codes)
	$snippetArray['comment'] = $_POST['description'];
	$snippetArray['category'] = $category;
	$snippetArray['tags'] = $_POST['tags'];
	$snippetArray['private'] = $_POST['private'];

	$snippet = new Snippet($snippetArray);
	var_dump($snippetArray);
	var_dump($snippet);
	if ($snippet->addNewSnippet()) 
		Tool::appendMessage($Lang->success_add_snippet, Tool::M_SUCCESS);
	else
		Tool::appendMessage($Lang->error_add_snippet, Tool::M_ERROR);

}

function delete_snippet() {

	global $Lang;

	$manager = SnippetsManager::getReference();

	if(empty($_GET['id']) OR !$snippet = $manager->getSnippetById($_GET['id'])) {
		Tool::appendMessage($Lang->error_delete_snippet, M_ERROR);
		return false;
	}

	$snippetOwner = $_SESSION['user'];

	if($snippetOwner->_id === $snippet->_userId) {
		$snippet->deleteSnippet();
		Tool::appendMessage($Lang->success_delete_snippet, M_SUCCESS);
	} else {
		Tool::appendMessage($Lang->error_delete_snippet, M_ERROR);
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

	global $Lang;
	$currentUser = $_SESSION['user'];
	$needUpdate = false;

	if(!empty($_POST['email'])) {

		if (Tool::emailExistInDB($_POST['email'])) {			
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$currentUser->_email = $_POST['email'];
				$needUpdate = true;
				
			} else {
				Tool::appendMessage($Lang->error_email_is_not_a_valid_email, Tool::M_ERROR);
			}				
		} else {
			Tool::appendMessage($Lang->error_email_is_unavailable, Tool::M_ERROR);
		}
	}
	
	if(!empty($_POST['language'])) {
		$langOfTheme = lang_of_theme();
		if(in_array($_POST['language'], $langOfTheme) AND $currentUser->_language !== $_POST['language']) {
			$currentUser->_language = $_POST['language'];
			$needUpdate = true;
		}
	}

	if(!empty($_FILES['new-avatar']['name'])) {
		try {
			$generator = new AvatarGenerator($_FILES['new-avatar'], $currentUser->_id);
			$needUpdate = true;
			$currentUser->_avatar = 1;
		} catch(AvatarGeneratorException $e) {
			Tool::appendMessage($e, Tool::M_ERROR);
		}
	}

	if (!empty($_POST['oldpassword'])) {
		if ($currentUser->_password === hash('sha256', $_POST['oldpassword'])) {
			if($_POST['newpassword-1'] === $_POST['newpassword-2']) {
				$currentUser->_password = hash('sha256', $_POST['newpassword-2']);
				$needUpdate = true;
			} else {
				Tool::appendMessage($Lang->error_password_are_different, Tool::M_ERROR);
			}
		} else {
			Tool::appendMessage($Lang->error_wrong_password, Tool::M_ERROR);
		}
	}
	//if (!empty(code_geshi)) {} # FIX IT

	if (!empty($needUpdate)) {
		$manager = UsersManager::getReference();
		if ($manager->updateUserInfos($currentUser->_id, $currentUser))
			Tool::appendMessage($Lang->success_update_user, Tool::M_SUCCESS);
		else
			Tool::appendMessage($Lang->error_update_user, Tool::M_ERROR);
	}
}