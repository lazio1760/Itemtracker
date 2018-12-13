<?php

$ids = json_decode($_REQUEST["ids"]);
//$ids = $_REQUEST["ids"];

//die($ids);

$start_date = date("Y-m-d", (strtotime($_REQUEST['startdate'])));
$display_start_date = date("m-d-Y", (strtotime($_REQUEST['startdate'])));
$end_date = date("Y-m-d", (strtotime($_REQUEST['enddate'])));
$display_end_date = date("m-d-Y", (strtotime($_REQUEST['enddate'])));

$get_yesterday_report_table = new createSummaryReportTable();

die($get_yesterday_report_table->createSummaryReportData($ids,$start_date,$display_start_date,$end_date,$display_end_date));

class createSummaryReportTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createSummaryReportData($ids,$start_date,$display_start_date,$end_date,$display_end_date){
		
		//return("works");
		
		//var_dump($ids);
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		$document = 'exportFile/employee_summary_report.csv';
		$handle = fopen($document, 'w');
		
		//$content = "<div id=\"datatableFormat2\">";
		$content .= "<div class=\"dataTableTitleFormat\"> EMPLOYEE SUMMARY REPORT </div>";
		$capture_data = "EMPLOYEE SUMMARY REPORT\r\n";
		$capture_data .= "\r\n";
		
