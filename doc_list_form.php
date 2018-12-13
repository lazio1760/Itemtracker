<?php

$current_date = date("m/d/Y", (strtotime('now') - (60*60*5)));

$content = "<div id=\"doc_list\">";
            
$content .= "<form id=\"doc_list_form\" name=\"doc_list_form\" class=\"formFormatting\">";
$content .= "<table><tbody>";

$content .= "<tr><td><label> Date: </label> <input type=\"text\" id=\"doc_list_input\" name=\"doc_list_input\" class=\"datepicker\"/> </td></tr>"; 
$content .= "</tbody></table>";

$content .= "</form>";
            
$content .= "</div>";

die($content);

?>