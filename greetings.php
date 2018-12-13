<?php

include ("hrtsDatabaseConnection.php");

$current_date = date("Y-m-d", (strtotime('now') - (60*60*5)));

session_start();
		
$hrtsConnect = new databaseConnection();

$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();

//$id = $_SESSION['id'];

$results = $hrtsConnection->query("SELECT * FROM `users_time` WHERE id = ". $_SESSION['id'] ." AND date = '$current_date'");

if($results->rowCount() == 0){
			
			die("BROKEN results in greeting.php");
		}
		
else{
	while($row = $results->fetch(PDO::FETCH_ASSOC)){ $login_time = $row["login_time"];}
}



$content = "Logged in as " . $_SESSION['firstName'] ." ". $_SESSION['lastName'] ." at ". $login_time ." on ". date("m-d-Y", (strtotime($current_date)));

die($content);

?>