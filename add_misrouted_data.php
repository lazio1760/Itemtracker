<?php

include ("hrtsDatabaseConnection.php");

$receiptDate = trim(date("Y-m-d", (strtotime($_REQUEST['receiptDate']))));
$deliveryCompany = trim($_REQUEST['deliveryCompany']);
$deliveryTracking = trim($_REQUEST['deliveryTracking']);
$documentType = trim($_REQUEST['documentType']);
$moreInfo = trim($_REQUEST['moreInfo']);
$modified = trim($_REQUEST['modified']);
$comment = trim($_REQUEST['comment']);

//die($fdaAppNumber);

$search = new update_document_data();

$search->update_document($receiptDate,$deliveryCompany,$deliveryTracking,$documentType,$moreInfo,$comment,$modified);

class update_document_data{
	
	public function update_document($receiptDate,$deliveryCompany,$deliveryTracking,$documentType,$moreInfo,$comment,$modified){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			$results = $hrtsConnection->prepare("INSERT INTO mis_routed (delivery_company,delivery_tracking_number,document_type,date_received,delivery_add_info,modified_by,comment) VALUES (:deliveryCompany,:deliveryTracking,:documentType,:receiptDate,:moreInfo,:modified,:comment)");
			
			$results->bindValue(':deliveryCompany', $deliveryCompany, PDO::PARAM_STR);
			$results->bindValue(':deliveryTracking', $deliveryTracking, PDO::PARAM_STR);
			$results->bindValue(':moreInfo', $moreInfo, PDO::PARAM_STR);
			$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
			$results->bindValue(':comment', $comment, PDO::PARAM_STR);
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':modified', $modified, PDO::PARAM_STR);
			$results->execute();
		}
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for add misrouted data error.'); </script>");
			
		}
		
		if($results->rowCount() == 1){
			
			
			die("<script type=\"text/javascript\"> alert('Misrouted mail successfully logged.'); </script>");
			
		}
		
		else{
			
			die("<script type=\"text/javascript\"> alert('Misrouted mail was not logged.'); </script>");
			
		}

	}
}

?>