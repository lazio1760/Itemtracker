<?php

include ("hrtsDatabaseConnection.php");

session_start();

$role = $_SESSION["role"];
$id = $_SESSION["id"];

$getModifyForm = new modify_attendance_form();

$getModifyForm->get_modify_attendance_form($role,$id);

class modify_attendance_form{
	
	public function get_modify_attendance_form($role,$id){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		if($role == "hrts_admin"){
			
			$results = $hrtsConnection->query("Select * FROM users WHERE id <> $id AND (role = 'hrts_admin' OR role = 'pm_admin' OR role = 'dpm_admin' OR role = 'superviser' OR role = 'task_leader' OR role = 'technician') ORDER BY lastName");
			
		}
		
		elseif($role == "pm_admin"){
		
			$results = $hrtsConnection->query("Select * FROM users WHERE id <> $id AND (role = 'dpm_admin' OR role = 'superviser' OR role = 'task_leader' OR role = 'technician') ORDER BY lastName");	
			
		}
		
		/*elseif($role == "dpm_admin"){
		
			$results = $hrtsConnection->query("Select * FROM users WHERE id <> $id AND (role = 'superviser' OR role = 'task_leader' OR role = 'technician') ORDER BY lastName");	
			
		}
		
		elseif($role == "superviser"){
			
			$results = $hrtsConnection->query("Select * FROM users WHERE id <> $id AND (role = 'task_leader' OR role = 'basic') ORDER BY lastName");
			
		}*/
		else{die('<script type="text/javascript"> alert("Based upon your role access denied."); </script>');}
		
		
		$content = "<div id=\"modifyEmployeeAttendance\">";
					
		$content .= "<form id=\"modifyEmployeeAttendanceForm\" name=\"modifyEmployeeAttendanceForm\" class=\"formFormatting\">";
		$content .= "<table><tbody>";
		$content .= "<tr><td><label> Name </label></td>";
		$content .= "<td class=\"tdWidth2\"><select name=\"employeeName\">";
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
		
			$content .="<option value=\"".$row["id"]."\">".$row["firstName"]." ".$row["lastName"]."</option>";
		
		}
		$content .= "</select></td>";
		$content .= "<td class=\"padding5\"><label> Modify Date </label></td><td><input type=\"text\" id=\"modifyDate\" name=\"modifyDate\" class=\"datepicker2\" tabindex=\"-1\" /></td></tr>";
		$content .= "</tbody></table>";
		$content .= "</form>";
					
		$content .= "</div>";
		
		echo $content;
		
	}

}

?>