		foreach($ids as $key=>$id){
		
			$results = $this->hrtsConnection->prepare("SELECT users.*, users_time.* FROM `users` INNER JOIN users_time ON users.id=users_time.id WHERE users_time.id = :id AND users_time.date BETWEEN :start_date AND :end_date");
			
			$results->bindValue(':start_date', $start_date, PDO::PARAM_STR);
			$results->bindValue(':end_date', $end_date, PDO::PARAM_STR);
			$results->bindValue(':id', $id, PDO::PARAM_INT);
			$results->execute();
			
			//$results = $this->hrtsConnection->query("SELECT * FROM users WHERE id = 2");
			
			$missing_results = $this->hrtsConnection->prepare("SELECT DISTINCT date FROM users_time WHERE date between :start_date AND :end_date");
			
			$missing_results->bindValue(':start_date', $start_date, PDO::PARAM_STR);
			$missing_results->bindValue(':end_date', $end_date, PDO::PARAM_STR);
			//$missing_results->bindValue(':id', $id, PDO::PARAM_INT);
			$missing_results->execute();
	
			
			if($key != 0) { $content .= "<div class=\"spacer\"> </div>"; }
		
			$content .= "<div class=\"stat_bar\">";
			//$content .= "<div class=\"textLeft\"> Date Range: $display_start_date through $display_end_date </div>";
			//$content .= "<div class=\"textRight\"> In: ". $results->rowCount() ." Out: ". ($missing_results->rowCount() - $results->rowCount()) ."</div>";
			$content .= "<label class=\"textLeft\"> Date Range: $display_start_date through $display_end_date </label>";
			$content .= "<label class=\"textRight\"> In: ". $results->rowCount() ." Out: ". ($missing_results->rowCount() - $results->rowCount()) ."</label>";
			$content .= "</div>";
			//$capture_data = "EMPLOYEE SUMMARY REPORT\r\n";
			$capture_data .= "\r\n";
			$capture_data .= "Date Range: $display_start_date through $display_end_date,In: ".$results->rowCount().",Out: ". ($missing_results->rowCount() - $results->rowCount()) ."\r\n";
			$content .= "<table class=\"tableFormat2\"><tbody>";
			$content .= "<tr><th class=\"tdWidth nowrap th_title\">Name </th><th class=\"tdWidth nowrap th_title\">Date </th><th class=\"tdWidth nowrap th_title\">Time In </th><th class=\"tdWidth nowrap th_title\">Start Lunch </th><th class=\"tdWidth nowrap th_title\">End Lunch </th><th class=\"tdWidth nowrap th_title\">Time Out </th><th class=\"tdWidth nowrap th_title\">Total Time Worked </th></tr>";
			$capture_data .= "\r\n";
			$capture_data .= "Name,Date,Time In,Start Lunch,End Lunch,Time Out,Total Time Worked \r\n";
			
			while($row = $results->fetch(PDO::FETCH_ASSOC)){
				
				if(!((empty($row["login_time"]))||(empty($row["logout_time"]))||(empty($row["on_lunch"]))||(empty($row["off_lunch"])))){
					$login_time = new DateTime($row["login_time"]);
					$logout_time = new DateTime($row["logout_time"]);
					$on_lunch = new DateTime($row["on_lunch"]);
					$off_lunch = new DateTime($row["off_lunch"]);
					
					$total_minutes_1 = $login_time->diff($on_lunch)->format('%i');
					
					$total_minutes_1 = round($total_minutes_1/60,2);
					
					$total_hours_1 = $login_time->diff($on_lunch)->format('%h');
					
					$total_minutes_2 = $off_lunch->diff($logout_time)->format('%i');
					
					$total_minutes_2 = round($total_minutes_2/60,2);
					
					$total_hours_2 = $off_lunch->diff($logout_time)->format('%h');
					
					$hours = ($total_hours_1 + $total_hours_2) + ($total_minutes_1+$total_minutes_2) + .5;
					
					//$hours = $total_hours_1;
				
					$content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\">".$row["date"]."</td><td class=\"tdFormat\">".$row["login_time"]."</td><td class=\"tdFormat\">".$row["on_lunch"]."</td><td class=\"tdFormat\">".$row["off_lunch"]."</td><td class=\"tdFormat\">".$row["logout_time"]."</td><td class=\"tdFormat\">$hours</td></tr>";
				
					$capture_data .= $row["firstName"]." ".$row["lastName"].",".$row["date"].",".$row["login_time"].",".$row["on_lunch"].",".$row["off_lunch"].",".$row["logout_time"].",$hours\r\n";
					
				}
				
				elseif((!empty($row["login_time"]))&&(!empty($row["logout_time"]))&&((empty($row["on_lunch"]))||(empty($row["off_lunch"])))){
					
					$login_time = new DateTime($row["login_time"]);
					$logout_time = new DateTime($row["logout_time"]);
					
					 //$hours = $login_time->diff($logout_time)->format('%h.%i');
					 
					 $my_hours = $login_time->diff($logout_time)->format('%h');
					 $my_minutes = $login_time->diff($logout_time)->format('%i');
					 
					 $my_minutes = round($my_minutes/60,2);
					 
					 $hours = $my_hours+$my_minutes + .5; 
					 
					 $content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\">".$row["date"]."</td><td class=\"tdFormat\">".$row["login_time"]."</td><td class=\"tdFormat\">".$row["on_lunch"]."</td><td class=\"tdFormat\">".$row["off_lunch"]."</td><td class=\"tdFormat\">".$row["logout_time"]."</td><td class=\"tdFormat\">$hours</td></tr>";
				
					$capture_data .= $row["firstName"]." ".$row["lastName"].",".$row["date"].",".$row["login_time"].",".$row["on_lunch"].",".$row["off_lunch"].",".$row["logout_time"].",$hours\r\n";
					
				}
				else{
					
					$content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\">".$row["date"]."</td><td class=\"tdFormat\">".$row["login_time"]."</td><td class=\"tdFormat\">".$row["on_lunch"]."</td><td class=\"tdFormat\">".$row["off_lunch"]."</td><td class=\"tdFormat\">".$row["logout_time"]."</td><td class=\"tdFormat\">0</td></tr>";
				
					$capture_data .= $row["firstName"]." ".$row["lastName"].",".$row["date"].",".$row["login_time"].",".$row["on_lunch"].",".$row["off_lunch"].",".$row["logout_time"].",0\r\n";	
					
				}
				
			}
	
			$content .= "</tbody></table>";
			
			if($results->rowCount() == 0){
				
				$name_results = $this->hrtsConnection->prepare("SELECT * FROM `users` WHERE id = :id");
			
				$name_results->bindValue(':id', $id, PDO::PARAM_INT);
				$name_results->execute();
				
				$row_name = $name_results->fetch(PDO::FETCH_ASSOC);
				
				/*$content = "<script type=\"text/javascript\"> alert('".$row_name["firstName"]." ".$row_name["lastName"]." does not have any time recorded for this range.'); </script>";*/
				
				//return($content);
				
				$content .= "<div class=\"stat_bar\"> ".$row_name["firstName"]." ".$row_name["lastName"]." does not have any time recorded for this range. </div>";
				$capture_data .= $row_name["firstName"]." ".$row_name["lastName"]." does not have any time recorded for this range.\r\n";
			}
		
		}
		
		$content .= "<br>";
		$content .= "<h3 id=\"generateReport\"> Generate Report </h3>";
		//$content .= "</div>";
		$content .= "<script type=\"text/javascript\">"; 
		
		$content .= "$('.dataTableTitleFormat').css('margin-top', 30);";
		$content .= "$('.dataTableTitleFormat').css('margin-bottom', 20);";
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
		
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=employee_summary_report','_newtab'); e.preventDefault();});";
		$content .="</script>";
		
		fwrite($handle,$capture_data);
		fclose($handle);
		
		return($content);	
	}
	
	
}

?>