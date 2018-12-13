<?php

require_once ("hrtsDatabaseConnection.php");

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
<script type="text/javascript" src="scripts/json2.js"> </script>

<script type="text/javascript">

	var browserWidth, browserHeight, titleDivHeight, mainDivHeight, breakDivHeight, calculatedPosition, calculatedPosition2, status, bundle;
	var delivery_company, more_info, delivery_tracking, document_type, manufacturer, cd, paper, volume;
	var underConstruction = "This function is under construction."
	
	$(document).ready(function(){
	
		
		// Disable caching of AJAX responses
		
		$.ajaxSetup ({
    		
    		cache: false
		});
		
		/* Button Actions */
		
		$('#endBreak').hide();
		
		$('#myAttendance').mouseup(function(e){/*alert(underConstruction); e.preventDefault();*/ $(".ui-dialog-content").dialog("destroy"); getAttendance(); e.preventDefault();});
		$('#startBreak').mouseup(function(e){/*alert(underConstruction); e.preventDefault(); $('#startBreak').hide(); $('#endBreak').show();*/ add_start_break_time(); e.preventDefault();});
		$('#endBreak').mouseup(function(e){/*alert(underConstruction); e.preventDefault();*/ $('#endBreak').hide(); $('#startBreak').show(); add_end_break_time(); e.preventDefault();});
		$('#logoutButton').mouseup(function(e){logout_hrts(); e.preventDefault();});
		
		$('#captureDocumentInformation').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getDocumentTrackingForm(); e.preventDefault();});
		$('#editMail').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getDocumentTrackingForm2(); e.preventDefault();});
		$('#mailTransfer').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getMailTransferForm(); e.preventDefault();});
		
		$('#workAssignments').mouseup(function(e){alert(underConstruction); e.preventDefault();});
		$('#processingDocument').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); documentProcessingForm(); e.preventDefault();});
		$('#processingDocumentCorrection').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); documentReprocessingForm(); e.preventDefault();});
		
		$('#locateDocument').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getDocumentLocationForm(); e.preventDefault();});
		
		
		$('#qcInternal').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); get_internal_qc_form(); e.preventDefault();});
		$('#qcExternal').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); get_external_qc_form(); e.preventDefault();});
		$('#customerReportedErrors').mouseup(function(e){alert(underConstruction); e.preventDefault();});
		$('#frequentIssues').mouseup(function(e){alert(underConstruction); e.preventDefault();});
		$('#frequentOffenders').mouseup(function(e){alert(underConstruction); e.preventDefault();});
		$('#errorsNotReported').mouseup(function(e){alert(underConstruction); e.preventDefault();});
		
		$('#addUser').mouseup(function(e){/*alert(underConstruction);*/  $(".ui-dialog-content").dialog("destroy"); addEmployeeForm(); e.preventDefault();});
		$('#modifyUser').mouseup(function(e){/*alert(underConstruction);*/ $(".ui-dialog-content").dialog("destroy"); getUpdateEmployee(); e.preventDefault();});
		$('#modifyAttendance').mouseup(function(e){/*alert(underConstruction); e.preventDefault();*/ $(".ui-dialog-content").dialog("destroy"); getModifyEmployeeAttendanceForm(); e.preventDefault();});
		$('#todayReport').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getTodayReportForm(); e.preventDefault();});
		$('#yesterdayReport').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getYesterdayReportForm(); e.preventDefault();});
		$('#employeeSummary').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getSummaryReportForm(); e.preventDefault();});
		$('#documentSearch').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); getDocumentSearchForm(); e.preventDefault();});
		$('#tracking_number_search').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); get_tracking_number_Form(); e.preventDefault();});
		$('#fda_number_search').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); get_fda_number_Form(); e.preventDefault();});
		$('#processing_status').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); show_processing_status(); e.preventDefault();});
		$('#modifyDocumentType').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); modifyDocumentType(); e.preventDefault();});
		$('#changePassword').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); change_password(); e.preventDefault();});
		$('#resetPassword').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); reset_password(); e.preventDefault();});
		//$('#todayDocument').mouseup(function(e){window.open('hrts\blank_page.php?dataType=today_documents','_newtab'); e.preventDefault();});
		$('#todayDocument').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); dump_today_docments(); e.preventDefault();});
		$('#operationalDashboard').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); get_operational_dashboard(); e.preventDefault();});
		$('#summarizedReport').mouseup(function(e){$(".ui-dialog-content").dialog("destroy"); summarizedReport(); e.preventDefault();});
		
		$.get('greetings.php').done(function(data){ $('#greetings').html(data); });
		
	});
	
/***************************** backspace button fix  *************************************************/
	
	 $(document).keydown(function (e) {
        var preventKeyPress;
        if (e.keyCode == 8) {
            var d = e.srcElement || e.target;
            switch (d.tagName.toUpperCase()) {
                case 'TEXTAREA':
                    preventKeyPress = d.readOnly || d.disabled;
                    break;
                case 'INPUT':
                    preventKeyPress = d.readOnly || d.disabled ||
                        (d.attributes["type"] && $.inArray(d.attributes["type"].value.toLowerCase(), ["radio", "checkbox", "submit", "button"]) >= 0);
                    break;
                case 'DIV':
                    preventKeyPress = d.readOnly || d.disabled || !(d.attributes["contentEditable"] && d.attributes["contentEditable"].value == "true");
                    break;
                default:
                    preventKeyPress = true;
                    break;
            }
        }
        else
            preventKeyPress = false;

        if (preventKeyPress)
            e.preventDefault();
    });

/**
 *
 * Datepicker function to set date fields
 *
*/

$(window).resize(function() {
    $("#captureDoc").dialog("option", "position", "center");
});	


	function startDatePicker(){
		
		$( ".datepicker" ).datepicker({
			
			autoSize: true,
			altFormat: "dd-mm-yyyy",
			appendText: " (mm/dd/yyyy)",
			changeMonth: true,
			changeYear: true,
			constrainInput: true
			
		});
		
		$( ".datepicker" ).datepicker("setDate", new Date());
		
	}
	
	function startDatePicker2(){
		
		$( ".datepicker2" ).datepicker({
			
			autoSize: true,
			altFormat: "dd-mm-yyyy",
			appendText: " (mm/dd/yyyy)",
			changeMonth: true,
			changeYear: true,
			constrainInput: true
			
		});
		
		//$( ".datepicker" ).datepicker("setDate", new Date());
		
	}
	
/** destroy dialog box **/	
	
	function cancel_button(){
		
		$(".ui-dialog-content").dialog("destroy");
		
	}
	
/********************************************************************* Logging Attendance *************************************************************************************************/
	
/**
 *
 * Ajax call to get my attendance dialog form
 *
*/	
	
	function getAttendance(){
		
		$.get('myAttendanceReport.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   setAttendanceForm();
			   
			   });
		
	}
	
/**
 *
 * Calls datepicker function and sets the jquery dialog 
 *
*/
	
	function setAttendanceForm(){
		
		startDatePicker();
		
		$( "#myAttendanceReport" ).dialog({
		
			title: "My Attendance Report",
			height: 250,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Search", click: function() { attendanceData(); }
			
					}]
		});
		
		$('#answerPhp').css('margin-top', 250);
		
		$('#answerPhp').css('margin-left', calculatedPosition2);	
		
	}
	
/**
 *
 * Ajax call to pass form parameters and  get attendance data in table form
 *
*/
	
	function attendanceData(){
		
		window.open('blank_page.php?startDate='+attendanceReport.startdate.value+'&endDate='+attendanceReport.enddate.value+'&reportType='+attendanceReport.reportType.value+'&dataType=attendance','_newtab'); 
	}
	
	function add_start_break_time(){
	
		
		$.post('break_time.php',{status: 'start'}).done(function(data){
		
			if(data){
				
				alert(data);
				
			}
			else{
				$.get('lunch_modal.php').done(function(data){ 
					   
					   $('#infoDiv').html(data);
					   
							setModal();
					   
					   });
			}
				   
		});
		
	}
	
	function reset_login(){
		
		$.get('lunch_modal.php').done(function(data){ 
					   
					   $('#infoDiv').html(data);
					   
							setModal();
					   
					   });	
		
	}
	
	function setModal(){
		
		$( "#at_lunch" ).dialog({
		
			title: "Lunch Time",
			height: 200,
			width: 650,
			//position: {my: "left top", at: "left top", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			modal: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [
			
					   
					   {text: "Login", click: function() { add_end_break_time(); }
			
					}]
		});		
		
	}
	
	function add_end_break_time(){
	
		
		$.post('break_time.php',{status: 'end'}).done(function(data){ $("#at_lunch").dialog("destroy"); });
		
	}
	
/**
 *
 * Ajax call to logout and record logout time
 *
*/	
	
	function logout_hrts(){
		
		$.post('logOut.php').done(function(data){ 
			   if(data == 'completed'){ window.location = "/hrts";}
			   else{alert(data);}
			   });
		
	}
	
/********************************************************************* Loggin Document info *************************************************************************************************/
	
