<?php

include ("hrtsDatabaseConnection.php");

$tis = $_REQUEST['tis'];
$group = $_REQUEST['group'];
$qcList = $_REQUEST['qcList'];
$grade = $_REQUEST['grade'];
$receipt_date = $_REQUEST['receipt_date'];
$trade_name = $_REQUEST['trade_name'];
$common_name = $_REQUEST['common_name'];
$applicant_information = $_REQUEST['applicant_information'];
$fda_application_number = $_REQUEST['fda_application_number'];
$electronic_submission = $_REQUEST['electronic_submission'];
$manufacturer = $_REQUEST['manufacturer'];
$document_type = $_REQUEST['document_type'];
$sub_type = $_REQUEST['sub_type'];
$letter_date = $_REQUEST['letter_date'];
$panel = $_REQUEST['panel'];
$division = $_REQUEST['division'];
$branch = $_REQUEST['branch'];
$product_code = $_REQUEST['product_code'];
$jacket_color = $_REQUEST['jacket_color'];
$acknowledgement_letter = $_REQUEST['acknowledgement_letter'];
$other = $_REQUEST['other'];
$other_field = $_REQUEST['other_field'];

$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));

//die("$tis $group $qcList $grade $receipt_date $trade_name $common_name $applicant_information $fda_application_number $electronic_submission $manufacturer $document_type $letter_date $panel $division $branch $product_code $jacket_color $acknowledgement_letter $other $other_field");

$qc_data = new update_qc_data();

$qc_data->submit_qc_data($tis,$group,$qcList,$grade,$receipt_date,$trade_name,$common_name,$applicant_information,$fda_application_number,$electronic_submission,$manufacturer,$document_type,$sub_type,$letter_date,$panel,$division,$branch,$product_code,$jacket_color,$acknowledgement_letter,$other,$other_field,$current_date,$current_time);

class update_qc_data{
	
