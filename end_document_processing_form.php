<?php

$group = trim($_REQUEST['group']);
$internal_number = trim($_REQUEST['internal_number']);
$receiptDate = date("Y-m-d", (strtotime($_REQUEST['receiptDate'])));
$documentType = trim($_REQUEST['documentType']);
$fdaAppNumber = trim($_REQUEST['fdaAppNumber']);

$content = "<div id=\"processDoc\">";
            
$content .= "<form id=\"processDocForm\" name=\"processDocForm\">";
$content .= "<input type=\"hidden\" id=\"group\" name=\"group\" value=\"$group\"/>";
$content .= "<input type=\"hidden\" id=\"documentType\" name=\"documentType\" value=\"$documentType\"/>";
//$content .= "<input type=\"hidden\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" value=\"$fdaAppNumber\"/>";
$content .= "<input type=\"hidden\" id=\"internal_number\" name=\"internal_number\" value=\"$internal_number\"/>";
$content .= "<input type=\"hidden\" id=\"receiptDate\" name=\"receiptDate\" value=\"$receiptDate\"/>";

$content .= "<table><tbody>";
$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> FDA Application Number </label></td><td>";

if($group == '510K'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
$content .= "<option value=\"K\" selected=\"selected\">K</option>";
$content .= "<option value=\"C\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> /";
$content .= "<select id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\">";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"3\" maxlength=\"3\"/>";
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
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\">";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"3\" maxlength=\"3\"/>";

$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash2\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter2\" name=\"fdaAppSupLetter2\">";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"3\" maxlength=\"3\"/>";	
}
elseif($group == 'PMA'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
$content .= "<option value=\"P\" selected=\"selected\">P</option>";
$content .= "<option value=\"D\">D</option>";
$content .= "<option value=\"H\">H</option>";
$content .= "<option value=\"M\">M</option>";
$content .= "<option value=\"N\">N</option>";
$content .= "<option value=\"C\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\">";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"3\" maxlength=\"3\"/>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"6\" maxlength=\"6\"/> <label id=\"slash2\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter2\" name=\"fdaAppSupLetter2\">";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"3\" maxlength=\"3\"/> <label id=\"slash3\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter3\" name=\"fdaAppSupLetter3\">";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup3\" name=\"fdaAppNumberSup3\" size=\"3\" maxlength=\"3\"/>";
}
elseif($group == 'RAD_HEALTH'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\" disabled=\"disabled\">";
$content .= "<option value=\"\" selected=\"selected\" disabled=\"disabled\"></option>";
$content .= "<option value=\"R\" disabled=\"disabled\">R</option>";
$content .= "<option value=\"C\" disabled=\"disabled\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" disabled=\"disabled\"/> /";
$content .= "<select id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\" disabled=\"disabled\">";
$content .= "<option value=\"\" disabled=\"disabled\"></option>";
$content .= "<option value=\"A\" disabled=\"disabled\">A</option>";
$content .= "<option value=\"R\" disabled=\"disabled\">R</option>";
$content .= "<option value=\"S\" disabled=\"disabled\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"3\" maxlength=\"3\" disabled=\"disabled\"/>";	
}

elseif($group == '513G'){
$content .= "<select name=\"document_type_id\" id=\"document_type_id\" disabled=\"disabled\">";
$content .= "<option value=\"\" selected=\"selected\" disabled=\"disabled\"></option>";
$content .= "<option value=\"R\" disabled=\"disabled\">R</option>";
$content .= "<option value=\"C\" disabled=\"disabled\">C</option>";
$content .= "</select>";
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" disabled=\"disabled\"/> /";
$content .= "<select id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\" disabled=\"disabled\">";
$content .= "<option value=\"\" disabled=\"disabled\"></option>";
$content .= "<option value=\"A\" disabled=\"disabled\">A</option>";
$content .= "<option value=\"R\" disabled=\"disabled\">R</option>";
$content .= "<option value=\"S\" disabled=\"disabled\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"3\" maxlength=\"3\" disabled=\"disabled\"/>";	
}

$content .= "</td></tr>";
$content .= "</tbody></table>";

$content .= "<table><tbody>";
//$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" value=\"$internal_number\"/></td></tr>";
//$content .= "<tr><td class=\"tdWidth\"><label> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker\" tabindex=\"-1\" value=\"$receiptDate\"/></td></tr>";
$content .= "<tr><td >Status</td><td>";
$content .= "<select name=\"status\">";
$content .= "<option value=\"Processing Complete\"> Processing Complete </option>";
//$content .= "<option value=\"Processing Incomplete\"> Processing Incomplete </option>";
$content .= "<option value=\"Dropout\"> Dropout </option>";
$content .= "<option value=\"FDA Hold\"> FDA Hold </option>";
$content .= "<option value=\"eCopy Hold\"> eCopy Hold </option>";
$content .= "<option value=\"eCopy Replacement\"> eCopy Replacement </option>";
$content .= "<option value=\"User Fee Hold\"> User Fee Hold </option>";
$content .= "<option value=\"User Fee\"> User Fee </option>";
$content .= "<option value=\"Combo Hold\"> Combo Hold </option>";
$content .= "<option value=\"FDA System Error\"> FDA System Error </option>";
$content .= "</select></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

$content .= "<script type=\"text/javascript\">"; 

$content .= "$('#moreInfo').hide();";
$content .= "$('#fdaAppNumber2').hide();";
$content .= "$('#fdaAppNumberSup2').hide();";
$content .= "$('#slash2').hide();";
$content .= "$('#fdaAppSupLetter2').hide();";

$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";

if($group == 'IDE'){
$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppSupLetter2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide(); $('#fdaAppSupLetter').hide();} else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppSupLetter2').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#slash').show(); $('#fdaAppSupLetter').show();} e.preventDefault();});";
}

if($group == 'PMA'){
$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'P'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#fdaAppNumberSup3').show(); $('#slash2').show(); $('#slash3').show(); $('#fdaAppSupLetter2').show(); $('#fdaAppSupLetter3').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#fdaAppSupLetter').hide(); $('#slash').hide();} else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#fdaAppNumberSup3').hide(); $('#fdaAppSupLetter2').hide(); $('#fdaAppSupLetter3').hide(); $('#slash2').hide(); $('#slash3').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#fdaAppSupLetter').show(); $('#slash').show(); } e.preventDefault();});";
$content .= "if($('#document_type_id option:selected').val() == 'P'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#fdaAppNumberSup3').show(); $('#slash2').show(); $('#slash3').show(); $('#fdaAppSupLetter2').show(); $('#fdaAppSupLetter3').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#fdaAppSupLetter').hide(); $('#slash').hide();}";
}

$content .="</script>";

echo $content;

?>
