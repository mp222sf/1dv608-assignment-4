<?php
require_once("model/UserCatalog.php");

class RegisterUser {

	private static $regEx = "/[^A-Za-z0-9_]/";

	private $username;
	private $password;
	private $repeatedPassword;
	private $userCatalog;

	public function __construct(UserCatalog $uCatalog, $inputUsername, $inputPassword, $inputRepeatPassword)
	{
		$this->username = $inputUsername;
		$this->password = $inputPassword;
		$this->repeatedPassword = $inputRepeatPassword;
		$this->userCatalog = $uCatalog;
	}

	public function isUsernameLengthCorrect()
	{
		if (strlen($this->username) >= 3)
		{
			return true;
		}
		return false;
	}

	public function isPasswordLengthCorrect()
	{
		if (strlen($this->password) >= 6)
		{
			return true;
		}
		return false;
	}

	public function isPasswordsEqual()
	{
		if ($this->password == $this->repeatedPassword)
		{
			return true;
		}
		return false;
	}

	public function isUsernameUnique()
	{
		foreach ($this->userCatalog->getUsers() as $user) {
		    if ($this->username == $user->getUsername())
		    {
		    	return false;
		    }
		}
		return true;
	}

	public function isUsernameFormatValid()
	{
		if (preg_match("/^[a-zA-Z\d]+$/", $this->username))
		{
			return true;
		}
		return false;
	}

	public function trimUsername()
	{
		$string = $this->username;
		$res = preg_replace("/<.*?>/", "", $string);
		$res = preg_replace('/[^A-Za-z0-9\-]/', '', $res);
		return $res;
	}

	// Checks if registration information is valid.
	public function validation()
	{
		return $this->isUsernameLengthCorrect() && $this->isPasswordLengthCorrect() && $this->isPasswordsEqual() && $this->isUsernameUnique() && $this->isUsernameFormatValid();
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}
}