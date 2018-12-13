<?php
	
	$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
		
		$documents = new operational_dash();

		die($documents->operations($current_date));

class operational_dash{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function operations($current_date){
			
			$this->hrtsConnect = new databaseConnection();
			$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
			
		try{
			//getting count for 510k received
			$kresults = $this->hrtsConnection->prepare("SELECT * FROM document where date_received = :date and document_type = '510K'");
			
			$kresults->bindValue(':date', $current_date, PDO::PARAM_STR); 
			$kresults->execute();
			
			$k_received = $kresults -> rowCount();
			
			// getting count for 510k currently processing
			$kresults = $this->hrtsConnection->prepare("SELECT * FROM 510k_processing where date_received = :date and status = 'processing'");
			$kresults->bindValue(':date', $current_date, PDO::PARAM_STR); 
			$kresults->execute();
			
			$k_processing = $kresults -> rowCount();
			
			// getting count for 510k that needs info
			/*$kresults = $this->hrtsConnection->prepare("SELECT * FROM 510k_processing where date_received = :date and status != 'Processing Complete' and status != 'processing'");
			$kresults->bindValue(':date', $current_date, PDO::PARAM_STR); 
			$kresults->execute();*/
			
			$k_info = $kresults -> rowCount();
			
			// getting count for 510k processed
			$kresults = $this->hrtsConnection->prepare("SELECT * FROM 510k_processing where date_received = :date and status = 'Processing Complete'");
			$kresults->bindValue(':date', $current_date, PDO::PARAM_STR); 
			$kresults->execute();
			
			$k_processed = $kresults -> rowCount();
			
			// getting count for 510k previous processing
			$kresults = $this->hrtsConnection->prepare("SELECT * FROM 510k_processing where date_received = DATE_SUB(:date, INTERVAL 1 DAY) and status != 'Processing Complete'");
			$kresults->bindValue(':date', $current_date, PDO::PARAM_STR); 
			$kresults->execute();
			
			$k_previous = $kresults -> rowCount();
			
			}

		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log counting for K operation process.'); </script>");
			
		}
		
