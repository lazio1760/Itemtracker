<?php

include ("hrtsDatabaseConnection.php");



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

$documentType = trim($_REQUEST['documentType']);
$group = trim($_REQUEST['group']);
//$fdaAppNumber = trim($_REQUEST['fdaAppNumber']);
$internal_number = trim($_REQUEST['internal_number']);
$receiptDate = trim(date("Y-m-d", (strtotime($_REQUEST['receiptDate']))));
$action = $_REQUEST['action'];
$modified = trim($_REQUEST['modified']);

//die($fdaAppNumber);

//die($internal_number);

$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));

$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));

$search = new update_document_processing();

$search->update_document_processing_status($internal_number,$receiptDate,$current_time,$action,$group,$documentType,$modified,$current_date,$fdaAppNumber);

class update_document_processing{
	
	public function update_document_processing_status($internal_number,$receiptDate,$current_time,$action,$group,$documentType,$modified,$current_date,$fdaAppNumber){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
				
		if($group == '510K'){
			if($action == "start"){
				
					try{
					$find_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND date_received = :receiptDate AND document_type = '510K'");
					
					$find_doc_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$find_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$find_doc_results->execute();
					}
					catch(PDOException $exeception){
				
						$error_document = 'errors/error_report.txt';
						$error_handle = fopen($error_document, 'w');
						fwrite($error_handle,$exeception->getMessage());
						fclose($error_handle);
						die("<script type=\"text/javascript\"> alert('Check log for document processing internal number query error.'); </script>");
						
					}
				
				if($find_doc_results->rowCount() == 0){ die("no_match"); }
				
				//$row = $find_doc_results->fetch(PDO::FETCH_ASSOC);
				try{
				$results = $hrtsConnection->prepare("INSERT INTO `510k_processing` (status,start_process,document_type,modified_by,original_processor,internal_number,date_received,start_date,fda_application_number) VALUES ('processing','$current_time',:documentType,:modified,:original_processor,:internal_number,:receiptDate,'$current_date',:fda_app_number)");
				
				$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
				$results->bindValue(':original_processor', $modified, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing insert error.'); </script>");
					
				}
				
				try{
				$delete_old_entry = $hrtsConnection->prepare("Delete from 510k_processing WHERE internal_number = :internal_number AND date_received = :receiptDate AND start_process <> '$current_time' AND end_process = '' AND end_date = '0000-00-00'");
				
				$delete_old_entry->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$delete_old_entry->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$delete_old_entry->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing insert error.'); </script>");
					
				}
				
				if($results->rowCount() == 1){
				
					die("started_processing");	
					
				}
				
				else{
					
					die("Update Failed ".$internal_number);
					
				}
			}
			
			else{
				if(!(empty($fdaAppNumber))){
					
					$results = $hrtsConnection->prepare("UPDATE `510k_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified, fda_application_number = :fda_app_number WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
					
					$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$results->execute();
					
				}
				else{
				$results = $hrtsConnection->prepare("UPDATE `510k_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
				
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':action', $action, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				
				if($results->rowCount() > 0){
					
				
					die("completed_processing");	
					
				}
				
				else{
					
					die("Update Failed ".$internal_number);
					
				}
			}
			
			
		}
		
		if($group == 'IDE'){
			if($action == "start"){
				
					try{
					$find_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND date_received = :receiptDate AND document_type = 'IDE'");
					
					$find_doc_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$find_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$find_doc_results->execute();
					}
					catch(PDOException $exeception){
				
						$error_document = 'errors/error_report.txt';
						$error_handle = fopen($error_document, 'w');
						fwrite($error_handle,$exeception->getMessage());
						fclose($error_handle);
						die("<script type=\"text/javascript\"> alert('Check log for document processing internal number query error.'); </script>");
						
					}
				
				
				if($find_doc_results->rowCount() == 0){ die("no_match"); }
				
				//$row = $find_doc_results->fetch(PDO::FETCH_ASSOC);
				try{
				$results = $hrtsConnection->prepare("INSERT INTO `ide_processing` (status,start_process,document_type,modified_by,original_processor,internal_number,date_received,start_date,fda_application_number) VALUES ('processing','$current_time',:documentType,:modified,:original_processor,:internal_number,:receiptDate,'$current_date',:fda_app_number)");
				
				$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
				$results->bindValue(':original_processor', $modified, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing insert error.'); </script>");
					
				}
				
				if($results->rowCount() == 1){
					
					die("started_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			else{//die($fdaAppNumber);
				if(!(empty($fdaAppNumber))){
					try{
					$results = $hrtsConnection->prepare("UPDATE `ide_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified, fda_application_number = :fda_app_number WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
					
					$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$results->execute();
					}
					catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing update error.'); </script>");
					
					}
					
					
				}
				else{
					try{
					$results = $hrtsConnection->prepare("UPDATE `ide_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
					
					$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$results->execute();
					}
					catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing update error.'); </script>");
					
					}
				}
				
				if($results->rowCount() > 0){
				
					
					
					die("completed_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
		}
		
		if($group == 'PMA'){
			if($action == "start"){
				
					try{
					$find_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND date_received = :receiptDate AND document_type = 'PMA'");
					
					$find_doc_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$find_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$find_doc_results->execute();
					}
					catch(PDOException $exeception){
				
						$error_document = 'errors/error_report.txt';
						$error_handle = fopen($error_document, 'w');
						fwrite($error_handle,$exeception->getMessage());
						fclose($error_handle);
						die("<script type=\"text/javascript\"> alert('Check log for document processing fda number query error.'); </script>");
						
					}
				
				
				if($find_doc_results->rowCount() == 0){ die("no_match"); }
				
				//$row = $find_doc_results->fetch(PDO::FETCH_ASSOC);
				try{
				$results = $hrtsConnection->prepare("INSERT INTO `pma_processing` (status,start_process,document_type,modified_by,original_processor,internal_number,date_received,start_date,fda_application_number) VALUES ('processing','$current_time',:documentType,:modified,:original_processor,:internal_number,:receiptDate,'$current_date',:fda_app_number)");
				
				$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
				$results->bindValue(':original_processor', $modified, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing insert error.'); </script>");
					
				}
				
				if($results->rowCount() == 1){
				
					die("started_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			else{
				if(!(empty($fdaAppNumber))){
					
					try{
					$results = $hrtsConnection->prepare("UPDATE `pma_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified, fda_application_number = :fda_app_number WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
					
					$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$results->execute();
					}
					catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing update error.'); </script>");
					
					}
					
					
				}
				else{
					try{
					$results = $hrtsConnection->prepare("UPDATE `pma_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
					
					$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$results->execute();
					}
					catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing update error.'); </script>");
					
					}
				}
					
				
				if($results->rowCount() > 0){
				
					
					die("completed_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			
		}
		
		if($group == 'RAD_HEALTH'){
			if($action == "start"){
				
					try{
					$find_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND date_received = :receiptDate AND document_type = 'RAD_HEALTH'");
					
					$find_doc_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$find_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$find_doc_results->execute();
					}
					catch(PDOException $exeception){
				
						$error_document = 'errors/error_report.txt';
						$error_handle = fopen($error_document, 'w');
						fwrite($error_handle,$exeception->getMessage());
						fclose($error_handle);
						die("<script type=\"text/javascript\"> alert('Check log for document processing fda number query error.'); </script>");
						
					}
				
				if($find_doc_results->rowCount() == 0){ die("no_match"); }
				
				//$row = $find_doc_results->fetch(PDO::FETCH_ASSOC);
				try{
				$results = $hrtsConnection->prepare("INSERT INTO `rad_processing` (status,start_process,document_type,modified_by,original_processor,internal_number,date_received,start_date,fda_application_number) VALUES ('processing','$current_time',:documentType,:modified,:original_processor,:internal_number,:receiptDate,'$current_date',:fda_app_number)");
				
				$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$results->bindValue(':original_processor', $modified, PDO::PARAM_STR);
				$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for document processing insert error.'); </script>");
					
				}
				
				if($results->rowCount() == 1){
				
					die("started_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			else{
				if(!(empty($fdaAppNumber))){
					$results = $hrtsConnection->prepare("UPDATE `rad_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE fda_application_number = :fda_app_number AND status = 'processing'");
				
					$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->execute();	
				}
				else{
				$results = $hrtsConnection->prepare("UPDATE `rad_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
				
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':action', $action, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				
				if($results->rowCount() > 0){
				
					
					if($action == "Processing Complete"){
						
						$reformatted_data = date("m-d-Y", (strtotime($receiptDate)));
						
						try{
		
							$results = $hrtsConnection->prepare("INSERT INTO `rad_internal_qc` (internal_number_date, grade, receipt_date_check, trade_name_check, common_name_check, applicant_information_check, fda_application_number_check, electronic_submission_check, manufacturer_check, document_type_check, letter_date_check, panel_check, division_check, branch_check, product_code_check, jacket_color_check, acknowledgement_letter_check, other_check, other_data, processor) VALUES ('$internal_number ($reformatted_data)','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',:modified)");
								
								//$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
								$results->bindValue(':modified', $modified, PDO::PARAM_STR);
								$results->execute();	
							
						}
						
						catch(PDOException $exeception){
										
										$document = 'errors/error_report.txt';
										$handle = fopen($document, 'w');
										fwrite($handle,$exeception->getMessage());
										fclose($handle);
										die("<script type=\"text/javascript\"> alert('Check log for qc data update error. (processing record)'); </script>");
										
						}
						
					}
					
					if(($action == "FDA Hold") || ($action == "eCopy Hold") || ($action == "User Fee Hold") || ($action == "Combo Hold")){
						
							try{
									$mail_transfer_results = $hrtsConnection->prepare("INSERT INTO `mail_transfer` (date_received,internal_number,date,time,document_type,division_from,division_to,reviewer_from,reviewer_to,reason,modified_by,fda_application_number) VALUES (:receiptDate,:internal_number,:date,:deliveryTime,:documentType,:fromLocation,:toLocation,:reviewer,:reviewer2,:reason,:modified,:fda_app_number)");
												
									$mail_transfer_results->bindValue(':fromLocation', 'Document Room Staff', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':toLocation', 'Document Room Hold Shelf', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reviewer', '', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reviewer2', '', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reason', $action, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':documentType', $group, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':date', $current_date, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':deliveryTime', $current_time, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':modified', $modified, PDO::PARAM_STR);
									$mail_transfer_results->execute();
								}
								
								catch(PDOException $exeception){
									
									$document = 'errors/error_report.txt';
									$handle = fopen($document, 'w');
									fwrite($handle,$exeception->getMessage());
									fclose($handle);
									die("<script type=\"text/javascript\"> alert('Check log for mail logout error.'); </script>");
									
								}	
							
						
						
					}
					
					die("completed_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			
		}
		
		if($group == '2579'){
			if($action == "start"){
				try{
				$find_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND date_received = :receiptDate AND document_type = '2579'");
				
				$find_doc_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$find_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$find_doc_results->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for add document data error.'); </script>");
					
				}
				
				if($find_doc_results->rowCount() == 0){ die("no_match"); }
				
				//$row = $find_doc_results->fetch(PDO::FETCH_ASSOC);
				try{
				$results = $hrtsConnection->prepare("INSERT INTO `2579_processing` (status,start_process,document_type,modified_by,original_processor,internal_number,date_received,start_date) VALUES ('processing','$current_time',:documentType,:modified,:original_processor,:internal_number,:receiptDate,'$current_date')");
				
				$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$results->bindValue(':original_processor', $modified, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for add document data error.'); </script>");
					
				}
				
				if($results->rowCount() == 1){
				
					die("started_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			else{
				$results = $hrtsConnection->prepare("UPDATE `2579_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
				
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':action', $action, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				
				if($results->rowCount() == 1){
				
					
					if(($action == "FDA Hold") || ($action == "eCopy Hold") || ($action == "User Fee Hold") || ($action == "Combo Hold")){
						
							try{
									$mail_transfer_results = $hrtsConnection->prepare("INSERT INTO `mail_transfer` (date_received,internal_number,date,time,document_type,division_from,division_to,reviewer_from,reviewer_to,reason,modified_by) VALUES (:receiptDate,:internal_number,:date,:deliveryTime,:documentType,:fromLocation,:toLocation,:reviewer,:reviewer2,:reason,:modified)");
												
									$mail_transfer_results->bindValue(':fromLocation', 'Document Room Staff', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':toLocation', 'Document Room Hold Shelf', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reviewer', '', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reviewer2', '', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reason', $action, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':documentType', $group, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':date', $current_date, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':deliveryTime', $current_time, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':modified', $modified, PDO::PARAM_STR);
									$mail_transfer_results->execute();
								}
								
								catch(PDOException $exeception){
									
									$document = 'errors/error_report.txt';
									$handle = fopen($document, 'w');
									fwrite($handle,$exeception->getMessage());
									fclose($handle);
									die("<script type=\"text/javascript\"> alert('Check log for mail logout error.'); </script>");
									
								}	
							
						
						
					}
					
					die("completed_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			
		}
		
		if($group == '513G'){
			if($action == "start"){
				if(!(empty($fdaAppNumber))){
					try{
					$find_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE fda_application_number = :fda_app_number");
					
					$find_doc_results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$find_doc_results->execute();
					}
					catch(PDOException $exeception){
				
						$error_document = 'errors/error_report.txt';
						$error_handle = fopen($error_document, 'w');
						fwrite($error_handle,$exeception->getMessage());
						fclose($error_handle);
						die("<script type=\"text/javascript\"> alert('Check log for document reprocessing fda number query error.'); </script>");
						
					}	
				}
				else{
					try{
					$find_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND date_received = :receiptDate AND document_type = '513G'");
					
					$find_doc_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$find_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$find_doc_results->execute();
					}
					catch(PDOException $exeception){
				
						$error_document = 'errors/error_report.txt';
						$error_handle = fopen($error_document, 'w');
						fwrite($error_handle,$exeception->getMessage());
						fclose($error_handle);
						die("<script type=\"text/javascript\"> alert('Check log for document processing internal number query error.'); </script>");
						
					}
				}
				
				if($find_doc_results->rowCount() == 0){ die("no_match"); }
				
				//$row = $find_doc_results->fetch(PDO::FETCH_ASSOC);
				try{
				$results = $hrtsConnection->prepare("INSERT INTO `513g_processing` (status,start_process,document_type,modified_by,original_processor,internal_number,date_received,start_date,fda_application_number) VALUES ('processing','$current_time',:documentType,:modified,:original_processor,:internal_number,:receiptDate,'$current_date',:fda_app_number)");
				
				$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$results->bindValue(':original_processor', $modified, PDO::PARAM_STR);
				$results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
				catch(PDOException $exeception){
			
					$error_document = 'errors/error_report.txt';
					$error_handle = fopen($error_document, 'w');
					fwrite($error_handle,$exeception->getMessage());
					fclose($error_handle);
					die("<script type=\"text/javascript\"> alert('Check log for add document data error.'); </script>");
					
				}
				
				if($results->rowCount() == 1){
				
					die("started_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			else{
				if(!(empty($fdaAppNumber))){
					
					$results = $hrtsConnection->prepare("UPDATE `513g_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE fda_application_number = :fda_app_number AND status = 'processing'");
					
					$results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->execute();	
				}
				else{
					$results = $hrtsConnection->prepare("UPDATE `513g_processing` SET status = :action, end_process = '$current_time', end_date = '$current_date', modified_by = :modified WHERE internal_number = :internal_number AND date_received = :receiptDate AND status = 'processing'");
					
					$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$results->bindValue(':action', $action, PDO::PARAM_STR);
					$results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
					$results->execute();
				}
				
				if($results->rowCount() == 1){
				
					if(($action == "FDA Hold") || ($action == "eCopy Hold") || ($action == "User Fee Hold") || ($action == "Combo Hold")){
						
							try{
									$mail_transfer_results = $hrtsConnection->prepare("INSERT INTO `mail_transfer` (date_received,internal_number,date,time,document_type,division_from,division_to,reviewer_from,reviewer_to,reason,modified_by,fda_application_number) VALUES (:receiptDate,:internal_number,:date,:deliveryTime,:documentType,:fromLocation,:toLocation,:reviewer,:reviewer2,:reason,:modified,:fda_app_number)");
												
									$mail_transfer_results->bindValue(':fromLocation', 'Document Room Staff', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':toLocation', 'Document Room Hold Shelf', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reviewer', '', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reviewer2', '', PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':reason', $action, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':documentType', $group, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':date', $current_date, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':deliveryTime', $current_time, PDO::PARAM_STR);
									$mail_transfer_results->bindValue(':modified', $modified, PDO::PARAM_STR);
									$mail_transfer_results->execute();
								}
								
								catch(PDOException $exeception){
									
									$document = 'errors/error_report.txt';
									$handle = fopen($document, 'w');
									fwrite($handle,$exeception->getMessage());
									fclose($handle);
									die("<script type=\"text/javascript\"> alert('Check log for mail logout error.'); </script>");
									
								}	
							
						
						
					}
					
					die("completed_processing");	
					
				}
				
				else{
					
					die("Update Failed <br>".$internal_number);
					
				}
			}
			
			
		}

	}
}


?>