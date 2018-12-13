<?php

$trackingNumber = $_REQUEST["trackingNumber"];
$date = date("Y-m-d", (strtotime($_REQUEST['date'])));
$display_current_date = date("m-d-Y", (strtotime($_REQUEST['date'])));
$manufacturer = $_REQUEST["manufacturer"];

//die($date);

$document_search_table = new createDocumentSearchTable();

die($document_search_table->createDocumentSearchData($trackingNumber,$date,$manufacturer));

class createDocumentSearchTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createDocumentSearchData($trackingNumber,$date,$manufacturer){
		
		//return("works");
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		try{
		$results = $this->hrtsConnection->prepare("SELECT * FROM `document` WHERE date_received = :date AND manufacturer = :manufacturer AND delivery_tracking_number LIKE :trackingNumber");
		
		$results->bindValue(':date', $date, PDO::PARAM_STR);
		$results->bindValue(':trackingNumber', "%$trackingNumber%", PDO::PARAM_STR);
		$results->bindValue(':manufacturer', $manufacturer, PDO::PARAM_STR);
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('Document not found.'); </script>";
			
			return($content);	
			
		}
		
		$document = 'exportFile/document_search.csv';
		$handle = fopen($document, 'w');
		 
		$content = "<div id=\"datatableFormat2\">";
		$content .= "<div class=\"dataTableTitleFormat\"> DOCUMENT SEARCH RESULTS </div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> FDA APPLICATION NUMBER </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> CD </th><th class=\"nowrap th_title\"> PAPER </th><th class=\"nowrap th_title\"> VOLUME </th><th class=\"nowrap th_title\"> MANUFACTURER </th><th class=\"nowrap th_title\"> DELIVERY COMPANY </th><th class=\"nowrap th_title\"> DELIVERY TRACKING NUMBER </th><th class=\"nowrap th_title\"> RECEIPT DATE </th></tr>";
		$capture_data = "INTERNAL NUMBER,FDA APPLICATION NUMBER,DOCUMENT TYPE,CD,PAPER,VOLUME,MANUFACTURER,DELIVERY COMPANY,DELIVERY TRACKING NUMBER,RECEIPT DATE\r\n";
		
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			if($row["document_type"] == '510K'){
					
					$document_type = "K";
					
				}
				elseif($row["document_type"] == 'IDE'){
					
					$document_type = "G";
					
				}
				elseif($row["document_type"] == 'PMA'){
					
					$document_type = "P";
					
				}
				elseif($row["document_type"] == 'RAD_HEALTH'){
				
					$document_type = "R";
					
				}
				elseif($row["document_type"] == 'NA'){
				
					$document_type = "NA";
					
				}
				
				
				if($row["delivery_company"]== "FEDEX"){
					
					$delivery_company = "Fed Ex";
					
				}
				elseif($row["delivery_company"]== "UPS"){
					
					$delivery_company = "UPS";
					
				}
				elseif($row["delivery_company"]== "USPS"){
					
					$delivery_company = "US Postal Service";
					
				}
				elseif($row["delivery_company"]== "AIRBORNE"){
					
					$delivery_company = "Airborne Express";
					
				}
				elseif($row["delivery_company"]== "TNT"){
					
					$delivery_company = "TNT Express";
					
				}
				elseif($row["delivery_company"]== "Other"){
					
					$delivery_company = "Other";

				}
			
			$content .= "<tr><td class=\"tdFormat\">".$row["internal_number"]."</td><td class=\"tdFormat\">".$row["fda_application_number"]."</td><td class=\"tdFormat\">".$document_type."</td><td class=\"tdFormat\">".$row["cd_copies"]."</td><td class=\"tdFormat\">".$row["paper_copies"]."</td><td class=\"tdFormat\">".$row["volume_number"]."</td><td class=\"tdFormat\">".$row["manufacturer"]."</td><td class=\"tdFormat\">".$delivery_company."</td><td class=\"tdFormat\">".$row["delivery_tracking_number"]."</td><td class=\"tdFormat\">".date("m/d/Y", (strtotime($row["date_received"])))."</td></tr>";
			$capture_data .= $row["internal_number"]. ",".$row["fda_application_number"].",".$document_type.",".$row["cd_copies"].",".$row["paper_copies"].",".$row["volume_number"].",".$row["manufacturer"].",".$delivery_company.",".$row["delivery_tracking_number"].",".date("m/d/Y", (strtotime($row["date_received"])))."\r\n";
			//fwrite($handle,$capture_data);
			
