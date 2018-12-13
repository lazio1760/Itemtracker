<?php

$content ="<div id=\"add_employee_div\">";
            
$content .="<form id=\"add_employee_form\" class=\"formFormatting\" name=\"add_employee_form\">";
$content .="<table><tbody>";
$content .="<tr><td ><label class=\"highlight\"> First Name </label></td><td><input type=\"text\" id=\"first_name\" name=\"first_name\" /></td></tr>";
$content .="<tr><td ><label class=\"highlight\"> Last Name </label></td><td><input type=\"text\" id=\"last_name\" name=\"last_name\" /></td></tr>";
$content .="<tr><td class=\"tdWidth2\"><label class=\"highlight\"> Email</label></td><td><input type=\"text\" id=\"email\" name=\"email\" value=\"@fda.hhs.gov\" /></td></tr>";
//$content .="<tr><td class=\"tdWidth2\">Password</td><td><input type=\"password\" id=\"password\" name=\"password\"  /></td></tr>";
$content .="<tr><td >Role</td><td>";
$content .="<select name=\"role\">";
$content .="<option value=\"hrts_admin\"> Heitech Services Admin </option>";
$content .="<option value=\"pm_admin\"> Program Manager </option>";
$content .="<option value=\"dpm_admin\"> Deputy Program Manager </option>";
$content .="<option value=\"supervisor\">  Supervisor </option>";
$content .="<option value=\"task_leader\"> Task Leader </option>";
$content .="<option value=\"technician\"> Technician </option>";
$content .="</select></td></tr>";
$content .="<tr><td >Group</td><td>";
$content .="<select name=\"group\">";
$content .="<option value=\"510K\"> 510K </option>";
$content .="<option value=\"IDE\"> IDE </option>";
$content .="<option value=\"PMA\"> PMA </option>";
$content .="<option value=\"RAD_HEALTH\">  RAD_HEALTH </option>";
$content .="<option value=\"MAILROOM\"> MAILROOM </option>";
$content .="</select></td></tr>";
$content .="<tr><td >Organization</td><td>";
$content .="<select name=\"organization\">";
$content .="<option value=\"Heitech Services Inc\"> Heitech Services Inc </option>";
$content .="<option value=\"Zimmerman Associates Inc\"> Zimmerman Associates Inc </option>";
$content .="</select></td></tr>";
$content .="<tr><td >Status</td><td>";
$content .="<select name=\"status\">";
$content .="<option value=\"Active\"> Active </option>";
$content .="<option value=\"Inactive\"> Inactive </option>";
$content .="</select></td></tr>";
$content .="</tbody></table>";
$content .="</form>";
            
$content .="</div>";

die($content);

?>