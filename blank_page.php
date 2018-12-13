<?php

include ("hrtsDatabaseConnection.php");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

session_start();

$hrtsConnect2 = new databaseConnection();
$hrtsConnection2 = $hrtsConnect2->hrtsDatabaseConnection();

$result = $hrtsConnection2->query("Select * FROM session");
$row = $result->fetch(PDO::FETCH_ASSOC);

if($_SESSION['variable'] != $row['variable']){
	
	//header('Location: http://localhost/hrts/');
	
	header('Location: /hrts/');
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/hrts.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery-ui-1.9.1.custom.css" />

<title>HEITECH SERVICES (HRTS)</title>

<script type="text/javascript" src="scripts/jquery-1.8.2.js"> </script>
<script type="text/javascript" src="scripts/jquery-ui-1.9.1.custom.js"> </script>

<script type="text/javascript">
	
	
	
</script>

</head>

<body>

    <div id="titleDiv">
    
    	<label id='title_text'> HeiQuality Automated Reporting and Tracking System </label>
    
    	<!--<img id="appTitle" src="images/hrts_title.png" />-->
        
        <!--<img id="heiTechLogo" src="images/HTS-logo3.png" height="80" />-->
    
    </div>
    
    
    <!--<div id="mainDiv">-->
    
		<?php 
			if($_REQUEST['dataType'] == 'attendance'){
				include("myAttendanceReportData.php");
			}
			elseif($_REQUEST['dataType'] == 'document'){
				include("createDocumentTable.php");
			}
			elseif($_REQUEST['dataType'] == 'today_report'){
				include("todayReportOutput.php");
			}  
			elseif($_REQUEST['dataType'] == 'yesterday_report'){
				include("yesterdayReportOutput.php");
			}
			elseif($_REQUEST['dataType'] == 'summary_report'){
				include("summaryReportOutput.php");
			} 
			elseif($_REQUEST['dataType'] == 'document_search_report'){
				include("document_search_report.php");
			}
			elseif($_REQUEST['dataType'] == 'tracking_number_report'){
				include("tracking_number_report.php");
			}
			elseif($_REQUEST['dataType'] == 'fda_number_report'){
				include("fda_number_report.php");
			}
			elseif($_REQUEST['dataType'] == 'processing_status_report'){
				include("processing_status_report.php");
			}
			elseif($_REQUEST['dataType'] == 'today_documents'){
				include("dump_today_documents.php");
			}
			elseif($_REQUEST['dataType'] == 'operational_dashboard'){
				include("operation_dash.php");
			}
			elseif($_REQUEST['dataType'] ==  'summarized_report'){
	             include("summarizedReport.php");
			}
			else{die('Invalid entry');}
        ?>	
    
    <!--</div>-->

</body>
</html>