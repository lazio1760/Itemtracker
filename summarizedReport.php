<?php
//include ("hrtsDatabaseConnection.php");

$date = "12-31-2013";

$date = explode("-",$date);

$month = $date[0];
$year = $date[2];

$document_search_table = new createDocumentSearchTable($month,$year);

die($document_search_table->createDocumentSearchData($month,$year));

class createDocumentSearchTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createDocumentSearchData($month,$year){
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		$document = 'stat_data/December2013_document_data_by_day.csv';
        
	    $handle = fopen($document, 'w');
		
		$document2 = 'stat_data/December2013_document_data_by_week.csv';
		$handle2 = fopen($document2, 'w');
		 
		
		$capture_data = "DECEMBER 2013 DOCUMENT DATA BY DAY\r\n";
		$capture_dataH = "<div class=\"dataTableTitleFormatSumm\">DECEMBER 2013 DOCUMENT DATA BY DAY</div><br>";
		
		$capture_dataH .= "<table class=\"tableFormat2\"><tbody>";
		$capture_dataH .= "<tr><th class=\"tdWidthH nowrap th_title\">DATE </th><th class=\"tdWidthH nowrap th_title\">DAY </th><th class=\"tdWidthH nowrap th_title\">510K </th><th class=\"tdWidthH nowrap th_title\">IDE </th><th class=\"tdWidthH nowrap th_title\">PMA </th><th class=\"tdWidthH nowrap th_title\">RAD_HEALTH </th><th class=\"tdWidthH nowrap th_title\">2579 </th><th class=\"tdWidthH nowrap th_title\">DAY_TOTAL </th></tr>";
		 

		$capture_data .= "DATE,DAY,510K,IDE,PMA,RAD_HEALTH,2579,DAY_TOTAL\r\n";
		
		$more_data = "DECEMBER 2013 DOCUMENT DATA BY WEEK\r\n";

		$more_data .= "WEEK #,DATE_RANGE,510K,IDE,PMA,RAD_HEALTH,2579,WEEK_TOTAL\r\n";
		
		for($z=1;$z<32;$z++){
			
				$day = str_pad($z, 2, '0', STR_PAD_LEFT);
				
				//echo($day);
	
				$values = "`date_received` = '$year-$month-$day'";
				
				$day_510K_results = $this->hrtsConnection->prepare("SELECT COUNT(`document_type`) 510K FROM `document` WHERE `document_type` = '510K' AND $values");
				$day_510K_results->execute();
				$day_510K_results_row = $day_510K_results->fetch(PDO::FETCH_ASSOC);
			
				$day_IDE_results = $this->hrtsConnection->prepare("SELECT COUNT(`document_type`) IDE FROM `document` WHERE `document_type` = 'IDE' AND $values");
				$day_IDE_results->execute();
				$day_IDE_results_row = $day_IDE_results->fetch(PDO::FETCH_ASSOC);
				
				$day_PMA_results = $this->hrtsConnection->prepare("SELECT COUNT(`document_type`) PMA FROM `document` WHERE `document_type` = 'PMA' AND $values");
				$day_PMA_results->execute();
				$day_PMA_results_row = $day_PMA_results->fetch(PDO::FETCH_ASSOC);
				
				$day_RAD_HEALTH_results = $this->hrtsConnection->prepare("SELECT COUNT(`document_type`) RAD_HEALTH FROM `document` WHERE `document_type` = 'RAD_HEALTH' AND $values");
				$day_RAD_HEALTH_results->execute();
				$day_RAD_HEALTH_results_row = $day_RAD_HEALTH_results->fetch(PDO::FETCH_ASSOC);
				
				$day_2579_results = $this->hrtsConnection->prepare("SELECT COUNT(`document_type`) '2579' FROM `document` WHERE `document_type` = '2579' AND $values");
				$day_2579_results->execute();
				$day_2579_results_row = $day_2579_results->fetch(PDO::FETCH_ASSOC);
				
				$date_formatted = trim(str_replace("'","",str_replace("`date_received` =","",$values)));
					
				$day_formatted = date("D",strtotime($date_formatted));
				
				$week_number = date("W",strtotime($date_formatted));
				
				if(($day_510K_results_row["510K"] != 0)||($day_IDE_results_row["IDE"] != 0)||($day_PMA_results_row["PMA"] != 0)||($day_RAD_HEALTH_results_row["RAD_HEALTH"] != 0)||($day_2579_results_row["2579"] != 0)){
				
					//$date_formatted = str_replace("'","",str_replace("`date_received` =","",$values));
					
					//$day_formatted = date("D",strtotime($date_formatted));
					
					$capture_data .= "$date_formatted,";
                    $capture_dataH .="<tr><td class=\"tdFormat\">$date_formatted</td>";
					$capture_data .= "$day_formatted,";
                    $capture_dataH .="<td class=\"tdFormat\">$day_formatted</td>";
					$capture_data .= "".$day_510K_results_row["510K"].",";
                    $capture_dataH .="<td class=\"tdFormat\">$day_510K_results_row[\"510K\"]</td>";
					$capture_data .= "".$day_IDE_results_row["IDE"].",";
                    $capture_dataH .="<td class=\"tdFormat\">$day_IDE_results_row[\"IDE\"]</td>";
					$capture_data .= "".$day_PMA_results_row["PMA"].",";
                    $capture_dataH .="<td class=\"tdFormat\">$day_PMA_results_row[\"PMA\"]</td>";
					$capture_data .= "".$day_RAD_HEALTH_results_row["RAD_HEALTH"].",";
                    $capture_dataH .="<td class=\"tdFormat\">$day_RAD_HEALTH_results_row[\"RAD_HEALTH\"]</td>";
					$capture_data .= "".$day_2579_results_row["2579"].",";
                    $capture_dataH .="<td class=\"tdFormat\">$day_2579_results_row[\"2579\"]</td>";
					$capture_data .= $day_510K_results_row["510K"] + $day_IDE_results_row["IDE"] + $day_PMA_results_row["PMA"] + $day_RAD_HEALTH_results_row["RAD_HEALTH"] + $day_2579_results_row["2579"];
					$capture_dataH .= "<td class=\"tdFormat\">$day_510K_results_row[\"510K\"] + $day_IDE_results_row[\"IDE\"] + $day_PMA_results_row[\"PMA\"] + $day_RAD_HEALTH_results_row[\"RAD_HEALTH\"] + $day_2579_results_row[\"2579\"]</td></tr>";
                    
                    $capture_data .= "\r\n";
				
					$weeks[$week_number]["510K"] += $day_510K_results_row["510K"];
					$weeks[$week_number]["IDE"] += $day_IDE_results_row["IDE"];
					$weeks[$week_number]["PMA"] += $day_PMA_results_row["PMA"];
					$weeks[$week_number]["RAD_HEALTH"] += $day_RAD_HEALTH_results_row["RAD_HEALTH"];
					$weeks[$week_number]["2579"] += $day_2579_results_row["2579"];
					$weeks[$week_number]["range"] .= "$date_formatted,";
					
				}
				
				
				
		}
       
