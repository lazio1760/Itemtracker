<?php

include ("hrtsDatabaseConnection.php");

//die("Here");

if(!(empty($_REQUEST['fdaAppNumber']))){
	
	$fdaAppNumber = trim($_REQUEST['fdaAppNumber']);
	$document_type_id = trim($_REQUEST['document_type_id']);
	//die($document_type_id);
	
	if(!(empty($_REQUEST['fdaAppSupLetter']))){
		$fdaAppSupLetter = trim($_REQUEST['fdaAppSupLetter']);
		//echo($fdaAppSupLetter);
		$fdaAppSupLetter = strtoupper($fdaAppSupLetter);
		
		if(empty($_REQUEST['fdaAppNumberSup'])){ $fdaAppNumberSup = "0"; }
		else{$fdaAppNumberSup = trim($_REQUEST['fdaAppNumberSup']);}
		$fdaAppNumberSup = str_pad($fdaAppNumberSup, 3, '0', STR_PAD_LEFT);
		
		if(($document_type_id == "P") && (!(empty($_REQUEST['fdaAppSupLetter2'])))){
		
				$fdaAppSupLetter2 = trim($_REQUEST['fdaAppSupLetter2']);
				//echo($fdaAppSupLetter);
				$fdaAppSupLetter2 = strtoupper($fdaAppSupLetter2);
				
				if(empty($_REQUEST['fdaAppNumberSup2'])){ $fdaAppNumberSup2 = "0"; }
				else{$fdaAppNumberSup2 = trim($_REQUEST['fdaAppNumberSup2']);}
				$fdaAppNumberSup2 = str_pad($fdaAppNumberSup2, 3, '0', STR_PAD_LEFT);
				
				$fdaAppNumber = "$document_type_id$fdaAppNumber/$fdaAppSupLetter$fdaAppNumberSup/$fdaAppSupLetter2$fdaAppNumberSup2";
		}
		
		elseif($document_type_id == "P"){$fdaAppNumber = "$document_type_id$fdaAppNumber/$fdaAppSupLetter$fdaAppNumberSup/0000"; }
		
		else{$fdaAppNumber = "$document_type_id$fdaAppNumber/$fdaAppSupLetter$fdaAppNumberSup";}
	}
	
	else{ $fdaAppNumber = "$document_type_id$fdaAppNumber/0000"; }
}

else{

	$fdaAppNumber = "";
	
}

$tis = $_REQUEST['tis'];
$group = $_REQUEST['group'];
//$qcList = $_REQUEST['qcList'];
//$grade = $_REQUEST['grade'];
$receipt_date = $_REQUEST['receipt_date'];
$trade_name = $_REQUEST['trade_name'];
$common_name = $_REQUEST['common_name'];
$applicant_information = $_REQUEST['applicant_information'];
$fda_application_number = $_REQUEST['fda_application_number'];
$electronic_submission = $_REQUEST['electronic_submission'];
$manufacturer = $_REQUEST['manufacturer'];
$document_type = $_REQUEST['document_type'];
$letter_date = $_REQUEST['letter_date'];
$panel = $_REQUEST['panel'];
$division = $_REQUEST['division'];
$branch = $_REQUEST['branch'];
$product_code = $_REQUEST['product_code'];
$jacket_color = $_REQUEST['jacket_color'];
$acknowledgement_letter = $_REQUEST['acknowledgement_letter'];
$other = $_REQUEST['other'];
$other_field = $_REQUEST['other_field'];
$sub_type = $_REQUEST['sub_type'];

//change request

$branch_change = $_REQUEST['branch_change'];
$panel_change = $_REQUEST['panel_change'];
$product_code_change = $_REQUEST['product_code_change'];
$incomplete_response = $_REQUEST['incomplete_response'];
$deletions = $_REQUEST['deletions'];
$document_type_change = $_REQUEST['document_type_change'];
$sub_type_change = $_REQUEST['sub_type_change'];
$hold_request = $_REQUEST['hold_request'];
$logout_code = $_REQUEST['logout_code'];
$close_out_code = $_REQUEST['close_out_code'];
$conversion = $_REQUEST['conversion'];
$comment = $_REQUEST['comment'];

$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));

