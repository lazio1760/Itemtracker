<?php

include ("hrtsDatabaseConnection.php");

$internal_number = trim($_REQUEST['internal_number']);
$receiptDate = trim(date("Y-m-d", (strtotime($_REQUEST['receiptDate']))));
$deliveryCompany = trim($_REQUEST['deliveryCompany']);
$deliveryTracking = trim($_REQUEST['deliveryTracking']);
$documentType = trim($_REQUEST['documentType']);
//$fdaAppNumber = trim($_REQUEST['fdaAppNumber']);
//if(empty($_REQUEST['fdaAppNumberSup'])){ $fdaAppNumberSup = "0"; }
//else{$fdaAppNumberSup = trim($_REQUEST['fdaAppNumberSup']);}
//$document_type_id = trim($_REQUEST['document_type_id']);
$manufacturer = trim($_REQUEST['manufacturer']);
$moreInfo = trim($_REQUEST['moreInfo']);
$cd = trim($_REQUEST['cd']);
$usb = trim($_REQUEST['usb']);
//die($usb);
$paper = trim($_REQUEST['paper']);
$volume = trim($_REQUEST['volume']);
$modified = trim($_REQUEST['modified']);

if(empty($_REQUEST['fdaAppNumber']) && $_REQUEST['document_type_id'] == "MAF"){
	
	$fdaAppNumber = "MAF0000/0000";
	
}
elseif(empty($_REQUEST['fdaAppNumber']) && $_REQUEST['document_type_id'] != "MAF"){
	
	$fdaAppNumber = $_REQUEST['document_type_id']."000000/0000";
	
}
else{
$fdaAppNumber = trim($_REQUEST['fdaAppNumber']);
if(empty($_REQUEST['fdaAppNumberSup'])){ $fdaAppNumberSup = "0"; }
else{$fdaAppNumberSup = trim($_REQUEST['fdaAppNumberSup']);}
$document_type_id = trim($_REQUEST['document_type_id']);

$fdaAppNumberSup = str_pad($fdaAppNumberSup, 4, '0', STR_PAD_LEFT);

if($document_type_id == "P"){
	
	if(empty($_REQUEST['fdaAppNumberSup2'])){ $fdaAppNumberSup2 = "0"; }
	else{$fdaAppNumberSup2 = trim($_REQUEST['fdaAppNumberSup2']);}	
	$fdaAppNumberSup2 = str_pad($fdaAppNumberSup2, 4, '0', STR_PAD_LEFT);
	$fdaAppNumber = "$document_type_id$fdaAppNumber/$fdaAppNumberSup/$fdaAppNumberSup2";
}

else{$fdaAppNumber = "$document_type_id$fdaAppNumber/$fdaAppNumberSup";}
}

if($_REQUEST['document_type_id'] == "R"){
	
	$report_type = trim($_REQUEST['reportType']);
}

else{$report_type ="";}



if((($deliveryCompany == "DHL") || ($deliveryCompany == "FEDEX") || ($deliveryCompany == "FEDEXG") || ($deliveryCompany == "TNT") || ($deliveryCompany == "UPS") || ($deliveryCompany == "USPS")) && (empty($deliveryTracking))){
	
die("<script type=\"text/javascript\"> alert('Please enter tracking number or \"NA\" if not available.'); </script>");

}

$search = new update_document_data();

$search->update_document($internal_number,$receiptDate,$deliveryCompany,$deliveryTracking,$documentType,$fdaAppNumber,$manufacturer,$moreInfo,$cd,$paper,$volume,$modified,$report_type,$usb);

class update_document_data{
	
	public function update_document($internal_number,$receiptDate,$deliveryCompany,$deliveryTracking,$documentType,$fdaAppNumber,$manufacturer,$moreInfo,$cd,$paper,$volume,$modified,$report_type,$usb){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		//$old_results = $hrtsConnection->query("SELECT * FROM `document` WHERE date_received = '$receiptDate' AND k_number = '$k_number'");
		/*
		$old_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE date_received = :receiptDate AND k_number = :k_number");
		
		$old_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
		$old_results->bindValue(':k_number', $k_number, PDO::PARAM_INT);
		$old_results->execute();
		
		$row = $old_results->fetch(PDO::FETCH_ASSOC);*/
		
	
		try{
		$results = $hrtsConnection->prepare("UPDATE `document` SET delivery_company = :deliveryCompany, delivery_tracking_number = :deliveryTracking, fda_application_number = :fdaAppNumber, manufacturer = :manufacturer, delivery_add_info = :moreInfo, cd_copies = :cd, paper_copies = :paper, volume_number = :volume, modified_by = :modified, usb_copies = :usb, report_type = :report_type WHERE date_received = :receiptDate AND internal_number = :internal_number AND document_type = :documentType");
		
			$results->bindValue(':cd', $cd, PDO::PARAM_INT);
			$results->bindValue(':usb', $usb, PDO::PARAM_INT);
			$results->bindValue(':paper', $paper, PDO::PARAM_INT);
			$results->bindValue(':report_type', $report_type, PDO::PARAM_STR);
			$results->bindValue(':volume', $volume, PDO::PARAM_STR);
			$results->bindValue(':deliveryCompany', $deliveryCompany, PDO::PARAM_STR);
			$results->bindValue(':deliveryTracking', $deliveryTracking, PDO::PARAM_STR);
			$results->bindValue(':moreInfo', $moreInfo, PDO::PARAM_STR);
			$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
			$results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
			$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_STR);
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':modified', $modified, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for update document data error.'); </script>");
			
		}
		if($results->rowCount() == 1){
			
		
			die("<script type=\"text/javascript\"> alert('Internal number $internal_number document type $documentType received on $receiptDate has been successfully updated.'); </script>");
			
		}
		
		else{
			
			die("<script type=\"text/javascript\"> alert('Internal number $internal_number document type $documentType received on $receiptDate was not updated.'); </script>");
			
		}

	}
}

?>