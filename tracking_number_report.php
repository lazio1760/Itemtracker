<?php

$trackingNumber = $_REQUEST["trackingNumber"];
$deliveryCompany = $_REQUEST["deliveryCompany"];

$document_search_table = new createDocumentSearchTable();

die($document_search_table->createDocumentSearchData($trackingNumber,$deliveryCompany));

class createDocumentSearchTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createDocumentSearchData($trackingNumber,$deliveryCompany){
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		try{
		$results = $this->hrtsConnection->prepare("SELECT * FROM `document` WHERE delivery_company = :deliveryCompany AND delivery_tracking_number LIKE :trackingNumber");
	
		$results->bindValue(':trackingNumber', "%$trackingNumber%", PDO::PARAM_STR);
		$results->bindValue(':deliveryCompany', $deliveryCompany, PDO::PARAM_STR);
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
			
		}
		
		$document = 'exportFile/tracking_number_search.csv';
		$handle = fopen($document, 'w');
		 
		$content = "<div class=\"dataTableTitleFormat\"> SEARCHED BY TRACKING NUMBER </div>";
		$capture_data = "SEARCHED BY TRACKING NUMBER\r\n";
		$capture_data .= "\r\n";
		
		if($results->rowCount() != 0){
		
			$content .= "<table class=\"tableFormat2\"><tbody>";
			$content .= "<tr><th class=\"nowrap th_title\"> INTERNAL NUMBER </th><th class=\"nowrap th_title\"> FDA APPLICATION NUMBER </th><th class=\"nowrap th_title\"> DOCUMENT TYPE </th><th class=\"nowrap th_title\"> eCOPY </th><th class=\"nowrap th_title\"> PAPER </th><th class=\"nowrap th_title\"> VOLUME </th><th class=\"nowrap th_title\"> MANUFACTURER </th><th class=\"nowrap th_title\"> DELIVERY COMPANY </th><th class=\"nowrap th_title\"> DELIVERY TRACKING NUMBER </th><th class=\"nowrap th_title\"> RECEIPT DATE </th></tr>";
			$capture_data .= "INTERNAL NUMBER,FDA APPLICATION NUMBER,DOCUMENT TYPE,eCOPY,PAPER,VOLUME,MANUFACTURER,DELIVERY COMPANY,DELIVERY TRACKING NUMBER,RECEIPT DATE\r\n";
			
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
				elseif($row["document_type"] == '513G'){
				
					$document_type = "C";
					
				}
				elseif($row["document_type"] == '2579'){
				
					$document_type = "NA";
					
				}
				
				if($row["delivery_company"]== "FEDEX"){
					
					$delivery_company = "Fed Ex";
					
				}
				elseif($row["delivery_company"]== "FEDEXG"){
						
						$delivery_company = "Fed Ex Ground";
						
				}
				elseif($row["delivery_company"]== "Hogan Lovells"){
						
						$delivery_company = "Hogan Lovells";
						
				}
				elseif($row["delivery_company"]== "UPS"){
					
					$delivery_company = "UPS";
					
				}
				elseif($row["delivery_company"]== "USPS"){
					
					$delivery_company = "US Postal Service";
					
				}
				elseif($row["delivery_company"]== "DHL"){
					
					$delivery_company = "DHL";
					
				}
				elseif($row["delivery_company"]== "TNT"){
					
					$delivery_company = "TNT Express";
					
				}
				elseif($row["delivery_company"]== "Other"){
					
					$delivery_company = "Other";

				}
				elseif($row["delivery_company"]== "FDA Personnel"){
					
					$delivery_company = "FDA Personnel";

				}
				elseif($row["delivery_company"]== "Gateway/PDF"){
					
					$delivery_company = "Gateway/PDF";

				}
				
				$content .= "<tr><td class=\"tdFormat\">".$row["internal_number"]."</td><td class=\"tdFormat\">".$row["fda_application_number"]."</td><td class=\"tdFormat\">".$document_type."</td><td class=\"tdFormat\">".$row["cd_copies"]."</td><td class=\"tdFormat\">".$row["paper_copies"]."</td><td class=\"tdFormat\">".$row["volume_number"]."</td><td class=\"tdFormat\">".$row["manufacturer"]."</td><td class=\"tdFormat\">".$delivery_company."</td><td class=\"tdFormat\">".$row["delivery_tracking_number"]."</td><td class=\"tdFormat\">".date("m/d/Y", (strtotime($row["date_received"])))."</td></tr>";
				$capture_data .= $row["internal_number"]. ",".$row["fda_application_number"].",".$document_type.",".$row["cd_copies"].",".$row["paper_copies"].",".$row["volume_number"].",".$row["manufacturer"].",".$delivery_company.",".$row["delivery_tracking_number"].",".date("m/d/Y", (strtotime($row["date_received"])))."\r\n";
				//fwrite($handle,$capture_data);		
			}
			
