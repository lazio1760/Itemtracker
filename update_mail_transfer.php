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


$fromLocation = $_REQUEST["fromLocation"];
$toLocation = $_REQUEST["toLocation"];
$reviewer = $_REQUEST["reviewer"];
$reviewer2 = $_REQUEST["reviewer2"];
$staff = $_REQUEST["staff"];
$staff2 = $_REQUEST["staff2"];
$reason = $_REQUEST["reason"];
if(!empty($_REQUEST['receiptDate'])){
$receiptDate = trim(date("Y-m-d", (strtotime($_REQUEST['receiptDate']))));
}
else{$receiptDate = "";}
$documentType = $_REQUEST["documentType"];
$internal_number = trim($_REQUEST["internal_number"]);
$modified = $_REQUEST["modified"];
$date = date("Y-m-d", (strtotime($_REQUEST['deliveryDate'])));
$deliveryTime = $_REQUEST["deliveryTimeHour"].":".$_REQUEST["deliveryTimeMinute"].":00 ".$_REQUEST["deliveryTimeAmPm"];

//die("$internal_number $documentType $receiptDate");


if(((!empty($fdaAppNumber)) && (!empty($internal_number))) || ((empty($fdaAppNumber)) && (empty($internal_number))) ){
	
	die("<script type=\"text/javascript\"> alert('Please enter FDA Application Number or Internal Number.'); getMailTransferForm(); </script>");		
	
}

$updateEmployeeTime = new update_mail_out();

$updateEmployeeTime->update_mail_logout_data($fromLocation,$toLocation,$reviewer,$reviewer2,$staff,$staff2,$reason,$date,$deliveryTime,$internal_number,$documentType,$receiptDate,$modified,$fdaAppNumber);

class update_mail_out{
	
	public function update_mail_logout_data($fromLocation,$toLocation,$reviewer,$reviewer2,$staff,$staff2,$reason,$date,$deliveryTime,$internal_number,$documentType,$receiptDate,$modified,$fdaAppNumber){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		if(!(empty($fdaAppNumber))){
			try{
			$check_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE fda_application_number = :fda_app_number");
			
			$check_doc_results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
			$check_doc_results->execute();
			}
			catch(PDOException $exeception){
		
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for document transfer fda number query error.'); </script>");
				
			}
			
		}
		else{
		
			try{
				
				$check_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND date_received = :receiptDate AND document_type = :document_type");
				
				$check_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$check_doc_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$check_doc_results->bindValue(':document_type', $documentType, PDO::PARAM_STR);
				$check_doc_results->execute();
				
			}
			
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail logout error.'); </script>");
				
			}
		}
		
		if($check_doc_results->rowCount() != 0){
			
			if(!(empty($fdaAppNumber))){
			
				$document_data = $check_doc_results->fetch(PDO::FETCH_ASSOC);
				
				try{
				$mail_transfer_results = $hrtsConnection->prepare("INSERT INTO `mail_transfer` (date_received,internal_number,date,time,document_type,division_from,division_to,reviewer_from,reviewer_to,reason,modified_by,fda_application_number,staff_from,staff_to) VALUES (:receiptDate,:internal_number,:date,:deliveryTime,:documentType,:fromLocation,:toLocation,:reviewer,:reviewer2,:reason,:modified,:fda_app_number,:staff,:staff2)");
								
					$mail_transfer_results->bindValue(':fromLocation', $fromLocation, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':toLocation', $toLocation, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':reviewer', $reviewer, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':reviewer2', $reviewer2, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':reason', $reason, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':receiptDate', $document_data["date_received"], PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':internal_number', $document_data["internal_number"], PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':documentType', $document_data["document_type"], PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':date', $date, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':deliveryTime', $deliveryTime, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':staff', $staff, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':staff2', $staff2, PDO::PARAM_STR);
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
			
			else{
				
				try{
				$mail_transfer_results = $hrtsConnection->prepare("INSERT INTO `mail_transfer` (date_received,internal_number,date,time,document_type,division_from,division_to,reviewer_from,reviewer_to,reason,modified_by,fda_application_number,staff_from,staff_to) VALUES (:receiptDate,:internal_number,:date,:deliveryTime,:documentType,:fromLocation,:toLocation,:reviewer,:reviewer2,:reason,:modified,:fda_app_number,:staff,:staff2)");
								
					$mail_transfer_results->bindValue(':fromLocation', $fromLocation, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':toLocation', $toLocation, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':reviewer', $reviewer, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':reviewer2', $reviewer2, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':reason', $reason, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':fda_app_number', $fdaAppNumber, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':date', $date, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':deliveryTime', $deliveryTime, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':staff', $staff, PDO::PARAM_STR);
					$mail_transfer_results->bindValue(':staff2', $staff2, PDO::PARAM_STR);
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
			
			if($mail_transfer_results->rowCount() == 1){
				
				die("<script type=\"text/javascript\"> alert('Mail transfer has been successfully logged.'); getMailTransferForm(); /*cancel_button();*/</script>");	
			}
			else{ die("<script type=\"text/javascript\"> alert('Mail transfer was not logged.'); </script>"); } 
		}
		
		else{die("<script type=\"text/javascript\"> alert('FDA Application Number: $fdaAppNumber does not exist.'); getMailTransferForm(); </script>");}
		
	}
	
}

?>