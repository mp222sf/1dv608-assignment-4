<?php

class UserDAL {

	private static $table = "Users";
	private static $tableRowUsername = "Username";
	private $userCatalog;

	public function __construct(mysqli $db)
	{
		$this->database = $db;
	}

	public function getUsers()
	{
		$this->userCatalog = new UserCatalog();	

		$stmt = $this->database->prepare("SELECT * FROM " . self::$table);
		if ($stmt === FALSE) {
			throw new Exception($this->database->error);
		}
		$stmt->execute();
	 	
	    $stmt->bind_result($username, $password);

	    while ($stmt->fetch()) {
	    	$user = new User($username, $password);
	    	$this->userCatalog->add($user);
		}
		return  $this->userCatalog;
	}

	public function add(User $toAdded)
	{
		$stmt = $this->database->prepare("INSERT INTO `a5233204_Users`.`Users` (
			`username` , `password` )
				VALUES (?, ?)");
		if ($stmt === FALSE) {
			throw new Exception($this->database->error);
		}

		$username = $toAdded->getUsername();
		$password = $toAdded->getPassword();
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
	}
}