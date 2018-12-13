<?php

$content = "<div id=\"myAttendanceReport\">";
            
$content .= "<form id=\"attendanceReport\" name=\"attendanceReport\">";
$content .= "<table><tbody>";
$content .= "<tr><td><label> Start Date: </label></td><td><input type=\"text\" id=\"startDateAttendance\" name=\"startdate\" class=\"datepicker\" tabindex=\"-1\" /></td>"; 
$content .= "<td class=\"padding5\"><label> End Date: </label></td><td><input type=\"text\" id=\"endDateAttendance\" name=\"enddate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
$content .= "</tbody></table>";
$content .= "<table><tbody>";
$content .= "<tr><td>Report Type</td><td>";
$content .= "<select name=\"reportType\">";
$content .= "<option value=\"summaryReport\"> Summary Report </option>";
$content .= "<option value=\"detailReport\"> Detail Report </option>";
$content .= "</select></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

echo $content;

?>