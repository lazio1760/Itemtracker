<?php

$content = "<div id=\"change_password\">";
            
$content .= "<form id=\"change_password_form\" name=\"change_password_form\" class=\"formFormatting\">";
$content .= "<table><tbody>";

$content .= "<tr><td ><label class=\"highlight\"> Enter New Password </label></td><td class=\"move_objects_right\"><input type=\"password\" id=\"new_password\" name=\"new_password\"/></td></tr>";
$content .= "<tr><td ><label class=\"highlight\"> Confirm New Password </label></td><td class=\"move_objects_right\"><input type=\"password\" id=\"new_password_again\" name=\"new_password_again\" /></td></tr>";

$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

$content .= "<script type=\"text/javascript\">"; 

$content .="</script>";

echo $content;

?>