//die("$tis $group $qcList $grade $receipt_date $trade_name $common_name $applicant_information $fda_application_number $electronic_submission $manufacturer $document_type $letter_date $panel $division $branch $product_code $jacket_color $acknowledgement_letter $other $other_field");

$qc_data = new update_qc_data();

$qc_data->submit_qc_data($tis,$group,$fdaAppNumber,$receipt_date,$trade_name,$common_name,$applicant_information,$fda_application_number,$electronic_submission,$manufacturer,$document_type,$letter_date,$panel,$division,$branch,$product_code,$jacket_color,$acknowledgement_letter,$other,$other_field,$current_date,$current_time,$branch_change,$panel_change,$product_code_change,$incomplete_response,$deletions,$document_type_change,$hold_request,$logout_code,$close_out_code,$sub_type,$sub_type_change,$conversion,$comment);

class update_qc_data{
	
	public function submit_qc_data($tis,$group,$fdaAppNumber,$receipt_date,$trade_name,$common_name,$applicant_information,$fda_application_number,$electronic_submission,$manufacturer,$document_type,$letter_date,$panel,$division,$branch,$product_code,$jacket_color,$acknowledgement_letter,$other,$other_field,$current_date,$current_time,$branch_change,$panel_change,$product_code_change,$incomplete_response,$deletions,$document_type_change,$hold_request,$logout_code,$close_out_code,$sub_type,$sub_type_change,$conversion,$comment){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		if($group == "510K"){//die("Group works");
		
			try{
				
				$find_document = $hrtsConnection->prepare("SELECT processor FROM 510k_internal_qc WHERE id = (select max(id) from 510k_internal_qc WHERE fda_application_number = :fdaAppNumber)");
				
				$find_document->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
				$find_document->execute();
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
				
			if($find_document->rowCount() == 1){
				
				$row = $find_document->fetch(PDO::FETCH_ASSOC);	
			
				try{
				
				$results = $hrtsConnection->prepare("INSERT INTO `510k_external_qc` (fda_application_number,grade,receipt_date_check,trade_name_check,common_name_check, applicant_information_check,fda_application_number_check,electronic_submission_check,manufacturer_check,document_type_check,letter_date_check,panel_check,division_check,branch_check, product_code_check,jacket_color_check,acknowledgement_letter_check,other_check,other_data,TIS,qc_date,qc_time,branch_change,panel_change,product_code_change,incomplete_response_change,deletions_change,document_type_change,hold_request_change,logout_code_change,close_out_code_change,processor,sub_type_check,sub_type_change,conversion_change,comment_change) VALUES (:fdaAppNumber,'Failed',:receipt_date,:trade_name,:common_name,:applicant_information,:fda_application_number,:electronic_submission,:manufacturer,:document_type,:letter_date,:panel,:division,:branch,:product_code,:jacket_color,:acknowledgement_letter,:other,:other_field,:tis,'$current_date','$current_time',:branch_change,:panel_change,:product_code_change,:incomplete_response,:deletions,:document_type_change,:hold_request,:logout_code,:close_out_code,:processor,:sub_type,:sub_type_change,:conversion,:comment)");
					
					$results->bindValue(':tis', $tis, PDO::PARAM_STR);
					$results->bindValue(':processor', $row["processor"], PDO::PARAM_STR);
					$results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
					$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
					$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
					$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
					$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
					$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
					$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
					$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
					$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
					$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
					$results->bindValue(':panel', $panel, PDO::PARAM_INT);
					$results->bindValue(':division', $division, PDO::PARAM_INT);
					$results->bindValue(':branch', $branch, PDO::PARAM_INT);
					$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
					$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
					$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
					$results->bindValue(':other', $other, PDO::PARAM_INT);
					$results->bindValue(':branch_change', $branch_change, PDO::PARAM_INT);
					$results->bindValue(':panel_change', $panel_change, PDO::PARAM_INT);
					$results->bindValue(':product_code_change', $product_code_change, PDO::PARAM_INT);
					$results->bindValue(':incomplete_response', $incomplete_response, PDO::PARAM_INT);
					$results->bindValue(':deletions', $deletions, PDO::PARAM_INT);
					$results->bindValue(':document_type_change', $document_type_change, PDO::PARAM_INT);
					$results->bindValue(':hold_request', $hold_request, PDO::PARAM_INT);
					$results->bindValue(':logout_code', $logout_code, PDO::PARAM_INT);
					$results->bindValue(':close_out_code', $close_out_code, PDO::PARAM_INT);
					$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
					$results->bindValue(':sub_type_change', $sub_type_change, PDO::PARAM_INT);
					$results->bindValue(':conversion', $conversion, PDO::PARAM_INT);
					$results->bindValue(':comment', $comment, PDO::PARAM_STR);
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
					
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);
					
				}
				
				else{
				
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);	
					
				}
			}
			else{
				
				$content_anwser ="<script type=\"text/javascript\"> alert('$fdaAppNumber does not exist.'); </script>";	
					
				die($content_anwser);	
				
			}
			
		}
		
