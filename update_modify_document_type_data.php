<?php

include ("hrtsDatabaseConnection.php");

$internal_number = trim($_REQUEST['internal_number']);
$receiptDate = trim(date("Y-m-d", (strtotime($_REQUEST['receiptDate']))));
$documentType = trim($_REQUEST['documentType']);
$documentType_old = trim($_REQUEST['documentType_old']);
$modified = trim($_REQUEST['modified']);

$search = new update_document_data();

$search->update_document($internal_number,$receiptDate,$documentType,$documentType_old,$modified);

class update_document_data{
	
	public function update_document($internal_number,$receiptDate,$documentType,$documentType_old,$modified){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
	
		try{
		$data_results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE internal_number = :internal_number AND  document_type = :documentType");
		
			$data_results->bindValue(':documentType', $documentType_old, PDO::PARAM_STR);
			$data_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$data_results->execute();
		}
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for get all document type data error.'); </script>");
			
		}
		
		try{
		$max_results = $hrtsConnection->prepare("SELECT MAX(internal_number) AS max_value FROM `document` WHERE document_type = :documentType");
		
			$max_results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
			$max_results->execute();
		}
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for max number document type data error.'); </script>");
		}
		
		$max_row = $max_results->fetch(PDO::FETCH_ASSOC);
		$new_internal_number = 1 + $max_row["max_value"];
		
		/*die("<script type=\"text/javascript\"> alert('".$max_row["max_value"]."'); </script>");*/
		//var_dump($max_row["max_value"]);
		//die($max_row["max_value"]);
		
		//die("$new_internal_number");
		
		try{
		$results = $hrtsConnection->prepare("DELETE FROM `document` WHERE internal_number = :internal_number AND  document_type = :documentType");
		
			$results->bindValue(':documentType', $documentType_old, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for delete document type doc error.'); </script>");
			
		}

		
		if($results->rowCount() == 1){
			
			if($documentType_old == '510K'){
				try{
				$document_type_delete_results = $hrtsConnection->prepare("DELETE FROM `510k_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
				$document_type_delete_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$document_type_delete_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$document_type_delete_results->execute();
				}
				catch(PDOException $exeception){
			
					$document = 'errors/error_report.txt';
					$handle = fopen($document, 'w');
					fwrite($handle,$exeception->getMessage());
					fclose($handle);
					die("<script type=\"text/javascript\"> alert('Check log for delete document type data error.'); </script>");
					
				}
			}
			elseif($documentType_old == 'IDE'){
				try{
				$document_type_delete_results = $hrtsConnection->prepare("DELETE FROM `ide_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
				$document_type_delete_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$document_type_delete_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$document_type_delete_results->execute();
				}
				catch(PDOException $exeception){
			
					$document = 'errors/error_report.txt';
					$handle = fopen($document, 'w');
					fwrite($handle,$exeception->getMessage());
					fclose($handle);
					die("<script type=\"text/javascript\"> alert('Check log for delete document type data error.'); </script>");
					
				}
			}
			elseif($documentType_old == 'PMA'){
				try{
				$document_type_delete_results = $hrtsConnection->prepare("DELETE FROM `pma_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
				$document_type_delete_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$document_type_delete_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$document_type_delete_results->execute();
				}
				catch(PDOException $exeception){
			
					$document = 'errors/error_report.txt';
					$handle = fopen($document, 'w');
					fwrite($handle,$exeception->getMessage());
					fclose($handle);
					die("<script type=\"text/javascript\"> alert('Check log for delete document type data error.'); </script>");
					
				}
			}
			elseif($documentType_old == 'RAD_HEALTH'){
				try{
				$document_type_delete_results = $hrtsConnection->prepare("DELETE FROM `rad_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
				$document_type_delete_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$document_type_delete_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$document_type_delete_results->execute();
				}
				catch(PDOException $exeception){
			
					$document = 'errors/error_report.txt';
					$handle = fopen($document, 'w');
					fwrite($handle,$exeception->getMessage());
					fclose($handle);
					die("<script type=\"text/javascript\"> alert('Check log for delete document type data error.'); </script>");
					
				}
			}
			elseif($documentType_old == '513G'){
				try{
				$document_type_delete_results = $hrtsConnection->prepare("DELETE FROM `513g_processing` WHERE internal_number = :internal_number AND date_received = :receiptDate");
				$document_type_delete_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
				$document_type_delete_results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
				$document_type_delete_results->execute();
				}
				catch(PDOException $exeception){
			
					$document = 'errors/error_report.txt';
					$handle = fopen($document, 'w');
					fwrite($handle,$exeception->getMessage());
					fclose($handle);
					die("<script type=\"text/javascript\"> alert('Check log for delete document type data error.'); </script>");
					
				}
			}
			
		
			/*die("<script type=\"text/javascript\"> alert('Internal number $internal_number document type $documentType received on $receiptDate has been successfully updated.'); </script>");*/
			
		/*}
		
		else{
			
			die("<script type=\"text/javascript\"> alert('Internal number $internal_number document type $documentType received on $receiptDate was not updated.'); </script>");
			
		}*/
		
		
			
				while($new_row = $data_results->fetch(PDO::FETCH_ASSOC)){
					
					$fda_application_number = str_split($new_row["fda_application_number"]);
					
					if($documentType == '510K'){
				
						//$fda_application_number = str_split($new_row["fda_application_number"]);
			
						//var_dump($fda_application_number);
			
						$count = count($fda_application_number);
						
						
						if(($fda_application_number[0] == "M") && ($fda_application_number[1] == "A") && ($fda_application_number[2] == "F")){
							
							$document_type_id = "K";	
							$fdaAppNumber = "$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						else{
							
							$document_type_id = "K";
							$fdaAppNumber = "$fda_application_number[1]$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						$new_fda_number = "$document_type_id$fdaAppNumber/$fdaAppNumberSup";
						//var_dump($new_fda_number);
					}
					elseif($documentType == 'IDE'){
						
						if(($fda_application_number[0] == "M") && ($fda_application_number[1] == "A") && ($fda_application_number[2] == "F")){
							
							$document_type_id = "G";	
							$fdaAppNumber = "$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						else{
							
							$document_type_id = "G";
							$fdaAppNumber = "$fda_application_number[1]$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						$new_fda_number = "$document_type_id$fdaAppNumber/$fdaAppNumberSup";
						//die($new_fda_number);
					}
					elseif($documentType == 'PMA'){
						
						if(($fda_application_number[0] == "M") && ($fda_application_number[1] == "A") && ($fda_application_number[2] == "F")){
							
							$document_type_id = "P";	
							$fdaAppNumber = "$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						else{
							
							$document_type_id = "P";
							$fdaAppNumber = "$fda_application_number[1]$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						$new_fda_number = "$document_type_id$fdaAppNumber/$fdaAppNumberSup";
					}
					elseif($documentType == 'RAD_HEALTH'){
						
						if(($fda_application_number[0] == "M") && ($fda_application_number[1] == "A") && ($fda_application_number[2] == "F")){
							
							$document_type_id = "R";	
							$fdaAppNumber = "$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						else{
							
							$document_type_id = "R";
							$fdaAppNumber = "$fda_application_number[1]$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						$new_fda_number = "$document_type_id$fdaAppNumber/$fdaAppNumberSup";
					}
					elseif($documentType == '513G'){
						
						if(($fda_application_number[0] == "M") && ($fda_application_number[1] == "A") && ($fda_application_number[2] == "F")){
							
							$document_type_id = "C";	
							$fdaAppNumber = "$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						else{
							
							$document_type_id = "C";
							$fdaAppNumber = "$fda_application_number[1]$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
							$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]";
						}
						
						$new_fda_number = "$document_type_id$fdaAppNumber/$fdaAppNumberSup";
					}
			
					try{
					$insert_new_results = $hrtsConnection->prepare("INSERT INTO document (delivery_company,delivery_tracking_number,document_type,fda_application_number,date_received,internal_number,manufacturer,delivery_add_info,cd_copies,paper_copies,volume_number,modified_by) VALUES (:deliveryCompany,:deliveryTracking,:documentType,:fdaAppNumber,:receiptDate,:internal_number,:manufacturer,:moreInfo,:cd,:paper,:volume,:modified)");
					
					$insert_new_results->bindValue(':cd', $new_row["cd_copies"], PDO::PARAM_INT);
					$insert_new_results->bindValue(':paper', $new_row["paper_copies"], PDO::PARAM_INT);
					$insert_new_results->bindValue(':volume', $new_row["volume_number"], PDO::PARAM_STR);
					$insert_new_results->bindValue(':deliveryCompany', $new_row["delivery_company"], PDO::PARAM_STR);
					$insert_new_results->bindValue(':deliveryTracking', $new_row["delivery_tracking_number"], PDO::PARAM_STR);
					$insert_new_results->bindValue(':moreInfo', $new_row["delivery_add_info"], PDO::PARAM_STR);
					$insert_new_results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
					$insert_new_results->bindValue(':fdaAppNumber', $new_fda_number, PDO::PARAM_STR);
					$insert_new_results->bindValue(':manufacturer', $new_row["manufacturer"], PDO::PARAM_STR);
					$insert_new_results->bindValue(':receiptDate', $new_row["date_received"], PDO::PARAM_STR);
					$insert_new_results->bindValue(':modified', $modified, PDO::PARAM_STR);
					$insert_new_results->bindValue(':internal_number', $new_internal_number, PDO::PARAM_INT);
					$insert_new_results->execute();
					}
					catch(PDOException $exeception){
						
						$error_document = 'errors/error_report.txt';
						$error_handle = fopen($error_document, 'w');
						fwrite($error_handle,$exeception->getMessage());
						fclose($error_handle);
						die("<script type=\"text/javascript\"> alert('Check log for update document type insert doc error.'); </script>");
						
					}
					$receiptDate = $new_row["date_received"];
				}
				
				/*if($insert_new_results->rowCount() == 1){
			
					if($documentType == '510K'){
						try{
						$document_type_insert_results = $hrtsConnection->prepare("INSERT INTO `510k_processing` (internal_number,date_received) VALUES(:internal_number,:receiptDate)");
						$document_type_insert_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
						$document_type_insert_results->bindValue(':internal_number', $new_internal_number, PDO::PARAM_INT);
						$document_type_insert_results->execute();
						}
						catch(PDOException $exeception){
			
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for update document type insert error.'); </script>");
							
						}
					}
					elseif($documentType == 'IDE'){
						try{
						$document_type_insert_results = $hrtsConnection->prepare("INSERT INTO `ide_processing` (internal_number,date_received) VALUES(:internal_number,:receiptDate)");
						$document_type_insert_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
						$document_type_insert_results->bindValue(':internal_number', $new_internal_number, PDO::PARAM_INT);
						$document_type_insert_results->execute();
						}
						catch(PDOException $exeception){
			
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for update document type insert error.'); </script>");
							
						}
					}
					elseif($documentType == 'PMA'){
						try{
						$document_type_insert_results = $hrtsConnection->prepare("INSERT INTO `pma_processing` (internal_number,date_received) VALUES(:internal_number,:receiptDate)");
						$document_type_insert_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
						$document_type_insert_results->bindValue(':internal_number', $new_internal_number, PDO::PARAM_INT);
						$document_type_insert_results->execute();
						}
						catch(PDOException $exeception){
			
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for update document type insert error.'); </script>");
							
						}
					}
					elseif($documentType == 'RAD_HEALTH'){
						try{
						$document_type_insert_results = $hrtsConnection->prepare("INSERT INTO `rad_processing` (internal_number,date_received) VALUES(:internal_number,:receiptDate)");
						$document_type_insert_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
						$document_type_insert_results->bindValue(':internal_number', $new_internal_number, PDO::PARAM_INT);
						$document_type_insert_results->execute();
						}
						catch(PDOException $exeception){
			
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for update document type insert error.'); </script>");
							
						}
					}
					elseif($documentType == '513G'){
						try{
						$document_type_insert_results = $hrtsConnection->prepare("INSERT INTO `513g_processing` (internal_number,date_received) VALUES(:internal_number,:receiptDate)");
						$document_type_insert_results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
						$document_type_insert_results->bindValue(':internal_number', $new_internal_number, PDO::PARAM_INT);
						$document_type_insert_results->execute();
						}
						catch(PDOException $exeception){
			
							$document = 'errors/error_report.txt';
							$handle = fopen($document, 'w');
							fwrite($handle,$exeception->getMessage());
							fclose($handle);
							die("<script type=\"text/javascript\"> alert('Check log for update document type insert error.'); </script>");
							
						}
					}
			
			
					/*die("<script type=\"text/javascript\"> alert('A new document has been successfully added.'); </script>");*/
					
				/*}*/
			
			die("<script type=\"text/javascript\"> alert('Internal number $internal_number document type $documentType received on $receiptDate has been successfully updated.'); </script>");
			
		}

	}
}

?>