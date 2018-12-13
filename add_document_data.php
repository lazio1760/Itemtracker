<?php

include ("hrtsDatabaseConnection.php");

$internal_number = trim($_REQUEST['internal_number']);
$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));
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


if((($deliveryCompany == "DHL") || ($deliveryCompany == "FedEx") || ($deliveryCompany == "FedEx Ground") || ($deliveryCompany == "TNT Express") || ($deliveryCompany == "UPS") || ($deliveryCompany == "USPS")) && (empty($deliveryTracking))){
	
die("<script type=\"text/javascript\"> alert('Please enter tracking number or \"NA\" if not available.'); </script>");

}

$search = new update_document_data();

$search->update_document($internal_number,$receiptDate,$deliveryCompany,$deliveryTracking,$documentType,$fdaAppNumber,$manufacturer,$moreInfo,$cd,$paper,$volume,$modified,$report_type,$usb,$current_time);

class update_document_data{
	
	public function update_document($internal_number,$receiptDate,$deliveryCompany,$deliveryTracking,$documentType,$fdaAppNumber,$manufacturer,$moreInfo,$cd,$paper,$volume,$modified,$report_type,$usb,$current_time){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			$results = $hrtsConnection->prepare("INSERT INTO document (delivery_company,delivery_tracking_number,document_type,fda_application_number,date_received,internal_number,manufacturer,delivery_add_info,cd_copies,paper_copies,volume_number,modified_by,usb_copies,report_type,time) VALUES (:deliveryCompany,:deliveryTracking,:documentType,:fdaAppNumber,:receiptDate,:internal_number,:manufacturer,:moreInfo,:cd,:paper,:volume,:modified,:usb,:report_type,:time)");
			
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
			$results->bindValue(':time', $current_time, PDO::PARAM_STR);
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
			
			
			die("<script type=\"text/javascript\"> alert('A new document has been successfully added.'); </script>");
			
		}
		
		else{
			
			die("Update Failed <br>".$internal_number."<br>".$receiptDate."<br>".$deliveryCompany."<br>".$deliveryTracking."<br>".$shippedDate."<br>".$documentType."<br>".$fdaAppNumber."<br>".$manufacturer);
			
		}

	}
}

?>