			$internal_number = $row["internal_number"];
			$fda_application_number = $row["fda_application_number"];
			$real_document_type = $row["document_type"];
		}
		
		$content .= "</tbody></table>";
		
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> RECEIPT DATE </th><th class=\"nowrap th_title\"> PROCESS START </th><th class=\"nowrap th_title\"> PROCESS END </th><th class=\"nowrap th_title\"> STATUS </th><th class=\"nowrap th_title\"> REPROCESSED </th><th class=\"nowrap th_title\"> REPROCESSED DATE </th><th class=\"nowrap th_title\"> ORIGINAL PROCESSOR </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .="\r\n";
		$capture_data .="INTERNAL NUMBER,DOCUMENT TYPE,RECEIPT DATE,PROCESS START,PROCESS END,STATUS,REPROCESSED,REPROCESSED DATE,ORIGINAL PROCESSOR,MODIFIED BY\r\n";
		
		
		
		if($document_type == "K"){
		
			try{
			$process_results = $this->hrtsConnection->prepare("SELECT * FROM `510k_processing` WHERE date_received = :date AND internal_number = :internal_number");
			
			$process_results->bindValue(':date', $date, PDO::PARAM_STR);
			$process_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
			$process_results->execute();
			}
			
			catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report process status error.'); </script>");
			
			}	
		
		}
		if($document_type == "P"){
		
			try{
			$process_results = $this->hrtsConnection->prepare("SELECT * FROM `pma_processing` WHERE date_received = :date AND internal_number = :internal_number");
			
			$process_results->bindValue(':date', $date, PDO::PARAM_STR);
			$process_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
			$process_results->execute();
			}
			
			catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report process status error.'); </script>");
			
			}		
		
		}
		elseif($document_type == "G"){
		
			try{
			$process_results = $this->hrtsConnection->prepare("SELECT * FROM `ide_processing` WHERE date_received = :date AND internal_number = :internal_number");
			
			$process_results->bindValue(':date', $date, PDO::PARAM_STR);
			$process_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
			$process_results->execute();
			}
			
			catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report process status error.'); </script>");
			
			}		
		
		}
		elseif($document_type == "R"){
		
			try{
			$process_results = $this->hrtsConnection->prepare("SELECT * FROM `rad_processing` WHERE date_received = :date AND internal_number = :internal_number");
			
			$process_results->bindValue(':date', $date, PDO::PARAM_STR);
			$process_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
			$process_results->execute();
			}
			
			catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report process status error.'); </script>");
			
			}		
		
		}
		elseif($document_type == "NA	"){
		
			try{
			$process_results = $this->hrtsConnection->prepare("SELECT * FROM `na_processing` WHERE date_received = :date AND internal_number = :internal_number");
			
			$process_results->bindValue(':date', $date, PDO::PARAM_STR);
			$process_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
			$process_results->execute();
			}
			
			catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report process status error.'); </script>");
			
			}			
		
		}
		
		while($process_row = $process_results->fetch(PDO::FETCH_ASSOC)){
		
			if(!(empty($process_row["status"]))){
				
				if(empty($process_row["reprocessed"])){
					
					$reprocessed_date = " ";	
					
				}
				else{ $reprocessed_date = date("m/d/Y", (strtotime($process_row["date_received"]))); }
									  
				
				$content .= "<tr><td class=\"tdFormat\">".$process_row["internal_number"]."</td><td class=\"tdFormat\">".$document_type."</td><td class=\"tdFormat\">".date("m/d/Y", (strtotime($process_row["date_received"])))."</td><td class=\"tdFormat\">".$process_row["start_process"]."</td><td class=\"tdFormat\">".$process_row["end_process"]."</td><td class=\"tdFormat\">".$process_row["status"]."</td><td class=\"tdFormat\">".$process_row["reprocessed"]."</td><td class=\"tdFormat\">".$reprocessed_date."</td><td class=\"tdFormat\">".$process_row["original_processor"]."</td><td class=\"tdFormat\">".$process_row["modified_by"]."</td></tr>";
				
				$content .= "</tbody></table>";
				
				$capture_data .=$process_row["internal_number"].",$document_type,".date("m/d/Y", (strtotime($process_row["date_received"]))).",".$process_row["start_process"].",".$process_row["end_process"].",".$process_row["status"].",".$process_row["reprocessed"].",".$reprocessed_date.",".$process_row["original_processor"].",".$process_row["modified_by"]."\r\n";
				
			}
			else{
				
				$content .= "</tbody></table>";
				$content .= "<div> The document has not been processed </div>";
			}
			
		}
		
		
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> FDA APPLICATION NUMBER </th><th class=\"nowrap th_title\"> DATE </th><th class=\"nowrap th_title\"> TIME </th><th class=\"nowrap th_title\"> DIVISION </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .="\r\n";
		$capture_data .="INTERNAL NUMBER,DOCUMENT TYPE,FDA APPLICATION NUMBER,DATE,TIME,DIVISION,MODIFIED BY\r\n";
		
		try{
			$mail_logout_results = $this->hrtsConnection->prepare("SELECT * FROM `mail_logout` WHERE fda_application_number = :fda_application_number AND internal_number = :internal_number AND document_type = :document_type");
			
			$mail_logout_results->bindValue(':fda_application_number', $fda_application_number, PDO::PARAM_STR);
			$mail_logout_results->bindValue(':document_type', $real_document_type, PDO::PARAM_STR);
			$mail_logout_results->bindValue(':internal_number', $internal_number, PDO::PARAM_STR);
			$mail_logout_results->execute();
			}
			
			catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report mail logout status error.'); </script>");
			
			}
			
		if($mail_logout_results->rowCount() == 0){
		
		$content .= "</tbody></table>";
		$content .= "<div> The document has not been logged out. </div>";
		//$content .= "The document has not been logged out.";
		$capture_data .="The document has not been logged out.\r\n";
		
		//return($content);	
		
		}
		else{				
			while($mail_logout_row = $mail_logout_results->fetch(PDO::FETCH_ASSOC)){
			
				$content .= "<tr><td class=\"tdFormat\">".$mail_logout_row["internal_number"]."</td><td class=\"tdFormat\">".$mail_logout_row["document_type"]."</td><td class=\"tdFormat\">".$mail_logout_row["fda_application_number"]."</td><td class=\"tdFormat\">".date("m/d/Y", (strtotime($mail_logout_row["date"])))."</td><td class=\"tdFormat\">".$mail_logout_row["time"]."</td><td class=\"tdFormat\">".$mail_logout_row["division"]."</td><td class=\"tdFormat\">".$mail_logout_row["modified_by"]."</td></tr>";
					
					$content .= "</tbody></table>";
					
					$capture_data .=$mail_logout_row["internal_number"].",".$mail_logout_row["document_type"].",".$mail_logout_row["fda_application_number"].",".date("m/d/Y", (strtotime($mail_logout_row["date"]))).",".$mail_logout_row["time"].",".$mail_logout_row["division"].",".$mail_logout_row["modified_by"]."\r\n";	
				
			}
		}
		
		fwrite($handle,$capture_data);
		fclose($handle);
		$content .= "<br>";
		$content .= "<h3 id=\"generateReport\"> Generate Report </h3>";
		$content .= "</div>";
		$content .= "<script type=\"text/javascript\">"; 
		$content .= "adjust_div_position();";
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=document_search','_newtab'); e.preventDefault();});";
		$content .="</script>";
		//$content .= "<br>". mysql_num_rows($results);
		
		return $content;

	}
	
	
}

?>