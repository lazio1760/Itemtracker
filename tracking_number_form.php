<?php

$content = "<div id=\"tracking_number_search_div\">";
            
$content .= "<form id=\"tracking_number\" name=\"tracking_number\" class=\"formFormatting\">";
$content .= "<table><tbody>";

$content .= "<tr><td ><label class=\"highlight\">Delivery Company</label></td><td class=\"move_objects_right\">";
$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
$content .= "<option value=\"DHL\">DHL</option>";
$content .= "<option value=\"FEDEX\">Fed Ex</option>";
$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
$content .= "<option value=\"TNT\">TNT Express</option>";
$content .= "<option value=\"UPS\">UPS</option>";
$content .= "<option value=\"USPS\">US Postal Service</option>";
$content .= "</select></td></tr>";

$content .= "<tr><td ><label class=\"highlight\"> Delivery Tracking Number </label></td><td class=\"move_objects_right\"><input type=\"text\" id=\"deliveryTracking\" name=\"deliveryTracking\" size=\"20\"/></td></tr>";

$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

$content .= "<script type=\"text/javascript\">"; 

$content .="</script>";

echo $content;

?>
