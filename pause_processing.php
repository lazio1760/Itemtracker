<?php

include ("hrtsDatabaseConnection.php");

$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));

$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));

$document_type_id = $_REQUEST["document_type_id"];
$internal_number = $_REQUEST["internal_number"];
$receiptDate = $_REQUEST["receiptDate"];
$status = $_REQUEST["status"];

//die($status);

$data = new pause_date();

$data->capture_pause_data($internal_number,$receiptDate,$current_time,$document_type_id,$current_date,$status);

class pause_date{
	
	public function capture_pause_data($internal_number,$receiptDate,$current_time,$document_type_id,$current_date,$status){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		
		if($status == "pause"){
			
			try{
				$results = $hrtsConnection->prepare("INSERT INTO `pause_data` (document_type,internal_number,receipt_date,start_pause,start_date) VALUES (:documentType,:internal_number,:receiptDate,'$current_time','$current_date')");
				
				$results->bindValue(':documentType', $document_type_id, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
			catch(PDOException $exeception){
		
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for pause data insert error.'); </script>");
				
			}
			
		}
		
		elseif($status == "unpause"){
		
			try{
				
				$results = $hrtsConnection->prepare("UPDATE `pause_data` SET end_pause = '$current_time', end_date = '$current_date' WHERE internal_number = :internal_number AND receipt_date = :receiptDate AND document_type = :documentType AND end_pause = ''");
				
				$results->bindValue(':documentType', $document_type_id, PDO::PARAM_STR);
				$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$results->execute();
				}
			catch(PDOException $exeception){
		
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for pause data update error.'); </script>");
				
			}
			
		}
		
		if(($status == "pause") && ($results->rowCount() == 1)){
			
			die("<div id='pause_msg' align=\"center\"> Currently the processing of this document has been paused. </div>");	
			
		}
		
		elseif(($status == "unpause") && ($results->rowCount() == 1)){
			
			die("<script type=\"text/javascript\"> jQuery(\"#pause_msg\").dialog(\"destroy\"); </script>");	
			
		}
		
	}
	
}

?>