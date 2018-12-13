<?php

include ("hrtsDatabaseConnection.php");

if(empty($_REQUEST['internal_number'])){
	
	die("Please enter internal number.");
	
}

$group = trim($_REQUEST['group']);
$internal_number = trim($_REQUEST['internal_number']);
$receiptDate = trim(date("Y-m-d", (strtotime($_REQUEST['receiptDate']))));

$search = new find_document_processing_form();

$search->get_document_processing_status($internal_number,$receiptDate,$group);

class find_document_processing_form{
	
	public function get_document_processing_status($internal_number,$receiptDate,$group){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		if($group == '510K'){
			$results = $hrtsConnection->prepare("SELECT * FROM `510k_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
			
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		elseif($group == 'IDE'){
			$results = $hrtsConnection->prepare("SELECT * FROM `ide_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
			
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		elseif($group == 'PMA'){
			$results = $hrtsConnection->prepare("SELECT * FROM `pma_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
			
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		elseif($group == 'RAD_HEALTH'){
			$results = $hrtsConnection->prepare("SELECT * FROM `rad_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
			
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		elseif($group == '513G'){
			$results = $hrtsConnection->prepare("SELECT * FROM `513g_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
			
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		
		$count = $results->rowCount();
		
		if($count == 0){
			
			die("internal number: $internal_number received on ".date("m-d-Y", (strtotime($receiptDate)))." document not found.");	
			
		}
		else{
				
				die("start");		
		
		}
		
	}
	
}


?>