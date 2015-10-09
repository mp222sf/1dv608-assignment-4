<?php
class UserAuthorization {

	private static $newUserRegistered = "newUserReg";

	private $loginUserInfo;
	private $alreadyLoggedIn = false;
	private $userCatalog;

	public function __construct(UserCatalog $userCatal)
	{
		$this->userCatalog = $userCatal;
	}

	public function tryLogin(User $logUser)
	{
		$this->loginUserInfo = $logUser;

		if ($this->isLoginInfoCorrect($this->loginUserInfo))
		{
			$this->setSession();
			return true;
		}

		return false;
	}

	public function setSession()
	{
		if ($this->isLoggedInSession()) 
		{
			$this->alreadyLoggedIn = true;
		}
		else {
			$_SESSION["username"] = $this->loginUserInfo->getUsername();
			$_SESSION["password"] = $this->loginUserInfo->getPassword();
		}
	}

	public function doLogout()
	{
		session_unset();
	}

	public function isLoggedInSession()
	{
		if (isset($_SESSION["username"]) && isset($_SESSION["password"])) 
		{
			$sessionUser = new User($_SESSION["username"], $_SESSION["password"]);
			if ($this->isLoginInfoCorrect($sessionUser))
			{
				return true;
			}
			return false;
		}
		return false;
	}

	public function isUsernameMissing()
	{
		if ($this->loginUserInfo->getUsername() == '')
		{
			return true;
		}
		return false;
	}

	public function isPasswordMissing()
	{
		if ($this->loginUserInfo->getPassword() == '')
		{
			return true;
		}
		return false;
	}

	public function loginWhenLoggedIn()
	{
		return $this->alreadyLoggedIn;
	}

	public function isLoginInfoCorrect(User $logUser)
	{
		foreach ($this->userCatalog->getUsers() as $user) {
		    if ($logUser->getUsername() == $user->getUsername() && $logUser->getPassword() == $user->getPassword())
		    {
		    	return true;
		    }
		}
		return false;
	}

	public function setNewUserRegistered($username)
	{
		$_SESSION[self::$newUserRegistered] = $username;
	}

	public function isNewUserRegistered()
	{
		if(isset($_SESSION[self::$newUserRegistered]))
		{
			return true;
		}
		return false;
	}

	public function getNewUserRegistered()
	{
		$username = $_SESSION[self::$newUserRegistered];
		session_unset();
		return $username;
	}

	public function getStaticSessionName()
	{
		return self::$newUserRegistered;
	}
}