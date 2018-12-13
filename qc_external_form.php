<?php

include ("hrtsDatabaseConnection.php");



$group = $_REQUEST['group'];

$form = new qc_form_bulid();
$form_object = $form->create_form($group);

class qc_form_bulid{
	
	public function create_form($group){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();

		$content ="<div id=\"qc_form\">";
			
		$content .="<form id=\"qcForm\" name=\"qcForm\" class=\"formFormatting\">";
		
		$content .="<div class='floating_left'>";
		
		$content .= "<table><tbody>";
		$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> FDA Application Number </label></td><td>";
		$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
		if($group == "510K"){
		$content .= "<option value=\"K\" selected=\"selected\">K</option>";
		}
		elseif($group == "IDE"){
		$content .= "<option value=\"G\">G</option>";
		$content .= "<option value=\"Q\">Q</option>";
		$content .= "<option value=\"MAF\">MAF</option>";
		$content .= "<option value=\"PI\">PI</option>";
		$content .= "<option value=\"V\">V</option>";
		}
		elseif($group == "PMA"){
		$content .= "<option value=\"P\">P</option>";
		$content .= "<option value=\"D\">D</option>";
		$content .= "<option value=\"H\">H</option>";
		$content .= "<option value=\"M\">M</option>";
		$content .= "<option value=\"N\">N</option>";
		}
		elseif($group == "RAD_HEALTH"){
		$content .= "<option value=\"R\">R</option>";
		}
		$content .= "</select>";
		
		$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label>";
		$content .= "<select id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\" >";
		$content .= "<option value=\"\"></option>";
		$content .= "<option value=\"A\">A</option>";
		$content .= "<option value=\"R\">R</option>";
		$content .= "<option value=\"S\">S</option>";
		$content .= "<option value=\"E\">E</option>";
		$content .= "<option value=\"W\">W</option>";
		$content .= "</select>"; 
		$content .= "<input type=\"text\" id=\"fdaAppNumberSup\" class=\"move_over\" name=\"fdaAppNumberSup\" size=\"3\" maxlength=\"3\"/>";
		
		$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash2\"> / </label>";
		$content .= "<select id=\"fdaAppSupLetter2\" name=\"fdaAppSupLetter2\" >";
		$content .= "<option value=\"\"></option>";
		$content .= "<option value=\"A\">A</option>";
		$content .= "<option value=\"R\">R</option>";
		$content .= "<option value=\"S\">S</option>";
		$content .= "<option value=\"E\">E</option>";
		$content .= "<option value=\"W\">W</option>";
		$content .= "</select>";  
		$content .= "<input type=\"text\" id=\"fdaAppNumberSup2\" class=\"move_over\" name=\"fdaAppNumberSup2\" size=\"3\" maxlength=\"3\"/>";
		
		$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber3\" name=\"fdaAppNumber3\" size=\"6\" maxlength=\"6\"/> <label id=\"slash3\"> / </label>";
		$content .= "<select id=\"fdaAppSupLetter3\" name=\"fdaAppSupLetter3\" >";
		$content .= "<option value=\"\"></option>";
		$content .= "<option value=\"A\">A</option>";
		$content .= "<option value=\"R\">R</option>";
		$content .= "<option value=\"S\">S</option>";
		$content .= "<option value=\"E\">E</option>";
		$content .= "<option value=\"W\">W</option>";
		$content .= "</select>";  
		$content .= "<input type=\"text\" id=\"fdaAppNumberSup3\" class=\"move_over\" name=\"fdaAppNumberSup3\" size=\"3\" maxlength=\"3\"/> <label id=\"slash4\"> / </label>";
		$content .= "<select id=\"fdaAppSupLetter4\" name=\"fdaAppSupLetter4\">";
		$content .= "<option value=\"\"></option>";
		$content .= "<option value=\"A\">A</option>";
		$content .= "<option value=\"R\">R</option>";
		$content .= "<option value=\"S\">S</option>";
		$content .= "<option value=\"E\">E</option>";
		$content .= "<option value=\"W\">W</option>";
		$content .= "</select>"; 
		$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup4\" name=\"fdaAppNumberSup4\" size=\"3\" maxlength=\"3\"/>";
		
		$content .= "</td></tr>";
		
		$content .= "</tbody></table>";
		
		$content .="</div>";
		
		$content .="<br> <br> <br>";
			 
		$content .="<div class='floating_left'>";
		$content .="<table><tbody>";
		
		$content .="<tr><th class='th_title2'><label> Change Request </label></th></tr>";
		$content .="<tr><td><label> Branch </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"branch_change\" name=\"branch_change\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Panel </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"panel_change\" name=\"panel_change\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Product Code </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"product_code_change\" name=\"product_code_change\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Incomplete Response </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"incomplete_response\" name=\"incomplete_response\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Deletions </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"deletions\" name=\"deletions\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Document Type </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"document_type_change\" name=\"document_type_change\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Sub Type </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"sub_type_change\" name=\"sub_type_change\" value=\"1\"/> </td></tr>";
		$content .="<tr><td><label> Hold Request </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"hold_request\" name=\"hold_request\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Logout Code </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"logout_code\" name=\"logout_code\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Close-out Code </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"close_out_code\" name=\"close_out_code\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Conversion </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"conversion\" name=\"conversion\" value=\"1\" /> </td></tr>";
		
		$content .="</tbody></table>";
		
		$content .="<table><tbody>";
		$content .="<tr><th class='th_title2'><label> Change Request Comments </label></th></tr>";
		$content .= "<tr><td><textarea class=\"\" id=\"comment_change\" name=\"comment_change\" rows=\"5\" cols='25'/> </textarea></td></tr>";
		$content .="</tbody></table>";
		
		$content .="</div>";
		
		$content .="<div class='floating_left move_over4'>";
		$content .="<table><tbody>";
		
		$content .="<tr><th class='th_title2'><label> ERROR TYPES </label></th></tr>";
		$content .="<tr><td><label> Receipt Date </label></td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"receipt_date\" name=\"receipt_date\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Trade Name </label></td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"trade_name\" name=\"trade_name\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Common Name </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"common_name\" name=\"common_name\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Applicant Information </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"applicant_information\" name=\"applicant_information\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> FDA Application Number </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"fda_application_number\" name=\"fda_application_number\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Electronic Submission </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"electronic_submission\" name=\"electronic_submission\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Manufacturer </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"manufacturer\" name=\"manufacturer\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Document Type </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"document_type\" name=\"document_type\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Sub Type </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"sub_type\" name=\"sub_type\" value=\"1\"/> </td></tr>";
		$content .="<tr><td><label> Letter Date </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"letter_date\" name=\"letter_date\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Panel </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"panel\" name=\"panel\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Division </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"division\" name=\"division\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Branch </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"branch\" name=\"branch\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Product Code </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"product_code\" name=\"product_code\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Jacket Color </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"jacket_color\" name=\"jacket_color\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Wrong Acknowledgement Letter Attached </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"acknowledgement_letter\" name=\"acknowledgement_letter\" value=\"1\" /> </td></tr>";
		$content .="<tr><td><label> Other </label><input class=\"other_field\" name=\"other_field\" type=\"text\" maxlength=\"30\" size=\"30\" /></td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"other\" name=\"other\" value=\"1\" /> </td></tr>";
		
		$content .="</tbody></table>";
		$content .="</div>";
		
		//$content .="<div>";
		
		
		//$content .="</div>";
		$content .="</form>";
		
		$content .="</div>";
		
		$content .= "<script type=\"text/javascript\">";
		
		/*$content .= "$('#qcList').change(function(){";
		
		$content .= "$('.grade').attr('disabled', false);";
		
		$content .= "});";
		
		$content .= "$('.grade').change(function(){"; 
			
		$content .= "if($(\".grade:checked\").val() == \"Passed\"){";  
		
		$content .= "$('.checkBoxValue').attr('disabled', 'disabled');";
		
		$content .= "$('.other_field').attr('disabled', 'disabled');";
		
		$content .= "}";
		$content .= "else if($('.grade:checked').val() == \"Failed\"){";
		
		$content .= "$('.checkBoxValue').attr('disabled', false);";
		
		$content .= "$('.other_field').attr('disabled', false);";
		
		$content .= "}";
		
		$content .= "});";*/
		
		$content .= "$('#moreInfo').hide();";
		$content .= "$('#fdaAppNumber2').hide();";
		$content .= "$('#fdaAppNumberSup2').hide();";
		$content .= "$('#slash2').hide();";
		$content .= "$('#fdaAppSupLetter2').hide();";
		$content .= "$('#fdaAppNumber3').hide();";
		$content .= "$('#fdaAppNumberSup3').hide();";
		$content .= "$('#slash3').hide();";
		$content .= "$('#fdaAppSupLetter3').hide();";
		//$content .= "$('#fdaAppNumber4').hide();";
		$content .= "$('#fdaAppNumberSup4').hide();";
		$content .= "$('#slash4').hide();";
		$content .= "$('#fdaAppSupLetter4').hide();";
		
		$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppSupLetter2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide(); $('#fdaAppSupLetter').hide(); $('#fdaAppNumber3').hide(); $('#fdaAppNumberSup3').hide(); $('#slash3').hide(); $('#fdaAppSupLetter3').hide(); $('#fdaAppNumberSup4').hide(); $('#slash4').hide(); $('#fdaAppSupLetter4').hide();} else if($('#document_type_id option:selected').val() == 'P'){ $('#fdaAppNumber3').show(); $('#fdaAppNumberSup3').show(); $('#slash3').show(); $('#fdaAppSupLetter3').show(); $('#fdaAppNumberSup4').show(); $('#slash4').show(); $('#fdaAppSupLetter4').show(); $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppSupLetter2').hide(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide(); $('#fdaAppSupLetter').hide(); } else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppSupLetter2').hide(); $('#fdaAppNumber3').hide(); $('#fdaAppNumberSup3').hide(); $('#slash3').hide(); $('#fdaAppSupLetter3').hide(); $('#fdaAppNumberSup4').hide(); $('#slash4').hide(); $('#fdaAppSupLetter4').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#slash').show(); $('#fdaAppSupLetter').show();} e.preventDefault();});";
		
		$content .= "if($('#document_type_id option:selected').val() == 'P'){ $('#fdaAppNumber3').show(); $('#fdaAppNumberSup3').show(); $('#slash3').show(); $('#fdaAppSupLetter3').show(); $('#fdaAppNumberSup4').show(); $('#slash4').show(); $('#fdaAppSupLetter4').show(); $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppSupLetter2').hide(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide(); $('#fdaAppSupLetter').hide();}";
		
		$content .="</script>";
		
		die($content);
		
	}
	
}

?>