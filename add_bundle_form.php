<?php

include ("hrtsDatabaseConnection.php");

$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));

$deliveryCompany = trim($_REQUEST['deliveryCompany']);
$deliveryTracking = trim($_REQUEST['deliveryTracking']);
$documentType = trim($_REQUEST['documentType']);
$manufacturer = trim($_REQUEST['manufacturer']);
$moreInfo = trim($_REQUEST['moreInfo']);
$cd = trim($_REQUEST['cd']);
$usb = trim($_REQUEST['usb']);
$paper = trim($_REQUEST['paper']);
$volume = trim($_REQUEST['volume']);
$modified = trim($_REQUEST['modified']);

//$internal_number = $_REQUEST['internal_number'];
//die($documentType);
$form = new add_document_form();

$form->blank_document_form($documentType,$current_date,$deliveryCompany,$deliveryTracking,$manufacturer,$cd,$paper,$volume,$moreInfo,$usb);

class add_document_form{

	public function blank_document_form($documentType,$current_date,$deliveryCompany,$deliveryTracking,$manufacturer,$cd,$paper,$volume,$moreInfo,$usb){
		
			$hrtsConnect = new databaseConnection();
			$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
			$content = "<div id=\"captureDoc\">";
            
			$content .= "<form id=\"captureDocForm\" name=\"captureDocForm\">";
			$content .= "<input type=\"hidden\" id=\"documentType\" name=\"documentType\" value=\"$documentType\" /></td></tr>";
			$content .= "<table><tbody>";
			
			try{
			$company_name = $hrtsConnection->prepare("SELECT company_name FROM `shipping_dropdown_values`");
		
			$company_name->execute();
			}
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for broken dropdown list error.'); </script>");
			}
			
			$content .= "<tr><td >Delivery Company</td><td>";
			$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
			
			while($company_name_row = $company_name->fetch(PDO::FETCH_ASSOC)){
		
				if($deliveryCompany == $company_name_row["company_name"]){$content .= "<option value=\"".$company_name_row["company_name"]."\" selected=\"selected\">".$company_name_row["company_name"]."</option>";}
				else{ $content .= "<option value=\"".$company_name_row["company_name"]."\">".$company_name_row["company_name"]."</option>"; }	
				
			}
			
			$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
			
			$content .= "<tr><td >Delivery Tracking Number</td><td><input type=\"text\" id=\"deliveryTracking\" name=\"deliveryTracking\" tabindex=\"-1\" value=\"$deliveryTracking\"/></td></tr>";
			$content .= "<tr><td class=\"tdWidth\">Manufacturer</td><td><input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" tabindex=\"-1\" value=\"$manufacturer\"/></td></tr>";
			
			$content .= "<tr><td class=\"tdWidth\">FDA Application Number</td><td>";
			
			if($documentType == '510K'){
			
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"K\">K</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> / <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
			}
			
			elseif($documentType == 'IDE'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"G\" selected=\"selected\">G</option>";
				$content .= "<option value=\"Q\">Q</option>";
				$content .= "<option value=\"MAF\">MAF</option>";
				$content .= "<option value=\"PI\">PI</option>";
				$content .= "<option value=\"V\">V</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
				$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\"/>";
				
			}
			
			elseif($documentType == 'PMA'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"P\" selected=\"selected\">P</option>";
				$content .= "<option value=\"D\">D</option>";
				$content .= "<option value=\"H\">H</option>";
				$content .= "<option value=\"M\">M</option>";
				$content .= "<option value=\"N\">N</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"6\" maxlength=\"6\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash3\"> / </label> </label> <input type=\"text\" id=\"fdaAppNumberSup3\" name=\"fdaAppNumberSup3\" size=\"4\" maxlength=\"4\"/>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
				
			}
			
			elseif($documentType == 'RAD_HEALTH'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"R\">R</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> / <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
				$content .= "<tr><td class=\"tdWidth\">Report Type</td><td><input type=\"text\" id=\"reportType\" name=\"reportType\" tabindex=\"-1\" /></td>";		
				
			}
			
			elseif($documentType == '2579'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"D\">D</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> / <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";	
				
			}
			
			elseif($documentType == '513G'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"C\">C</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> / <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";	
				
			}
			
			$content .= "</td></tr>";
			
			$content .= "<tr><td >Number of CDs</td><td><input type=\"text\" id=\"cd\" name=\"cd\" tabindex=\"-1\" value=\"$cd\"/></td></tr>";
			$content .= "<tr><td >Number of USB Drives</td><td><input type=\"text\" id=\"usb\" name=\"usb\" tabindex=\"-1\" value=\"$usb\"/></td></tr>";
			$content .= "<tr><td >Number of Paper Copies</td><td><input type=\"text\" id=\"paper\" name=\"paper\" tabindex=\"-1\" value=\"$paper\"/></td></tr>";
			$content .= "<tr><td >Volume Number</td><td><input type=\"text\" id=\"volume\" name=\"volume\" tabindex=\"-1\" value=\"$volume\"/></td></tr>";
			$content .= "<tr><td ><label class=\"highlight\"> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
			
			if($documentType == '510K'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"K\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($documentType == 'IDE'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"G\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($documentType == 'PMA'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"P\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($documentType == 'RAD_HEALTH'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"R\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($documentType == '513G'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"C\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($documentType == 'Mis_Routed'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"MR\" readonly=\"readonly\" /></td></tr>";
			}
			
			elseif($documentType == '2579'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"NA\" readonly=\"readonly\" /></td></tr>";
			}
			
			try{
				$max_results = $hrtsConnection->prepare("SELECT MAX(internal_number) AS max_value FROM `document` WHERE document_type = :documentType AND date_received = '$current_date'");
			
				$max_results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
				$max_results->execute();
			}
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for max number document type data error mail login form.'); </script>");
			}
		
		$max_row = $max_results->fetch(PDO::FETCH_ASSOC);
		
		//die($max_row["max_value"]);
		
		if(empty($max_row["max_value"])){
			
			$new_internal_number = 1;
			
		}
		else{
			
			$new_internal_number = 1 + $max_row["max_value"];
			
		}
			
			$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" value=\"$new_internal_number\" readonly=\"readonly\"/></td></tr>";
			$content .= "</tbody></table>";
			$content .= "</form>";
						
			$content .= "</div>";
			
			$content .= "<script type=\"text/javascript\">"; 
			$content .= "$('#moreInfo').hide();";
			$content .= "$('#fdaAppNumber2').hide();";
			$content .= "$('#fdaAppNumberSup2').hide();";
			$content .= "$('#slash2').hide();";
			
			$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";
			
			if($documentType == 'IDE'){
			$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide();} else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#slash').show(); } e.preventDefault();});";
			}
			
			
			if($documentType == 'PMA'){
			$content .= "if($('#document_type_id option:selected').val() == 'P'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#fdaAppNumberSup3').show(); $('#slash2').show(); $('#slash3').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide();}";
			$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'P'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#fdaAppNumberSup3').show(); $('#slash2').show(); $('#slash3').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide();} else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#fdaAppNumberSup3').hide(); $('#slash2').hide(); $('#slash3').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#slash').show(); } e.preventDefault();});";
			}
			
			$content .="</script>";
			
			die($content);	
			
	}
}
?>