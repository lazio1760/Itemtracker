<?php

include ("hrtsDatabaseConnection.php");

$id = $_REQUEST["id"];

$get_form = new update_employee();

$get_form->update_employee_form($id);

class update_employee{
	
	public function update_employee_form($id){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		$results = $hrtsConnection->query("Select * FROM users WHERE id = $id");
		
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$content ="<div id=\"update_employee_div\">";
            
			$content .="<form id=\"update_employee_form\" class=\"formFormatting\" name=\"update_employee_form\">";
			$content .="<input type=\"hidden\" id=\"id\" name=\"id\" value=\"$id\" />";
			$content .="<table><tbody>";
			$content .="<tr><td ><label class=\"highlight\"> First Name </label></td><td><input type=\"text\" id=\"first_name\" name=\"first_name\" value=\"".$row["firstName"]."\" /></td></tr>";
			$content .="<tr><td ><label class=\"highlight\"> Last Name </label></td><td><input type=\"text\" id=\"last_name\" name=\"last_name\" tabindex=\"-1\" value=\"".$row["lastName"]."\"/></td></tr>";
			$content .="<tr><td class=\"tdWidth2\"><label class=\"highlight\">Email</label></td><td><input type=\"text\" id=\"email\" name=\"email\" tabindex=\"-1\" value=\"".$row["email"]."\" /></td></tr>";
			//$content .="<tr><td class=\"tdWidth2\">Password</td><td><input type=\"password\" id=\"password\" name=\"password\" tabindex=\"-1\" value=\"".$row["password"]."\" readonly=\"readonly\" /></td></tr>";
			if($row["role"] == "hrts_admin"){
				$content .="<tr><td >Role</td><td>";
				$content .="<select name=\"role\">";
				$content .="<option value=\"hrts_admin\" selected=\"selected\"> Heitech Services Admin </option>";
				$content .="<option value=\"pm_admin\"> Program Manager </option>";
				$content .="<option value=\"dpm_admin\"> Deputy Program Manager </option>";
				$content .="<option value=\"supervisor\">  Supervisor </option>";
				$content .="<option value=\"task_leader\"> Task Leader </option>";
				$content .="<option value=\"technician\"> Technician </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["role"] == "pm_admin"){
				$content .="<tr><td >Role</td><td>";
				$content .="<select name=\"role\">";
				$content .="<option value=\"hrts_admin\"> Heitech Services Admin </option>";
				$content .="<option value=\"pm_admin\" selected=\"selected\"> Program Manager </option>";
				$content .="<option value=\"dpm_admin\"> Deputy Program Manager </option>";
				$content .="<option value=\"supervisor\">  Supervisor </option>";
				$content .="<option value=\"task_leader\"> Task Leader </option>";
				$content .="<option value=\"technician\"> Technician </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["role"] == "dpm_admin"){
				$content .="<tr><td >Role</td><td>";
				$content .="<select name=\"role\">";
				$content .="<option value=\"hrts_admin\"> Heitech Services Admin </option>";
				$content .="<option value=\"pm_admin\"> Program Manager </option>";
				$content .="<option value=\"dpm_admin\" selected=\"selected\"> Deputy Program Manager </option>";
				$content .="<option value=\"supervisor\">  Supervisor </option>";
				$content .="<option value=\"task_leader\"> Task Leader </option>";
				$content .="<option value=\"technician\"> Technician </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["role"] == "supervisor"){
				$content .="<tr><td >Role</td><td>";
				$content .="<select name=\"role\">";
				$content .="<option value=\"hrts_admin\"> Heitech Services Admin </option>";
				$content .="<option value=\"pm_admin\"> Program Manager </option>";
				$content .="<option value=\"dpm_admin\"> Deputy Program Manager </option>";
				$content .="<option value=\"supervisor\" selected=\"selected\">  Supervisor </option>";
				$content .="<option value=\"task_leader\"> Task Leader </option>";
				$content .="<option value=\"technician\"> Technician </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["role"] == "task_leader"){
				$content .="<tr><td >Role</td><td>";
				$content .="<select name=\"role\">";
				$content .="<option value=\"hrts_admin\"> Heitech Services Admin </option>";
				$content .="<option value=\"pm_admin\"> Program Manager </option>";
				$content .="<option value=\"dpm_admin\"> Deputy Program Manager </option>";
				$content .="<option value=\"supervisor\">  Supervisor </option>";
				$content .="<option value=\"task_leader\" selected=\"selected\"> Task Leader </option>";
				$content .="<option value=\"technician\"> Technician </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["role"] == "technician"){
				$content .="<tr><td >Role</td><td>";
				$content .="<select name=\"role\">";
				$content .="<option value=\"hrts_admin\"> Heitech Services Admin </option>";
				$content .="<option value=\"pm_admin\"> Program Manager </option>";
				$content .="<option value=\"dpm_admin\"> Deputy Program Manager </option>";
				$content .="<option value=\"supervisor\">  Supervisor </option>";
				$content .="<option value=\"task_leader\"> Task Leader </option>";
				$content .="<option value=\"technician\" selected=\"selected\"> Technician </option>";
				$content .="</select></td></tr>";
			}
			if($row["group"] == "510K"){
				$content .="<tr><td >Group</td><td>";
				$content .="<select name=\"group\">";
				$content .="<option value=\"510K\" selected=\"selected\"> 510K </option>";
				$content .="<option value=\"IDE\"> IDE </option>";
				$content .="<option value=\"PMA\"> PMA </option>";
				$content .="<option value=\"RAD_HEALTH\">  RAD_HEALTH </option>";
				$content .="<option value=\"MAILROOM\"> MAILROOM </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["group"] == "IDE"){
				$content .="<tr><td >Group</td><td>";
				$content .="<select name=\"group\">";
				$content .="<option value=\"510K\"> 510K </option>";
				$content .="<option value=\"IDE\" selected=\"selected\"> IDE </option>";
				$content .="<option value=\"PMA\"> PMA </option>";
				$content .="<option value=\"RAD_HEALTH\">  RAD_HEALTH </option>";
				$content .="<option value=\"MAILROOM\"> MAILROOM </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["group"] == "PMA"){
				$content .="<tr><td >Group</td><td>";
				$content .="<select name=\"group\">";
				$content .="<option value=\"510K\"> 510K </option>";
				$content .="<option value=\"IDE\"> IDE </option>";
				$content .="<option value=\"PMA\" selected=\"selected\"> PMA </option>";
				$content .="<option value=\"RAD_HEALTH\">  RAD_HEALTH </option>";
				$content .="<option value=\"MAILROOM\"> MAILROOM </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["group"] == "RAD_HEALTH"){
				$content .="<tr><td >Group</td><td>";
				$content .="<select name=\"group\">";
				$content .="<option value=\"510K\"> 510K </option>";
				$content .="<option value=\"IDE\"> IDE </option>";
				$content .="<option value=\"PMA\"> PMA </option>";
				$content .="<option value=\"RAD_HEALTH\" selected=\"selected\">  RAD_HEALTH </option>";
				$content .="<option value=\"MAILROOM\"> MAILROOM </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["group"] == "NA"){
				$content .="<tr><td >Group</td><td>";
				$content .="<select name=\"group\">";
				$content .="<option value=\"510K\"> 510K </option>";
				$content .="<option value=\"IDE\"> IDE </option>";
				$content .="<option value=\"PMA\"> PMA </option>";
				$content .="<option value=\"RAD_HEALTH\">  RAD_HEALTH </option>";
				$content .="<option value=\"MAILROOM\" selected=\"selected\"> MAILROOM </option>";
				$content .="</select></td></tr>";
			}
			if($row["organization"] == "Heitech Services Inc"){
				$content .="<tr><td >Organization</td><td>";
				$content .="<select name=\"organization\">";
				$content .="<option value=\"Heitech Services Inc\" selected=\"selected\"> Heitech Services Inc </option>";
				$content .="<option value=\"Zimmerman Associates Inc\"> Zimmerman Associates Inc </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["organization"] == "Zimmerman Associates Inc"){
				$content .="<tr><td >Organization</td><td>";
				$content .="<select name=\"organization\">";
				$content .="<option value=\"Heitech Services Inc\"> Heitech Services Inc </option>";
				$content .="<option value=\"Zimmerman Associates Inc\" selected=\"selected\"> Zimmerman Associates Inc </option>";
				$content .="</select></td></tr>";
			}
			if($row["status"] == "Active" ){
				$content .="<tr><td >Status</td><td>";
				$content .="<select name=\"status\">";
				$content .="<option value=\"Active\" selected=\"selected\"> Active </option>";
				$content .="<option value=\"Inactive\"> Inactive </option>";
				$content .="</select></td></tr>";
			}
			elseif($row["status"] == "Inactive" ){
				$content .="<tr><td >Status</td><td>";
				$content .="<select name=\"status\">";
				$content .="<option value=\"Active\"> Active </option>";
				$content .="<option value=\"Inactive\" selected=\"selected\"> Inactive </option>";
				$content .="</select></td></tr>";
			}
			$content .="</tbody></table>";
			$content .="</form>";
						
			$content .="</div>";
			
			die($content);
		}
		
		
	}
	
	
}

?>