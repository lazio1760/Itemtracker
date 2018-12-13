<?php
	$content = "<div id=\"opsDetail\">";
            
$content .= "<form id=\"opsDetailForm\" name=\"opsDetailForm\">";
$content .= "<table><tbody>";

$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
$content .= "<select name=\"documentType\">";
$content .= "<option value=\"510K\"> K </option>";
$content .= "<option value=\"IDE\"> G </option>";
$content .= "<option value=\"PMA\"> P </option>";
$content .= "<option value=\"RAD_HEALTH\"> R </option>";
$content .= "</select></td></tr>";

$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

echo $content;

?>