/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getDocumentTrackingForm(){
		
		bundle = 0;
		
		$.get('document_form.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   setDocumentTrackingForm();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setDocumentTrackingForm(){
		
		$("#moreInfo").hide();
		
		startDatePicker();
		
		startDatePicker2();
     
		
		$( "#captureDoc" ).dialog({
		
			title: "Mail Login",
			height: 280,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv'), within: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Show Document List", click: function() {show_document_list(); }},
					   {text: "Search", click: function() { getAddDocument(); }
			
					}]
		});		
	//	});
	}


	
	function show_document_list(){
		
		window.open('blank_page.php?dataType=document','_newtab');	
		
	}
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function searchDocumentData(){
		
		$.post('find_document_form.php',{documentType: captureDocForm.documentType.value, receiptDate: captureDocForm.receiptDate.value}
			   ).done(function(data){
				   
			   //$(".ui-dialog-content").dialog("destroy");
			   
			   //$('#infoDiv').html(data);
			   if(data == "update"){
			   	alert('Internal number ' + captureDocForm.internal_number.value + ' document type ' + captureDocForm.documentType.value + ' received on ' + captureDocForm.receiptDate.value + ' has already been logged.');
				//getUpdateDocumentForm();
			   }
			   else if(data == "add"){
			   	getAddDocument();
			   }
			   else if(data == "Mis_Routed"){
			   	getAddMisRouted();
			   }
			   
			   });
		
	}
	
	
/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume){
		
		//alert(delivery_company + " " +	more_info + " " + delivery_tracking + " " + document_type + " " + manufacturer + " " + cd + " " + paper + " " + volume);
		
		
		$.post('add_bundle_form.php',{documentType: document_type, deliveryCompany: delivery_company, moreInfo: more_info, deliveryTracking: delivery_tracking, manufacturer: manufacturer, cd: cd, usb: usb, paper: paper, volume: volume}).done(function(data){ 
			   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setAddDocument();
			   
			   });
		
	}
	
	
/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getAddDocument(){
		
		$.post('add_document_form.php',{documentType: captureDocForm.documentType.value, receiptDate: captureDocForm.receiptDate.value}).done(function(data){ 
			   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setAddDocument();
			   
			   });
		
	}
	
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setAddDocument(){
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#captureDoc" ).dialog({
		
			title: "Add Mail To Log",
			height: 570,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save Bundle", click: function() {copyData(); document_save_comfirmation(); }},
					   {text: "Save", click: function() { bundle = 0; document_save_comfirmation(); }
			
					}]
		});		
		
	}
	
	
	function copyData(){
	 
		delivery_company = captureDocForm.deliveryCompany.value; 
		more_info = captureDocForm.moreInfo.value;
		delivery_tracking = captureDocForm.deliveryTracking.value; 
		document_type = captureDocForm.documentType.value; 
		manufacturer = captureDocForm.manufacturer.value; 
		cd = captureDocForm.cd.value; 
		usb = captureDocForm.usb.value;
		paper = captureDocForm.paper.value; 
		volume = captureDocForm.volume.value;
		
		//alert(delivery_company + " " +	more_info + " " + delivery_tracking + " " + document_type + " " + manufacturer + " " + cd + " " + paper + " " + volume);
		
		bundle = 1;
		
	}
	
		
/**
 *
 * Ajax call to add mail data to doucment table
 *
*/
	
	function addDocument(){
		
		if(captureDocForm.document_type_id.value == "MAF"){
		
			if(captureDocForm.moreInfo.value){
				
				$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				  // $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   if(bundle == 1){
					   
						getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume);  
					   
				   }
				   else{
					
				   getAddDocument();
				   }
				   
				   });
				
			}
			
			else{$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				   //$(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				    if(bundle == 1){
					   
					  getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume); 
					   
				   }
				   else{
				   
				   getAddDocument();
				   }
				   
				   });
			}
		}
		
	else if(captureDocForm.document_type_id.value == "P"){
		
			if(captureDocForm.moreInfo.value){
				
				$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, fdaAppNumberSup2: captureDocForm.fdaAppNumberSup3.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				   //$(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   if(bundle == 1){
					   
						getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume);  
					   
				   }
				   else{
					
				   getAddDocument();
				   }
				   
				   });
				
			}
			
			else{$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, fdaAppNumberSup2: captureDocForm.fdaAppNumberSup3.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				   //$(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				    if(bundle == 1){
					   
					  getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume); 
					   
				   }
				   else{
				   
				   getAddDocument();
				   }
				   
				   });
			}
		}
		
		else if(captureDocForm.document_type_id.value == "R"){//alert(captureDocForm.reportType.value);
			
			if(captureDocForm.moreInfo.value){
				
				$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, reportType: captureDocForm.reportType.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				  // $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				    if(bundle == 1){
					   
					 	getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume);  
					   
				   }
				   else{
				   
				   getAddDocument();
				   }
				   
				   });
				
			}
			
			else{$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, reportType: captureDocForm.reportType.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				  // $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				    if(bundle == 1){
					   
					   getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume);
					   
				   }
				   else{
				   
				   getAddDocument();
				   }
				   
				   });
			}	
			
		}
		
		else{
			
			if(captureDocForm.moreInfo.value){
				
				$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				  // $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				    if(bundle == 1){
					   
					 	getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume);  
					   
				   }
				   else{
				  
				   getAddDocument();
				   }
				   
				   });
				
			}
			
			else{$.post('add_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				   //$(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				    if(bundle == 1){
					   
					   getBundle(delivery_company,more_info,delivery_tracking,document_type,manufacturer,cd,usb,paper,volume);
					   
				   }
				   else{
				   
				   getAddDocument();
				   }
				   
				   });
			}	
			
		}
		
	}
	
/* Comfirmation */	
function document_save_comfirmation(){
		
		$.get('confirmation_modal.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   		set_confirmation_modal();
			   
			   });
		
	}
	
	function set_confirmation_modal(){
		
		$( "#confirmation" ).dialog({
		
			title: "Mail Login Confirmation",
			height: 200,
			width: 650,
			//position: {my: "left top", at: "left top", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: true,
			modal: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [
			
					   {text: "No", click: function() { $("#confirmation").dialog("destroy"); }},
					   {text: "Yes", click: function() { $("#confirmation").dialog("destroy"); addDocument(); }
			
					}]
		});		
		
	}
	
	
	
/********************************************************************* edit logged in Document ***********************************************************************************************/	
	
/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getDocumentTrackingForm2(){
		
		$.get('document_edit_form.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   setDocumentTrackingForm2();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setDocumentTrackingForm2(){
		
		$("#moreInfo").hide();
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#captureDoc" ).dialog({
		
			title: "Edit Mail Login",
			height: 280,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Show Document List", click: function() {show_document_list(); }},
					   {text: "Search", click: function() { searchDocumentData2(); }
			
					}]
		});		
		
	}
	
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function searchDocumentData2(){
		
		$.post('find_document_form.php',{internal_number: captureDocForm.internal_number.value, documentType: captureDocForm.documentType.value, receiptDate: captureDocForm.receiptDate.value}
			   ).done(function(data){
				   
			   //$(".ui-dialog-content").dialog("destroy");
			   
			   //$('#infoDiv').html(data);
			   if(data == "update"){
			   	//alert('update document');
				getUpdateDocumentForm();
			   }
			   else if(data == "add"){
			   	//getAddDocument();
				
				alert('Internal number ' + captureDocForm.internal_number.value + ' document type ' + captureDocForm.documentType.value + ' received on ' + captureDocForm.receiptDate.value + ' does not exist.');
			   }
			   
			   });
		
	}
	
/**
 *
 * Ajax call to update document data
 *
*/	
	
	function getUpdateDocumentForm(){
		
		
		$.post('update_document_form.php',{internal_number: captureDocForm.internal_number.value, documentType: captureDocForm.documentType.value, receiptDate: captureDocForm.receiptDate.value}).done(function(data){ 
			   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setUpdateDocumentForm();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setUpdateDocumentForm(){
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#captureDoc" ).dialog({
		
			title: "Update Document",
			height: 550,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save", click: function() {document_edit_comfirmation(); }
			
					}]
		});		
		
	}
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function updateDocumentForm(){
		
		if(captureDocForm.document_type_id.value == "MAF"){
		
			if(captureDocForm.moreInfo.value){
				
				$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
				
			}
			
			else{$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
			}
		}
		
		
		else if(captureDocForm.document_type_id.value == "P"){
		
			if(captureDocForm.moreInfo.value){
				
				$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, fdaAppNumberSup2: captureDocForm.fdaAppNumberSup3.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
				
			}
			
			else{$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber2.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup2.value, fdaAppNumberSup2: captureDocForm.fdaAppNumberSup3.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
			}
		}
		
		else if(captureDocForm.document_type_id.value == "R"){//alert(captureDocForm.reportType.value);
			
			if(captureDocForm.moreInfo.value){
				
				$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, reportType: captureDocForm.reportType.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   
				   });
				
			}
			
			else{$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, reportType: captureDocForm.reportType.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
			}	
			
		}
		
		
		else{
			
			if(captureDocForm.moreInfo.value){
				
				$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: captureDocForm.moreInfo.value,deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value, manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
				
			}
			
			else{$.post('update_document_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, deliveryCompany: captureDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: captureDocForm.deliveryTracking.value, document_type_id: captureDocForm.document_type_id.value, fdaAppNumber: captureDocForm.fdaAppNumber.value, fdaAppNumberSup: captureDocForm.fdaAppNumberSup.value, documentType: captureDocForm.documentType.value,manufacturer: captureDocForm.manufacturer.value, cd: captureDocForm.cd.value, usb: captureDocForm.usb.value, paper: captureDocForm.paper.value, volume: captureDocForm.volume.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
			}	
			
		}
		
		
	}


