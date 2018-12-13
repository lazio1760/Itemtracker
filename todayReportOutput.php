<?php

if($_REQUEST["sortType"] == "sortName"){
	
	$sort = "users.lastName";
	
	//die($sort);
	
}

elseif($_REQUEST["sortType"] == "sortTimeIn"){
	
	$sort = "users_time.login_time";
	
	//die($sort);
	
}

$current_date = date("Y-m-d", (strtotime('now') - (60*60*5)));

$display_current_date = date("m-d-Y", (strtotime('now') - (60*60*5)));

$get_today_report_table = new createTodayReportTable();

die($get_today_report_table->createTodayReportData($current_date,$sort,$display_current_date));

class createTodayReportTable{
	
	public $hrtsConnect;
	public $hrtsConnection;
	
	function createTodayReportData($current_date,$sort,$display_current_date){
		
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
			die("<script type=\"text/javascript\"> alert('Check log for Today report error.'); </script>");
			
		}
		
		if($results->rowCount() == 0){
			
			$content = "<script type=\"text/javascript\"> alert('No records found.'); </script>";
			
			return($content);	
			
		}
		
		$document = 'exportFile/today_report.csv';
		$handle = fopen($document, 'w');
		
		//$content = "<div id=\"datatableFormat2\">";
		$content .= "<div class=\"dataTableTitleFormat\"> TODAY REPORT </div>";
		$content .= "<div class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> Date: $display_current_date </label>";
		$content .= "<label class=\"textRight\"> In Today: ". $results->rowCount() ."</label>";
		$content .= "</div>";
		$capture_data = "TODAY REPORT\r\n";
		$capture_data .= "\r\n";
		$capture_data .= "Date: $display_current_date,In Today: ".$results->rowCount()."\r\n";
		$content .= "<table class=\"tableFormat2\"><tbody>";
		$content .= "<tr><th class=\"tdWidth nowrap th_title\">Name </th><th class=\"tdWidth nowrap th_title\">Time In </th></tr>";
		$capture_data .= "\r\n";
		$capture_data .= "Name,Time In\r\n";
		
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			
			$content .= "<tr><td class=\"tdFormat\">". $row["firstName"]." ".$row["lastName"]."</td><td class=\"tdFormat\">".$row["login_time"]."</td></tr>";	
		
			$capture_data .= $row["firstName"]." ".$row["lastName"].",".$row["login_time"]."\r\n";
		}

		$content .= "</tbody></table>";
		
		$content .="<div class=\"divspacer\"> </div>";
		
		//$results = $this->hrtsConnection->query("SELECT users.* FROM `users` LEFT JOIN users_time ON users.id=users_time.id WHERE users_time.date <>'$current_date' AND users_time.id IS NULL ORDER BY $sort");
		try{
		$results = $this->hrtsConnection->query("SELECT * FROM users u WHERE NOT EXISTS(SELECT * FROM users_time t WHERE u.id=t.id AND t.date = '$current_date')");
		}
		
		catch(PDOException $exeception){
			
			$error_document = 'errors/error_report.txt';
			$error_handle = fopen($error_document, 'w');
			fwrite($error_handle,$exeception->getMessage());
			fclose($error_handle);
			die("<script type=\"text/javascript\"> alert('Check log for Today report error.'); </script>");
			
		}
		
		$content .= "<div class=\"stat_bar\">";
		$content .= "<label class=\"textLeft\"> Date: $display_current_date</label>";
		$content .= "<label class=\"textRight\"> Out Today: ". $results->rowCount() ."</label>";
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
		$content .= "$('.textRight').css('margin-left', (tableWidth/3));";
		
		
		$content .= "$('#generateReport').mouseup(function(e){window.open('output_to_csv.php?table_data=today_report','_newtab'); e.preventDefault();});";
		$content .="</script>";
		
		fwrite($handle,$capture_data);
		fclose($handle);
		
		return($content);	
	}
	
	
}

?>