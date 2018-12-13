<?php

include ("hrtsDatabaseConnection.php");

$hrtsConnect = new databaseConnection();
$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();

$current_date = date("m/d/Y", (strtotime('now')/* - (60*60*5)*/));

$content = "<div id=\"summaryReportTool\">";
            
$content .= "<form id=\"summaryReportForm\" name=\"summaryReportForm\" class=\"formFormatting\">";
$content .= "<table><tbody>";
$content .= "<tr><td><label> Name </label></td>";
$content .= "<td class=\"tdWidth2\"><select multiple id='employeeName' name='employeeName'>";

$results = $hrtsConnection->query("Select * FROM users ORDER BY lastName");

while($row = $results->fetch(PDO::FETCH_ASSOC)){
		
			$content .="<option value=\"".$row["id"]."\">".$row["firstName"]." ".$row["lastName"]."</option>";
		
		}
$content .= "</select></td></tr>";
$content .= "</tbody></table>";
$content .= "<table><tbody>";
$content .= "<tr><td><label> Start Date: </label></td><td><input type=\"text\" id=\"startDateAttendance\" name=\"startdate\" class=\"datepicker\" tabindex=\"-1\" /></td>"; 
$content .= "<td class=\"padding5\"><label> End Date: </label></td><td><input type=\"text\" id=\"endDateAttendance\" name=\"enddate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
$content .= "</tbody></table>";
//$content .= "<table><tbody>";
//$content .= "<tr><td><label> Sort By: </label></td><td>";
//$content .= "<select name=\"sortType\">";
//$content .= "<option value=\"sortName\"> Name </option>";
//$content .= "<option value=\"sortTimeIn\"> Time In </option>";
//$content .= "<option value=\"sortTimeOut\"> Time Out </option>";
//$content .= "<option value=\"sortTimeIn\"> Hours </option>";
//$content .= "</select></td></tr>";
//$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

die($content);

?>