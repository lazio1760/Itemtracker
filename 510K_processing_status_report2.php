<?php

include ("hrtsDatabaseConnection.php");

$document_search_table = new createDocumentSearchTable();

die($document_search_table->createDocumentSearchData());

class createDocumentSearchTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createDocumentSearchData(){
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		$document = 'stat_data/pma_processing.csv';
		$handle = fopen($document, 'w');
		 
		$content = "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		$capture_data = "MAIL PROCESSING STATUS\r\n";
		
		//$document = 'exportFile/mail_processing_status.csv';
		//$handle = fopen($document, 'w');
		 
		//$content .= "<div class=\"dataTableTitleFormat\"> MAIL PROCESSING STATUS </div>";
		//$capture_data = "MAIL PROCESSING STATUS\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "PMA Group\r\n";
		$capture_data .= "\r\n";
		$content .= "<div class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> 510K Group </label>";
		//$content .= "<label class=\"textRight\"> In: ". $results->rowCount() ." Out: ". ($missing_results->rowCount() - $results->rowCount()) ."</label>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap\"> Date </th><th class=\"nowrap th_title\"> Count </th><th class=\"nowrap th_title\"> Min Time </th><th class=\"nowrap th_title\"> Max Time </th><th class=\"nowrap th_title\"> AVE Time </th></tr>";
		$capture_data .= "Date,Count,Min Time,Max Time,AVE Time\r\n";
	
			
			try{
				$process_results = $this->hrtsConnection->prepare("SELECT * FROM `pma_processing` WHERE `date_received` BETWEEN '2013-08-09' AND '2013-08-27'");
			
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
				 
				 $minutes[$row["date_received"]][] = $my_hours+$my_minutes+$my_seconds;
			}
			
			foreach($minutes as $key => $value){
				
				$min_value = min($value);
				$max_value = max($value);
				$avg_value = array_sum($value)/count($value);
				
				echo("For $key: min = $min_value, max = $max_value, average = $avg_value <br>"); 	
				
			}
			
			die();
				
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
			
		
					
		$content .= "</tbody></table>";
		
		fwrite($handle,$capture_data);
		fclose($handle);
		
		return $content;
		
	}
	
}

?>