<?php
require_once('view/RegisterView.php');
require_once('model/RegisterUser.php');

class RegisterController {

	private $registerView;
	private $HTMLview;
	private $regUserModel;
	private $userDAL;
	private $userCatalog;
	private $userAuth;

	public function __construct(UserDAL $uDAL, UserCatalog $uCatalog, UserAuthorization $uAuth) {
		$this->userDAL = $uDAL;
		$this->userCatalog = $uCatalog;
		$this->userAuth = $uAuth;
		$this->registerView = new RegisterView();
	}

	// Does the registration of a new User.
	public function doRegister()
	{
		if ($this->registerView->didUserPressRegister())
		{
			$this->userCatalog = $this->userDAL->getUsers();

			$this->regUserModel = new RegisterUser($this->userCatalog, $this->registerView->getInputUsername(), $this->registerView->getInputPassword(), $this->registerView->getInputRepeatedPassword());
			$this->regUserModel->isUsernameFormatValid();

			if ($this->regUserModel->validation())
			{
				if ($this->regUserModel->isUsernameUnique())
				{
					$loginUser = new User($this->registerView->getInputUsername(), $this->registerView->getInputPassword());
					$this->userDAL->add($loginUser);

					$_SESSION[$this->userAuth->getStaticSessionName()] = $loginUser->getUsername();
					header("Location: ?");
					die();
				}
			}
		}
		
		$this->HTMLview = $this->registerView->response($this->regUserModel);
	}

	// Contains the HTML-respons from the login/logout.
	public function getHTML()
	{
		return $this->HTMLview;
	}
}