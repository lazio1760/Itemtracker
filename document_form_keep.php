<?php

$content = "<div id=\"captureDoc\">";
            
$content .= "<form id=\"captureDocForm\" name=\"captureDocForm\">";
$content .= "<table><tbody>";
$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Assigned Internal K Number</label></td><td><input type=\"text\" id=\"internalK\" name=\"internalK\" /></td></tr>";
$content .= "<tr><td class=\"tdWidth\">FDA Application Number</td><td><input type=\"text\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td class=\"tdWidth\">Manufacturer</td><td><input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td >Document Type</td><td>";
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
$content .= "<tr><td >Delivery Company</td><td>";
$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
$content .= "<option value=\"AIRBORNE\">Airborne Express</option>";
$content .= "<option value=\"FEDEX\">Fed Ex</option>";
$content .= "<option value=\"TNT\">TNT Express</option>";
$content .= "<option value=\"UPS\">UPS</option>";
$content .= "<option value=\"USPS\">US Postal Service</option>";
$content .= "<option value=\"Other\">Other</option>";
$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
$content .= "<tr><td >Delivery Tracking Number</td><td><input type=\"text\" id=\"deliveryTracking\" name=\"deliveryTracking\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td ><label> Shipped Date </label></td><td><input type=\"text\" id=\"shippedDate\" name=\"shippedDate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td ><label class=\"highlight\"> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

$content .= "<script type=\"text/javascript\">"; 
//$content .= "optionValue = $('#moreInfo option:selected').val()";$('#moreInfo').show();
//$content .= "if(optionValue == 'Other'){alert('Works WELL!!!!!!');}";
//$content .= "$('#deliveryCompany').change(function(e){optionValue = $('#deliveryCompany option:selected').val(); $('#moreInfo').show(); e.preventDefault();});";

$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";

$content .="</script>";

echo $content;

?>
