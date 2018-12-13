<?php

$date = date("Y-m-d", (strtotime($_REQUEST['date'])));

$documents = new dump_document_data();

$documents->get_all_documents($date);

class dump_document_data{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	
	function get_all_documents($date){
		
		$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
		
		//$document = "exportFile/document_dump_$current_date.csv";
		$document = "exportFile/document_dump_$date.csv";
		$handle = fopen($document, 'w');
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		$results = $this->hrtsConnection->query("SELECT * FROM `document` WHERE date_received = '$date' ORDER BY `document_type`, `internal_number`");
		
		//$results = $this->hrtsConnection->query("SELECT * FROM `document` WHERE date_received = '2013-09-13' ORDER BY `document_type`, `internal_number`");
		
		if($results->rowCount() == 0){
				
			$capture_data ="No document have been logged for $date";
			fwrite($handle,$capture_data);
			fclose($handle);	
			header("Location: output_to_csv.php?table_data=document_dump_$date");
		}
		
		else{
		 
			$capture_data = "Date,Time,Carr,Tracking No.,Firm Name,Item,CD/Other,Type,To\r\n";
			
			while($row = $results->fetch(PDO::FETCH_ASSOC)){
				
				$media_count = $row["cd_copies"] + $row["usb_copies"];
				
				if(!empty($row["date_received"]) && !empty($row["time"])){
					$time = date("m/d/Y", (strtotime($row["date_received"]))). " " . $row["time"];
				}
				else{ $time=""; }
				
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
					elseif($row["document_type"] == '2579'){
					
						$document_type = "NA";
						
					}
					
				if($row["document_type"] == 'RAD_HEALTH'){
					
					$report_type = $row["report_type"];	
					
				}
				else{
					$report_type = $row["fda_application_number"];	
				}
					
				$capture_data .= date("m/d/Y", (strtotime($row["date_received"]))). ",".$time.",".$row["delivery_company"].",".$row["delivery_tracking_number"].",".$row["manufacturer"].",".$report_type.",".$media_count.",".$document_type.",".$row["internal_number"]."\r\n";
						
			}
			
			fwrite($handle,$capture_data);
			fclose($handle);
			header("Location: output_to_csv.php?table_data=document_dump_$date");
		}

	}
	
}

?>