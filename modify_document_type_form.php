<?php

$content = "<div id=\"captureDoc\">";
            
$content .= "<form id=\"captureDocForm\" name=\"captureDocForm\">";
$content .= "<table><tbody>";

$content .= "<tr><td ><label class=\"highlight\"> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
$content .= "<select name=\"documentType\">";
$content .= "<option value=\"510K\"> K </option>";
$content .= "<option value=\"IDE\"> G </option>";
$content .= "<option value=\"PMA\"> P </option>";
$content .= "<option value=\"RAD_HEALTH\"> R </option>";
$content .= "<option value=\"513G\"> C </option>";
$content .= "<option value=\"Mis_Routed\"> MR </option>";
$content .= "</select></td></tr>";
$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" /></td></tr>";

$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

$content .= "<script type=\"text/javascript\">"; 

$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";

$content .="</script>";

echo $content;

?>
