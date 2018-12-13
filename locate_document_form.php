<?php

include ("hrtsDatabaseConnection.php");

$fdaAppNumber = $_REQUEST['fdaAppNumber'];
$documentType = $_REQUEST['documentType'];

$search = new locate_document_form();

$search->locate_document($fdaAppNumber,$documentType);

class locate_document_form{
	
	public function locate_document($fdaAppNumber,$documentType){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
		$results = $hrtsConnection->prepare("SELECT * FROM `document_location` WHERE fda_application_number = :fdaAppNumber AND document_type = :documentType");
		
		$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
		$results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
		$results->execute();
		}
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('An error occurred searching for a document location.'); </script>");
			
		}
		
		if($results->rowCount() == 0){
			
			$content = "failed";
			
			die($content);	
			
		}
		else{
		
				$content = "found";
				die($content);
				
		}	
		
	}
	
}

?>