/* Comfirmation */	
function document_edit_comfirmation(){
		
		$.get('confirmation_modal.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   		set_confirmation_edit_modal();
			   
			   });
		
	}
	
	function set_confirmation_edit_modal(){
		
		$( "#confirmation" ).dialog({
		
			title: "Edit Mail Login Confirmation",
			height: 200,
			width: 650,
			//position: {my: "left top", at: "left top", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: true,
			modal: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [
			
					   {text: "No", click: function() { $("#confirmation").dialog("destroy"); }},
					   {text: "Yes", click: function() { $("#confirmation").dialog("destroy"); updateDocumentForm(); }
			
					}]
		});		
		
	}
	
/********************************************************* Misrouted Mail ******************************************************************************************/

	/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getAddMisRouted(){
		
		$.post('add_misrouted_form.php').done(function(data){ 
			   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setAddMisRouted();
			   
			   });
		
	}	
	
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setAddMisRouted(){
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#misroutedDoc" ).dialog({
		
			title: "Misrouted Mail",
			height: 350,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save", click: function() { misroute_comfirmation(); }
			
					}]
		});		
		
	}
	
	function addmisrouted(){
		
		if(misroutedDocForm.moreInfo.value){
			
			$.post('add_misrouted_data.php',{ receiptDate: misroutedDocForm.receiptDate.value, deliveryCompany: misroutedDocForm.deliveryCompany.value, moreInfo: misroutedDocForm.moreInfo.value,deliveryTracking: misroutedDocForm.deliveryTracking.value, comment: misroutedDocForm.comment.value, documentType: misroutedDocForm.documentType.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   });
			
		}
		
		else{$.post('add_misrouted_data.php',{ receiptDate: misroutedDocForm.receiptDate.value, deliveryCompany: misroutedDocForm.deliveryCompany.value, moreInfo: " ", deliveryTracking: misroutedDocForm.deliveryTracking.value, documentType: misroutedDocForm.documentType.value, comment: misroutedDocForm.comment.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   });
		}
		
	}	
	


/* Comfirmation */	
function misroute_comfirmation(){
		
		$.get('confirmation_modal.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   		set_misroute_confirmation_modal();
			   
			   });
		
	}
	
	function set_misroute_confirmation_modal(){
		
		$( "#confirmation" ).dialog({
		
			title: "Misrouted Mail Confirmation",
			height: 200,
			width: 650,
			//position: {my: "left top", at: "left top", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: true,
			modal: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [
			
					   {text: "No", click: function() { $("#confirmation").dialog("destroy"); }},
					   {text: "Yes", click: function() { $("#confirmation").dialog("destroy"); addmisrouted(); }
			
					}]
		});		
		
	}

/********************************************************************* Document Processing *************************************************************************************************/
	
function documentProcessingForm(){
		
		$.get('document_processing_form.php', {group: <?php echo('"'.$_SESSION["group"].'"'); ?>}).done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   status = "start";
			   
			   setDocumentProcessingForm();
			   
			   });
		
	}
	
	function setDocumentProcessingForm(){
		
		startDatePicker();
		
		$( "#processDoc" ).dialog({
		
			title: "Initial Document Processing",
			height: 350,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Search", click: function() {startDocumentProcessingForm(); }
			
					}]
		});
		
	}

	
	function startDocumentProcessingForm(){
	
		$.post('start_document_processing_form.php',{internal_number: processDocForm.internal_number.value, receiptDate: processDocForm.receiptDate.value, /*document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup.value,*/ group: processDocForm.group.value}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setStartDocumentProcessingForm();
			   
			   });
		
		
	}
	
	function setStartDocumentProcessingForm(){
		
		startDatePicker();
		
		$( "#processDoc" ).dialog({
		
			title: "Start Processing Document",
			height: 250,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
					  
						text: "Cancel", click: function() {cancel_button(); }},
			
					   {text: "Start Processing", click: function() { updateDocumentProcessingForm(); }
			
					}]
		});
		
	}
	
	function endDocumentProcessingForm(){
	
		$.post('end_document_processing_form.php',{internal_number: processDocForm.internal_number.value, receiptDate: processDocForm.receiptDate.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup.value, group: processDocForm.group.value}
			   ).done(function(data){
				   
				 $(".ui-dialog-content").dialog("destroy");
				 
				 //alert(status);
			   
			   $('#infoDiv').html(data);
			   
			   setEndDocumentProcessingForm();
			   
			   });			
		
	}
	
	function setEndDocumentProcessingForm(){
		
		startDatePicker();
		
		$( "#processDoc" ).dialog({
		
			title: "Stop Processing Document",
			height: 250,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Pause", click: function() {pause_processing(); }},
					   {text: "Stop", click: function() { status = processDocForm.status.value; document_processing_comfirmation(); }
			
					}]
		});
		
	}

function pause_processing(){
		
		$.get('pause_processing.php',{internal_number: processDocForm.internal_number.value, receiptDate: processDocForm.receiptDate.value, document_type_id: processDocForm.document_type_id.value, status:'pause'}).done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   		set_pause_processing();
			   
			   });
		
	}
	
	function set_pause_processing(){
		
		$( "#pause_msg" ).dialog({
		
			title: "Processing Paused",
			height: 200,
			width: 650,
			//position: {my: "left top", at: "left top", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: true,
			modal: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [

					   {text: "Unpause", click: function() { unpause_processing(); }
			
					}]
		});		
		
	}
	
function unpause_processing(){
		
		$.get('pause_processing.php',{internal_number: processDocForm.internal_number.value, receiptDate: processDocForm.receiptDate.value, document_type_id: processDocForm.document_type_id.value, status:'unpause'}).done(function(data){ 
			   
			    $('#infoDiv').html(data);
			   
			   });
}
	
function updateDocumentProcessingForm(){
		
		if(processDocForm.document_type_id.value == "MAF"){
		$.post('update_document_processing_data.php',{internal_number: processDocForm.internal_number.value, documentType: processDocForm.documentType.value, receiptDate: processDocForm.receiptDate.value, action: status, group: processDocForm.group.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber2.value, fdaAppSupLetter: processDocForm.fdaAppSupLetter2.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup2.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
				   
				if(data == "no_match"){
					
					alert('Mail entry not found for ' + processDocForm.internal_number.value +' .');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentProcessingForm();	
					
				}
				
				
				else if(data == "started_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' started processing.');
					
					status = 'processing';
					
					//$(".ui-dialog-content").dialog("destroy");
					
					endDocumentProcessingForm(); 	
					
				}

				
				else if(data == "completed_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' completed processing.');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentProcessingForm(); 	
					
				}
				else{ alert(data); }
			   
			   });
		
		}
		
	else if(processDocForm.document_type_id.value == "P"){
		$.post('update_document_processing_data.php',{internal_number: processDocForm.internal_number.value, documentType: processDocForm.documentType.value, receiptDate: processDocForm.receiptDate.value, action: status, group: processDocForm.group.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber2.value, fdaAppSupLetter: processDocForm.fdaAppSupLetter2.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup2.value, fdaAppSupLetter2: processDocForm.fdaAppSupLetter3.value, fdaAppNumberSup2: processDocForm.fdaAppNumberSup3.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
				   
				if(data == "no_match"){
					
					alert('Mail entry not found for ' + processDocForm.internal_number.value +' .');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentProcessingForm();	
					
				}
				
				
				else if(data == "started_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' started processing.');
					
					status = 'processing';
					
					//$(".ui-dialog-content").dialog("destroy");
					
					endDocumentProcessingForm(); 	
					
				}

				
				else if(data == "completed_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' completed processing.');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentProcessingForm(); 	
					
				}
				else{ alert(data); }
			   
			   });
		
		}
	
	else{
	$.post('update_document_processing_data.php',{internal_number: processDocForm.internal_number.value, documentType: processDocForm.documentType.value, receiptDate: processDocForm.receiptDate.value, action: status, group: processDocForm.group.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber.value, fdaAppSupLetter: processDocForm.fdaAppSupLetter.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
				   
				if(data == "no_match"){
					
					alert('Mail entry not found for ' + processDocForm.internal_number.value +' .');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentProcessingForm();	
					
				}
				
				
				else if(data == "started_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' started processing.');
					
					status = 'processing';
					
					//$(".ui-dialog-content").dialog("destroy");
					
					endDocumentProcessingForm(); 	
					
				}

				
				else if(data == "completed_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' completed processing.');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentProcessingForm(); 	
					
				}
				else{ alert(data); }
			   
			   });
	}
		
}
	
	
	/* Comfirmation */	
function document_processing_comfirmation(){
		
		$.get('confirmation_modal.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   		set_document_processing_modal();
			   
			   });
		
	}
	
	function set_document_processing_modal(){
		
		$( "#confirmation" ).dialog({
		
			title: "Document Processing Confirmation",
			height: 200,
			width: 650,
			//position: {my: "left top", at: "left top", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: true,
			modal: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [
			
					   {text: "No", click: function() { $("#confirmation").dialog("destroy"); }},
					   {text: "Yes", click: function() { $("#confirmation").dialog("destroy"); updateDocumentProcessingForm(); }
			
					}]
		});		
		
	}

