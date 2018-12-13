<?php

session_start();

include ("hrtsDatabaseConnection.php");

include ("trackTime.php");

$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));

$lunch_status = $_REQUEST["status"];

$myConnection = new databaseConnection();
$data_connection = $myConnection->hrtsDatabaseConnection();
		
$check_lunch_status = $data_connection->query("Select * FROM users_time WHERE id = " .$_SESSION['id']. " and date = '$current_date'");

$lunch_status_row = $check_lunch_status->fetch(PDO::FETCH_ASSOC);

if((!empty($lunch_status_row["on_lunch"])) && (!empty($lunch_status_row["off_lunch"])) && $lunch_status == "start"){

	die("Lunch hours already submitted for today please see administrator to make adjustments.");

}

if($lunch_status == "start"){
	
	//die($_SESSION['id']);

	$start_lunch_time = new startLunch();
	
	$start_lunch_time->start_lunch($_SESSION['id']);

}

if($lunch_status == "end"){

	$end_lunch_time = new endLunch();
	
	$end_lunch_time->end_lunch($_SESSION['id']);

}


?>