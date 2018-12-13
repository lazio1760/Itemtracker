<?php

/**
 *
 * Working Class verison
 *
 */

$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$id = $_SESSION['id'];

$startDate = date("Y-m-d", (strtotime($_REQUEST['startDate'])));
$endDate = date("Y-m-d", (strtotime($_REQUEST['endDate'])));
$startDate2 = date("m-d-Y", (strtotime($_REQUEST['startDate'])));
$endDate2 = date("m-d-Y", (strtotime($_REQUEST['endDate'])));
$reportType = $_REQUEST['reportType'];

if(empty($startDate)){
	
		$content .= "<script type=\"text/javascript\"> alert('Please enter start date.'); </script>";
		
		die($content);
	
}

if(empty($endDate)){
	
		$content .= "<script type=\"text/javascript\"> alert('Please enter end date.'); </script>";
		
		die($content);
	
}


if(empty($reportType)){
	
		$content .= "<script type=\"text/javascript\"> alert('Please select a report type.'); </script>";
		
		die($content);
	
}

$myAttendanceReport = new myAttendanceReport();

if($reportType == "summaryReport"){
	
	echo $myAttendanceReport->summaryReport($firstName,$lastName,$id,$startDate,$endDate,$startDate2,$endDate2);
	
}

elseif($reportType == "detailReport"){
	
	echo $myAttendanceReport->detailReport($firstName,$lastName,$id,$startDate,$endDate,$startDate2,$endDate2);
	
}

class myAttendanceReport{
	
	public $loginTime = NULL;
	public $logoutTime = NULL;
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function summaryReport($firstName,$lastName,$id,$startDate,$endDate,$startDate2,$endDate2){
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		
		//$results = $this->hrtsConnection->query("SELECT * FROM users_time WHERE date BETWEEN '$startDate' AND '$endDate' ORDER BY date");
		
		$results = $this->hrtsConnection->query("SELECT * FROM users_time WHERE id = $id AND date BETWEEN '$startDate' AND '$endDate' ORDER BY date");
		
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No records found.'); </script>";
			
			die($content);	
			
		}
		
		$document = 'exportFile/attendance_summary.csv';
		$handle = fopen($document, 'w');
		 
		//$content = "<div id=\"datatableFormat2\">";
		$content .= "<div class=\"dataTableTitleFormat\"> ATTENDANCE SUMMARY REPORT </div>";
		$content .= "<div class=\"stat_bar\">";
		$content .= "<div class=\"textLeft\"> Date Range: $startDate2 through $endDate2 </div>";
		$content .= "</div>";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"tdWidth nowrap th_title\">Name </th><th class=\"tdWidth2\"> Date </th><th class=\"tdWidth2\"> Hours Worked </th></tr>";
		$capture_data = "ATTENDANCE SUMMARY REPORT\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "Date Range: $startDate2 through $endDate2\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "NAME,DATE,TOTAL HOURS\r\n";
		
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$date = $row["date"];
			
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
				
				$hours = ($total_hours_1 + $total_hours_2) + ($total_minutes_1+$total_minutes_2);
				
				$content .= "<tr><td class=\"tdFormat\">".$firstName." ".$lastName."</td><td class=\"tdFormat\">".date("m-d-Y", (strtotime($date)))."</td><td class=\"tdFormat\">$hours</td></tr>";
				$capture_data .= $firstName." ".$lastName. ",".date("m-d-Y", (strtotime($date))).",$hours\r\n";
			}
			elseif((!empty($row["login_time"]))&&(!empty($row["logout_time"]))&&((empty($row["on_lunch"]))||(empty($row["off_lunch"])))){
			
				$login_time = new DateTime($row["login_time"]);
				$logout_time = new DateTime($row["logout_time"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 
				 $my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes;
				
				$content .= "<tr><td class=\"tdFormat\">".$firstName." ".$lastName."</td><td class=\"tdFormat\">".date("m-d-Y", (strtotime($date)))."</td><td class=\"tdFormat\">$hours</td></tr>";
				$capture_data .= $firstName." ".$lastName. ",".date("m-d-Y", (strtotime($date))).",$hours\r\n";
			}
			
			else{  
				$content .= "<tr><td class=\"tdFormat\">".$firstName." ".$lastName."</td><td class=\"tdFormat\">".date("m-d-Y", (strtotime($date)))."</td><td class=\"tdFormat\">0</td></tr>";
				$capture_data .= $firstName." ".$lastName. ",".date("m-d-Y", (strtotime($date))).",0\r\n";
			
			}
					
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
		$content .= "$('#ide').css('margin-top', 20);";
		$content .= "$('#pma').css('margin-top', 20);";
		$content .= "$('#rad').css('margin-top', 20);";
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
		
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=attendance_summary','_newtab'); e.preventDefault();});";
		$content .="</script>";
		//$content .= "<br>". mysql_num_rows($results);
		
		return $content;

	}
	
	function detailReport($firstName,$lastName,$id,$startDate,$endDate,$startDate2,$endDate2){
		
		/*$content ="<script type=\"text/javascript\"> alert('Currently unavailable.'); </script>";*/
		
		//return("works");
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		
		$results = $this->hrtsConnection->prepare("SELECT users.*, users_time.* FROM `users` INNER JOIN users_time ON users.id=users_time.id WHERE users_time.id = :id AND users_time.date BETWEEN :start_date AND :end_date");
		
		$results->bindValue(':start_date', $startDate, PDO::PARAM_STR);
		$results->bindValue(':end_date', $endDate, PDO::PARAM_STR);
		$results->bindValue(':id', $id, PDO::PARAM_INT);
		$results->execute();
		
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No records found.'); </script>";
			
			return($content);	
			
		}
		
		$document = 'exportFile/attendance_detail_report.csv';
		$handle = fopen($document, 'w');
		
		//$content = "<div id=\"datatableFormat2\">";
		$content .= "<div class=\"dataTableTitleFormat\"> ATTENDANCE DETAIL REPORT </div>";
		$content .= "<div class=\"stat_bar\">";
		$content .= "<div class=\"textLeft\"> Date Range: $startDate2 through $endDate2 </div>";
		$content .= "</div>";
		$capture_data = "ATTENDANCE DETAIL REPORT\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "Date Range: $startDate2 through $endDate2\r\n";
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
		
		$content .= "<br>";
		$content .= "<h3 id=\"generateReport\"> Generate Report </h3>";
		//$content .= "</div>";
		$content .= "<script type=\"text/javascript\">"; 
		
		$content .= "$('.dataTableTitleFormat').css('margin-top', 30);";
		$content .= "$('.dataTableTitleFormat').css('margin-bottom', 20);";
		$content .= "$('#ide').css('margin-top', 20);";
		$content .= "$('#pma').css('margin-top', 20);";
		$content .= "$('#rad').css('margin-top', 20);";
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
		
		
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=attendance_detail_report','_newtab'); e.preventDefault();});";
		$content .="</script>";
		
		fwrite($handle,$capture_data);
		fclose($handle);
		
		
		return $content;

	}	
	
}



?>