<?php
require_once("User.php");

class UserCatalog {

	private $users = array();

	public function add(User $toAdd) {
		foreach ($this->users as $user) {
			if ($user->getUsername() === $toAdd->getUsername()) {
				throw new Exception("You cannot add two users with the same name");
			}
		}
		$key = $toAdd->getUsername();
		$this->users[$key] = $toAdd;
	}

	public function getUsers() {
		return $this->users;
	}
}