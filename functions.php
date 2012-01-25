<?php

function __autoload($className) {

	$classPath = 'classes/' . $className . '.class.php';

	if(file_exists($classPath))
		require $classPath;

}

function create_paging($elementCounted,  $elementPerPage) {

	global $Pages;

	$countPage = ceil ($elementCounted / $elementPerPage);
	$pageRequested = 1;

	if(!empty($_GET['page']) AND (intval($_GET['page']) <= $countPage OR intval($_GET['page']) < 1)) {
		$pageRequested = intval($_GET['page']);
	}

	if($elementCounted > $elementPerPage) {
		if($pageRequested > 3) {
			$Pages = array();
			if($pageRequested > $countPage - 3) {
				$i = (($countPage - 4) > 1) ? $countPage - 4 : 2;
			} else {
				$i = $pageRequested - 2;
			}

			for ($j = 0; $i < $countPage AND $j <= 3; $i++, $j++) {
				$Pages[] = $i;
			}
			$Pages[] = $countPage;
		} else {
			$Pages = array();
			for ($j = 0, $i = 2; $i < $countPage AND $j <= 3; $i++, $j++) {
				$Pages[] = $i;
			}
			$Pages[] = $countPage;
		}
	}

	if (!empty($pageRequested))
		return $pageRequested;
	else
		return 1;

}

function is_admin() {

	global $User;
	return $User->isadmin;

}

function remind_post($param) {

	if(!empty($_POST) AND isset($_POST[$param]))
		echo htmlspecialchars($_POST[$param]);

}

function remind_get($param) {

	if(!empty($_GET) AND isset($_GET[$param]))
		echo htmlspecialchars($_GET[$param]);

}

/*
 * Page loader
 * -------------------------------------------------------------------------------------
*/

function load_page() {

	global $Categories;
	global $LangsList;
	global $Snippet;
	global $Snippets;
	global $ThemesList;
	global $Users;

	$pageLoader = new PageLoader( $_GET['action'] );

	if ( array_key_exists( 'category', $_GET ) )
		$pageLoader->setCategory( $_GET['category'] );
	if ( array_key_exists( 'tags', $_GET ) )
		$pageLoader->setTag( $_GET['tags'] );
	if ( array_key_exists( 'id', $_GET ) )
		$pageLoader->setSnippetId( $_GET['id'] );
	if ( array_key_exists( 'query', $_GET ) )
		$pageLoader->setQuery( $_GET['query'] );

	$pageInfos = $pageLoader->getPageInfos();

	$Categories = $pageInfos->categories;
	$LangsList = $pageInfos->langs;
	$ThemesList = $pageInfos->themes;

	if ( is_array( $pageInfos->snippets ) )
		$Snippets = $pageInfos->snippets;
	else
		$Snippet = $pageInfos->snippets;
	$Users = $pageInfos->users;

	return $pageInfos->fileName;
}

/*
 * POST processing
 * -------------------------------------------------------------------------------------
*/