/********************************************************************* Document Reprocessing *************************************************************************************************/
	
function documentReprocessingForm(){
		
		$.get('document_processing_form.php', {group: <?php echo('"'.$_SESSION["group"].'"'); ?>}).done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   status = "start";
			   
			   setDocumentReprocessingForm();
			   
			   });
		
	}
	
	function setDocumentReprocessingForm(){
		
		startDatePicker();
		
		$( "#processDoc" ).dialog({
		
			title: "Document Correction Processing",
			height: 350,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Search", click: function() {startDocumentReprocessingForm(); }
			
					}]
		});
		
	}
	
	
	function startDocumentReprocessingForm(){
		
		$.post('start_document_processing_form.php',{internal_number: processDocForm.internal_number.value, receiptDate: processDocForm.receiptDate.value, group: processDocForm.group.value}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setStartDocumentReprocessingForm();
			   
			   });
		
	}
	
	function setStartDocumentReprocessingForm(){
		
		startDatePicker();
		
		$( "#processDoc" ).dialog({
		
			title: "Start Processing Document",
			height: 250,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
					  
						text: "Cancel", click: function() {cancel_button(); }},
			
					   {text: "Start Processing", click: function() { updateDocumentReprocessingForm(); }
			
					}]
		});
		
	}
	
	function endDocumentReprocessingForm(){
		
		$.post('end_document_processing_form.php',{internal_number: processDocForm.internal_number.value, receiptDate: processDocForm.receiptDate.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup.value, group: processDocForm.group.value}
			   ).done(function(data){
				   
				 $(".ui-dialog-content").dialog("destroy");
				 
				 //alert(status);
			   
			   $('#infoDiv').html(data);
			   
			   setEndDocumentReprocessingForm();
			   
			   });
		
	}
	
	function setEndDocumentReprocessingForm(){
		
		startDatePicker();
		
		$( "#processDoc" ).dialog({
		
			title: "Stop Processing Document",
			height: 250,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					    text: "Cancel", click: function() {cancel_button(); }},
					   //{text: "Dropout", click: function() {status = "dropout"; updateDocumentReprocessingForm(); }},
					   {text: "Stop", click: function() { status = processDocForm.status.value; document_reprocessing_comfirmation(); }
			
					}]
		});
		
	}
	
	
	function updateDocumentReprocessingForm(){
		
		if(processDocForm.document_type_id.value == "MAF"){
		$.post('update_document_reprocessing_data.php',{internal_number: processDocForm.internal_number.value, documentType: processDocForm.documentType.value, receiptDate: processDocForm.receiptDate.value, action: status, group: processDocForm.group.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber2.value, fdaAppSupLetter: processDocForm.fdaAppSupLetter2.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup2.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
				   
				if(data == "no_match"){
					
					alert('Mail entry not found for ' + processDocForm.internal_number.value +' .');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentReprocessingForm();	
					
				}
				
				
				else if(data == "started_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' started processing.');
					
					status = 'processing';
					
					//$(".ui-dialog-content").dialog("destroy");
					
					endDocumentReprocessingForm(); 	
					
				}

				
				else if(data == "completed_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' completed processing.');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentReprocessingForm(); 	
					
				}
				else{ alert(data); }
			   
			   });
		
		}
		
	else if(processDocForm.document_type_id.value == "P"){
		$.post('update_document_processing_data.php',{internal_number: processDocForm.internal_number.value, documentType: processDocForm.documentType.value, receiptDate: processDocForm.receiptDate.value, action: status, group: processDocForm.group.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber2.value, fdaAppSupLetter: processDocForm.fdaAppSupLetter2.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup2.value, fdaAppSupLetter2: processDocForm.fdaAppSupLetter3.value, fdaAppNumberSup2: processDocForm.fdaAppNumberSup3.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
				   
				if(data == "no_match"){
					
					alert('Mail entry not found for ' + processDocForm.internal_number.value +' .');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentReprocessingForm();	
					
				}
				
				
				else if(data == "started_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' started processing.');
					
					status = 'processing';
					
					//$(".ui-dialog-content").dialog("destroy");
					
					endDocumentReprocessingForm(); 	
					
				}

				
				else if(data == "completed_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' completed processing.');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentReprocessingForm(); 	
					
				}
				else{ alert(data); }
			   
			   });
		
		}
	
	else{
	$.post('update_document_reprocessing_data.php',{internal_number: processDocForm.internal_number.value, documentType: processDocForm.documentType.value, receiptDate: processDocForm.receiptDate.value, action: status, group: processDocForm.group.value, document_type_id: processDocForm.document_type_id.value, fdaAppNumber: processDocForm.fdaAppNumber.value, fdaAppSupLetter: processDocForm.fdaAppSupLetter.value, fdaAppNumberSup: processDocForm.fdaAppNumberSup.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
				   
				if(data == "no_match"){
					
					alert('Mail entry not found for ' + processDocForm.internal_number.value +' .');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentReprocessingForm();	
					
				}
				
				
				else if(data == "started_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' started processing.');
					
					status = 'processing';
					
					//$(".ui-dialog-content").dialog("destroy");
					
					endDocumentReprocessingForm(); 	
					
				}

				
				else if(data == "completed_processing"){
					
					//alert('Internal number: ' + processDocForm.internal_number.value + ' completed processing.');
					
					$(".ui-dialog-content").dialog("destroy");
					
					documentReprocessingForm(); 	
					
				}
				else{ alert(data); }
			   
			   });
	}
		
	
		
	}
	
	/* Comfirmation */	
function document_reprocessing_comfirmation(){
		
		$.get('confirmation_modal.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   		set_document_reprocessing_modal();
			   
			   });
		
	}
	
	function set_document_reprocessing_modal(){
		
		$( "#confirmation" ).dialog({
		
			title: "Document Correction Processing Confirmation",
			height: 200,
			width: 650,
			//position: {my: "left top", at: "left top", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: true,
			modal: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [
			
					   {text: "No", click: function() { $("#confirmation").dialog("destroy"); }},
					   {text: "Yes", click: function() { $("#confirmation").dialog("destroy"); updateDocumentReprocessingForm(); }
			
					}]
		});		
		
	}
	
/************************************************************** Mail Transfer ***************************************************************/

/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getMailTransferForm(){
		
		$.get('mail_transfer_form.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   setMailTransferForm();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setMailTransferForm(){
		
		startDatePicker();
		
		startDatePicker2();
		
		$("#reviewer").hide();
		$("#reviewer_label").hide();
		
		$("#reviewer2").hide();
		$("#reviewer_label2").hide();
		
		$( "#mail_Transfer" ).dialog({
		
			title: "Mail Transfer",
			height: 520,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save", click: function() { updateMailTransferData(); }
			
					}]
		});		
		
	}
	
