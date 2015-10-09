<?php
require_once('view/LoginView.php');


class LoginController {

	private $loginView;
	private $userAuth;
	private $HTMLview;
	private $startUser;
	private $userDAL;

	public function __construct(UserDAL $uDAL, UserCatalog $userCatal, UserAuthorization $uAuth) {
		$this->userDAL = $uDAL;
		$this->userAuth = $uAuth;
		$this->loginView = new LoginView($this->userAuth);
	}

	// Does the login/logout.
	public function doLogin()
	{
		if ($this->userAuth->isLoggedInSession())
		{
			if ($this->loginView->didUserPressLogout())
			{
				$this->userAuth->doLogout();
				$this->loginView->justLoggedOut();
			}
		}
		else 
		{
			if ($this->loginView->didUserPressLogin())
			{
				$loginAttemptUser = new User($this->loginView->getInputUsername(), $this->loginView->getInputPassword());
				$this->userAuth->tryLogin($loginAttemptUser);
				$this->loginView->justLoggedIn();
			}
		}
		$this->HTMLview = $this->loginView->response();
	}

	// Checks if the User is logged in.
	public function isLoggedIn()
	{
		if ($this->userAuth->isLoggedInSession())
		{
			return true;
		}
		return false;
	}

	// Contains the HTML-respons from the login/logout.
	public function getHTML()
	{
		return $this->HTMLview;
	}
}