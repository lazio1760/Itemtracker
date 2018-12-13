<?php

$content = "<div id=\"locateDoc\">";
            
$content .= "<form id=\"locateDocForm\"  name=\"locateDocForm\">";
$content .= "<table><tbody>";
$content .= "<tr><td><label class=\"highlight\">FDA Application Number</label></td><td><input type=\"text\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td ><label class=\"highlight\"> Document Type </label></td><td>";
$content .= "<select name=\"documentType\">";
$content .= "<option value=\"510K_A\"> Original 510(k) Submissions </option>";
$content .= "<option value=\"510K_B\"> 510(k) Hold Requests </option>";
$content .= "<option value=\"510K_C\"> 510(k) Requests for Extensions Exemptions</option>";
$content .= "<option value=\"510K_D\"> 510(k) Additional Information Requests</option>";
$content .= "<option value=\"510K_E\"> 510(k) Withdrawal Requests</option>";
$content .= "<option value=\"510K_F\"> 510(k) CLIA and Unsolicited Amendments</option>";
$content .= "<option value=\"510K_G\"> 510(k) \"X\" Files, \"BK\" Files, and \"BK/A\" Files</option>";
$content .= "<option value=\"510K_H\"> 510(k) Modifications or Corrections</option>";
$content .= "<option value=\"510K_I\"> 510(k) Closeout</option>";
$content .= "<option value=\"510K_J\"> Incomplete Responses</option>";
$content .= "<option value=\"510K_K\"> Appeals </option>";
$content .= "<option value=\"510K_L\"> Denovo's </option>";
$content .= "<option value=\"master_A\">Original Master Files </option>";
$content .= "<option value=\"master_B\">Master File Amendments and Authorization Letters</option>";
$content .= "<option value=\"PMA_A\"> PMA Shell and Modules</option>";
$content .= "<option value=\"PMA_B\"> PMA Modules Amendments</option>";
$content .= "<option value=\"PMA_C\"> Original PMA Applications</option>";
$content .= "<option value=\"PMA_D\"> Amendments to Original PMA Applications</option>";
$content .= "<option value=\"PMA_E\"> Modifying a PMA Amendment Record</option>";
$content .= "<option value=\"PMA_F\"> PMA Application Supplements</option>";
$content .= "<option value=\"PMA_G\"> Amendments to PMA Supplements</option>";
$content .= "<option value=\"PMA_H\"> PMA \"BP\" Files and \"BP/S\" Files</option>";
$content .= "<option value=\"PMA_I\"> HDE Originals and Supplements</option>";
$content .= "<option value=\"PMA_J\"> HDE Amendments</option>";
$content .= "<option value=\"IDE_A\"> IDE Original Submissions/EUA's/FIH's</option>";
$content .= "<option value=\"IDE_B\"> IDE Supplement and Amendment Submissions</option>";
$content .= "<option value=\"IDE_C\"> IDE Log Out for Originals, Supplements and Amendments</option>";
$content .= "<option value=\"IDE_D\"> IDE Misrouted and Corrected Documents </option>";
$content .= "<option value=\"IDE_E\"> IDE Pre-Submissions</option>";
$content .= "<option value=\"OCERSOP_A\"> RadHealth</option>";
$content .= "<option value=\"OCERSOP_B\"> Form 2579</option>";
$content .= "</select></td></tr>";
$content .= "<tr><td>Status</td><td><select name=\"status\"><option value=\"checkout\">Check Out</option><option value=\"checkin\">Check In</option></select></td></tr>";
$content .= "<tr><td>Assigned Internal K Number</td><td><input type=\"text\" id=\"internalK\" name=\"internalK\" tabindex=\"-1\" /></td></tr>"; 
$content .= "<tr><td>Shelf Location</td><td><input type=\"text\" id=\"shelfLocation\" name=\"shelfLocation\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td>Check Out Location</td><td><input type=\"text\" id=\"checkoutLocation\" name=\"checkoutLocation\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td>Who Checked Out</td><td><input type=\"text\" id=\"whoCheckedOut\" name=\"whoCheckedOut\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td><label> Checked In Date </label></td><td><input type=\"text\" id=\"checkedInDate\" name=\"checkedInDate\" class=\"datepicker2\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td><label> Checked Out Date </label></td><td><input type=\"text\" id=\"checkedOutDate\" name=\"checkedOutDate\" class=\"datepicker2\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td><label> Due In Date </label></td><td><input type=\"text\" id=\"dueInDate\" name=\"dueInDate\" class=\"datepicker2\" tabindex=\"-1\" /></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

echo $content;

?>
