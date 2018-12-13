<?php

include ("hrtsDatabaseConnection.php");

$documentType = $_REQUEST['documentType'];

$internal_number = $_REQUEST['internal_number'];

$receiptDate = date("Y-m-d", (strtotime($_REQUEST['receiptDate'])));

$search = new update_document_form();

$search->get_update_form($internal_number,$receiptDate,$documentType);

class update_document_form{
	
	public function get_update_form($internal_number,$receiptDate,$documentType){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			$results = $hrtsConnection->prepare("SELECT * FROM `document` WHERE date_received = :receiptDate AND internal_number = :internal_number AND document_type = :documentType");
			
			$results->bindValue(':receiptDate', $receiptDate, PDO::PARAM_STR);
			$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
			$results->bindValue(':internal_number', $internal_number, PDO::PARAM_INT);
			$results->execute();
		}
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for update document form error.'); </script>");
			
		}

		while($row = $results->fetch(PDO::FETCH_ASSOC)){
				
			$content = "<div id=\"captureDoc\">";
            
			$content .= "<form id=\"captureDocForm\" name=\"captureDocForm\">";
			$content .= "<input type=\"hidden\" id=\"documentType_old\" name=\"documentType_old\" value=\"".$row["document_type"]."\" /></td></tr>";
			
			$content .= "<table><tbody>";
			$content .= "<tr><td class=\"tdWidth\"><label> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker2\" tabindex=\"-1\" value=\"".date("m/d/Y", (strtotime($row["date_received"])))."\" /></td></tr>";
			
			if($row["document_type"] == '510K'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
				$content .= "<select name=\"documentType\">";
				$content .= "<option value=\"510K\" selected=\"selected\"> K </option>";
				$content .= "<option value=\"IDE\"> G </option>";
				$content .= "<option value=\"PMA\"> P </option>";
				$content .= "<option value=\"RAD_HEALTH\"> R </option>";
				$content .= "<option value=\"513G\"> C </option>";
				$content .= "<option value=\"Mis_Routed\"> MR </option>";
				$content .= "</select></td></tr>";
			}
			elseif($row["document_type"] == 'IDE'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
				$content .= "<select name=\"documentType\">";
				$content .= "<option value=\"510K\"> K </option>";
				$content .= "<option value=\"IDE\" selected=\"selected\"> G </option>";
				$content .= "<option value=\"PMA\"> P </option>";
				$content .= "<option value=\"RAD_HEALTH\"> R </option>";
				$content .= "<option value=\"513G\"> C </option>";
				$content .= "<option value=\"Mis_Routed\"> MR </option>";
				$content .= "</select></td></tr>";
			}
			elseif($row["document_type"] == 'PMA'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
				$content .= "<select name=\"documentType\">";
				$content .= "<option value=\"510K\"> K </option>";
				$content .= "<option value=\"IDE\"> G </option>";
				$content .= "<option value=\"PMA\" selected=\"selected\"> P </option>";
				$content .= "<option value=\"RAD_HEALTH\"> R </option>";
				$content .= "<option value=\"513G\"> C </option>";
				$content .= "<option value=\"Mis_Routed\"> MR </option>";
				$content .= "</select></td></tr>";
			}
			elseif($row["document_type"] == 'RAD_HEALTH'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
				$content .= "<select name=\"documentType\">";
				$content .= "<option value=\"510K\"> K </option>";
				$content .= "<option value=\"IDE\"> G </option>";
				$content .= "<option value=\"PMA\"> P </option>";
				$content .= "<option value=\"RAD_HEALTH\" selected=\"selected\"> R </option>";
				$content .= "<option value=\"513G\"> C </option>";
				$content .= "<option value=\"Mis_Routed\"> MR </option>";
				$content .= "</select></td></tr>";
			}
			elseif($row["document_type"] == '513G'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
				$content .= "<select name=\"documentType\">";
				$content .= "<option value=\"510K\"> K </option>";
				$content .= "<option value=\"IDE\"> G </option>";
				$content .= "<option value=\"PMA\"> P </option>";
				$content .= "<option value=\"RAD_HEALTH\"> R </option>";
				$content .= "<option value=\"513G\" selected=\"selected\"> C </option>";
				$content .= "<option value=\"Mis_Routed\"> MR </option>";
				$content .= "</select></td></tr>";
			}
			elseif($row["document_type"] == 'Mis_Routed'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
				$content .= "<select name=\"documentType\">";
				$content .= "<option value=\"510K\"> K </option>";
				$content .= "<option value=\"IDE\"> G </option>";
				$content .= "<option value=\"PMA\"> P </option>";
				$content .= "<option value=\"RAD_HEALTH\"> R </option>";
				$content .= "<option value=\"513G\"> C </option>";
				$content .= "<option value=\"Mis_Routed\" selected=\"selected\"> MR </option>";
				$content .= "</select></td></tr>";
			}
			
			$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" value=\"".$row["internal_number"]."\" readonly=\"readonly\"/></td></tr>";
			$content .= "</tbody></table>";
			$content .= "</form>";
						
			$content .= "</div>";
				
				$content .= "<script type=\"text/javascript\">"; 
			$content .= "$('#moreInfo').hide();";
			$content .= "$('#fdaAppNumber2').hide();";
			$content .= "$('#fdaAppNumberSup2').hide();";
			$content .= "$('#slash2').hide();";
			
			$content .= "if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide();}";
			
			$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";
			$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide();} else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#slash').show(); } e.preventDefault();});";
			
			$content .="</script>";
				
				die($content);
				
		}
			
	}
}
?>
