<?php

$group = trim($_REQUEST['group']);

$content = "<div id=\"processDoc\">";
            
$content .= "<form id=\"processDocForm\" name=\"processDocForm\">";

$content .= "<table><tbody>";
$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> FDA Application Number </label></td><td>";

if($group == '510K'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
$content .= "<option value=\"K\" selected=\"selected\">K</option>";
$content .= "<option value=\"C\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> / <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
}
elseif($group == 'IDE'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
$content .= "<option value=\"G\" selected=\"selected\">G</option>";
$content .= "<option value=\"Q\">Q</option>";
$content .= "<option value=\"MAF\">MAF</option>";
$content .= "<option value=\"PI\">PI</option>";
$content .= "<option value=\"V\">V</option>";
$content .= "<option value=\"C\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\"/>";	
}
elseif($group == 'PMA'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
$content .= "<option value=\"P\" selected=\"selected\">P</option>";
$content .= "<option value=\"H\">H</option>";
$content .= "<option value=\"D\">D</option>";
$content .= "<option value=\"M\">M</option>";
$content .= "<option value=\"N\">N</option>";
$content .= "<option value=\"C\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
}
elseif($group == 'RAD_HEALTH'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
$content .= "<option value=\"R\" selected=\"selected\">R</option>";
$content .= "<option value=\"C\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> / <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";	
}

$content .= "</td></tr>";
$content .= "</tbody></table>";


$content .= "<div class=\"or_position\"> <label class=\"or_position2\"> or </label> </div>";


$content .= "<table><tbody>";
$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" /></td></tr>";

if($group == '510K'){

	$content .= "<tr><td ><label class=\"highlight\">Group</label></td><td>";
	$content .= "<select name=\"group\">";
	$content .= "<option value=\"510K\" selected=\"selected\"> 510K </option>";
	$content .= "<option value=\"513G\"> 513G </option>";
	$content .= "</select></td></tr>";				

}
elseif($group == 'IDE'){
	
	$content .= "<tr><td ><label class=\"highlight\">Group</label></td><td>";
	$content .= "<select name=\"group\">";
	$content .= "<option value=\"IDE\" selected=\"selected\"> IDE </option>";
	$content .= "<option value=\"513G\"> 513G </option>";
	$content .= "</select></td></tr>";

}
elseif($group == 'PMA'){

	$content .= "<tr><td ><label class=\"highlight\">Group</label></td><td>";
	$content .= "<select name=\"group\">";
	$content .= "<option value=\"PMA\" selected=\"selected\"> PMA </option>";
	$content .= "<option value=\"513G\"> 513G </option>";
	$content .= "</select></td></tr>";	

}
elseif($group == 'RAD_HEALTH'){

	$content .= "<tr><td ><label class=\"highlight\">Group</label></td><td>";
	$content .= "<select name=\"group\">";
	$content .= "<option value=\"RAD_HEALTH\" selected=\"selected\"> RAD_HEALTH </option>";
	$content .= "<option value=\"2579\"> 2579 </option>";
	$content .= "<option value=\"513G\"> 513G </option>";
	$content .= "</select></td></tr>";	

}
elseif($group == '513G'){

	$content .= "<tr><td ><label class=\"highlight\">Group</label></td><td>";
	$content .= "<select name=\"group\">";
	$content .= "<option value=\"510K\"> 510K </option>";
	$content .= "<option value=\"IDE\"> IDE </option>";
	$content .= "<option value=\"PMA\"> PMA </option>";
	$content .= "<option value=\"RAD_HEALTH\"> RAD_HEALTH </option>";
	$content .= "<option value=\"513G\" selected=\"selected\"> 513G </option>";
	$content .= "</select></td></tr>";	

}

$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker2\" /></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

$content .= "<script type=\"text/javascript\">"; 
$content .= "$('#moreInfo').hide();";
$content .= "$('#fdaAppNumber2').hide();";
$content .= "$('#fdaAppNumberSup2').hide();";
$content .= "$('#slash2').hide();";

$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";
$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide();} else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#slash').show(); } e.preventDefault();});";

$content .="</script>";

echo $content;

?>
