<?php

class PageLoader {

	// Internal use
	private $_category;
	private $_lang;
	private $_request;
	private $_snippetId;
	private $_tag;
	private $_theme;

	// Return of getPage()
	private $_categories;
	private $_file;
	private $_langs;
	private $_page;
	private $_snippets;
	private $_themes;
	private $_users;

	public function __construct( $req_type )
	{
		$this->_request = $req_type;

		if ( !empty( $category ) )
			$this->_category = $category;

		if ( !empty( $tag ) )
			$this->_tag = $tag;

		$this->_theme = Tool::loadTheme();
		$this->_lang = Tool::loadLanguage();
	}

	public function setCategory( $category )
	{
		if ( !empty( $category ) )
			$this->_category;
	}

	public function setTag( $tag )
	{
		if ( !empty( $tag ) )
			$this->_tag;
	}

	public function setSnippetId( $id )
	{
		if ( !empty( $id ) )
			$this->_snippetId = $id;
	}

	public function getPageInfos()
	{
		$page = new stdClass();

		$this->get_page_by_request();

		$page->categories = $this->_categories;
		$page->fileName = $this->_file;
		$page->langs = $this->_langs;
		$page->paging = $this->_page;
		$page->snippets = $this->_snippets;
		$page->themes = $this->_themes;
		$page->users = $this->_users;

		return $page;
	}

	private function get_page_by_request()
	{
		$req = $this->_request;
		if ( !empty( $_SESSION['user'] ) )
			$currentUser = $_SESSION['user']->toStdObject();

		if ( $this->_request === 'logout' )
		{
			session_destroy();
			$this->_file = 'login';
		}
		else if ( !empty( $this->_theme->$req ) )
		{
			$this->_file = $this->_request;

			if ( $this->_request === 'admin' )
			{
				if ( $currentUser->isadmin )
				{
					$manager = UsersManager::getReference();
					$users = $manager->countOfUsers( $currentUser->id );

					$this->_page = create_paging($users->count, NUM_USER_PER_PAGE);
					$this->_users = $manager->getAllUsers($this->_page, $currentUser->id);
				}
				else
				{
					Tool::appendMessage( $this->_lang->error_not_enough_right, Tool::M_ERROR );
					$this->_file = 'default';
				}
			}
			elseif ( $this->_request === 'browse' )
			{
				$manager = SnippetsManager::getReference();
				$conditions = new stdClass();
				$this->_snippets = array();

				if ( !empty( $this->_category ) )
				{
					$conditions->field = 'category';
					$conditions->value = $this->_category;
				}
				elseif ( !empty( $this->_tag ) )
				{
					$conditions->field = 'tags';
					$conditions->value = $this->_tag;
				}
				else
				{
					$conditions = false;
				}

				$nb_snippets = $manager->countOfSnippetByUser( $currentUser->id, $conditions );
				$snippetsObjectInArray = array();
				$this->_snippets = array();

				$this->_page = create_paging( $nb_snippets->count, NUM_SNIPPET_PER_PAGE );

				if ( !empty( $conditions ) )
				{
					if ( $conditions->field === 'category' )
						$snippetsObjectInArray = $manager->getSnippetsByCategory( $currentUser->id, $conditions->value, $this->_page );

					elseif ( $conditions->field === 'tags' )
						$snippetsObjectInArray = $manager->getSnippetsByTag( $currentUser->id, $conditions->value, $this->_page );
				}

				if( empty( $snippetsObjectInArray ) )
					$snippetsObjectInArray = $manager->getSnippetsByUser( $currentUser->id, $this->_page );

				foreach($snippetsObjectInArray AS $snippet)
					$this->_snippets[] = $snippet->toStdObject();
			}
			elseif ( $this->_request === 'edit' )
			{
				if ( !empty( $this->_snippetId ) AND $this->_request === 'edit' )
				{
					$manager = SnippetsManager::getReference();
					$snippets = $manager->getSnippetById( $this->_snippetId );
					$this->_snippets = $snippets->toStdObject();
	            }
	            if ( $this->_snippets->idUser !== $currentUser->id )
	            {
					Tool::appendMessage( $this->_lang->error_not_enough_right, Tool::M_ERROR );
					$this->_file = ( empty( $_SESSION['user'] ) ) ? 'login' : 'default';
				}
				else
				{
					$userCategories = SnippetsManager::getReference();
					$this->_categories = $userCategories->getAllCategories( $currentUser->id );
					$this->_file = 'new';
				}
			}
			elseif ( $this->_request === 'new' )
			{
				$userCategories = SnippetsManager::getReference();
				$this->_categories = $userCategories->getAllCategories( $currentUser->id );

				$this->_file = 'new';
			}
			elseif ( $this->_request === 'search' )
			{
				do_search();
			}
			elseif ( $this->_request === 'settings' )
			{
				$this->_themes = array();
				$this->_langs = array();

				$themes = Tool::getAllThemes();
				$langs = Tool::getAllLangs();

				foreach($themes as $theme)
					$this->_themes[] = $theme->dirname;

				foreach($langs as $lang)
				{
					$langObj = new stdClass();

					if ( !empty($lang->name) )
						$langObj->name = $lang->name;

					$langObj->filename = $lang->filename;
					$this->_langs[] = $langObj;
				}
			}
			elseif ( $this->_request === 'single' )
			{
				$manager = SnippetsManager::getReference();
				$snippet = $manager->getSnippetById( $this->_snippetId );
				$this->_snippets = $snippet->toStdObject();

				if ( empty( $this->_snippets->id ) )
				{
					if ( empty ( $_SESSION['messages'][Tool::M_SUCCESS] ) ||
					! in_array( $this->_lang->success_delete_snippet, $_SESSION['messages'][Tool::M_SUCCESS] ) )
						Tool::appendMessage( $this->_lang->error_snippet_not_exist, Tool::M_ERROR );

					$this->_file = ( empty( $_SESSION['user'] ) ) ? 'login' : 'default';
				}
				else if (( empty( $currentUser ) OR $currentUser->id !== $this->_snippets->idUser ) AND
						!empty( $this->_snippets->privacy ))
				{
					Tool::appendMessage( $this->_lang->error_not_enough_right, Tool::M_ERROR );
					$this->_file = ( empty( $_SESSION['user'] ) ) ? 'login' : 'default';
				}
			}
		}
		else
		{
			Tool::appendMessage( $this->_lang->error_file_not_found . ' : ' . $this->_request , Tool::M_ERROR );
			$this->_file = 'default';
		}
	}
}