			$content .= "</tbody></table>";
		}
		
		elseif($results->rowCount() == 0){
			
			try{
				$results = $this->hrtsConnection->prepare("SELECT * FROM `mis_routed` WHERE delivery_company = :deliveryCompany AND delivery_tracking_number LIKE :trackingNumber");
			
				$results->bindValue(':trackingNumber', "%$trackingNumber%", PDO::PARAM_STR);
				$results->bindValue(':deliveryCompany', $deliveryCompany, PDO::PARAM_STR);
				$results->execute();
			}
			
			catch(PDOException $exeception){
				
				$error_document = 'errors/error_report.txt';
				$error_handle = fopen($error_document, 'w');
				fwrite($error_handle,$exeception->getMessage());
				fclose($error_handle);
				die("<script type=\"text/javascript\"> alert('Check log for document search report error.'); </script>");
				
			}
			
			$document = 'exportFile/tracking_number_search.csv';
			$handle = fopen($document, 'w');
			 
			$content = "<div class=\"dataTableTitleFormat\"> SEARCHED BY TRACKING NUMBER </div>";
			$capture_data = "SEARCHED BY TRACKING NUMBER\r\n";
			$capture_data .= "\r\n";
			
			if($results->rowCount() != 0){
			
				$content .= "<table class=\"tableFormat2\"><tbody>";
				$content .= "<tr><th class=\"nowrap\"> DELIVERY TRACKING NUMBER </th><th class=\"nowrap th_title\"> DELIVERY COMPANY </th><th class=\"nowrap th_title\"> DELIVERY INFORMATION </th><th class=\"nowrap th_title\"> RECEIPT DATE </th><th class=\"nowrap th_title\"> COMMENT </th><th class=\"nowrap th_title\"> MODIFIED BY </th></tr>";
				$capture_data .= "DELIVERY TRACKING NUMBER,DELIVERY COMPANY,DELIVERY INFORMATION,RECEIPT DATE,COMMENT,MODIFIED BY\r\n";
				
				while($row = $results->fetch(PDO::FETCH_ASSOC)){
						
						
						if($row["delivery_company"]== "FEDEX"){
							
							$delivery_company = "Fed Ex";
							
						}
						elseif($row["delivery_company"]== "UPS"){
							
							$delivery_company = "UPS";
							
						}
						elseif($row["delivery_company"]== "USPS"){
							
							$delivery_company = "US Postal Service";
							
						}
						elseif($row["delivery_company"]== "DHL"){
							
							$delivery_company = "DHL";
							
						}
						elseif($row["delivery_company"]== "TNT"){
							
							$delivery_company = "TNT Express";
							
						}
						elseif($row["delivery_company"]== "Other"){
							
							$delivery_company = "Other";
		
						}
					
					$content .= "<tr><td class=\"tdFormat\">".$row["delivery_tracking_number"]."</td>";
					$content .= "<td class=\"tdFormat\">".$delivery_company."</td>";
					$content .= "<td class=\"tdFormat\">".$row["delivery_add_info"]."</td>";
					$content .= "<td class=\"tdFormat\">".date("m/d/Y", (strtotime($row["date_received"])))."</td>";
					$content .= "<td class=\"tdFormat\">".$row["comment"]."</td>";
					$content .= "<td class=\"tdFormat\">".$row["modified_by"]."</td></tr>";
					
					$capture_data .= $row["delivery_tracking_number"]. ",".$delivery_company.",".$row["delivery_add_info"].",".date("m/d/Y", (strtotime($row["date_received"]))).",".$row["comment"].",".$row["modified_by"]."\r\n";
					//fwrite($handle,$capture_data);		
				}
				
				$content .= "</tbody></table>";
					
			}
			else{
					$content = "<script type=\"text/javascript\"> alert('Mail not found.'); </script>";
				
					return($content);
					
			}
		}
		
		fwrite($handle,$capture_data);
		fclose($handle);
					
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
		
		
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=tracking_number_search','_newtab'); e.preventDefault();});";
		$content .="</script>";
		//$content .= "<br>". mysql_num_rows($results);
		
		return $content;

	}
	
	
}


?>