		if($group == "IDE"){//die("Group works");
			try{
				
				$find_document = $hrtsConnection->prepare("SELECT processor FROM ide_internal_qc WHERE fda_application_number = :fdaAppNumber");
				
				$find_document->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
				$find_document->execute();
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
				
			if($find_document->rowCount() == 1){
				
				$row = $find_document->fetch(PDO::FETCH_ASSOC);	
			
				try{
				
				$results = $hrtsConnection->prepare("INSERT INTO `ide_external_qc` (fda_application_number,grade,receipt_date_check,trade_name_check,common_name_check, applicant_information_check,fda_application_number_check,electronic_submission_check,manufacturer_check,document_type_check,letter_date_check,panel_check,division_check,branch_check, product_code_check,jacket_color_check,acknowledgement_letter_check,other_check,other_data,TIS,qc_date,qc_time,branch_change,panel_change,product_code_change,incomplete_response_change,deletions_change,document_type_change,hold_request_change,logout_code_change,close_out_code_change,processor,sub_type_check,sub_type_change,conversion_change,comment_change) VALUES (:fdaAppNumber,'Failed',:receipt_date,:trade_name,:common_name,:applicant_information,:fda_application_number,:electronic_submission,:manufacturer,:document_type,:letter_date,:panel,:division,:branch,:product_code,:jacket_color,:acknowledgement_letter,:other,:other_field,:tis,'$current_date','$current_time',:branch_change,:panel_change,:product_code_change,:incomplete_response,:deletions,:document_type_change,:hold_request,:logout_code,:close_out_code,:processor,:sub_type,:sub_type_change,:conversion,:comment)");
					
					$results->bindValue(':tis', $tis, PDO::PARAM_STR);
					$results->bindValue(':processor', $row["processor"], PDO::PARAM_STR);
					$results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
					$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
					$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
					$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
					$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
					$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
					$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
					$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
					$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
					$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
					$results->bindValue(':panel', $panel, PDO::PARAM_INT);
					$results->bindValue(':division', $division, PDO::PARAM_INT);
					$results->bindValue(':branch', $branch, PDO::PARAM_INT);
					$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
					$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
					$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
					$results->bindValue(':other', $other, PDO::PARAM_INT);
					$results->bindValue(':branch_change', $branch_change, PDO::PARAM_STR);
					$results->bindValue(':panel_change', $panel_change, PDO::PARAM_STR);
					$results->bindValue(':product_code_change', $product_code_change, PDO::PARAM_STR);
					$results->bindValue(':incomplete_response', $incomplete_response, PDO::PARAM_INT);
					$results->bindValue(':deletions', $deletions, PDO::PARAM_INT);
					$results->bindValue(':document_type_change', $document_type_change, PDO::PARAM_INT);
					$results->bindValue(':hold_request', $hold_request, PDO::PARAM_INT);
					$results->bindValue(':logout_code', $logout_code, PDO::PARAM_INT);
					$results->bindValue(':close_out_code', $close_out_code, PDO::PARAM_INT);
					$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
					$results->bindValue(':sub_type_change', $sub_type_change, PDO::PARAM_INT);
					$results->bindValue(':conversion', $conversion, PDO::PARAM_INT);
					$results->bindValue(':comment', $comment, PDO::PARAM_STR);
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
					
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);
					
				}
				
				else{
				
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);	
					
				}
			}
			else{
				
				$content_anwser ="<script type=\"text/javascript\"> alert('$fdaAppNumber does not exist.'); </script>";	
					
				die($content_anwser);	
				
			}
			
		}
		
		if($group == "PMA"){//die("Group works");
			try{
				
				$find_document = $hrtsConnection->prepare("SELECT processor FROM pma_internal_qc WHERE fda_application_number = :fdaAppNumber");
				
				$find_document->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
				$find_document->execute();
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
				
			if($find_document->rowCount() == 1){
				
				$row = $find_document->fetch(PDO::FETCH_ASSOC);	
			
				try{
				
				$results = $hrtsConnection->prepare("INSERT INTO `pma_external_qc` (fda_application_number,grade,receipt_date_check,trade_name_check,common_name_check, applicant_information_check,fda_application_number_check,electronic_submission_check,manufacturer_check,document_type_check,letter_date_check,panel_check,division_check,branch_check, product_code_check,jacket_color_check,acknowledgement_letter_check,other_check,other_data,TIS,qc_date,qc_time,branch_change,panel_change,product_code_change,incomplete_response_change,deletions_change,document_type_change,hold_request_change,logout_code_change,close_out_code_change,processor,sub_type_check,sub_type_change,conversion_change,comment_change) VALUES (:fdaAppNumber,'Failed',:receipt_date,:trade_name,:common_name,:applicant_information,:fda_application_number,:electronic_submission,:manufacturer,:document_type,:letter_date,:panel,:division,:branch,:product_code,:jacket_color,:acknowledgement_letter,:other,:other_field,:tis,'$current_date','$current_time',:branch_change,:panel_change,:product_code_change,:incomplete_response,:deletions,:document_type_change,:hold_request,:logout_code,:close_out_code,:processor,:sub_type,:sub_type_change,:conversion,:comment)");
					
					$results->bindValue(':tis', $tis, PDO::PARAM_STR);
					$results->bindValue(':processor', $row["processor"], PDO::PARAM_STR);
					$results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
					$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
					$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
					$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
					$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
					$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
					$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
					$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
					$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
					$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
					$results->bindValue(':panel', $panel, PDO::PARAM_INT);
					$results->bindValue(':division', $division, PDO::PARAM_INT);
					$results->bindValue(':branch', $branch, PDO::PARAM_INT);
					$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
					$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
					$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
					$results->bindValue(':other', $other, PDO::PARAM_INT);
					$results->bindValue(':branch_change', $branch_change, PDO::PARAM_STR);
					$results->bindValue(':panel_change', $panel_change, PDO::PARAM_STR);
					$results->bindValue(':product_code_change', $product_code_change, PDO::PARAM_STR);
					$results->bindValue(':incomplete_response', $incomplete_response, PDO::PARAM_INT);
					$results->bindValue(':deletions', $deletions, PDO::PARAM_INT);
					$results->bindValue(':document_type_change', $document_type_change, PDO::PARAM_INT);
					$results->bindValue(':hold_request', $hold_request, PDO::PARAM_INT);
					$results->bindValue(':logout_code', $logout_code, PDO::PARAM_INT);
					$results->bindValue(':close_out_code', $close_out_code, PDO::PARAM_INT);
					$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
					$results->bindValue(':sub_type_change', $sub_type_change, PDO::PARAM_INT);
					$results->bindValue(':conversion', $conversion, PDO::PARAM_INT);
					$results->bindValue(':comment', $comment, PDO::PARAM_STR);
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
					
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);
					
				}
				
				else{
				
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);	
					
				}
			}
			else{
				
				$content_anwser ="<script type=\"text/javascript\"> alert('$fdaAppNumber does not exist.'); </script>";	
					
				die($content_anwser);	
				
			}
			
		}
		
		if($group == "RAD_HEALTH"){//die("Group works");
			try{
				
				$find_document = $hrtsConnection->prepare("SELECT processor FROM rad_internal_qc WHERE fda_application_number = :fdaAppNumber");
				
				$find_document->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
				$find_document->execute();
			}
			
			catch(PDOException $exeception){
							
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (qc_data)'); </script>");
							
			}
				
			if($find_document->rowCount() == 1){
				
				$row = $find_document->fetch(PDO::FETCH_ASSOC);	
			
				try{
				
				$results = $hrtsConnection->prepare("INSERT INTO `rad_external_qc` (fda_application_number,grade,receipt_date_check,trade_name_check,common_name_check, applicant_information_check,fda_application_number_check,electronic_submission_check,manufacturer_check,document_type_check,letter_date_check,panel_check,division_check,branch_check, product_code_check,jacket_color_check,acknowledgement_letter_check,other_check,other_data,TIS,qc_date,qc_time,branch_change,panel_change,product_code_change,incomplete_response_change,deletions_change,document_type_change,hold_request_change,logout_code_change,close_out_code_change,processor,sub_type_check,sub_type_change,conversion_change,comment_change) VALUES (:fdaAppNumber,'Failed',:receipt_date,:trade_name,:common_name,:applicant_information,:fda_application_number,:electronic_submission,:manufacturer,:document_type,:letter_date,:panel,:division,:branch,:product_code,:jacket_color,:acknowledgement_letter,:other,:other_field,:tis,'$current_date','$current_time',:branch_change,:panel_change,:product_code_change,:incomplete_response,:deletions,:document_type_change,:hold_request,:logout_code,:close_out_code,:processor,:sub_type,:sub_type_change,:conversion,:comment)");
					
					$results->bindValue(':tis', $tis, PDO::PARAM_STR);
					$results->bindValue(':processor', $row["processor"], PDO::PARAM_STR);
					$results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':other_field', $other_field, PDO::PARAM_STR);
					$results->bindValue(':receipt_date', $receipt_date, PDO::PARAM_INT);
					$results->bindValue(':trade_name', $trade_name, PDO::PARAM_INT);
					$results->bindValue(':common_name', $common_name, PDO::PARAM_INT);
					$results->bindValue(':applicant_information', $applicant_information, PDO::PARAM_INT);
					$results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_INT);
					$results->bindValue(':electronic_submission', $electronic_submission, PDO::PARAM_INT);
					$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_INT);
					$results->bindValue(':document_type', $document_type, PDO::PARAM_INT);
					$results->bindValue(':letter_date', $letter_date, PDO::PARAM_INT);
					$results->bindValue(':panel', $panel, PDO::PARAM_INT);
					$results->bindValue(':division', $division, PDO::PARAM_INT);
					$results->bindValue(':branch', $branch, PDO::PARAM_INT);
					$results->bindValue(':product_code', $product_code, PDO::PARAM_INT);
					$results->bindValue(':jacket_color', $jacket_color, PDO::PARAM_INT);
					$results->bindValue(':acknowledgement_letter', $acknowledgement_letter, PDO::PARAM_INT);
					$results->bindValue(':other', $other, PDO::PARAM_INT);
					$results->bindValue(':branch_change', $branch_change, PDO::PARAM_STR);
					$results->bindValue(':panel_change', $panel_change, PDO::PARAM_STR);
					$results->bindValue(':product_code_change', $product_code_change, PDO::PARAM_STR);
					$results->bindValue(':incomplete_response', $incomplete_response, PDO::PARAM_INT);
					$results->bindValue(':deletions', $deletions, PDO::PARAM_INT);
					$results->bindValue(':document_type_change', $document_type_change, PDO::PARAM_INT);
					$results->bindValue(':hold_request', $hold_request, PDO::PARAM_INT);
					$results->bindValue(':logout_code', $logout_code, PDO::PARAM_INT);
					$results->bindValue(':close_out_code', $close_out_code, PDO::PARAM_INT);
					$results->bindValue(':sub_type', $sub_type, PDO::PARAM_INT);
					$results->bindValue(':sub_type_change', $sub_type_change, PDO::PARAM_INT);
					$results->bindValue(':conversion', $conversion, PDO::PARAM_INT);
					$results->bindValue(':comment', $comment, PDO::PARAM_STR);
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
					
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data successfully added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);
					
				}
				
				else{
				
					$content_anwser ="<script type=\"text/javascript\"> alert('Quality Control data failed to be added for $fdaAppNumber'); </script>";	
					
					die($content_anwser);	
					
				}
			}
			else{
				
				$content_anwser ="<script type=\"text/javascript\"> alert('$fdaAppNumber does not exist.'); </script>";	
					
				die($content_anwser);	
				
			}
			
		}
		
	}
	
}

?>