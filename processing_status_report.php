<?php

$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));

//die($current_date);

$document_search_table = new createDocumentSearchTable();

die($document_search_table->createDocumentSearchData($current_date));

class createDocumentSearchTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createDocumentSearchData($current_date){
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		$document = 'exportFile/mail_processing_status.csv';
		$handle = fopen($document, 'w');
		 
		$content = "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		$capture_data = "MAIL PROCESSING STATUS\r\n";
		
		try{
		$results = $this->hrtsConnection->prepare("SELECT internal_number FROM `document` Where date_received = '$current_date' AND document_type = '510K'");
	
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		/*
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No mail has been logged in for ".date("m-d-Y", (strtotime($current_date))).".'); </script>";
			
			return($content);	
			
		}
		*/
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$internal_number_510K[] = $row[internal_number];
			
		}
		
		//$document = 'exportFile/mail_processing_status.csv';
		//$handle = fopen($document, 'w');
		 
		//$content .= "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		//$capture_data = "MAIL PROCESSING STATUS\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "510K Group\r\n";
		$capture_data .= "\r\n";
		$content .= "<div class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> 510K Group </label>";
		//$content .= "<label class=\"textRight\"> In: ". $results->rowCount() ." Out: ". ($missing_results->rowCount() - $results->rowCount()) ."</label>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DATE RECEIVED </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> START DATE </th><th class=\"nowrap th_title\"> START TIME </th><th class=\"nowrap th_title\"> END DATE </th><th class=\"nowrap th_title\"> END TIME </th><th class=\"nowrap th_title\"> PROCESS TIME </th><th class=\"nowrap th_title\"> STATUS </th><th class=\"nowrap th_title\"> REPROCESSED </th><th class=\"nowrap th_title\"> ORIGINAL PROCESSOR </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .= "INTERNAL NUMBER,DATE RECEIVED,DOCUMENT TYPE,START DATE,START TIME,END DATE,END TIME,PROCESS TIME,STATUS,REPROCESSED,ORIGINAL PROCESSOR,MODIFIED BY\r\n";
		
