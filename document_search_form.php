<?php

$content = "<div id=\"document_search\">";
            
$content .= "<form id=\"document_search_Form\" name=\"document_search_Form\" class=\"formFormatting\">";
$content .= "<table><tbody>";
$content .= "<tr><td class=\"tdWidth\"><label> Delivery Tracking Number </label></td><td><input type=\"text\" id=\"trackingNumber\" name=\"trackingNumber\" /> </td></tr>";
$content .= "<tr><td><label> Receipt Date </label></td><td><input type=\"text\" id=\"date\" name=\"date\" class=\"datepicker2\" /> </td></tr>";
$content .= "<tr><td><label> Manufacturer </label></td><td><input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" /> </td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

die($content);

?>