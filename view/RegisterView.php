<?php
class RegisterView {

	private static $register = 'RegisterView::Register';
	private static $registerUsername = 'RegisterView::UserName';
	private static $registerPassword = 'RegisterView::Password';
	private static $registerPasswordRepeat = 'RegisterView::PasswordRepeat';
	private static $registermessageId = 'RegisterView::Message';

	public function response($registerUserModel) {

		$responseMessage = "";
		$usernameToRemeber = "";

		if ($registerUserModel != NULL)
		{
			if (!$registerUserModel->isUsernameLengthCorrect())
			{
				$usernameToRemeber = $this->getInputUsername();
				$responseMessage = "Username has too few characters, at least 3 characters.<br>";
			}
			if (!$registerUserModel->isPasswordLengthCorrect())
			{
				$usernameToRemeber = $this->getInputUsername();
				$responseMessage .= "Password has too few characters, at least 6 characters. <br>";
			}
			if (!$registerUserModel->isPasswordsEqual())
			{
				$usernameToRemeber = $this->getInputUsername();
				$responseMessage .= "Passwords do not match. <br>";
			}
			if (!$registerUserModel->isUsernameUnique())
			{
				$usernameToRemeber = $this->getInputUsername();
				$responseMessage .= "User exists, pick another username. <br>";
			}
			if (!$registerUserModel->isUsernameFormatValid())
			{
				$usernameToRemeber = $registerUserModel->trimUsername();
				$responseMessage .= "Username contains invalid characters. <br>";
			}
			if ($registerUserModel->validation())
			{
				$responseMessage = "Registered new user.";
			}
		}
		
		return $this->generateRegisterUserFormHTML($responseMessage, $usernameToRemeber);
	}

	private function generateRegisterUserFormHTML($message, $rememberUsername)
	{
		return '
			<h2>Register new user</h2>
			<form method="post" > 
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					
					<p id="' . self::$registermessageId. '">' . $message . '</p>

					<label for="' . self::$registerUsername . '">Username :</label>
					<input type="text" id="' . self::$registerUsername . '" name="' . self::$registerUsername . '" value="' . $rememberUsername . '" /><br>

					<label for="' . self::$registerPassword . '">Password :</label>
					<input type="password" id="' . self::$registerPassword . '" name="' . self::$registerPassword . '" /><br>

					<label for="' . self::$registerPasswordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$registerPasswordRepeat . '" name="' . self::$registerPasswordRepeat . '" /><br>
					
					<input type="submit" name="' . self::$register . '" value="register" />
				</fieldset>
			</form>
		';
	}

	// Asks if the User did press the register-button.
	public function didUserPressRegister()
	{
		return isset($_POST[self::$register]);
	}

	public function getInputUsername()
	{
		return $_POST[self::$registerUsername];
	}

	public function getInputPassword()
	{
		return $_POST[self::$registerPassword];
	}

	public function getInputRepeatedPassword()
	{
		return $_POST[self::$registerPasswordRepeat];
	}
}