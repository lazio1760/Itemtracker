<?php

include ("hrtsDatabaseConnection.php");

$deliveryLocation = $_REQUEST["deliveryLocation"];
$fdaAppNumber = trim($_REQUEST["fdaAppNumber"]);
$documentType = $_REQUEST["documentType"];
$internal_number = trim($_REQUEST["internal_number"]);
$modified = $_REQUEST["modified"];
$date = date("Y-m-d", (strtotime($_REQUEST['deliveryDate'])));
$deliveryTime = $_REQUEST["deliveryTimeHour"].":".$_REQUEST["deliveryTimeMinute"].":00 ".$_REQUEST["deliveryTimeAmPm"];

$updateEmployeeTime = new update_mail_out();

$updateEmployeeTime->update_mail_logout_data($deliveryLocation,$date,$deliveryTime,$internal_number,$documentType,$fdaAppNumber,$modified);

class update_mail_out{
	
	public function update_mail_logout_data($deliveryLocation,$date,$deliveryTime,$internal_number,$documentType,$fdaAppNumber,$modified){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			
			$check_doc_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND fda_application_number = :fda_application_number AND document_type = :document_type");
			
			$check_doc_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$check_doc_results->bindValue(':fda_application_number', $fdaAppNumber, PDO::PARAM_STR);
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
		
		if($check_doc_results->rowCount() != 0){
			try{
			$mail_logout_results = $hrtsConnection->prepare("INSERT INTO `mail_logout` (fda_application_number,internal_number,date,time,document_type,division,modified_by) VALUES (:fdaAppNumber,:internal_number,:date,:deliveryTime,:documentType,:deliveryLocation,:modified)");
							
				$mail_logout_results->bindValue(':deliveryLocation', $deliveryLocation, PDO::PARAM_STR);
				$mail_logout_results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
				$mail_logout_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
				$mail_logout_results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$mail_logout_results->bindValue(':date', $date, PDO::PARAM_STR);
				$mail_logout_results->bindValue(':deliveryTime', $deliveryTime, PDO::PARAM_STR);
				$mail_logout_results->bindValue(':modified', $modified, PDO::PARAM_STR);
				$mail_logout_results->execute();
			}
			
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail logout error.'); </script>");
				
			}
			
			if($mail_logout_results->rowCount() == 1){
				
				die("<script type=\"text/javascript\"> alert('FDA number: $fdaAppNumber has been successfully added to logged out.'); </script>");	
			}
			else{ die("<script type=\"text/javascript\"> alert('FDA number: $fdaAppNumber was not logged out.'); </script>"); }
		}
		else{die("<script type=\"text/javascript\"> alert('The combination of FDA number: $fdaAppNumber, document type: $documentType, internal number: $internal_number does not exist.'); </script>");}
		
	}
	
}

?>