		foreach($internal_number_510K as $internal_number_value){	
			
			try{
				$process_results = $this->hrtsConnection->prepare("SELECT * FROM `510k_processing` Where id = (select max(id) from `510k_processing` Where internal_number = $internal_number_value AND date_received = '$current_date')");
			
				$process_results->execute();
			}
			
			catch(PDOException $exeception){
				
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail processing status report error.'); </script>");
				
			}
			
			while($row = $process_results->fetch(PDO::FETCH_ASSOC)){
				
				$login_time = new DateTime($row["start_process"]);
				$logout_time = new DateTime($row["end_process"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 $my_seconds = $login_time->diff($logout_time)->format('%s');
				 
				 $my_hours = round($my_hours*60,2);
				 $my_seconds = round($my_seconds/60,2);
				 
				 //$my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes+$my_seconds;
				
				$content .= "<tr>";
				$content .= "<td class=\"tdFormat\">".$row["internal_number"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["date_received"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["document_type"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["start_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["start_process"]."</td>";
				if($row["end_date"] == "0000-00-00"){
				$content .= "<td class=\"tdFormat\"></td>";
				$content .= "<td class=\"tdFormat\"></td>";
				$content .= "<td class=\"tdFormat\"></td>";	
				}
				else{
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["end_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["end_process"]."</td>";
				$content .= "<td class=\"tdFormat\">$hours</td>";
				}
				$content .= "<td class=\"tdFormat\">".$row["status"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["reprocessed"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["original_processor"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["modified_by"]."</td>";
				$content .= "</tr>";
				
				$capture_data .= "".$row["internal_number"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["date_received"]))).",";
				$capture_data .= "".$row["document_type"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["start_date"]))).",";
				$capture_data .= "".$row["start_process"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["end_date"]))).",";
				$capture_data .= "".$row["end_process"].",";
				$capture_data .= "$hours,";
				$capture_data .= "".$row["status"].",";
				$capture_data .= "".$row["reprocessed"].",";
				$capture_data .= "".$row["original_processor"].",";
				$capture_data .= "".$row["modified_by"]."";
				$capture_data .= "\r\n";
				
			}
			
		}
					
		$content .= "</tbody></table>";
		
		if($results->rowCount() == 0){ $content .="<div class=\"stat_bar\"> No 510K mail logged.</div>"; }
		
/*********************************************************************************************************************************************/	

try{
		$results = $this->hrtsConnection->prepare("SELECT internal_number FROM `document` Where date_received = '$current_date' AND document_type = 'IDE'");
	
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		/*
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No mail has been logged in for ".date("m-d-Y", (strtotime($current_date))).".'); </script>";
			
			return($content);	
			
		}
		*/
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$internal_number_IDE[] = $row[internal_number];
			
		}
		
		//$document = 'exportFile/mail_processing_status.csv';
		//$handle = fopen($document, 'w');
		 
		//$content .= "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		//$capture_data = "MAIL PROCESSING STATUS\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "IDE Group\r\n";
		$capture_data .= "\r\n";
		$content .= "<div id=\"ide\" class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> IDE Group </label>";
		//$content .= "<label class=\"textRight\"> Count: ". count($internal_number_IDE) ."</label>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DATE RECEIVED </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> START DATE </th><th class=\"nowrap th_title\"> START TIME </th><th class=\"nowrap th_title\"> END DATE </th><th class=\"nowrap th_title\"> END TIME </th><th class=\"nowrap th_title\"> PROCESS TIME </th><th class=\"nowrap th_title\"> STATUS </th><th class=\"nowrap th_title\"> REPROCESSED </th><th class=\"nowrap th_title\"> ORIGINAL PROCESSOR </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .= "INTERNAL NUMBER,DATE RECEIVED,DOCUMENT TYPE,START DATE,START TIME,END DATE,END TIME,PROCESS TIME,STATUS,REPROCESSED,ORIGINAL PROCESSOR,MODIFIED BY\r\n";
		
		foreach($internal_number_IDE as $internal_number_value){	
			
			try{
				$process_results = $this->hrtsConnection->prepare("SELECT * FROM `ide_processing` Where id = (select max(id) from `ide_processing` Where internal_number = $internal_number_value AND date_received = '$current_date')");
			
				$process_results->execute();
			}
			
			catch(PDOException $exeception){
				
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail processing status report error.'); </script>");
				
			}
			
			while($row = $process_results->fetch(PDO::FETCH_ASSOC)){
				
				$login_time = new DateTime($row["start_process"]);
				$logout_time = new DateTime($row["end_process"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 $my_seconds = $login_time->diff($logout_time)->format('%s');
				 
				 $my_hours = round($my_hours*60,2);
				 $my_seconds = round($my_seconds/60,2);
				 
				 //$my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes+$my_seconds;
				
				$content .= "<tr>";
				$content .= "<td class=\"tdFormat\">".$row["internal_number"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["date_received"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["document_type"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["start_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["start_process"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["end_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["end_process"]."</td>";
				$content .= "<td class=\"tdFormat\">$hours</td>";
				$content .= "<td class=\"tdFormat\">".$row["status"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["reprocessed"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["original_processor"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["modified_by"]."</td>";
				$content .= "</tr>";
				
				$capture_data .= "".$row["internal_number"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["date_received"]))).",";
				$capture_data .= "".$row["document_type"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["start_date"]))).",";
				$capture_data .= "".$row["start_process"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["end_date"]))).",";
				$capture_data .= "".$row["end_process"].",";
				$capture_data .= "$hours,";
				$capture_data .= "".$row["status"].",";
				$capture_data .= "".$row["reprocessed"].",";
				$capture_data .= "".$row["original_processor"].",";
				$capture_data .= "".$row["modified_by"]."";
				$capture_data .= "\r\n";
				
			}
			
		}
					
		$content .= "</tbody></table>";
		
		if($results->rowCount() == 0){ $content .="<div class=\"stat_bar\"> No IDE mail logged.</div>"; }
		
/*********************************************************************************************************************************************/		

try{
		$results = $this->hrtsConnection->prepare("SELECT internal_number FROM `document` Where date_received = '$current_date' AND document_type = 'PMA'");
	
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		/*
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No mail has been logged in for ".date("m-d-Y", (strtotime($current_date))).".'); </script>";
			
			return($content);	
			
		}
		*/
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$internal_number_PMA[] = $row[internal_number];
			
		}
		
		//$document = 'exportFile/mail_processing_status.csv';
		//$handle = fopen($document, 'w');
		 
		//$content .= "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		//$capture_data = "MAIL PROCESSING STATUS\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "PMA Group\r\n";
		$capture_data .= "\r\n";
		$content .= "<div id=\"pma\" class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> PMA Group </label>";
		//$content .= "<label class=\"textRight\"> Count: ". count($internal_number_IDE) ."</label>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DATE RECEIVED </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> START DATE </th><th class=\"nowrap th_title\"> START TIME </th><th class=\"nowrap th_title\"> END DATE </th><th class=\"nowrap th_title\"> END TIME </th><th class=\"nowrap th_title\"> PROCESS TIME </th><th class=\"nowrap th_title\"> STATUS </th><th class=\"nowrap th_title\"> REPROCESSED </th><th class=\"nowrap th_title\"> ORIGINAL PROCESSOR </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .= "INTERNAL NUMBER,DATE RECEIVED,DOCUMENT TYPE,START DATE,START TIME,END DATE,END TIME,PROCESS TIME,STATUS,REPROCESSED,ORIGINAL PROCESSOR,MODIFIED BY\r\n";
		
		foreach($internal_number_PMA as $internal_number_value){	
			
			try{
				$process_results = $this->hrtsConnection->prepare("SELECT * FROM `pma_processing` Where id = (select max(id) from `pma_processing` Where internal_number = $internal_number_value AND date_received = '$current_date')");
			
				$process_results->execute();
			}
			
			catch(PDOException $exeception){
				
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail processing status report error.'); </script>");
				
			}
			
			while($row = $process_results->fetch(PDO::FETCH_ASSOC)){
				
				$login_time = new DateTime($row["start_process"]);
				$logout_time = new DateTime($row["end_process"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 $my_seconds = $login_time->diff($logout_time)->format('%s');
				 
				 $my_hours = round($my_hours*60,2);
				 $my_seconds = round($my_seconds/60,2);
				 
				 //$my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes+$my_seconds;
				
				$content .= "<tr>";
				$content .= "<td class=\"tdFormat\">".$row["internal_number"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["date_received"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["document_type"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["start_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["start_process"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["end_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["end_process"]."</td>";
				$content .= "<td class=\"tdFormat\">$hours</td>";
				$content .= "<td class=\"tdFormat\">".$row["status"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["reprocessed"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["original_processor"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["modified_by"]."</td>";
				$content .= "</tr>";
				
				$capture_data .= "".$row["internal_number"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["date_received"]))).",";
				$capture_data .= "".$row["document_type"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["start_date"]))).",";
				$capture_data .= "".$row["start_process"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["end_date"]))).",";
				$capture_data .= "".$row["end_process"].",";
				$capture_data .= "$hours,";
				$capture_data .= "".$row["status"].",";
				$capture_data .= "".$row["reprocessed"].",";
				$capture_data .= "".$row["original_processor"].",";
				$capture_data .= "".$row["modified_by"]."";
				$capture_data .= "\r\n";
				
			}
			
		}
					
		$content .= "</tbody></table>";
		
		if($results->rowCount() == 0){ $content .="<div class=\"stat_bar\"> No PMA mail logged.</div>"; }
		
/*********************************************************************************************************************************************/			

try{
		$results = $this->hrtsConnection->prepare("SELECT internal_number FROM `document` Where date_received = '$current_date' AND document_type = 'RAD_HEALTH'");
	
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		/*
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No mail has been logged in for ".date("m-d-Y", (strtotime($current_date))).".'); </script>";
			
			return($content);	
			
		}
		*/
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$internal_number_RAD[] = $row[internal_number];
			
		}
		
		//$document = 'exportFile/mail_processing_status.csv';
		//$handle = fopen($document, 'w');
		 
		//$content .= "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		//$capture_data = "MAIL PROCESSING STATUS\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "Rad Health Group\r\n";
		$capture_data .= "\r\n";
		$content .= "<div id=\"rad\" class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> Rad Health Group </label>";
		//$content .= "<label class=\"textRight\"> Count: ". count($internal_number_IDE) ."</label>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DATE RECEIVED </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> START DATE </th><th class=\"nowrap th_title\"> START TIME </th><th class=\"nowrap th_title\"> END DATE </th><th class=\"nowrap th_title\"> END TIME </th><th class=\"nowrap th_title\"> PROCESS TIME </th><th class=\"nowrap th_title\"> STATUS </th><th class=\"nowrap th_title\"> REPROCESSED </th><th class=\"nowrap th_title\"> ORIGINAL PROCESSOR </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .= "INTERNAL NUMBER,DATE RECEIVED,DOCUMENT TYPE,START DATE,START TIME,END DATE,END TIME,PROCESS TIME,STATUS,REPROCESSED,ORIGINAL PROCESSOR,MODIFIED BY\r\n";
		
		
		
		foreach($internal_number_RAD as $internal_number_value){	
			
			try{
				$process_results = $this->hrtsConnection->prepare("SELECT * FROM `rad_processing` Where id = (select max(id) from `rad_processing` Where internal_number = $internal_number_value AND date_received = '$current_date')");
			
				$process_results->execute();
			}
			
			catch(PDOException $exeception){
				
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail processing status report error.'); </script>");
				
			}
			
			while($row = $process_results->fetch(PDO::FETCH_ASSOC)){
				
				$login_time = new DateTime($row["start_process"]);
				$logout_time = new DateTime($row["end_process"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 $my_seconds = $login_time->diff($logout_time)->format('%s');
				 
				 $my_hours = round($my_hours*60,2);
				 $my_seconds = round($my_seconds/60,2);
				 
				 //$my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes+$my_seconds;
				
				$content .= "<tr>";
				$content .= "<td class=\"tdFormat\">".$row["internal_number"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["date_received"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["document_type"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["start_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["start_process"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["end_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["end_process"]."</td>";
				$content .= "<td class=\"tdFormat\">$hours</td>";
				$content .= "<td class=\"tdFormat\">".$row["status"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["reprocessed"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["original_processor"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["modified_by"]."</td>";
				$content .= "</tr>";
				
				$capture_data .= "".$row["internal_number"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["date_received"]))).",";
				$capture_data .= "".$row["document_type"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["start_date"]))).",";
				$capture_data .= "".$row["start_process"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["end_date"]))).",";
				$capture_data .= "".$row["end_process"].",";
				$capture_data .= "$hours,";
				$capture_data .= "".$row["status"].",";
				$capture_data .= "".$row["reprocessed"].",";
				$capture_data .= "".$row["original_processor"].",";
				$capture_data .= "".$row["modified_by"]."";
				$capture_data .= "\r\n";
				
			}
			
		}
					
		$content .= "</tbody></table>";
		
		if($results->rowCount() == 0){ $content .="<div class=\"stat_bar\"> No Rad Health mail logged.</div>"; }
		
/*********************************************************************************************************************************************/	

	try{
		$results = $this->hrtsConnection->prepare("SELECT internal_number FROM `document` Where date_received = '$current_date' AND document_type = '513G'");
	
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		/*
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No mail has been logged in for ".date("m-d-Y", (strtotime($current_date))).".'); </script>";
			
			return($content);	
			
		}
		*/
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$internal_number_513G[] = $row[internal_number];
			
		}
		
		//$document = 'exportFile/mail_processing_status.csv';
		//$handle = fopen($document, 'w');
		 
		//$content .= "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		//$capture_data = "MAIL PROCESSING STATUS\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "513G Group\r\n";
		$capture_data .= "\r\n";
		$content .= "<div id=\"513g\" class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> 513G Group </label>";
		//$content .= "<label class=\"textRight\"> Count: ". count($internal_number_IDE) ."</label>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DATE RECEIVED </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> START DATE </th><th class=\"nowrap th_title\"> START TIME </th><th class=\"nowrap th_title\"> END DATE </th><th class=\"nowrap th_title\"> END TIME </th><th class=\"nowrap th_title\"> PROCESS TIME </th><th class=\"nowrap th_title\"> STATUS </th><th class=\"nowrap th_title\"> REPROCESSED </th><th class=\"nowrap th_title\"> ORIGINAL PROCESSOR </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .= "INTERNAL NUMBER,DATE RECEIVED,DOCUMENT TYPE,START DATE,START TIME,END DATE,END TIME,PROCESS TIME,STATUS,REPROCESSED,ORIGINAL PROCESSOR,MODIFIED BY\r\n";
		
		
		
		foreach($internal_number_513G as $internal_number_value){	
			
			try{
				$process_results = $this->hrtsConnection->prepare("SELECT * FROM `513g_processing` Where id = (select max(id) from `513g_processing` Where internal_number = $internal_number_value AND date_received = '$current_date')");
			
				$process_results->execute();
			}
			
			catch(PDOException $exeception){
				
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail processing status report error.'); </script>");
				
			}
			
			while($row = $process_results->fetch(PDO::FETCH_ASSOC)){
				
				$login_time = new DateTime($row["start_process"]);
				$logout_time = new DateTime($row["end_process"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 $my_seconds = $login_time->diff($logout_time)->format('%s');
				 
				 $my_hours = round($my_hours*60,2);
				 $my_seconds = round($my_seconds/60,2);
				 
				 //$my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes+$my_seconds;
				
				$content .= "<tr>";
				$content .= "<td class=\"tdFormat\">".$row["internal_number"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["date_received"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["document_type"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["start_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["start_process"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["end_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["end_process"]."</td>";
				$content .= "<td class=\"tdFormat\">$hours</td>";
				$content .= "<td class=\"tdFormat\">".$row["status"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["reprocessed"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["original_processor"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["modified_by"]."</td>";
				$content .= "</tr>";
				
				$capture_data .= "".$row["internal_number"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["date_received"]))).",";
				$capture_data .= "".$row["document_type"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["start_date"]))).",";
				$capture_data .= "".$row["start_process"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["end_date"]))).",";
				$capture_data .= "".$row["end_process"].",";
				$capture_data .= "$hours,";
				$capture_data .= "".$row["status"].",";
				$capture_data .= "".$row["reprocessed"].",";
				$capture_data .= "".$row["original_processor"].",";
				$capture_data .= "".$row["modified_by"]."";
				$capture_data .= "\r\n";
				
			}
			
		}
					
		$content .= "</tbody></table>";
		
		if($results->rowCount() == 0){ $content .="<div class=\"stat_bar\"> No 513G Health mail logged.</div>"; }
		
/*********************************************************************************************************************************************/	

	try{
		$results = $this->hrtsConnection->prepare("SELECT internal_number FROM `document` Where date_received = '$current_date' AND document_type = '2579'");
	
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		/*
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No mail has been logged in for ".date("m-d-Y", (strtotime($current_date))).".'); </script>";
			
			return($content);	
			
		}
		*/
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$internal_number_2579[] = $row[internal_number];
			
		}
		
		//$document = 'exportFile/mail_processing_status.csv';
		//$handle = fopen($document, 'w');
		 
		//$content .= "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		//$capture_data = "MAIL PROCESSING STATUS\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "2579 Group\r\n";
		$capture_data .= "\r\n";
		$content .= "<div id=\"2579\" class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> 2579 Group </label>";
		//$content .= "<label class=\"textRight\"> Count: ". count($internal_number_IDE) ."</label>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> DATE RECEIVED </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> START DATE </th><th class=\"nowrap th_title\"> START TIME </th><th class=\"nowrap th_title\"> END DATE </th><th class=\"nowrap th_title\"> END TIME </th><th class=\"nowrap th_title\"> PROCESS TIME </th><th class=\"nowrap th_title\"> STATUS </th><th class=\"nowrap th_title\"> REPROCESSED </th><th class=\"nowrap th_title\"> ORIGINAL PROCESSOR </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
		$capture_data .= "INTERNAL NUMBER,DATE RECEIVED,DOCUMENT TYPE,START DATE,START TIME,END DATE,END TIME,PROCESS TIME,STATUS,REPROCESSED,ORIGINAL PROCESSOR,MODIFIED BY\r\n";
		
		
		
		foreach($internal_number_2579 as $internal_number_value){	
			
			try{
				$process_results = $this->hrtsConnection->prepare("SELECT * FROM `2579_processing` Where id = (select max(id) from `2579_processing` Where internal_number = $internal_number_value AND date_received = '$current_date')");
			
				$process_results->execute();
			}
			
			catch(PDOException $exeception){
				
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for mail processing status report error.'); </script>");
				
			}
			
			while($row = $process_results->fetch(PDO::FETCH_ASSOC)){
				
				$login_time = new DateTime($row["start_process"]);
				$logout_time = new DateTime($row["end_process"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 $my_seconds = $login_time->diff($logout_time)->format('%s');
				 
				 $my_hours = round($my_hours*60,2);
				 $my_seconds = round($my_seconds/60,2);
				 
				 //$my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes+$my_seconds;
				
				$content .= "<tr>";
				$content .= "<td class=\"tdFormat\">".$row["internal_number"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["date_received"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["document_type"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["start_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["start_process"]."</td>";
				$content .= "<td class=\"tdFormat\">".date("m-d-Y", (strtotime($row["end_date"])))."</td>";
				$content .= "<td class=\"tdFormat\">".$row["end_process"]."</td>";
				$content .= "<td class=\"tdFormat\">$hours</td>";
				$content .= "<td class=\"tdFormat\">".$row["status"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["reprocessed"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["original_processor"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["modified_by"]."</td>";
				$content .= "</tr>";
				
				$capture_data .= "".$row["internal_number"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["date_received"]))).",";
				$capture_data .= "".$row["document_type"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["start_date"]))).",";
				$capture_data .= "".$row["start_process"].",";
				$capture_data .= "".date("m-d-Y", (strtotime($row["end_date"]))).",";
				$capture_data .= "".$row["end_process"].",";
				$capture_data .= "$hours,";
				$capture_data .= "".$row["status"].",";
				$capture_data .= "".$row["reprocessed"].",";
				$capture_data .= "".$row["original_processor"].",";
				$capture_data .= "".$row["modified_by"]."";
				$capture_data .= "\r\n";
				
			}
			
		}
					
		$content .= "</tbody></table>";
		
		if($results->rowCount() == 0){ $content .="<div class=\"stat_bar\"> No 2579 mail logged.</div>"; }
		
		/************************************************************************************************************/		
		
		fwrite($handle,$capture_data);
		fclose($handle);
		
		$content .= "<br>";
		$content .= "<h3 id=\"generateReport\"> Generate Report </h3>";
		//$content .= "</div>";
		$content .= "<script type=\"text/javascript\">";
		 
		$content .= "$('.dataTableTitleFormat').css('margin-top', 30);";
		$content .= "$('.dataTableTitleFormat').css('margin-bottom', 20);";
		$content .= "$('#ide').css('margin-top', 20);";
		$content .= "$('#pma').css('margin-top', 20);";
		$content .= "$('#rad').css('margin-top', 20);";
		$content .= "$('#513g').css('margin-top', 20);";
		$content .= "$('#2579').css('margin-top', 20);";
		$content .= "$('#stat_bar').css('margin-top', 20);";
		$content .= "$('#stat_bar').css('margin-bottom', 5);";
		$content .= "$('.tableFormat2').css('margin-top', 10);";
		$content .= "browserWidth = $(window).width();";
		$content .= "tableWidth = $('.tableFormat2').width();";
		$content .= "adjustedMargin = (browserWidth - tableWidth)/2;";
		$content .= "$('.tableFormat2').css('margin-left', adjustedMargin);";
		$content .= "$('#generateReport').css('margin-left', adjustedMargin);";
		$content .= "$('#generateReport').css('margin-bottom', 10);";
		$content .= "$('.dataTableTitleFormat').css('margin-left', adjustedMargin);";
		$content .= "$('.stat_bar').css('margin-left', adjustedMargin);";
		$content .= "$('.stat_bar').css('width', tableWidth);";
		$content .= "$('.textRight').css('margin-left', (tableWidth/2));";
		$content .= "$('#mainDiv').css('background-image', 'none');";
		
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=mail_processing_status','_newtab'); e.preventDefault();});";
		$content .="</script>";
		//$content .= "<br>". mysql_num_rows($results);
		
		return $content;

	}
	
}

?>