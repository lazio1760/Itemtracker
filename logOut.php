<?php

include ("hrtsDatabaseConnection.php");

include ("trackTime.php");

session_start();

$id = $_SESSION['id'];

$logoutTime = new logoutTime();
			
$logoutTime->logout_time($id);

unset($_SESSION['firstName']);
unset($_SESSION['lastName']);
unset($_SESSION['id']);
unset($_SESSION['current_date']);
unset($_SESSION['current_time']);

session_destroy();

die("completed");

?>