	public function submit_qc_data($tis,$group,$qcList,$grade,$receipt_date,$trade_name,$common_name,$applicant_information,$fda_application_number,$electronic_submission,$manufacturer,$document_type,$sub_type,$letter_date,$panel,$division,$branch,$product_code,$jacket_color,$acknowledgement_letter,$other,$other_field,$current_date,$current_time){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		if($group == "510K"){//die("Group works");
			try{
		
			$results = $hrtsConnection->prepare("UPDATE `510k_internal_qc` SET grade = :grade, receipt_date_check = :receipt_date, trade_name_check = :trade_name, common_name_check = :common_name, applicant_information_check = :applicant_information, fda_application_number_check = :fda_application_number, electronic_submission_check = :electronic_submission, manufacturer_check = :manufacturer, document_type_check = :document_type, sub_type_check = :sub_type, letter_date_check = :letter_date, panel_check = :panel, division_check = :division, branch_check = :branch, product_code_check = :product_code, jacket_color_check = :jacket_color, acknowledgement_letter_check = :acknowledgement_letter, other_check= :other, other_data = :other_field, TIS = :tis,  qc_date = '$current_date', qc_time = '$current_time' WHERE fda_application_number = :qcList AND grade = ''");
				
				$results->bindValue(':tis', $tis, PDO::PARAM_STR);
				//$results->bindValue(':group', $group, PDO::PARAM_STR);
				$results->bindValue(':qcList', $qcList, PDO::PARAM_STR);
				$results->bindValue(':grade', $grade, PDO::PARAM_STR);
				$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
				$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
				$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
				$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
				$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
				$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
				$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
				$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
				$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
				$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
				$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
				$results->bindValue(':panel', $panel, PDO::PARAM_INT);
				$results->bindValue(':division', $division, PDO::PARAM_INT);
				$results->bindValue(':branch', $branch, PDO::PARAM_INT);
				$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
				$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
				$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
				$results->bindValue(':other', $other, PDO::PARAM_INT);
				$results->execute();	
			
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
			
			if($results->rowCount() == 1){
				
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $qcList'); </script>";	
				
				die($content_anwser);
				
			}
			
			else{
			
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $qcList'); </script>";	
				
				die($content_anwser);	
				
			}
			
		}
		
		if($group == "IDE"){//die("Group works");
			try{
		
			$results = $hrtsConnection->prepare("UPDATE `ide_internal_qc` SET grade = :grade, receipt_date_check = :receipt_date, trade_name_check = :trade_name, common_name_check = :common_name, applicant_information_check = :applicant_information, fda_application_number_check = :fda_application_number, electronic_submission_check = :electronic_submission, manufacturer_check = :manufacturer, document_type_check = :document_type, sub_type_check = :sub_type, letter_date_check = :letter_date, panel_check = :panel, division_check = :division, branch_check = :branch, product_code_check = :product_code, jacket_color_check = :jacket_color, acknowledgement_letter_check = :acknowledgement_letter, other_check= :other, other_data = :other_field, TIS = :tis,  qc_date = '$current_date' , qc_time = '$current_time' WHERE fda_application_number = :qcList AND grade = ''");
				
				$results->bindValue(':tis', $tis, PDO::PARAM_STR);
				//$results->bindValue(':group', $group, PDO::PARAM_STR);
				$results->bindValue(':qcList', $qcList, PDO::PARAM_STR);
				$results->bindValue(':grade', $grade, PDO::PARAM_STR);
				$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
				$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
				$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
				$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
				$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
				$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
				$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
				$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
				$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
				$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
				$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
				$results->bindValue(':panel', $panel, PDO::PARAM_INT);
				$results->bindValue(':division', $division, PDO::PARAM_INT);
				$results->bindValue(':branch', $branch, PDO::PARAM_INT);
				$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
				$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
				$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
				$results->bindValue(':other', $other, PDO::PARAM_INT);
				$results->execute();	
			
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
			
			if($results->rowCount() == 1){
				
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $qcList'); </script>";	
				
				die($content_anwser);
				
			}
			
			else{
			
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $qcList'); </script>";	
				
				die($content_anwser);	
				
			}
			
		}
		
		if($group == "PMA"){//die("Group works");
			try{
		
			$results = $hrtsConnection->prepare("UPDATE `pma_internal_qc` SET grade = :grade, receipt_date_check = :receipt_date, trade_name_check = :trade_name, common_name_check = :common_name, applicant_information_check = :applicant_information, fda_application_number_check = :fda_application_number, electronic_submission_check = :electronic_submission, manufacturer_check = :manufacturer, document_type_check = :document_type, sub_type_check = :sub_type, letter_date_check = :letter_date, panel_check = :panel, division_check = :division, branch_check = :branch, product_code_check = :product_code, jacket_color_check = :jacket_color, acknowledgement_letter_check = :acknowledgement_letter, other_check= :other, other_data = :other_field, TIS = :tis,  qc_date = '$current_date', qc_time = '$current_time' WHERE fda_application_number = :qcList AND grade = ''");
				
				$results->bindValue(':tis', $tis, PDO::PARAM_STR);
				//$results->bindValue(':group', $group, PDO::PARAM_STR);
				$results->bindValue(':qcList', $qcList, PDO::PARAM_STR);
				$results->bindValue(':grade', $grade, PDO::PARAM_STR);
				$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
				$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
				$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
				$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
				$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
				$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
				$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
				$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
				$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
				$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
				$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
				$results->bindValue(':panel', $panel, PDO::PARAM_INT);
				$results->bindValue(':division', $division, PDO::PARAM_INT);
				$results->bindValue(':branch', $branch, PDO::PARAM_INT);
				$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
				$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
				$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
				$results->bindValue(':other', $other, PDO::PARAM_INT);
				$results->execute();	
			
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
			
			if($results->rowCount() == 1){
				
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $qcList'); </script>";	
				
				die($content_anwser);
				
			}
			
			else{
			
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $qcList'); </script>";	
				
				die($content_anwser);	
				
			}
			
		}
		
		if($group == "RAD_HEALTH"){//die("Group works");
			try{
		
			$results = $hrtsConnection->prepare("UPDATE `rad_internal_qc` SET grade = :grade, receipt_date_check = :receipt_date, trade_name_check = :trade_name, common_name_check = :common_name, applicant_information_check = :applicant_information, fda_application_number_check = :fda_application_number, electronic_submission_check = :electronic_submission, manufacturer_check = :manufacturer, document_type_check = :document_type, sub_type_check = :sub_type, letter_date_check = :letter_date, panel_check = :panel, division_check = :division, branch_check = :branch, product_code_check = :product_code, jacket_color_check = :jacket_color, acknowledgement_letter_check = :acknowledgement_letter, other_check= :other, other_data = :other_field, TIS = :tis,  qc_date = '$current_date', qc_time = '$current_time' WHERE internal_number_date = :qcList AND grade = ''");
				
				$results->bindValue(':tis', $tis, PDO::PARAM_STR);
				//$results->bindValue(':group', $group, PDO::PARAM_STR);
				$results->bindValue(':qcList', $qcList, PDO::PARAM_STR);
				$results->bindValue(':grade', $grade, PDO::PARAM_STR);
				$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
				$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
				$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
				$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
				$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
				$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
				$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
				$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
				$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
				$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
				$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
				$results->bindValue(':panel', $panel, PDO::PARAM_INT);
				$results->bindValue(':division', $division, PDO::PARAM_INT);
				$results->bindValue(':branch', $branch, PDO::PARAM_INT);
				$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
				$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
				$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
				$results->bindValue(':other', $other, PDO::PARAM_INT);
				$results->execute();	
			
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
			
			if($results->rowCount() == 1){
				
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $qcList'); </script>";	
				
				die($content_anwser);
				
			}
			
			else{
			
				$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $qcList'); </script>";	
				
				die($content_anwser);	
				
			}
			
		}
		
	}
	
}

?>