<?php
	
	$docType = $_REQUEST["type"];
	
	if(isset($docType))
	{
	
	$documents = new operational_detail();

		die($documents->details($docType));
		}

class operational_detail{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	
	function details($docs){
	
		try{	
			
			
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
			$docsName = str_replace('_', ' ', $docs);
			
			$title = array('Received Today', 'Currently Processing', 'Need Information', 'Processed', 'From Yesterday');
			
			if($docs == "510K")
				$output = array( 'tName' => '510k_processing', 'date' => date("Y-m-d", (strtotime('now') - (60*60*4))));
			elseif($docs == "IDE")
				$output = array( 'tName' => 'ide_processing', 'date' => date("Y-m-d", (strtotime('now') - (60*60*4))));
			elseif($docs == "PMA")
				$output = array( 'tName' => 'pma_processing', 'date' => date("Y-m-d", (strtotime('now') - (60*60*4))));
			elseif($docs == "RAD_HEALTH")
				$output = array( 'tName' => 'rad_processing', 'date' => date("Y-m-d", (strtotime('now') - (60*60*4))));
				
			$content = "<div class=\"dataTableTitleFormat\"> Operational Detail for $docsName </div>";
			
			/********************************************************** Received Docs **************************************************************/
			//getting count for 510k received
			$rec_count = $this->hrtsConnection->prepare("SELECT doc.internal_number, doc.fda_application_number, doc.delivery_company, doc.delivery_tracking_number, doc.manufacturer  FROM document doc LEFT JOIN ". $output['tName'] ." tb ON doc.document_type = tb.document_type  WHERE doc.date_received = :date and doc.document_type = '" . $docs ."'");
			
			
			//$rec_docs->bindValue(':tabName', $output['tName'], PDO::PARAM_STR);
			$rec_count->bindValue(':date', $output['date'], PDO::PARAM_STR); 
			$rec_count->execute();
			
			$count = $rec_count -> rowCount();
			
			$content .= "<div class=\"dataTableTitleFormat\">Received Today: $count </div>";
			$content .= "<table class=\"tableFormat2\">
				<tbody>
					<tr>
						<td class=\"tdWidth nowrap th_title\">Internal Number</td>
						<td class=\"tdWidth nowrap th_title\">FDA Number</td>
						<td class=\"tdWidth nowrap th_title\">Shipper</td> 
						<td class=\"tdWidth nowrap th_title\">Tracking Number</td> 
						<td class=\"tdWidth nowrap th_title\">Sponsor</td></tr>";
						
			while($data = $rec_count->fetch(PDO::FETCH_ASSOC)){
			
			$content .= "<tr><td class=\"tdFormat\">". $data["internal_number"] ."</td> <td class=\"tdFormat\">". $data["fda_application_number"]  ."</td> <td class=\"tdFormat\">". $data["delivery_company"]  ."</td> <td class=\"tdFormat\">". $data["delivery_tracking_number"] ."</td> <td class=\"tdFormat\">" .$data["manufacturer"] ."</td></tr>";
			
			}
			$content .= "</tbody>
			</table> <br /><br />";
			/********************************************************** Processing Docs **************************************************************/
			//getting count for 510k received
			$rec_docs = $this->hrtsConnection->prepare("Select doc.internal_number, doc.fda_application_number, doc.delivery_company, doc.delivery_tracking_number, doc.manufacturer from ". $output['tName'] ." tb INNER JOIN document doc ON doc.internal_number=tb.internal_number AND doc.date_received=tb.date_received Where doc.document_type = '" . $docs ."' AND tb.date_received = :date and tb.status = 'processing'");
			
					
			$rec_docs->bindValue(':date', $output['date'], PDO::PARAM_STR); 
			$rec_docs->execute();
			
			$count = $rec_docs -> rowCount();
			
			$content .= "<div class=\"dataTableTitleFormat\">Currently Processing: $count </div>";
			$content .= "<table class=\"tableFormat2\">
				<tbody>
					<tr>
						<td class=\"tdWidth nowrap th_title\">Internal Number</td>
						<td class=\"tdWidth nowrap th_title\">FDA Number</td>
						<td class=\"tdWidth nowrap th_title\">Shipper</td> 
						<td class=\"tdWidth nowrap th_title\">Tracking Number</td> 
						<td class=\"tdWidth nowrap th_title\">Sponsor</td></tr>";
						
			while($data = $rec_docs->fetch(PDO::FETCH_ASSOC)){
			
			$content .= "<tr><td class=\"tdFormat\">". $data["internal_number"] ."</td> <td class=\"tdFormat\">". $data["fda_application_number"]  ."</td> <td class=\"tdFormat\">". $data["delivery_company"]  ."</td> <td class=\"tdFormat\">". $data["delivery_tracking_number"] ."</td> <td class=\"tdFormat\">" .$data["manufacturer"] ."</td></tr>";
			
			}
			$content .= "</tbody>
			</table> <br /><br />";
			/********************************************************** Need Info **************************************************************/
			//getting count for 510k received
			/*$rec_info = $this->hrtsConnection->prepare("Select doc.internal_number, doc.fda_application_number, doc.delivery_company, doc.delivery_tracking_number, doc.manufacturer from ". $output['tName'] ." tb INNER JOIN document doc ON doc.internal_number=tb.internal_number AND doc.date_received=tb.date_received Where doc.document_type = '" . $docs ."' AND tb.date_received = :date AND tb.status != 'Processing Complete'
AND tb.status != 'processing'");
			
					
			$rec_info->bindValue(':date', $output['date'], PDO::PARAM_STR); 
			$rec_info->execute();
			
			$count = $rec_info -> rowCount();
			
			$content .= "<div class=\"dataTableTitleFormat\">Need Information: $count </div>";
			$content .= "<table class=\"tableFormat2\">
				<tbody>
					<tr>
						<td class=\"tdWidth nowrap th_title\">Internal Number</td>
						<td class=\"tdWidth nowrap th_title\">FDA Number</td>
						<td class=\"tdWidth nowrap th_title\">Shipper</td> 
						<td class=\"tdWidth nowrap th_title\">Tracking Number</td> 
						<td class=\"tdWidth nowrap th_title\">Sponsor</td></tr>";
						
			while($data = $rec_info->fetch(PDO::FETCH_ASSOC)){
			
			$content .= "<tr><td class=\"tdFormat\">". $data["internal_number"] ."</td> <td class=\"tdFormat\">". $data["fda_application_number"]  ."</td> <td class=\"tdFormat\">". $data["delivery_company"]  ."</td> <td class=\"tdFormat\">". $data["delivery_tracking_number"] ."</td> <td class=\"tdFormat\">" .$data["manufacturer"] ."</td></tr>";
			
			}
			$content .= "</tbody>
			</table> <br /><br />";*/
			
			/********************************************************** Completed **************************************************************/
			//getting count for 510k received
			$rec_completed = $this->hrtsConnection->prepare("Select doc.internal_number, doc.fda_application_number, doc.delivery_company, doc.delivery_tracking_number, doc.manufacturer from ". $output['tName'] ." tb INNER JOIN document doc ON doc.internal_number=tb.internal_number AND doc.date_received=tb.date_received Where doc.document_type = '" . $docs ."' AND tb.date_received = :date AND tb.status = 'Processing Complete'");
			
					
			$rec_completed->bindValue(':date', $output['date'], PDO::PARAM_STR); 
			$rec_completed->execute();
			
			$count = $rec_completed -> rowCount();
			
			$content .= "<div class=\"dataTableTitleFormat\">Processed: $count </div>";
			$content .= "<table class=\"tableFormat2\">
				<tbody>
					<tr>
						<td class=\"tdWidth nowrap th_title\">Internal Number</td>
						<td class=\"tdWidth nowrap th_title\">FDA Number</td>
						<td class=\"tdWidth nowrap th_title\">Shipper</td> 
						<td class=\"tdWidth nowrap th_title\">Tracking Number</td> 
						<td class=\"tdWidth nowrap th_title\">Sponsor</td></tr>";
						
			while($data = $rec_completed->fetch(PDO::FETCH_ASSOC)){
			
			$content .= "<tr><td class=\"tdFormat\">". $data["internal_number"] ."</td> <td class=\"tdFormat\">". $data["fda_application_number"]  ."</td> <td class=\"tdFormat\">". $data["delivery_company"]  ."</td> <td class=\"tdFormat\">". $data["delivery_tracking_number"] ."</td> <td class=\"tdFormat\">" .$data["manufacturer"] ."</td></tr>";
			
			}
			$content .= "</tbody>
			</table> <br /><br />";
			
			/********************************************************** From Yesterday **************************************************************/
			//getting count for 510k received
			$rec_prev = $this->hrtsConnection->prepare("Select doc.internal_number, doc.fda_application_number, doc.delivery_company, doc.delivery_tracking_number, doc.manufacturer from ". $output['tName'] ." tb INNER JOIN document doc ON doc.internal_number=tb.internal_number AND doc.date_received=tb.date_received Where doc.document_type = '" . $docs ."' AND tb.date_received = DATE_SUB(:date, INTERVAL 1 DAY) AND tb.status = 'processing'");
			
					
			$rec_prev->bindValue(':date', $output['date'], PDO::PARAM_STR); 
			$rec_prev->execute();
			
			$count = $rec_prev -> rowCount();
			
			$content .= "<div class=\"dataTableTitleFormat\">Prior Pending: $count </div>";
			$content .= "<table class=\"tableFormat2\">
				<tbody>
					<tr>
						<td class=\"tdWidth nowrap th_title\">Internal Number</td>
						<td class=\"tdWidth nowrap th_title\">FDA Number</td>
						<td class=\"tdWidth nowrap th_title\">Shipper</td> 
						<td class=\"tdWidth nowrap th_title\">Tracking Number</td> 
						<td class=\"tdWidth nowrap th_title\">Sponsor</td></tr>";
						
			while($data = $rec_prev->fetch(PDO::FETCH_ASSOC)){
			
			$content .= "<tr><td class=\"tdFormat\">". $data["internal_number"] ."</td> <td class=\"tdFormat\">". $data["fda_application_number"]  ."</td> <td class=\"tdFormat\">". $data["delivery_company"]  ."</td> <td class=\"tdFormat\">". $data["delivery_tracking_number"] ."</td> <td class=\"tdFormat\">" .$data["manufacturer"] ."</td></tr>";
			
			}
			$content .= "</tbody>
			</table> <br /><br />";
			
			}
			
			catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for Operational Detail error.'); </script>");
			
		}
			
			
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
				
				//$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=document_list','_newtab'); e.preventDefault();});";
				$content .="</script>";
				
				return($content);
			
		
		
		
	}
}

?>