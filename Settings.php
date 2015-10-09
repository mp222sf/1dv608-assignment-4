<?php
/**
 * The settings file contains installation specific information
 * 
 */
class Settings {

	// Settings for setup of the MYSQL-connection.
	const MYSQL_SERVER = "mysql5.000webhost.com";
	const MYSQL_USERNAME = "a5233204_mp222sf";
	const MYSQL_PASSWORD = "hejhej123";
	const MYSQL_DATABASE = "a5233204_Users";
	const MYSQL_PORT = "3306";

	// Display errors if the appear.
	const DISPLAY_ERRORS = true;

	// Sets timezone.
	public function __construct()
	{
		date_default_timezone_set('Europe/Stockholm');
	}
}		