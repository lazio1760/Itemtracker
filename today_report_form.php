<?php

$current_date = date("m/d/Y", (strtotime('now') - (60*60*5)));

$content = "<div id=\"todayReportTool\">";
            
$content .= "<form id=\"todayReportForm\" name=\"todayReportForm\">";
$content .= "<table><tbody>";
//$content .= "<tr><td><label> Date: </label> <input type=\"text\" id=\"todayDate\" name=\"todayDate\" class=\"datepicker2\" value=\"$current_date\" tabindex=\"-1\" readonly=\"readonly\" /></td></tr>";
$content .= "<tr><td><label> Date: </label> <input type=\"text\" id=\"todayDate\" name=\"todayDate\" value=\"$current_date\" tabindex=\"-1\" readonly=\"readonly\" /> (mm/dd/yyyy) </td></tr>"; 
$content .= "</tbody></table>";
$content .= "<table><tbody>";
$content .= "<tr><td><label> Sort By: </label></td><td>";
$content .= "<select name=\"sortType\">";
$content .= "<option value=\"sortName\"> Name </option>";
$content .= "<option value=\"sortTimeIn\"> Time In </option>";
$content .= "</select></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

die($content);

?>