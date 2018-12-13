<?php
/*
if(!(empty($_REQUEST['fdaAppNumber']))){
	
	$fdaAppNumber = trim($_REQUEST['fdaAppNumber']);
	if(empty($_REQUEST['fdaAppNumberSup'])){ $fdaAppNumberSup = "0"; }
	else{$fdaAppNumberSup = trim($_REQUEST['fdaAppNumberSup']);}
	$document_type_id = trim($_REQUEST['document_type_id']);
	
	$fdaAppNumberSup = str_pad($fdaAppNumberSup, 3, '0', STR_PAD_LEFT);
	
	$fdaAppNumber = "$document_type_id$fdaAppNumber/$fdaAppNumberSup";
}

else{

	$fdaAppNumber = "";
	
}
*/
$group = trim($_REQUEST['group']);
$internal_number = trim($_REQUEST['internal_number']);
$receiptDate = date("Y-m-d", (strtotime($_REQUEST['receiptDate'])));
$fdaAppNumber = "";

if(empty($internal_number)){
	
	die("<script type=\"text/javascript\"> alert('Please enter internal number.'); documentProcessingForm(); </script>");		
	
}




$content = "<div id=\"processDoc\">";
            
$content .= "<form id=\"processDocForm\" name=\"processDocForm\">";
$content .= "<input type=\"hidden\" id=\"group\" name=\"group\" value=\"$group\"/>";
$content .= "<input type=\"hidden\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" value=\"\"/>";
$content .= "<input type=\"hidden\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" value=\"\"/>";
$content .= "<input type=\"hidden\" id=\"document_type_id\" name=\"document_type_id\" value=\"\"/>";
$content .= "<input type=\"hidden\" id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\" value=\"\"/>";
$content .= "<input type=\"hidden\" id=\"internal_number\" name=\"internal_number\" value=\"$internal_number\"/>";
$content .= "<input type=\"hidden\" id=\"receiptDate\" name=\"receiptDate\" value=\"$receiptDate\"/>";
$content .= "<table><tbody>";
//$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" value=\"$internal_number\"/></td></tr>";
$content .= "<tr><td > Submission Type</td><td>";
$content .= "<select name=\"documentType\">";

if($group == '510K'){
$content .= "<option value=\"Original 510(k) Submissions\"> Original 510(k) Submissions </option>";
$content .= "<option value=\"510(k) Hold Requests\"> 510(k) Hold Requests </option>";
$content .= "<option value=\"510(k) Requests for Extensions\"> 510(k) Requests for Extensions </option>";
$content .= "<option value=\"510(k) Additional Information Requests\"> 510(k) Additional Information Requests</option>";
$content .= "<option value=\"510(k) Withdrawal Requests\"> 510(k) Withdrawal Requests</option>";
$content .= "<option value=\"510(k) CLIA and Amendments\"> 510(k) CLIA and Amendments </option>";
$content .= "<option value=\"510(k) \"X\" Files, \"BK\" Files, and \"BK/A\" Files\"> 510(k) \"X\" Files, \"BK\" Files, and \"BK/A\" Files</option>";
$content .= "<option value=\"510(k) Modifications or Corrections\"> 510(k) Modifications or Corrections</option>";
$content .= "<option value=\"510(k) Add to File\"> 510(k) Add to File </option>";
$content .= "<option value=\"510(k) Deletion\"> 510(k) Deletion </option>";
$content .= "<option value=\"510(k) Closeout\"> 510(k) Closeout </option>";
$content .= "<option value=\"Incomplete Responses\"> Incomplete Responses</option>";
$content .= "<option value=\"Appeals\"> Appeals </option>";
$content .= "<option value=\"Denovo's\"> Denovo's </option>";
//$content .= "<option value=\"513G Original\"> 513G Original </option>";
//$content .= "<option value=\"513G Amendments\"> 513G Amendments </option>";
$content .= "<option value=\"QC/Boxing\"> QC/Boxing </option>";
}