function do_login() {

    global $User;
	global $Lang;

	$manager = UsersManager::getReference();

	if(!empty($_POST['signin-login']) AND !empty($_POST['signin-password'])) {
		if($user = $manager->userExistinDB($_POST['signin-login'])
			AND $user->_password === hash('sha256', $_POST['signin-password'])) {

			if($user->_locked == 0) {
				$_SESSION['user'] = $user;
				$User = $user->toStdObject();
				$Lang = Tool::loadLanguage();
			} else {
				Tool::appendMessage($Lang->error_user_locked, Tool::M_ERROR);
			}

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
		Tool::appendMessage($Lang->error_account_reset, Tool::M_ERROR);
	} else {

		try {
			$user->_password = Tool::generatePassword(8);

			$email = new PasswordEmailer();
			$email->setReceiver( $user->_email );
			$email->setUser( $user->_name );
			if ( !empty( $Lang->emailreset ) )
				$email->setContent( $Lang->emailreset );
			$email->setNewPassord( $user->_password );
			$email->send();

			$user->_password = hash('sha256', $user->_password );
			$manager = UsersManager::getReference();
			$manager->updateUserInfos( $user->_id, $user );

			Tool::appendMessage($Lang->info_reset_email_send, Tool::M_INFO);

		} catch( PasswordEmailerException $pee ) {
			Tool::appendMessage( $pee->getMessage(), Tool::M_ERROR );
		}
	}

}

function do_admin() {

	global $User;
	global $Lang;

	$manager = UsersManager::getReference();
	$user = $manager->getUserInformations($_POST['id']);

	if(is_admin()) {
		if (empty($user)) {
			Tool::appendMessage($Lang->error_user_not_exists, Tool::M_ERROR);
		} else {
			if(!empty($_POST['delete'])) {
				$manager = SnippetsManager::getReference();
				$manager->deleteSnippetsOfUser( $user->_id );
				$user->deleteUser();
				Tool::appendMessage($Lang->success_delete_user, Tool::M_SUCCESS);
			} else {
				$user->_admin = 0;
				$user->_locked = 0;
				if(!empty($_POST['isadmin']))
					$user->_admin = 1;
				if(!empty($_POST['islocked']))
					$user->_locked = 1;

				if($manager->updateUserInfos($user->_id, $user))
					Tool::appendMessage($Lang->success_update_user, Tool::M_SUCCESS);
				else
					Tool::appendMessage($Lang->error_update_user, Tool::M_ERROR);
			}
		}
	} else {
		Tool::appendMessage($Lang->error_not_enough_right, Tool::M_ERROR);
	}
}

function add_snippet() {

	global $Lang;

	if (!empty($_SESSION['user'])) {
		$currentUser = $_SESSION['user'];
		$snippetArray = array();

		if(empty($_POST['name'])) {
			Tool::appendMessage($Lang->error_missing_snippet_name, Tool::M_ERROR);
			return false;
		}

		if(!empty($_POST['newcategory']))
			$category = $_POST['newcategory'];
		else
			$category = $_POST['category'];

		$snippetArray['name'] = $_POST['name'];
		$snippetArray['id_user'] = $currentUser->_id;
		$snippetArray['last_update'] = time();
		$snippetArray['content'] = $_POST['content'];
		$snippetArray['language'] = (intval(!empty($_POST['language']))) ? $_POST['language'] : 0;  ## FIX IT (geshi codes)
		$snippetArray['comment'] = $_POST['description'];
		$snippetArray['category'] = $category;
		$snippetArray['tags'] = $_POST['tags'];
		$snippetArray['private'] = $_POST['private'];

		$snippet = new Snippet($snippetArray);

		if (!empty($_GET['id'])) {
			$manager = SnippetsManager::getReference();
			$oldSnippet = $manager->getSnippetById($_GET['id']);

			if(!empty($currentUser) AND $oldSnippet->_idUser === $currentUser->_id) {

				if($manager->updateSnippetInfos($oldSnippet->_id, $snippet))
					Tool::appendMessage($Lang->success_update_snippet, Tool::M_SUCCESS);
				else
					Tool::appendMessage($Lang->error_update_snippet, Tool::M_ERROR);

			} else {
				Tool::appendMessage($Lang->error_not_enough_right, Tool::M_ERROR);
			}
		} else {
			if($snippet->addNewSnippet())
				Tool::appendMessage($Lang->success_add_snippet, Tool::M_SUCCESS);
			else
				Tool::appendMessage($Lang->error_add_snippet, Tool::M_ERROR);
		}
	}
}

function delete_snippet() {

	global $Lang;

	$manager = SnippetsManager::getReference();

	if(empty($_GET['id']) OR !$snippet = $manager->getSnippetById($_GET['id'])) {
		Tool::appendMessage($Lang->error_delete_snippet, Tool::M_ERROR);
		return false;
	}

	$snippetOwner = $_SESSION['user'];

	if($snippetOwner->_id === $snippet->_userId) {
		$snippet->deleteSnippet();
		Tool::appendMessage($Lang->success_delete_snippet, Tool::M_SUCCESS);
	} else {
		Tool::appendMessage($Lang->error_delete_snippet, Tool::M_ERROR);
	}

}

function update_account() {

    global $User;
	global $Lang;

	$currentUser = $_SESSION['user'];
	$needUpdate = false;

	if(!empty($_POST['email'])) {
		if(Tool::emailExistInDB($_POST['email'])) {
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

	if(!empty($_POST['theme'])) {
		if($currentUser->_theme !== $_POST['theme']) {
			$themes = Tool::getAllThemes();
			$themesDirName= array();

			foreach($themes as $themeInfos) {
				$themesDirName[] = $themeInfos->dirname;
			}

			if(!empty($themesDirName)) {
				if(in_array($_POST['theme'], $themesDirName)) {
					$currentUser->_theme = $_POST['theme'];
					$needUpdate = true;
				} else {
					Tool::appendMessage($Lang->error_theme_unvailable, Tool::M_ERROR);
				}
			} else {
				Tool::appendMessage($Lang->error_no_theme_avaible, Tool::M_ERROR);
			}
		}
	}

	if(!empty($_POST['language'])) {
		global $Lang;
		if($currentUser->_language !== $_POST['language']) {
			$langs = Tool::getAllLangs();
			$langFilesName= array();

            if (!empty($langs)) {
				foreach($langs as $langInfos) {
					$langFilesName[] = $langInfos->filename;
				}
			}

			if(!empty($langFilesName)) {
				if(in_array($_POST['language'], $langFilesName)) {
					$currentUser->_language = $_POST['language'];
					$Lang = Tool::loadLanguage();
					$needUpdate = true;
				} else {
					Tool::appendMessage($Lang->error_lang_unvailable, Tool::M_ERROR);
				}
			} else {
				Tool::appendMessage($Lang->error_no_lang_avaible, Tool::M_ERROR);
			}
		}
	}

	if(!empty($_FILES['new-avatar']['name'])) {
		if($_FILES['new-avatar']['size'] <= 2 * 1024 * 1024) {
			try {
				$generator = new AvatarGenerator($_FILES['new-avatar'], $currentUser->_id);
				$currentUser->_avatar = 1;
				$needUpdate = true;
			} catch(AvatarGeneratorException $e) {
				Tool::appendMessage($e, Tool::M_ERROR);
			}
		} else {
			Tool::appendMessage($Lang->error_avatar_oversized, Tool::M_ERROR);
		}
	}

	if(!empty($_POST['oldpassword'])) {
		if($currentUser->_password === hash('sha256', $_POST['oldpassword'])) {
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

	//if(!empty(code_geshi)) {} # FIX IT

	if(!empty($needUpdate)) {
		$manager = UsersManager::getReference();
		if($manager->updateUserInfos($currentUser->_id, $currentUser)) {
			Tool::appendMessage($Lang->success_update_user, Tool::M_SUCCESS);
			$_SESSION['user'] = $currentUser;
			$User = $currentUser->toStdObject();
		} else {
			Tool::appendMessage($Lang->error_update_user, Tool::M_ERROR);
		}
	}

}

function update_snippet() {

	global $Lang;
	global $Theme;

	if(array_key_exists('edit-snippet', $_POST)) {
		add_snippet();
		$includeFile = 'new';

	} elseif(!empty($_POST['delete-snippet'])) {
		if(isset($_SESSION['user']))
			$user = $_SESSION['user'];

		$manager = SnippetsManager::getReference();
		$oldSnippet = $manager->getSnippetById($_POST['snippet-id']);

		if(!empty($user) AND $oldSnippet->_idUser === $user->_id) {
			if($oldSnippet->deleteSnippet())
				Tool::appendMessage($Lang->success_delete_snippet, Tool::M_SUCCESS);
			else
				Tool::appendMessage($Lang->error_delete_snippet, Tool::M_ERROR);
		} else {
			Tool::appendMessage($Lang->error_not_enough_right, Tool::M_ERROR);
		}
	}

}
