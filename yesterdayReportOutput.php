<?php

if($_REQUEST["sortType"] == "sortName"){
	
	$sort = "users.lastName";
	
	//die($_REQUEST["sortType"]);
	
}

elseif($_REQUEST["sortType"] == "sortTimeIn"){
	
	$sort = "users_time.login_time";
	
	//die($_REQUEST["sortType"]);
	
}

elseif($_REQUEST["sortType"] == "sortTimeOut"){
	
	$sort = "users_time.logout_time";
	
	//die($_REQUEST["sortType"]);
	
}

elseif($_REQUEST["sortType"] == "sortHours"){
	
	$sort = "users.lastName";
	
	//die($_REQUEST["sortType"]);
	
}

$current_date = date("Y-m-d", (strtotime($_REQUEST['date'])));
$display_current_date = date("m-d-Y", (strtotime($_REQUEST['date'])));

$get_yesterday_report_table = new createYesterdayReportTable();

die($get_yesterday_report_table->createYesterdayReportData($current_date,$sort,$display_current_date));

class createYesterdayReportTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createYesterdayReportData($current_date,$sort,$display_current_date){
		
		//return("works");
		
		$this->hrtsConnect = new databaseConnection();
		$this->hrtsConnection = $this->hrtsConnect->hrtsDatabaseConnection();
		try{
		$results = $this->hrtsConnection->prepare("SELECT users.*, users_time.* FROM `users` INNER JOIN users_time ON users.id=users_time.id WHERE users_time.date = :current_date ORDER BY :sort");
		
		$results->bindValue(':current_date', $current_date, PDO::PARAM_STR);
		$results->bindValue(':sort', $sort, PDO::PARAM_STR);
		$results->execute();
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for yesterday report error.'); </script>");
			
		}
		
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No records found.'); </script>";
			
			return($content);	
			
		}
		
		$document = 'exportFile/yesterday_report.csv';
		$handle = fopen($document, 'w');
		
		$content = "<div id=\"datatableFormat2\">";
		$content .= "<div class=\"dataTableTitleFormat\"> YESTERDAY REPORT </div>";
		$content .= "<div>";
		$content .= "<div class=\"floatTextLeft\"> Date: $display_current_date</div>";
		$content .= "<div id=\"countStatement\" class=\"floatTextRight\"> In Today: ". $results->rowCount() ."</div>";
		$content .= "</div>";
		$capture_data = "YESTERDAY REPORT\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "Date: $display_current_date,In Today: ".$results->rowCount()."\r\n";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"tdWidth nowrap th_title\">Name </th><th class=\"tdWidth nowrap th_title\">Time In </th><th class=\"tdWidth nowrap th_title\">Time Out </th><th class=\"tdWidth nowrap th_title\">Total Time Worked </th></tr>";
		$capture_data .= "\r\n";
		$capture_data .= "Name,Time In,Time Out,Total Time Worked \r\n";
		
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
				
				$hours = ($total_hours_1 + $total_hours_2) + ($total_minutes_1+$total_minutes_2);
				
				$content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\">".$row["login_time"]."</td><td class=\"tdFormat\">".$row["logout_time"]."</td><td class=\"tdFormat\">$hours</td></tr>";
				
				$capture_data .= $row["firstName"]." ".$row["lastName"].",".$row["login_time"].",".$row["logout_time"].",$hours\r\n";
			}
			elseif((!empty($row["login_time"]))&&(!empty($row["logout_time"]))&&((empty($row["on_lunch"]))||(empty($row["off_lunch"])))){
				
				$login_time = new DateTime($row["login_time"]);
				$logout_time = new DateTime($row["logout_time"]);
				
				 //$hours = $login_time->diff($logout_time)->format('%h.%i');
				 
				 $my_hours = $login_time->diff($logout_time)->format('%h');
				 $my_minutes = $login_time->diff($logout_time)->format('%i');
				 
				 $my_minutes = round($my_minutes/60,2);
				 
				 $hours = $my_hours+$my_minutes;
				 
				 $content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\">".$row["login_time"]."</td><td class=\"tdFormat\">".$row["logout_time"]."</td><td class=\"tdFormat\">$hours</td></tr>";
				
				$capture_data .= $row["firstName"]." ".$row["lastName"].",".$row["login_time"].",".$row["logout_time"].",$hours\r\n";
				
			}
			else{  
			
				$content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\">".$row["login_time"]."</td><td class=\"tdFormat\">".$row["logout_time"]."</td><td class=\"tdFormat\">0</td></tr>";
				
				$capture_data .= $row["firstName"]." ".$row["lastName"].",".$row["login_time"].",".$row["logout_time"].",0\r\n";
			
			}
			
		}

		$content .= "</tbody></table>";
		
		$content .="<div class=\"divspacer\"> </div>";
		
		//$results = $this->hrtsConnection->query("SELECT users.* FROM `users` LEFT JOIN users_time ON users.id=users_time.id WHERE users_time.id IS NULL ORDER BY users.lastName");
		
		$results = $this->hrtsConnection->prepare("SELECT * FROM users u WHERE NOT EXISTS(SELECT * FROM users_time t WHERE u.id=t.id AND t.date = :current_date) ORDER BY u.lastName");
		
		$results->bindValue(':current_date', $current_date, PDO::PARAM_STR);
		//$results->bindValue(':sort', $sort, PDO::PARAM_STR);
		$results->execute();
		
		//$content = "This is the row count ". $results->rowCount();
		
		$content .= "<div>";
		$content .= "<div class=\"floatTextLeft\"> Date: $display_current_date</div>";
		$content .= "<div id=\"countStatement\" class=\"floatTextRight\"> Out Today: ". $results->rowCount() ."</div>";
		$content .= "</div>";
		$capture_data .= "\r\n";
		$capture_data .= "Date: $display_current_date,Out Today: ".$results->rowCount()."\r\n";
		$capture_data .= "\r\n";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"tdWidth nowrap th_title\">Name </th><th class=\"tdWidth nowrap th_title\">Comment </th></tr>";
		$capture_data .= "Name,Comment\r\n";
		
		
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\"> NA </td></tr>";	
			
			$capture_data .= $row["firstName"]." ".$row["lastName"].",NA\r\n";
			
		}
		
		$content .= "</tbody></table>";
		
		$content .= "<br>";
		$content .= "<h3 id=\"generateReport\"> Generate Report </h3>";
		$content .= "</div>";
		$content .= "<script type=\"text/javascript\">"; 
		$content .= "adjust_div_position();";
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=yesterday_report','_newtab'); e.preventDefault();});";
		$content .="</script>";
		
		fwrite($handle,$capture_data);
		fclose($handle);
		
		return($content);	
	}
	
	
}

?>