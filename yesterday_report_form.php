<?php

$current_date = date("m/d/Y", (strtotime('now') - (60*60*5)));

$content = "<div id=\"yesterdayReportTool\">";
            
$content .= "<form id=\"yesterdayReportForm\" name=\"yesterdayReportForm\">";
$content .= "<table><tbody>";
//$content .= "<tr><td><label> Date: </label> <input type=\"text\" id=\"todayDate\" name=\"todayDate\" class=\"datepicker2\" value=\"$current_date\" tabindex=\"-1\" readonly=\"readonly\" /></td></tr>";
$content .= "<tr><td><label> Date: </label> <input type=\"text\" id=\"yesterdayDate\" name=\"yesterdayDate\" class=\"datepicker\" tabindex=\"-1\" /> </td></tr>"; 
$content .= "</tbody></table>";
$content .= "<table><tbody>";
$content .= "<tr><td><label> Sort By: </label></td><td>";
$content .= "<select name=\"sortType\">";
$content .= "<option value=\"sortName\"> Name </option>";
$content .= "<option value=\"sortTimeIn\"> Time In </option>";
$content .= "<option value=\"sortTimeOut\"> Time Out </option>";
//$content .= "<option value=\"sortTimeIn\"> Hours </option>";
$content .= "</select></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

die($content);

?>