		try{
			//getting count for IDE received
			$ideresults = $this->hrtsConnection->prepare("SELECT * FROM document where date_received = :date and document_type = 'IDE'");
			
			$ideresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$ideresults->execute();
			$ide_received = $ideresults-> rowCount();
			
			//getting count for IDE currently processing
			$ideresults = $this->hrtsConnection->prepare("SELECT * FROM ide_processing where date_received = :date and status = 'processing'");
			
			$ideresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$ideresults->execute();
			$ide_processing = $ideresults-> rowCount();
			
			//getting count for IDE need info
			/*$ideresults = $this->hrtsConnection->prepare("SELECT * FROM ide_processing where date_received = :date and status != 'Processing Complete' and status != 'processing'");
			
			$ideresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$ideresults->execute();
			$ide_info = $ideresults-> rowCount();*/
			
			//getting count for IDE processed
			$ideresults = $this->hrtsConnection->prepare("SELECT * FROM ide_processing where date_received = :date and status = 'Processing Complete'");
			
			$ideresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$ideresults->execute();
			$ide_processed = $ideresults-> rowCount();
			
			//getting count for IDE previous processing
			$ideresults = $this->hrtsConnection->prepare("SELECT * FROM ide_processing where date_received = DATE_SUB(:date, INTERVAL 1 DAY) and status != 'Processing Complete'");
			
			$ideresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$ideresults->execute();
			$ide_previous = $ideresults-> rowCount();
			}

		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log counting for IDE operation process.'); </script>");
			
		}
		
		try{
			//Getting count for PMA received today
			$pmaresults = $this->hrtsConnection->prepare("SELECT * FROM document where date_received = :date and document_type = 'PMA'");
			
			$pmaresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$pmaresults->execute();
			$pma_received = $pmaresults-> rowCount();
			 
			 //Getting count for PMA currently processing
			$pmaresults = $this->hrtsConnection->prepare("SELECT * FROM pma_processing where date_received = :date and status = 'processing'");
			
			$pmaresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$pmaresults->execute();
			$pma_processing = $pmaresults-> rowCount();
			 
			 //Getting count for PMA need info
			/*$pmaresults = $this->hrtsConnection->prepare("SELECT * FROM pma_processing where date_received = :date and status != 'Processing Complete' and status != 'processing'");
			
			$pmaresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$pmaresults->execute();
			$pma_info = $pmaresults-> rowCount();*/
			 
			 //Getting count for PMA processed
			$pmaresults = $this->hrtsConnection->prepare("SELECT * FROM pma_processing where date_received = :date and status = 'Processing Complete'");
			
			$pmaresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$pmaresults->execute();
			$pma_processed = $pmaresults-> rowCount();
			
			//Getting count for PMA processed
			$pmaresults = $this->hrtsConnection->prepare("SELECT * FROM pma_processing where date_received = DATE_SUB(:date, INTERVAL 1 DAY) and status != 'Processing Complete'");
			
			$pmaresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$pmaresults->execute();
			$pma_previous = $pmaresults-> rowCount();
			
			}

		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log counting for PMA operation process.'); </script>");
			
		}
		
		try{
			//Getting count for RAD received
			$radresults = $this->hrtsConnection->prepare("SELECT * FROM document where date_received = :date and document_type = 'RAD_HEALTH'");
			
			$radresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$radresults->execute();
			$rad_received = $radresults-> rowCount();
			
			//Getting count for RAD processing
			$radresults = $this->hrtsConnection->prepare("SELECT * FROM rad_processing where date_received = :date and status = 'processing'");
			
			$radresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$radresults->execute();
			$rad_processing = $radresults-> rowCount();
			
			
			//Getting count for RAD need info
			/*$radresults = $this->hrtsConnection->prepare("SELECT * FROM rad_processing where date_received = :date and status != 'Processing Complete' and status != 'processing'");
			
			$radresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$radresults->execute();
			$rad_info = $radresults-> rowCount();*/
			
			//Getting count for RAD processed
			$radresults = $this->hrtsConnection->prepare("SELECT * FROM rad_processing where date_received = :date and status = 'Processing Complete'");
			
			$radresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$radresults->execute();
			$rad_processed = $radresults-> rowCount();
			
			//Getting count for RAD previous
			$radresults = $this->hrtsConnection->prepare("SELECT * FROM rad_processing where date_received = DATE_SUB(:date, INTERVAL 1 DAY) and status != 'Processing Complete'");
			
			$radresults->bindValue(':date', $current_date, PDO::PARAM_STR);
			$radresults->execute();
			$rad_previous = $radresults-> rowCount();
			
			}

		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log counting for RAD operation process.'); </script>");
			
		}
		
	
	$sum_received = $k_received + $ide_received + $pma_received + $rad_received;
	$sum_processed  = $k_processed + $ide_processed + $pma_processed + $rad_processed;
	$sum_processing = $k_processing + $ide_processing + $pma_processing + $rad_processing;
	$sum_prev = $k_previous + $ide_previous + $pma_previous + $rad_previous;
	
	$content = "<div class=\"dataTableTitleFormat\"> Operational Dashboard </div>";
	$content .= "<table class=\"tableFormat2\"><tbody>";
	$content .= "<tr>";
	$content .= "<td class=\"tdWidth2 th_title\"></td>";
	$content .= "<td class=\"tdWidth nowrap th_title\">510k</td>";
	$content .= "<td class=\"tdWidth nowrap th_title\">IDE</td>";
	$content .= "<td class=\"tdWidth nowrap th_title\">PMA</td>"; 
	$content .= "<td class=\"tdWidth nowrap th_title\">RADHEALTH</td>"; 
	$content .= "<td class=\"tdWidth nowrap th_title\">TOTAL</td>";
	$content .= "</tr>";
	
	$content .= "<tr>";
	$content .= "<td class=\"tdWidth2 th_title\">Received Today</td>";
	$content .= "<td class=\"tdFormat\">$k_received </td>";
	$content .= "<td class=\"tdFormat\"> $ide_received </td>";
	$content .= "<td class=\"tdFormat\"> $pma_received </td>";
	$content .= "<td class=\"tdFormat\"> $rad_received </td>"; 
	$content .= "<td class=\"tdFormat\"> $sum_received</td>";
	$content .= "</tr>";
	
	$content .= "<tr><td class=\"tdWidth2 th_title\">Currently Processing</td>";
	$content .= "<td class=\"tdFormat\"> $k_processing </td>";
	$content .= "<td class=\"tdFormat\"> $ide_processing </td>";
	$content .= "<td class=\"tdFormat\"> $pma_processing </td>"; 
	$content .= "<td class=\"tdFormat\"> $rad_processing </td>";
	$content .= "<td class=\"tdFormat\"> $sum_processing </td>";
	$content .= "</tr>";

	$content .= "<tr>";
	$content .= "<td class=\"tdWidth2 th_title\">Processed</td>";
	$content .= "<td class=\"tdFormat\"> $k_processed </td>";
	$content .= "<td class=\"tdFormat\"> $ide_processed </td>";
	$content .= "<td class=\"tdFormat\"> $pma_processed </td>";
	$content .= "<td class=\"tdFormat\"> $rad_processed </td>";
	$content .= "<td class=\"tdFormat\"> $sum_processed </td>";
	$content .= "</tr>";
	
	$content .= "<tr>";
	$content .= "<td class=\"tdWidth2 th_title\">Prior Pending</td>";
	$content .= "<td class=\"tdFormat\"> $k_previous </td>";
	$content .= "<td class=\"tdFormat\"> $ide_previous </td>";
	$content .= "<td class=\"tdFormat\">$pma_previous </td>";
	$content .= "<td class=\"tdFormat\"> $rad_previous</td>";
	$content .= "<td class=\"tdFormat\">$sum_prev </td>";
	$content .= "</tr>";
	
	$content .= "</tbody></table>";
	
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

