<?php
class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private $justLoggedIn = false;
	private $justLoggedOut = false;
	private $userAuth;

	public function __construct(UserAuthorization $uAuth)
	{
		$this->userAuth = $uAuth;
	}

	public function justLoggedIn()
	{
		$this->justLoggedIn = true;
	}

	public function justLoggedOut()
	{
		$this->justLoggedOut = true;
	}

	public function response() {

		if ($this->didUserPressLogin())
		{
			if ($this->justLoggedIn == false)
			{
				$response = $this->generateLogoutButtonHTML("");
			}
			else if ($this->userAuth->isUsernameMissing())
			{
				$response = $this->generateLoginFormHTML("Username is missing", "");
			}
			else if ($this->userAuth->isPasswordMissing())
			{
				$response = $this->generateLoginFormHTML("Password is missing", $this->getInputUsername());
			}
			else if (!$this->userAuth->isLoggedInSession())
			{
				$response = $this->generateLoginFormHTML("Wrong name or password", $this->getInputUsername());
			}
			else {
				$response = $this->generateLogoutButtonHTML("Welcome");
			}
			
		}
		else if ($this->didUserPressLogout())
		{
			if ($this->justLoggedOut == false)
			{
				$response = $this->generateLoginFormHTML("", "");
			}
			else {
				$response = $this->generateLoginFormHTML("Bye bye!", "");
			}
		}
		else 
		{
			if ($this->userAuth->isNewUserRegistered())
			{
				$response = $this->generateLoginFormHTML("Registered new user.", $this->userAuth->getNewUserRegistered());
			}
			else if ($this->userAuth->isLoggedInSession())
			{
				$response = $this->generateLogoutButtonHTML("");
			}
			else {
				$response = $this->generateLoginFormHTML("", "");
			}
			
		}
		return $response;
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	private function generateLoginFormHTML($message, $previousInputUsername) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $previousInputUsername . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	// Tells if the User is logged in.
	public function getIsLoggedIn()
	{
		return $this->isLoggedIn;
	}

	// Asks if the User did press the login-button.
	public function didUserPressLogin()
	{
		return isset($_POST[self::$login]);
	}

	// Asks if the User did press the logout-button.
	public function didUserPressLogout()
	{
		return isset($_POST[self::$logout]);
	}

	// Gets the Name that the User inputs.
	public function getInputUsername()
	{
		return $_POST[self::$name];
	}

	// Gets the Password that the User inputs.
	public function getInputPassword()
	{
		return $_POST[self::$password];
	}

	// Gets if the User did select "Keep me logged in".
	public function getSelectKeep()
	{
		return isset($_POST[self::$keep]);
	}
}