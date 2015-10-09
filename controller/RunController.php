<?php
require_once("model/UserDAL.php");
require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');
require_once("model/UserCatalog.php");
require_once('model/UserAuthorization.php');

class RunController {
	// Controllers
	private $loginControl;
	private $registerControl;
	private $loginView;
	private $loginUser;
	private $userAuth;
	private $userDAL;
	private $userCatalog;

	// HTML-respone.
	private $responeHTML;
	private static $registerQueryString = 'register';
	
	// MYSQL
	private $db;

	public function __construct() {
		$set = new Settings();

		$this->db = new mysqli(Settings::MYSQL_SERVER, Settings::MYSQL_USERNAME, Settings::MYSQL_PASSWORD, Settings::MYSQL_DATABASE, Settings::MYSQL_PORT);
		if (mysqli_connect_errno())
		{
			printf("Connect failed : %s\n", mysqli_connect_error());
			exit();
		}
		
		$this->userDAL = new UserDAL($this->db);
		$this->userCatalog = new UserCatalog();
		$this->userCatalog = $this->userDAL->getUsers();
		$this->userAuth = new UserAuthorization($this->userCatalog);
		$this->registerControl = new RegisterController($this->userDAL, $this->userCatalog, $this->userAuth);
		$this->loginControl = new LoginController($this->userDAL, $this->userCatalog, $this->userAuth);
	}

	// Start the application. Selects between Register and Login.
	public function start()
	{
		if (isset($_GET[self::$registerQueryString]))
		{
			$this->registerControl->doRegister();
			$this->responeHTML = $this->registerControl->getHTML();
		}
		else 
		{
			$this->loginControl->doLogin(); 
			$this->responeHTML = $this->loginControl->getHTML();
		}
		$this->db->close();
	}

	public function getHTML()
	{
		return $this->responeHTML;
	}

	public function isLoggedIn()
	{
		return $this->loginControl->isLoggedIn();
	}

	public function getQueryStringRegister()
	{
		return self::$registerQueryString;
	}
}						