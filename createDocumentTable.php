<?php

/**
 *
 * Working Class verison
 *
 */

$current_date = date("Y-m-d", (strtotime('now') - (60*60*5)));

$get_document_table = new createDocumentTable($current_date);

die($get_document_table->createDocumentTableData($current_date));

class createDocumentTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createDocumentTableData($current_date){
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		
		$results = $this->hrtsConnection->query("SELECT * FROM `document` WHERE date_received = '$current_date' ORDER BY `document_type`, `internal_number`");
		
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No records found.'); </script>";
			
			$capture_data ="No document have been logged for $current_date";
			fwrite($handle,$capture_data);
			fclose($handle);
			
			die($content);	
			
		}
		
		$document = 'exportFile/document_list.csv';
		$handle = fopen($document, 'w');
		 
		//$content = "<div id=\"datatableFormat2\">";
		$content .= "<div class=\"dataTableTitleFormat\"> DOCUMENT LIST </div>";
		$capture_data = "DOCUMENT LIST\r\n";
		$capture_data .= "\r\n";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"nowrap th_title\"> Date </th><th class=\"nowrap th_title\"> Time </th><th class=\"nowrap th_title\"> Carrier </th><th class=\"nowrap th_title\"> Tracking No. </th><th class=\"nowrap th_title\"> Firm Name </th><th class=\"nowrap th_title\"> Item </th><th class=\"nowrap th_title\"> CD/Other </th><th class=\"nowrap th_title\"> Type </th><th class=\"nowrap th_title\"> To </th></tr>";
		$capture_data .= "Date,Time,Carr,Tracking No.,Firm Name,Item,CD/Other,Type,To\r\n";
		
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
				
				$content .= "<tr>";
				$content .= "<td class=\"tdFormat\">" .date("m/d/Y", (strtotime($row["date_received"]))). " </td>";
				$content .= "<td class=\"tdFormat\">". $row["time"] ."</td>";
				$content .= "<td class=\"tdFormat\">".$row["delivery_company"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["delivery_tracking_number"]."</td>";
				$content .= "<td class=\"tdFormat\">".$row["manufacturer"]."</td>";
				$content .= "<td class=\"tdFormat\">".$report_type."</td>";
				$content .= "<td class=\"tdFormat\">$media_count</td>";
				$content .= "<td class=\"tdFormat\"> $document_type </td>";
				$content .= "<td class=\"tdFormat\">".$row["internal_number"]."</td>";
				$content .= "</tr>";
						
			}
		fwrite($handle,$capture_data);
		fclose($handle);
					
		$content .= "</tbody></table>";
		
		$content .= "<br>";
		$content .= "<h3 id=\"generateReport\"> Generate Report </h3>";
		//$content .= "</div>";
		$content .= "<script type=\"text/javascript\">";
		 
		$content .= "$('.dataTableTitleFormat').css('margin-top', 30);";
		$content .= "$('.dataTableTitleFormat').css('margin-bottom', 20);";
		$content .= "$('.tableFormat2').css('margin-top', 10);";
		$content .= "browserWidth = $(window).width();";
		$content .= "tableWidth = $('.tableFormat2').width();";
		$content .= "adjustedMargin = (browserWidth - tableWidth)/2;";
		$content .= "$('.tableFormat2').css('margin-left', adjustedMargin);";
		$content .= "$('#generateReport').css('margin-left', adjustedMargin);";
		$content .= "$('.dataTableTitleFormat').css('margin-left', adjustedMargin);";
		
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=document_list','_newtab'); e.preventDefault();});";
		$content .="</script>";
		//$content .= "<br>". mysql_num_rows($results);
		
		return $content;

	}
	
}



?>