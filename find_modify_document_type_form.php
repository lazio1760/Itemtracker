<?php

include ("hrtsDatabaseConnection.php");

$documentType = $_REQUEST['documentType'];

$internal_number = $_REQUEST['internal_number'];

$receiptDate = date("Y-m-d", (strtotime($_REQUEST['receiptDate'])));

$search = new find_document_form();

$search->find_document($internal_number,$receiptDate,$documentType);

class find_document_form{
	
	public function find_document($internal_number,$receiptDate,$documentType){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			$results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE date_received = :receiptDate AND internal_number = :internal_number AND document_type = :documentType");
			
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for find document form error.'); </script>");
			
		}
		
		if($results->rowCount() == 0){
			
			if($documentType == "Mis_Routed") {$content = "Mis_Routed"; die($content);}
			
			$content = "add";
			
			die($content);	
			
		}
		else{
		
				//if($documentType == "Mis_Routed") {$content = "Mis_Routed"; die($content);}
				
				$content = "update";
				die($content);
				
		}	
		
	}
	
}

?>