elseif($group == 'PMA'){
$content .= "<option value=\"PMA New Report\"> PMA New Report </option>";
$content .= "<option value=\"PMA Amendments to Report\"> PMA Amendments to Report </option>";
$content .= "<option value=\"PMA Shell and Modules\"> PMA Shell and Modules</option>";
$content .= "<option value=\"PMA Modules Amendments\"> PMA Modules Amendments</option>";
$content .= "<option value=\"PMA Shell Amendments\"> PMA Shell Amendments</option>";
$content .= "<option value=\"Module Supplements\"> Module Supplements </option>";
$content .= "<option value=\"Original PMA Applications\"> Original PMA Applications</option>";
$content .= "<option value=\"Amendments to Original PMA Applications\"> Amendments to Original PMA Applications</option>";
$content .= "<option value=\"Modifying a PMA Amendments Record\"> Modifying a PMA Amendments Record</option>";
$content .= "<option value=\"PMA Application Supplements\"> PMA Application Supplements</option>";
$content .= "<option value=\"Amendments to PMA Supplements\"> Amendments to PMA Supplements</option>";
$content .= "<option value=\"PMA \"BP\" Files and \"BP/S\" Files\"> PMA \"BP\" Files and \"BP/S\" Files</option>";
$content .= "<option value=\"HDE New Report\"> HDE New Report </option>";
$content .= "<option value=\"HDE Amendments to Report\"> HDE Amendments to Report </option>";
$content .= "<option value=\"HDE Originals and Supplements\"> HDE Originals and Supplements</option>";
$content .= "<option value=\"HDE Amendments\"> HDE Amendments</option>";
$content .= "<option value=\"PDP New Report\"> PDP New Report </option>";
$content .= "<option value=\"PDP Amendments to Report\"> PDP Amendments to Report </option>";
$content .= "<option value=\"PDP Supplements\"> PDP Supplements </option>";
$content .= "<option value=\"PDP Amendments to Supplements\"> PDP Amendments to Supplements </option>";
//$content .= "<option value=\"513G Original\"> 513G Original </option>";
//$content .= "<option value=\"513G Amendments\"> 513G Amendments </option>";
$content .= "<option value=\"Data Entry Sheet Processing\"> Data Entry Sheet Processing </option>";
$content .= "<option value=\"QC/Boxing\"> QC/Boxing </option>";
}

elseif($group == 'IDE'){
//$content .= "<option value=\"IDE Reports\"> IDE Reports </option>";
//$content .= "<option value=\"IDE Amendments to Reports\"> IDE Amendments to Reports </option>";
//$content .= "<option value=\"IDE Amendments to Supplements\"> IDE Amendments to Supplements </option>";
$content .= "<option value=\"IDE Original Submissions/EUA's/FIH's\"> IDE Original Submissions/EUA's/FIH's</option>";
$content .= "<option value=\"IDE Supplements and Amendments Submissions\"> IDE Supplements and Amendments Submissions</option>";
$content .= "<option value=\"IDE Log Out for Originals, Supplements and Amendments\"> IDE Log Out for Originals, Supplements and Amendments</option>";
$content .= "<option value=\"IDE Misrouted and Corrected Documents\"> IDE Misrouted and Corrected Documents </option>";
$content .= "<option value=\"IDE Pre-Submissions\"> IDE Pre-Submissions</option>";
$content .= "<option value=\"IDE Pre-Submission Original\"> IDE Pre-Submission Original </option>";
$content .= "<option value=\"IDE Pre-Submissions Supplements\"> IDE Pre-Submissions Supplements</option>";
$content .= "<option value=\"IDE Pre-Submissions Amendments\"> IDE Pre-Submissions Amendments </option>";
$content .= "<option value=\"IDE Pre-Submissions Amendments to Supplements\"> IDE Pre-Submissions Amendments to Supplements</option>";
$content .= "<option value=\"IDE Pre-Submissions Logouts\"> IDE Pre-Submissions Logouts</option>";
$content .= "<option value=\"IDE Pre-IDE logouts\"> IDE Pre-IDE logouts </option>";
$content .= "<option value=\"Original Master Files\">Original Master Files </option>";
$content .= "<option value=\"Master File Amendments\"> Master File Amendments </option>";
//$content .= "<option value=\"513G Original\"> 513G Original </option>";
//$content .= "<option value=\"513G Amendments\"> 513G Amendments </option>";
$content .= "<option value=\"QC/Boxing\"> QC/Boxing </option>";
}

elseif($group == 'RAD_HEALTH'){
$content .= "<option value=\"RadHealth Correspondence\"> RadHealth Correspondence </option>";
$content .= "<option value=\"RadHealth Correspondence Scanning\"> RadHealth Correspondence Scanning </option>";
$content .= "<option value=\"RadHealth Safety Reports\"> RadHealth Safety Reports </option>";
$content .= "<option value=\"RadHealth Safety Reports Scanning\"> RadHealth Safety Reports Scanning </option>";
$content .= "<option value=\"Form 2579\"> Form 2579 </option>";
$content .= "<option value=\"2579 Scanning\"> 2579 Scanning </option>";
//$content .= "<option value=\"513G Original\"> 513G Original </option>";
//$content .= "<option value=\"513G Amendments\"> 513G Amendments </option>";
$content .= "<option value=\"QC/Boxing\"> QC/Boxing </option>";
}

elseif($group == '513G'){
$content .= "<option value=\"513G Original\"> 513G Original </option>";
$content .= "<option value=\"513G Amendments\"> 513G Amendments </option>";
}

$content .= "</select></td></tr>";
//$content .= "<tr><td class=\"tdWidth\"><label> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker\" tabindex=\"-1\" value=\"$receiptDate\"/></td></tr>";
$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

echo $content;

?>
