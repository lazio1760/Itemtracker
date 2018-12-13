<?php

$modified = $_REQUEST["modified"];

$loginTime = $_REQUEST["loginTimeHour"].":".$_REQUEST["loginTimeMinute"].":00 ".$_REQUEST["loginTimeAmPm"];
$logoutTime = $_REQUEST["logoutTimeHour"].":".$_REQUEST["logoutTimeMinute"].":00 ".$_REQUEST["logoutTimeAmPm"];
if(!empty($_REQUEST["startLunchTimeHour"]) && !empty($_REQUEST["startLunchTimeMinute"])){
	$startLunch = $_REQUEST["startLunchTimeHour"].":".$_REQUEST["startLunchTimeMinute"].":00 ".$_REQUEST["startLunchTimeAmPm"];
}
else{$startLunch = "";}
if(!empty($_REQUEST["endLunchTimeHour"]) && !empty($_REQUEST["endLunchTimeMinute"])){
$endLunch = $_REQUEST["endLunchTimeHour"].":".$_REQUEST["endLunchTimeMinute"].":00 ".$_REQUEST["endLunchTimeAmPm"];
}
else{$endLunch = "";}
$comments = $_REQUEST["comments"];

include ("hrtsDatabaseConnection.php");

$id = $_REQUEST['id'];

$date = date("Y-m-d", (strtotime($_REQUEST['date'])));

$updateEmployeeTime = new update_employee_time_data();

$updateEmployeeTime->update_time_data($id,$date,$loginTime,$logoutTime,$startLunch,$endLunch,$modified,$comments);

class update_employee_time_data{
	
	public function update_time_data($id,$date,$loginTime,$logoutTime,$startLunch,$endLunch,$modified,$comments){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		$results = $hrtsConnection->exec("UPDATE `users_time` SET login_time = '$loginTime', logout_time = '$logoutTime', on_lunch = '$startLunch', off_lunch = '$endLunch', modified_by = '$modified', comments = '$comments' WHERE id = $id AND date = '$date'");
		
		if($results == 1){
			
			die("Employee has been updated.");
		}
		
		else {die("Update Failed");}
	}
	
}

?>