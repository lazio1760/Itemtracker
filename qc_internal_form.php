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
		$content .="<table><tbody>";
		$content .="<tr><th class='th_title2'><label> QC LIST </label></th></tr>";                
		//$content .="<tr><td class='align_up'> QC List </td><td class='align_up'>";
		$content .="<tr><td>";
		
		if($group == "510K"){//die("Group works");
		
			try{
				$get_documents = $hrtsConnection->prepare("SELECT fda_application_number FROM `510k_internal_qc` WHERE `grade` = ''");
			
				$get_documents->execute();
			}
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for get qc document list error qc form.'); </script>");
			}
		
		}
		
		elseif($group == "IDE"){//die("Group works");
		
			try{
				$get_documents = $hrtsConnection->prepare("SELECT fda_application_number FROM `ide_internal_qc` WHERE `grade` = ''");
			
				$get_documents->execute();
			}
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for get qc document list error qc form.'); </script>");
			}
		
		}
		
		elseif($group == "PMA"){//die("Group works");
		
			try{
				$get_documents = $hrtsConnection->prepare("SELECT fda_application_number FROM `pma_internal_qc` WHERE `grade` = ''");
			
				$get_documents->execute();
			}
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for get qc document list error qc form.'); </script>");
			}
		
		}
		
		elseif($group == "RAD_HEALTH"){//die("Group works");
		
			try{
				$get_documents = $hrtsConnection->prepare("SELECT internal_number_date FROM `rad_internal_qc` WHERE `grade` = ''");
			
				$get_documents->execute();
			}
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for get qc document list error qc form.'); </script>");
			}
		
		}
		 
		if($get_documents->rowCount() != 0){
			                
			$content .="<select name=\"qcList\" id=\"qcList\" size='15'>";
			
			if($group == "RAD_HEALTH"){
				while($row = $get_documents->fetch(PDO::FETCH_ASSOC)){
				$content .="<option value=\"".$row["internal_number_date"]."\">".$row["internal_number_date"]."</option>";
				}
			}
			else{
				while($row = $get_documents->fetch(PDO::FETCH_ASSOC)){
				$content .="<option value=\"".$row["fda_application_number"]."\">".$row["fda_application_number"]."</option>";
				}
			}
			
			$content .="</select>";
		}
		
		else{
		
			$content .="<label> No documents in queue </label>";	
			
		}
		
		$content .="</td></tr>";
		$content .="</tbody></table>";
		$content .="<div class=\"spacer\"> </div>";
		$content .="<table><tbody>";
					
		//$content .="<tr><td > QC Queue </td><td> <input type=\"text\" id=\"queueNum\" name=\"queueNum\" size=\"4\" maxlength=\"4\" value=\"50\" readonly=\"readonly\"/> </td>";
		
		$content .="<tr><td>";
		
		$content .="<input type=\"radio\" class=\"grade\" name=\"grade\" value=\"Passed\" disabled=\"disabled\"><label>Passed</label>";
		
		$content .="</td>";
		$content .="<td>";
		
		$content .="<input type=\"radio\" class=\"grade\" name=\"grade\" value=\"Failed\" disabled=\"disabled\"><label>Failed</label>";
		
		$content .="</td></tr>";
						
		$content .="</tbody></table>";
		$content .="</div>";
		
		$content .="<div class='floating_left move_over4'>";
		$content .="<table><tbody>";
		
		$content .="<tr><th class='th_title2'><label> ERROR TYPES </label></th></tr>";
		$content .="<tr><td><label> Receipt Date </label></td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"receipt_date\" name=\"receipt_date\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Trade Name </label></td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"trade_name\" name=\"trade_name\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Common Name </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"common_name\" name=\"common_name\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Applicant Information </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"applicant_information\" name=\"applicant_information\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> FDA Application Number </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"fda_application_number\" name=\"fda_application_number\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Electronic Submission </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"electronic_submission\" name=\"electronic_submission\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Manufacturer </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"manufacturer\" name=\"manufacturer\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Document Type </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"document_type\" name=\"document_type\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Sub Type </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"sub_type\" name=\"sub_type\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Letter Date </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"letter_date\" name=\"letter_date\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Panel </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"panel\" name=\"panel\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Division </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"division\" name=\"division\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Branch </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"branch\" name=\"branch\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Product Code </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"product_code\" name=\"product_code\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Jacket Color </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"jacket_color\" name=\"jacket_color\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Wrong Acknowledgement Letter Attached </label> </td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"acknowledgement_letter\" name=\"acknowledgement_letter\" value=\"1\" disabled=\"\"/> </td></tr>";
		$content .="<tr><td><label> Other </label><input class=\"other_field\" name=\"other_field\" type=\"text\" maxlength=\"30\" size=\"30\" disabled=\"\"/></td><td> <input type=\"checkbox\" class=\"checkBoxValue\" id=\"other\" name=\"other\" value=\"1\" disabled=\"\"/> </td></tr>";
		
		$content .="</tbody></table>";
		$content .="</div>";
		
		//$content .="<div>";
		
		
		//$content .="</div>";
		$content .="</form>";
		
		$content .="</div>";
		
		$content .= "<script type=\"text/javascript\">";
		
		$content .= "$('#qcList').change(function(){";
		
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
		
		$content .= "});";
		
		$content .="</script>";
		
		die($content);
		
	}
	
}

?>