function updateMailTransferData(){
	
	if(mailTransferForm.reviewer.value){
		
		reviewer = mailTransferForm.reviewer.value;
		
	}
	else { reviewer = ' '; }
	
	if(mailTransferForm.reviewer2.value){
		
		reviewer2 = mailTransferForm.reviewer2.value;
		
	}
	else { reviewer2 = ' '; }
	
	
	
	if(mailTransferForm.staff_name.value){
		
		staff = mailTransferForm.staff_name.value;
		
	}
	else { staff = ' '; }
	
	if(mailTransferForm.staff_name2.value){
		
		staff2 = mailTransferForm.staff_name2.value;
		
	}
	else { staff2 = ' '; }
	
	if(mailTransferForm.internal_number.value){
		
		internal_number_value = mailTransferForm.internal_number.value;
		receiptDate_value = mailTransferForm.receiptDate.value;
		documentType_value = mailTransferForm.documentType.value;
		
	}
	
	else{
		
		internal_number_value = "";
		receiptDate_value = "";
		documentType_value = "";
		
	}
	
	
		if(mailTransferForm.document_type_id.value == "MAF"){
			
			//alert(mailTransferForm.fdaAppSupLetter2.value);
			
		$.post('update_mail_transfer.php',{receiptDate: receiptDate_value, documentType: documentType_value, internal_number: internal_number_value, fromLocation: mailTransferForm.fromLocation.value, toLocation: mailTransferForm.toLocation.value, staff: staff, staff2: staff2, reviewer: reviewer, reviewer2: reviewer2, reason: mailTransferForm.reason.value, deliveryDate: mailTransferForm.deliveryDate.value, deliveryTimeHour: mailTransferForm.deliveryTimeHour.value, deliveryTimeMinute: mailTransferForm.deliveryTimeMinute.value, deliveryTimeAmPm: mailTransferForm.deliveryTimeAmPm.value, document_type_id: mailTransferForm.document_type_id.value, fdaAppNumber: mailTransferForm.fdaAppNumber2.value, fdaAppSupLetter: mailTransferForm.fdaAppSupLetter2.value, fdaAppNumberSup: mailTransferForm.fdaAppNumberSup2.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			    $('#infoDiv').html(data);
			   
			   });
			   
		}
		
		else if(mailTransferForm.document_type_id.value == "P"){
			
			//alert(mailTransferForm.fdaAppSupLetter2.value);
			
		$.post('update_mail_transfer.php',{receiptDate: receiptDate_value, documentType: documentType_value, internal_number: internal_number_value, fromLocation: mailTransferForm.fromLocation.value, toLocation: mailTransferForm.toLocation.value, staff: staff, staff2: staff2, reviewer: reviewer, reviewer2: reviewer2, reason: mailTransferForm.reason.value, deliveryDate: mailTransferForm.deliveryDate.value, deliveryTimeHour: mailTransferForm.deliveryTimeHour.value, deliveryTimeMinute: mailTransferForm.deliveryTimeMinute.value, deliveryTimeAmPm: mailTransferForm.deliveryTimeAmPm.value, document_type_id: mailTransferForm.document_type_id.value, fdaAppNumber: mailTransferForm.fdaAppNumber3.value, fdaAppSupLetter: mailTransferForm.fdaAppSupLetter3.value, fdaAppNumberSup: mailTransferForm.fdaAppNumberSup3.value, fdaAppSupLetter2: mailTransferForm.fdaAppSupLetter4.value, fdaAppNumberSup2: mailTransferForm.fdaAppNumberSup4.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			    $('#infoDiv').html(data);
			   
			   });
			   
		}
		
		else{//alert(mailTransferForm.fdaAppSupLetter.value);
			
			$.post('update_mail_transfer.php',{receiptDate: receiptDate_value, documentType: documentType_value, internal_number: internal_number_value, fromLocation: mailTransferForm.fromLocation.value, toLocation: mailTransferForm.toLocation.value, staff: staff, staff2: staff2, reviewer: reviewer, reviewer2: reviewer2, reason: mailTransferForm.reason.value, deliveryDate: mailTransferForm.deliveryDate.value, deliveryTimeHour: mailTransferForm.deliveryTimeHour.value, deliveryTimeMinute: mailTransferForm.deliveryTimeMinute.value, deliveryTimeAmPm: mailTransferForm.deliveryTimeAmPm.value, document_type_id: mailTransferForm.document_type_id.value, fdaAppNumber: mailTransferForm.fdaAppNumber.value, fdaAppSupLetter: mailTransferForm.fdaAppSupLetter.value,fdaAppNumberSup: mailTransferForm.fdaAppNumberSup.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			    $('#infoDiv').html(data);
			   
			   });
		}
		
}

/**===================================================================== Administrative Functions ==============================================**/

/********************************************************************** Add Employee ******************************************************************/

function addEmployeeForm(){
		
		$.get('add_employee_form.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   setAddEmployeeForm();
			   
			   });
		
	}
	
	function setAddEmployeeForm(){
		
		$( "#add_employee_div" ).dialog({
		
			title: "Add Employee",
			height: 400,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save", click: function() { addEmployeeData(); }
			
					}]
		})
		
	}	
	
	function addEmployeeData(){
		
	
		$.post('add_employee_data.php',{first_name: add_employee_form.first_name.value, last_name: add_employee_form.last_name.value, email: add_employee_form.email.value, role: add_employee_form.role.value, group: add_employee_form.group.value, organization: add_employee_form.organization.value, status: add_employee_form.status.value,  modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			    $('#infoDiv').html(data);
			   
			   });
		
	}
	
/********************************************************************** Modifiy Employee ******************************************************************/

function getUpdateEmployee(){
		
		$.get('select_employee.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			  setUpdateEmployee();
			   
			   });
		
	}
	

	
	function setUpdateEmployee(){
		
		$( "#selectUpdateEmployee" ).dialog({
		
			title: "Modify Employee",
			height: 210,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Search", click: function() { updateEmployeeForm(); }
			
					}]
		});		
		
	}

function updateEmployeeForm(){
		
		$.post('update_employee_form.php',{id: selectUpdateEmployeeForm.employeeName.value}
			   ).done(function(data){
			
				$(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setUpdateEmployeeForm();
			   
			   });
		
	}
	
	function setUpdateEmployeeForm(){
		
		$( "#update_employee_div" ).dialog({
		
			title: "Update Employee",
			height: 400,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save", click: function() { updateEmployeeData(); }
			
					}]
		})
		
	}	
	
	function updateEmployeeData(){
		
	
		$.post('update_employee_data.php',{id: update_employee_form.id.value, first_name: update_employee_form.first_name.value, last_name: update_employee_form.last_name.value, email: update_employee_form.email.value, /*password: update_employee_form.password.value,*/ role: update_employee_form.role.value, group: update_employee_form.group.value, organization: update_employee_form.organization.value, status: update_employee_form.status.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			    $('#infoDiv').html(data);
			   
			   });
		
	}
	
/***************************************************************Modify Attendance***********************************************************************/