	$capture_dataH .="</tbody></table>";	
 //   $capture_dataH .="<br>"	;
 //   $capture_dataH .= "<script type=\"text/javascript\">"; 
		
	//	$capture_dataH .= "$('.dataTableTitleFormat').css('margin-top', 30);";
	//	$capture_dataH .= "$('.dataTableTitleFormat').css('margin-bottom', 20);";
	//	$capture_dataH .= "$('#stat_bar').css('margin-top', 20);";
	//	$capture_dataH .= "$('#stat_bar').css('margin-bottom', 5);";
	//	$capture_dataH .= "$('.tableFormat2').css('margin-top', 10);";
	//	$capture_dataH .= "browserWidth = $(window).width();";
	//	$capture_dataH .= "tableWidth = $('.tableFormat2').width();";
	//	$capture_dataH .= "adjustedMargin = (browserWidth - tableWidth)/2;";
	//	$capture_dataH .= "$('.tableFormat2').css('margin-left', adjustedMargin);";
	//	$capture_dataH .= "$('#generateReport').css('margin-left', adjustedMargin);";
	//	$capture_dataH .= "$('#generateReport').css('margin-bottom', 10);";
	//	$capture_dataH .= "$('.dataTableTitleFormat').css('margin-left', adjustedMargin);";
	//	$capture_dataH .= "$('.stat_bar').css('margin-left', adjustedMargin);";
	//	$capture_dataH .= "$('.stat_bar').css('width', tableWidth);";
	//	$capture_dataH .= "$('.textRight').css('margin-left', (tableWidth/3));";
		
		
	//	$capture_dataH .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=today_report','_newtab'); e.preventDefault();});";
	//	$capture_dataH .="</script>";	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
		//var_dump($weeks[40]);
		
		$i = 1;
		
		foreach($weeks as $week_num){
			
				$range = explode(",",$week_num["range"]);
				$count = count($range);
				$count -= 2;
				$began_date = $range[0];
				$end_date = $range[$count];
				$more_data .= "$i,";
				$more_data .= "$began_date TO $end_date,";
				$more_data .= "".$week_num["510K"].",";
				$more_data .= "".$week_num["IDE"].",";
				$more_data .= "".$week_num["PMA"].",";
				$more_data .= "".$week_num["RAD_HEALTH"].",";
				$more_data .= "".$week_num["2579"].",";
				$more_data .= $week_num["510K"] + $week_num["IDE"] + $week_num["PMA"] + $week_num["RAD_HEALTH"] + $week_num["2579"];
				$more_data .= "\r\n";
				
				$i += 1;
		}
		//echo $more_data;
		fwrite($handle,$capture_data);
		fwrite($handle2,$more_data);
        
        fclose($handle2);
        fclose($handle);
		
		
		//var_dump($weeks[40]);
		
		//return $content;
		
		$return = $capture_dataH."Please review December2013_document_data_by_day.csv and December2013_document_data_by_week.csv located at /hrts/stat_data";
		
		return $return;
		
	}
}

?>