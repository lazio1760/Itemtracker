<?php

include ("hrtsDatabaseConnection.php");

//session_start();

//$role = $_SESSION["role"];
//$id = $_SESSION["id"];

$getEmployeeList = new employee_list();

$getEmployeeList->get_employee_list_form();

class employee_list{
	
	public function get_employee_list_form(){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
			
		$results = $hrtsConnection->query("Select * FROM users ORDER BY lastName");
	
		$content = "<div id=\"selectUpdateEmployee\">";
					
		$content .= "<form id=\"selectUpdateEmployeeForm\" name=\"selectUpdateEmployeeForm\" class=\"formFormatting\">";
		$content .= "<table><tbody>";
		$content .= "<tr><td><label> Name </label></td>";
		$content .= "<td class=\"tdWidth2\"><select name=\"employeeName\">";
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
		
			$content .="<option value=\"".$row["id"]."\">".$row["firstName"]." ".$row["lastName"]."</option>";
		
		}
		$content .= "</select></td></tr>";
		$content .= "</tbody></table>";
		$content .= "</form>";
					
		$content .= "</div>";
		
		echo $content;
		
	}

}

?>