/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getModifyEmployeeAttendanceForm(){
		
		$.get('modify_attendance.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   setModifyEmployeeAttendanceForm();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setModifyEmployeeAttendanceForm(){
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#modifyEmployeeAttendance" ).dialog({
		
			title: "Modify Employee Attendance",
			height: 220,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Search", click: function() { getUpdateModifyEmployeeAttendanceForm(); }
			
					}]
		});		
		
	}
	
	function getUpdateModifyEmployeeAttendanceForm(){
		
		
		$.post('modify_employee_time_form.php',{id: modifyEmployeeAttendanceForm.employeeName.value, date: modifyEmployeeAttendanceForm.modifyDate.value}).done(function(data){ 
			   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setUpdateModifyEmployeeAttendanceForm();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setUpdateModifyEmployeeAttendanceForm(){
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#updateModifyAttendance" ).dialog({
		
			title: "Modify Employee Attendance",
			height: 310,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Update", click: function() { updateModifyEmployeeAttendanceForm(); }
			
					}]
		});			
		
	}
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function updateModifyEmployeeAttendanceForm(){
		
	
		$.post('update_employee_time_form.php',{id: updateModifyAttendanceForm.id.value, date: updateModifyAttendanceForm.modifyDate.value, loginTimeHour: updateModifyAttendanceForm.loginTimeHour.value, loginTimeMinute: updateModifyAttendanceForm.loginTimeMinute.value, loginTimeAmPm: updateModifyAttendanceForm.loginTimeAmPm.value, logoutTimeHour: updateModifyAttendanceForm.logoutTimeHour.value, logoutTimeMinute: updateModifyAttendanceForm.logoutTimeMinute.value, logoutTimeAmPm: updateModifyAttendanceForm.logoutTimeAmPm.value, startLunchTimeHour: updateModifyAttendanceForm.startLunchTimeHour.value, startLunchTimeMinute: updateModifyAttendanceForm.startLunchTimeMinute.value, startLunchTimeAmPm: updateModifyAttendanceForm.startLunchTimeAmPm.value, endLunchTimeHour: updateModifyAttendanceForm.endLunchTimeHour.value, endLunchTimeMinute: updateModifyAttendanceForm.endLunchTimeMinute.value, endLunchTimeAmPm: updateModifyAttendanceForm.endLunchTimeAmPm.value, comments: updateModifyAttendanceForm.comments.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
			   ).done(function(data){
				   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   //$('#infoDiv').html(data);
			   
			   alert(data);
			   
			   });
		
	}
	
/*======================================================== Today Report =================================================================================*/
		
/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getTodayReportForm(){
		
		$.get('today_report_form.php').done(function(data){ 
													 
				$(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setTodayReportForm();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setTodayReportForm(){
		
		//startDatePicker2();
		
		$( "#todayReportTool" ).dialog({
		
			title: "Today Report",
			height: 250,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Process", click: function() { show_today_report(); }
			
					}]
		});
		
	}
	
	function show_today_report(){
		
		//answer = $('form input[type=radio]:checked').val();
		
		window.open('blank_page.php?sortType='+todayReportForm.sortType.value+'&dataType=today_report','_newtab');	
		
	}
	
/*======================================================== Summary Report =================================================================================*/
		
/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function getSummaryReportForm(){
		
		$.get('summary_report_form.php').done(function(data){
														 
				$(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setSummaryReportForm();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setSummaryReportForm(){
		
		startDatePicker();
		
		$( "#summaryReportTool" ).dialog({
		
			title: "Summary Report",
			height: 320,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: true,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Process", click: function() { show_summary_report(); }
			
					}]
		});
		
	}
	
	function show_summary_report(){
		
		//answer = $('form input[type=radio]:checked').val();
		
		//var selectedValues = $('#employeeName').val();
		
		var id_values = $('#employeeName').val();
		
		/** ie 7 fix **/
		
		var selectedValues = '[';
		
		for(i=0;i<id_values.length;i++){
			
			if(i != 0) {selectedValues += ','}
			
			selectedValues += '"' + id_values[i] + '"';
		
		}
		
		selectedValues += ']';
		
		//var selectedValues = '["1","2","3"]';
		
		//alert(selectedValues);
		//window.open('blank_page.php?ids='+JSON.stringify(selectedValues)+'&startdate='+summaryReportForm.startdate.value+'&enddate='+summaryReportForm.enddate.value+'&dataType=summary_report','_newtab');
		
		window.open('blank_page.php?ids='+selectedValues+'&startdate='+summaryReportForm.startdate.value+'&enddate='+summaryReportForm.enddate.value+'&dataType=summary_report','_newtab');	
		
	}
	
/************************************************************** Search by Tracking Number ************************************************************************/

function get_tracking_number_Form(){
		
		$.get('tracking_number_form.php').done(function(data){
														 
				$(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   set_tracking_number_Form();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function set_tracking_number_Form(){
		
		$( "#tracking_number_search_div" ).dialog({
		
			title: "Find Mail By Tracking Number",
			height: 250,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Search", click: function() { show_tracking_number(); }
			
					}]
		});
		
	}
	
	function show_tracking_number(){
		
		//answer = $('form input[type=radio]:checked').val();
		
		window.open('blank_page.php?trackingNumber='+tracking_number.deliveryTracking.value+'&deliveryCompany='+tracking_number.deliveryCompany.value+'&dataType=tracking_number_report','_newtab');	
			
	
	}
	
/******************************************** get_fda_number_Form() ******************************************************/

function get_fda_number_Form(){
		
		$.get('fda_number_form.php').done(function(data){
														 
				$(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   set_fda_number_Form();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function set_fda_number_Form(){
		
		$( "#fda_number_search_div" ).dialog({
		
			title: "Find Mail By FDA Application Number",
			height: 220,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Search", click: function() { show_fda_number(); }
			
					}]
		});
		
	}
	
	function show_fda_number(){
		
		//answer = $('form input[type=radio]:checked').val();
		
		window.open('blank_page.php?fdaNumber='+fda_number.fdaAppNumber.value+'&dataType=fda_number_report','_newtab');	
			
	
	}

/***************************************************** get_processing_status_Form() ********************************************************************/


function show_processing_status(){
		
		//answer = $('form input[type=radio]:checked').val();
		
		window.open('blank_page.php?dataType=processing_status_report','_newtab');	
			
	
	}
	
/*********************************************************** Modify Document Type ********************************************************************/

/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function modifyDocumentType(){
		
		$.get('modify_document_type_form.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   setModifyDocumentType();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setModifyDocumentType(){
		
		$("#moreInfo").hide();
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#captureDoc" ).dialog({
		
			title: "Modify Document Type",
			height: 280,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Show Document List", click: function() {show_document_list(); }},
					   {text: "Search", click: function() { searchtModifyDocumentType(); }
			
					}]
		});		
		
	}
	
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function searchtModifyDocumentType(){
		
		$.post('find_modify_document_type_form.php',{internal_number: captureDocForm.internal_number.value, documentType: captureDocForm.documentType.value, receiptDate: captureDocForm.receiptDate.value}
			   ).done(function(data){
				   
			   //$(".ui-dialog-content").dialog("destroy");
			   
			   //$('#infoDiv').html(data);
			   if(data == "update"){
			   	//alert('update document');
				getUpdateModifyDocumentType();
			   }
			   else if(data == "add"){
			   	//getAddDocument();
				
				alert('Internal number ' + captureDocForm.internal_number.value + ' document type ' + captureDocForm.documentType.value + ' received on ' + captureDocForm.receiptDate.value + ' does not exist.');
			   }
			   
			   });
		
	}
	
/**
 *
 * Ajax call to update document data
 *
*/	
	
	function getUpdateModifyDocumentType(){
		
		
		$.post('update_modify_document_type_form.php',{internal_number: captureDocForm.internal_number.value, documentType: captureDocForm.documentType.value, receiptDate: captureDocForm.receiptDate.value}).done(function(data){ 
			   
			   $(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   setUpdateModifyDocumentType();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function setUpdateModifyDocumentType(){
		
		startDatePicker();
		
		startDatePicker2();
		
		$( "#captureDoc" ).dialog({
		
			title: "Change Document Type",
			height: 280,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save", click: function() { updateModifyDocumentType(); }
			
					}]
		});		
		
	}
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function updateModifyDocumentType(){
				
				$.post('update_modify_document_type_data.php',{internal_number: captureDocForm.internal_number.value, receiptDate: captureDocForm.receiptDate.value, documentType: captureDocForm.documentType.value, documentType_old: captureDocForm.documentType_old.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
		
	}

/*********************************************************** Change Password ********************************************************************/

/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function change_password(){
		
		$.get('change_password_form.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   set_change_password();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function set_change_password(){
		
		
		$( "#change_password" ).dialog({
		
			title: "Change Password",
			height: 250,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Save", click: function() { submit_change_password(); }
			
					}]
		});		
		
	}
	
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function submit_change_password(){
		
		$.post('submit_change_password.php',{new_password: change_password_form.new_password.value, new_password_again: change_password_form.new_password_again.value, modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>,  id: <?php echo('"'.$_SESSION["id"].'"'); ?>}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
		
	}
	
/*********************************************************** Reset Password ********************************************************************/

/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function reset_password(){
		
		$.get('reset_password_form.php').done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   set_reset_password();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function set_reset_password(){
		
		
		$( "#resetPasswordEmployee" ).dialog({
		
			title: "Reset Employee Password",
			height: 220,
			width: 650,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Reset", click: function() { submit_reset_password(); }
			
					}]
		});		
		
	}
	
	
/**
 *
 * Ajax call to pass form parameters and  get document search results in table form
 *
*/
	
	function submit_reset_password(){
		
		$.post('submit_reset_password.php',{ modified: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>,  id: resetPasswordEmployeeForm.employeeName.value}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
		
	}
	
/*********************************************************** Internal Quality Control ********************************************************************/	


function get_internal_qc_form(){
	
	$.get('qc_internal_form.php',{group: <?php echo('"'.$_SESSION["group"].'"'); ?>}).done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   set_internal_qc_form();
			   
			   });	
	
}

function set_internal_qc_form(){
	
	$( "#qc_form" ).dialog({
			
				title: "Internal Quality Control Form",
				height:620,
				width: 650,
				position: {my: "top", at: "top", of: $('#infoDiv')},
				//position: [calculatedPosition,120],
				resizable: false,
				draggable: false,
				closeOnEscape: false,
				dialogClass: 'no-close changeBackground',
				buttons: [{
				
						   text: "Cancel", click: function() {cancel_button(); }},
						   {text: "Submit", click: function() { /*if($('#receipt_date').is(':checked')){alert(1);} else{alert(0);}*/ submit_internal_qc_data(); }
				
						}]
	});
	
}


function submit_internal_qc_data(){
	
	if($("#receipt_date").is(':checked')){receipt_date_value = 1;} else{ receipt_date_value = 0; }; //alert("receipt_date_value " + receipt_date_value);
	if($("#trade_name").is(':checked')){trade_name_value = 1;} else{ trade_name_value = 0; }; //alert("trade_name_value " + trade_name_value);
	if($("#common_name").is(':checked')){common_name_value = 1;} else{ common_name_value = 0; }; //alert("common_name_value " + common_name_value);
	if($("#applicant_information").is(':checked')){applicant_information_value = 1;} else{ applicant_information_value = 0; }; //alert("applicant_information_value " + applicant_information_value);
	if($("#fda_application_number").is(':checked')){fda_application_number_value = 1;} else{ fda_application_number_value = 0; }; //alert("fda_application_number_value " + fda_application_number_value);
	if($("#electronic_submission").is(':checked')){electronic_submission_value = 1;} else{ electronic_submission_value = 0; }; //alert("electronic_submission_value " + electronic_submission_value);
	if($("#manufacturer").is(':checked')){manufacturer_value = 1;} else{ manufacturer_value = 0; }; //alert("manufacturer_value " + manufacturer_value);
	if($("#document_type").is(':checked')){document_type_value = 1;} else{ document_type_value = 0; }; //alert("document_type_value " + document_type_value);
	if($("#sub_type").is(':checked')){sub_type_value = 1;} else{ sub_type_value = 0; }; //alert("document_type_value " + document_type_value);
	if($("#letter_date").is(':checked')){letter_date_value = 1;} else{ letter_date_value = 0; }; //alert("letter_date_value " + letter_date_value);
	if($("#panel").is(':checked')){panel_value = 1;} else{ panel_value = 0; }; //alert("panel_value " + panel_value);
	if($("#division").is(':checked')){division_value = 1;} else{ division_value = 0; }; //alert("division_value " + division_value);
	if($("#branch").is(':checked')){branch_value = 1;} else{ branch_value = 0; }; //alert("branch_value " + branch_value);
	if($("#product_code").is(':checked')){product_code_value = 1;} else{ product_code_value = 0; }; //alert("product_code_value " + product_code_value);
	if($("#jacket_color").is(':checked')){jacket_color_value = 1;} else{ jacket_color_value = 0; }; //alert("jacket_color_value " + jacket_color_value);
	if($("#acknowledgement_letter").is(':checked')){acknowledgement_letter_value = 1;} else{ acknowledgement_letter_value = 0; }; //alert("acknowledgement_letter_value " + acknowledgement_letter_value);
	if($("#other").is(':checked')){other_value = 1;} else{ other_value = 0; }; //alert("other_value " + other_value);
	
	grade = $(".grade:checked").val();
	
	if(grade == null){ alert("No documents in queue to submit."); get_internal_qc_form();}
	
	$.post('qc_internal_data.php',{ tis: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>, group: <?php echo('"'.$_SESSION["group"].'"'); ?>,   	qcList: qcForm.qcList.value, grade: grade, receipt_date: receipt_date_value, trade_name: trade_name_value, common_name: common_name_value, applicant_information: applicant_information_value, fda_application_number: fda_application_number_value, electronic_submission: electronic_submission_value, manufacturer: manufacturer_value, document_type: document_type_value, sub_type: sub_type_value, letter_date: letter_date_value, panel: panel_value, division: division_value, branch: branch_value, product_code: product_code_value, jacket_color: jacket_color_value, acknowledgement_letter: acknowledgement_letter_value, other: other_value, other_field: qcForm.other_field.value}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
	
}

/*********************************************************** External Quality Control ********************************************************************/	


function get_external_qc_form(){
	
	$.get('qc_external_form.php',{group: <?php echo('"'.$_SESSION["group"].'"'); ?>}).done(function(data){ 
			   
			   $('#infoDiv').html(data);
			   
			   set_external_qc_form();
			   
			   });	
	
}

function set_external_qc_form(){
	
	$( "#qc_form" ).dialog({
			
				title: "External Quality Control Form",
				height:690,
				width: 650,
				position: {my: "top", at: "top", of: $('#infoDiv')},
				//position: [calculatedPosition,120],
				resizable: false,
				draggable: false,
				closeOnEscape: false,
				dialogClass: 'no-close changeBackground',
				buttons: [{
				
						   text: "Cancel", click: function() {cancel_button(); }},
						   {text: "Submit", click: function() { submit_external_qc_data(); }
				
						}]
	});
	
}


function submit_external_qc_data(){
	
	if($("#receipt_date").is(':checked')){receipt_date_value = 1;} else{ receipt_date_value = 0; }; //alert("receipt_date_value " + receipt_date_value);
	if($("#trade_name").is(':checked')){trade_name_value = 1;} else{ trade_name_value = 0; }; //alert("trade_name_value " + trade_name_value);
	if($("#common_name").is(':checked')){common_name_value = 1;} else{ common_name_value = 0; }; //alert("common_name_value " + common_name_value);
	if($("#applicant_information").is(':checked')){applicant_information_value = 1;} else{ applicant_information_value = 0; }; //alert("applicant_information_value " + applicant_information_value);
	if($("#fda_application_number").is(':checked')){fda_application_number_value = 1;} else{ fda_application_number_value = 0; }; //alert("fda_application_number_value " + fda_application_number_value);
	if($("#electronic_submission").is(':checked')){electronic_submission_value = 1;} else{ electronic_submission_value = 0; }; //alert("electronic_submission_value " + electronic_submission_value);
	if($("#manufacturer").is(':checked')){manufacturer_value = 1;} else{ manufacturer_value = 0; }; //alert("manufacturer_value " + manufacturer_value);
	if($("#document_type").is(':checked')){document_type_value = 1;} else{ document_type_value = 0; }; //alert("document_type_value " + document_type_value);
	if($("#sub_type").is(':checked')){sub_type_value = 1;} else{ sub_type_value = 0; }; //alert("document_type_value " + document_type_value);
	if($("#letter_date").is(':checked')){letter_date_value = 1;} else{ letter_date_value = 0; }; //alert("letter_date_value " + letter_date_value);
	if($("#panel").is(':checked')){panel_value = 1;} else{ panel_value = 0; }; //alert("panel_value " + panel_value);
	if($("#division").is(':checked')){division_value = 1;} else{ division_value = 0; }; //alert("division_value " + division_value);
	if($("#branch").is(':checked')){branch_value = 1;} else{ branch_value = 0; }; //alert("branch_value " + branch_value);
	if($("#product_code").is(':checked')){product_code_value = 1;} else{ product_code_value = 0; }; //alert("product_code_value " + product_code_value);
	if($("#jacket_color").is(':checked')){jacket_color_value = 1;} else{ jacket_color_value = 0; }; //alert("jacket_color_value " + jacket_color_value);
	if($("#acknowledgement_letter").is(':checked')){acknowledgement_letter_value = 1;} else{ acknowledgement_letter_value = 0; }; //alert("acknowledgement_letter_value " + acknowledgement_letter_value);
	if($("#other").is(':checked')){other_value = 1;} else{ other_value = 0; }; //alert("other_value " + other_value);
	
	//changes to documents
	if($("#branch_change").is(':checked')){branch_change_value = 1;} else{ branch_change_value = 0; }; //alert("receipt_date_value " + receipt_date_value);
	if($("#panel_change").is(':checked')){panel_change_value = 1;} else{ panel_change_value = 0; }; //alert("trade_name_value " + trade_name_value);
	if($("#product_code_change").is(':checked')){product_code_change_value = 1;} else{ product_code_change_value = 0; }; //alert("common_name_value " + common_name_value);
	if($("#incomplete_response").is(':checked')){incomplete_response_value = 1;} else{ incomplete_response_value = 0; }; //alert("applicant_information_value " + applicant_information_value);
	if($("#deletions").is(':checked')){deletions_value = 1;} else{ deletions_value = 0; }; //alert("fda_application_number_value " + fda_application_number_value);
	if($("#document_type_change").is(':checked')){document_type_change_value = 1;} else{ document_type_change_value = 0; }; //alert("electronic_submission_value " + electronic_submission_value);
	if($("#sub_type_change").is(':checked')){sub_type_change_value = 1;} else{ sub_type_change_value = 0; }; //alert("electronic_submission_value " + electronic_submission_value);
	if($("#hold_request").is(':checked')){hold_request_value = 1;} else{ hold_request_value = 0; }; //alert("manufacturer_value " + manufacturer_value);
	if($("#logout_code").is(':checked')){logout_code_value = 1;} else{ logout_code_value = 0; }; //alert("document_type_value " + document_type_value);
	if($("#close_out_code").is(':checked')){close_out_code_value = 1;} else{ close_out_code_value = 0; }; //alert("letter_date_value " + letter_date_value);
	if($("#conversion").is(':checked')){conversion_value = 1;} else{ conversion_value = 0; }; //alert("letter_date_value " + letter_date_value);
	
	if($("#comment_change").val()){comment_change = $("#comment_change").val()} else{comment_change = '';}
	
	if(qcForm.document_type_id.value == "MAF"){
	$.post('qc_external_data.php',{ tis: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>, group: <?php echo('"'.$_SESSION["group"].'"'); ?>,  receipt_date: receipt_date_value, trade_name: trade_name_value, common_name: common_name_value, applicant_information: applicant_information_value, fda_application_number: fda_application_number_value, electronic_submission: electronic_submission_value, manufacturer: manufacturer_value, document_type: document_type_value, letter_date: letter_date_value, panel: panel_value, division: division_value, branch: branch_value, product_code: product_code_value, jacket_color: jacket_color_value, acknowledgement_letter: acknowledgement_letter_value, other: other_value, other_field: qcForm.other_field.value, branch_change: branch_change_value, panel_change: panel_change_value, product_code_change: product_code_change_value, incomplete_response: incomplete_response_value, deletions: deletions_value, document_type_change: document_type_change_value, hold_request: hold_request_value, logout_code: logout_code_value, close_out_code: close_out_code_value, document_type_id: qcForm.document_type_id.value, fdaAppNumber: qcForm.fdaAppNumber2.value, fdaAppSupLetter: qcForm.fdaAppSupLetter2.value, fdaAppNumberSup: qcForm.fdaAppNumberSup2.value, comment: comment_change, conversion: conversion_value, sub_type: sub_type_value, sub_type_change: sub_type_change_value }
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
	}
	
	else if(qcForm.document_type_id.value == "P"){
	$.post('qc_external_data.php',{ tis: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>, group: <?php echo('"'.$_SESSION["group"].'"'); ?>, receipt_date: receipt_date_value, trade_name: trade_name_value, common_name: common_name_value, applicant_information: applicant_information_value, fda_application_number: fda_application_number_value, electronic_submission: electronic_submission_value, manufacturer: manufacturer_value, document_type: document_type_value, letter_date: letter_date_value, panel: panel_value, division: division_value, branch: branch_value, product_code: product_code_value, jacket_color: jacket_color_value, acknowledgement_letter: acknowledgement_letter_value, other: other_value, other_field: qcForm.other_field.value, branch_change: branch_change_value, panel_change: panel_change_value, product_code_change: product_code_change_value, incomplete_response: incomplete_response_value, deletions: deletions_value, document_type_change: document_type_change_value, hold_request: hold_request_value, logout_code: logout_code_value, close_out_code: close_out_code_value,document_type_id: qcForm.document_type_id.value, fdaAppNumber: qcForm.fdaAppNumber3.value, fdaAppSupLetter: qcForm.fdaAppSupLetter3.value, fdaAppNumberSup: qcForm.fdaAppNumberSup3.value, fdaAppSupLetter2: qcForm.fdaAppSupLetter4.value, fdaAppNumberSup2: qcForm.fdaAppNumberSup4.value, comment: comment_change, conversion: conversion_value, sub_type: sub_type_value, sub_type_change: sub_type_change_value}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
	}
	
	else{
		
		$.post('qc_external_data.php',{ tis: <?php echo('"'.$_SESSION["firstName"].' '.$_SESSION["lastName"].'"'); ?>, group: <?php echo('"'.$_SESSION["group"].'"'); ?>,  receipt_date: receipt_date_value, trade_name: trade_name_value, common_name: common_name_value, applicant_information: applicant_information_value, fda_application_number: fda_application_number_value, electronic_submission: electronic_submission_value, manufacturer: manufacturer_value, document_type: document_type_value, letter_date: letter_date_value, panel: panel_value, division: division_value, branch: branch_value, product_code: product_code_value, jacket_color: jacket_color_value, acknowledgement_letter: acknowledgement_letter_value, other: other_value, other_field: qcForm.other_field.value, branch_change: branch_change_value, panel_change: panel_change_value, product_code_change: product_code_change_value, incomplete_response: incomplete_response_value, deletions: deletions_value, document_type_change: document_type_change_value, hold_request: hold_request_value, logout_code: logout_code_value, close_out_code: close_out_code_value, document_type_id: qcForm.document_type_id.value, fdaAppNumber: qcForm.fdaAppNumber.value, fdaAppSupLetter: qcForm.fdaAppSupLetter.value,fdaAppNumberSup: qcForm.fdaAppNumberSup.value, comment: comment_change, conversion: conversion_value, sub_type: sub_type_value, sub_type_change: sub_type_change_value}
				   ).done(function(data){
					   
				   $(".ui-dialog-content").dialog("destroy");
				   
				   $('#infoDiv').html(data);
				   
				   });
	}
}

//================================================================================ Document listing

/**
 *
 * Ajax call to get document dialog form
 *
*/	
	
	function dump_today_docments(){
		
		$.get('doc_list_form.php').done(function(data){ 
													 
				$(".ui-dialog-content").dialog("destroy");
			   
			   $('#infoDiv').html(data);
			   
			   set_doc_list_form();
			   
			   });
		
	}
	
/**
 *
 * Set Document form date fields and jquery dialog form
 *
*/
	
	function set_doc_list_form(){
		
		startDatePicker();
		
		$( "#doc_list" ).dialog({
		
			title: "Document List By Date",
			height: 230,
			width: 600,
			position: {my: "center", at: "center", of: $('#infoDiv')},
			//position: [calculatedPosition,120],
			resizable: false,
			draggable: false,
			closeOnEscape: false,
   			dialogClass: 'no-close changeBackground',
			buttons: [{
			
					   text: "Cancel", click: function() {cancel_button(); }},
					   {text: "Process", click: function() { get_doc_list(); }
			
					}]
		});
		
	}

function get_doc_list(){

	//alert(doc_list_form.doc_list_input.value);
	window.open('blank_page.php?dataType=today_documents&date='+doc_list_form.doc_list_input.value+'','_newtab');	
	
}

//================================================================================ Operational Dashboard

function get_operational_dashboard(){

	window.open('blank_page.php?dataType=operational_dashboard','_newtab');	
	
}

function summarizedReport(){
	
	window.open('blank_page.php?dataType=summarized_report','_newtab');	
}

</script>



</head>

<body>

    <div id="titleDiv">
    
    	<label id='title_text'> HeiQuality Automated Reporting and Tracking System </label>
    
    	<!--<img id="appTitle" src="images/hrts_title.png" />-->
        
        <!--<img id="heiTechLogo" src="images/HTS-logo3.png" height="80" />-->
    
    </div>
    
    <div id="mainDiv">
    
    	<div id="sideMenuBar">
        
        	<h2> TIME TRACKING </h2>
           	<h3 id="myAttendance"> <p class="shiftText5">My Attendance</p> </h3>
            <h3 id="startBreak"> <p class="shiftText5">Start Lunch Break</p> </h3>
    		<h3 id="endBreak"> <p class="shiftText5"> End Lunch Break</p> </h3>  
            <!--<h3 id="modifyAttendance"> Modify Attendance </h3>-->
            <!--<h3 id="forgotToSignOut"> Forgot to Sign Out </h3>-->
            <h3 id="logoutButton"> <p class="shiftText5"> Logout </p></h3>
            
            <h2> MAIL PROCESSING </h2>
            <h3 id="captureDocumentInformation"> <p class="shiftText5"> Mail Login </p></h3>
            <h3 id="mailTransfer"> <p class="shiftText5"> Mail Transfer </p></h3>
            <h3 id="editMail"> <p class="shiftText5"> Edit Mail Login </p></h3>
            
            <h2> DOCUMENT PROCESSING </h2>
            <!--<h3 id="workAssignments"> Work Assignments </h3>-->
            <h3 id="processingDocument"> <p class="shiftText5"> Initial Document Processing </p></h3>
            <h3 id="processingDocumentCorrection"> <p class="shiftText5"> Document Correction Processing </p></h3>
            
            
            <!--<h2> QUALITY CONTROL </h2>
            <h3 id="qcInternal"> <p class="shiftText5"> Internal QC </p> </h3>-->
            
            <?php 
			
				if(($_SESSION["role"] == "hrts_admin")||($_SESSION["role"] == "pm_admin")||($_SESSION["role"] == "dpm_admin")||($_SESSION["role"] == "supervisor")||($_SESSION["role"] == "task_leader")){ 
					$qc_content ="<h2> QUALITY CONTROL </h2>";
					$qc_content .="<h3 id=\"qcInternal\"> <p class=\"shiftText5\"> Internal QC </p></h3>";
					$qc_content .="<h3 id=\"qcExternal\"> <p class=\"shiftText5\"> External QC </p></h3>";
					
					echo $qc_content;
				}
			
			?>
            
            <?php
				if(($_SESSION["role"] == "hrts_admin")||($_SESSION["role"] == "pm_admin")||($_SESSION["role"] == "dpm_admin")){ 
					$admin_content ="<h2> ADMINISTRATIVE </h2>";
					$admin_content .="<h3 id=\"addUser\"> <p class=\"shiftText5\"> Add Employee </p></h3>";
					$admin_content .="<h3 id=\"modifyUser\"> <p class=\"shiftText5\">Modify Employee </p></h3>";
					$admin_content .="<h3 id=\"modifyAttendance\"> <p class=\"shiftText5\"> Modify Employee Attendance </p></h3>";
					$admin_content .="<h3 id=\"todayReport\"> <p class=\"shiftText5\"> Today Report </p></h3>";
					//$admin_content .="<h3 id=\"yesterdayReport\"> Yesterday Report </h3>";
					$admin_content .="<h3 id=\"employeeSummary\"> <p class=\"shiftText5\"> Employee Summary Report </p></h3>";
					//$admin_content .="<h3 id=\"documentSearch\"> Document Search  </h3>";
					$admin_content .="<h3 id=\"tracking_number_search\"> <p class=\"shiftText5\"> Search By Tracking Number </p></h3>";
					$admin_content .="<h3 id=\"fda_number_search\"> <p class=\"shiftText5\"> Search By FDA Application Number </p></h3>";
					//$admin_content .="<h3 id=\"processing_status\"> <p class=\"shiftText5\"> Mail Processing Status </p></h3>";
					//$admin_content .="<h3 id=\"modifyDocumentType\"> <p class=\"shiftText5\"> Modify Document Type </p></h3>";
					$admin_content .="<h3 id=\"changePassword\"> <p class=\"shiftText5\"> Change Password </p></h3>";
					$admin_content .="<h3 id=\"resetPassword\"> <p class=\"shiftText5\"> Reset Employee Password </p></h3>";
					$admin_content .="<h3 id=\"operationalDashboard\"> <p class=\"shiftText5\"> Operational Dashboard </p></h3>";
					$admin_content .="<h3 id=\"summarizedReport\"> <p class=\"shiftText5\"> Summarized Report </p></h3>";
					//$admin_content .="<h3 id=\"todayDocument\"> <p class=\"shiftText5\"> Documents By Date </p></h3>";
					
					echo $admin_content;
				}
				else{
					
					$admin_content ="<h2> ADMINISTRATIVE </h2>";

					$admin_content .="<h3 id=\"changePassword\"> <p class=\"shiftText5\"> Change Password </p></h3>";
					
					echo $admin_content;	
					
				}
				
				/*$results = $hrtsConnection2->query("Select * FROM users_time Where id = ".$_SESSION["id"]."");
				$rows = $results->fetch(PDO::FETCH_ASSOC);
				
				if((!(empty($rows["on_lunch"]))) && empty($rows["off_lunch"])){
				
					
					$lunch_model = "<script type=\"text/javascript\"> reset_login(); </script>";
					
					echo $lunch_model;	
				}*/
			
				
			?>
            
            <?php
			
				$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
				$results = $hrtsConnection2->query("Select * FROM users_time Where id = ".$_SESSION["id"]." AND `date` = '$current_date'");
				$rows = $results->fetch(PDO::FETCH_ASSOC);
				
				if((!(empty($rows["on_lunch"]))) && empty($rows["off_lunch"])){
				//if(($rows["on_lunch"] != "")&&($rows["off_lunch"] == "")){
				
					$lunch_model = "<script type=\"text/javascript\"> reset_login(); </script>";
					
					//$lunch_model = $rows["on_lunch"] . " and " . $rows["off_lunch"];
					
					echo $lunch_model;	
				}
			
			?>
        
        </div>
        
        
        <div id="greetings">   
        
        </div>
        
        <div id="infoDiv">
        
           
            
        </div>
    
    </div>

</body>
</html>