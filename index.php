<?php

require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/RunController.php');
require_once('Settings.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
if (Settings::DISPLAY_ERRORS)
{
	ini_set('display_errors', 'On');
}
else {
	ini_set('display_errors', 'Off');
}


//CREATE OBJECTS
$dtv = new DateTimeView();
$lv = new LayoutView();
$run = new RunController();

// Starts the application.
$run->start(); 

$htmlReponse = $run->getHTML();
$htmlDateTime = $dtv->show();
$loggedInStatus = $run->isLoggedIn();
$qStringRegister = $run->getQueryStringRegister();
$lv->render($loggedInStatus, $htmlReponse, $htmlDateTime, $qStringRegister);

