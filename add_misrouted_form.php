<?php

include ("hrtsDatabaseConnection.php");

$form = new add_document_form();

$form->blank_document_form();

class add_document_form{

	public function blank_document_form(){
		
			$hrtsConnect = new databaseConnection();
			$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
			$content = "<div id=\"misroutedDoc\">";
            
			$content .= "<form id=\"misroutedDocForm\" name=\"misroutedDocForm\" class=\"formFormatting\">";
			$content .= "<input type=\"hidden\" id=\"documentType\" name=\"documentType\" value=\"Mis_Routed\" /></td></tr>";
			$content .= "<table><tbody>";
			$content .= "<tr><td >Delivery Company</td><td>";
			$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
			
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
		
			while($company_name_row = $company_name->fetch(PDO::FETCH_ASSOC)){
			
				$content .= "<option value=\"".$company_name_row["company_name"]."\">".$company_name_row["company_name"]."</option>";	
				
			}
			
			$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
			$content .= "<tr><td >Delivery Tracking Number</td><td><input type=\"text\" id=\"deliveryTracking\" name=\"deliveryTracking\" /></td></tr>";
			$content .= "<tr><td >Comment</td><td><input type=\"text\" id=\"comment\" name=\"comment\" /></td></tr>";
			$content .= "<tr><td ><label class=\"highlight\"> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
				
			$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"MD\" readonly=\"readonly\" /></td></tr>";	
			$content .= "</tbody></table>";
			$content .= "</form>";
						
			$content .= "</div>";
			
			$content .= "<script type=\"text/javascript\">"; 
			$content .= "$('#moreInfo').hide();";
			$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";
			
			$content .="</script>";
			
			die($content);	
			
	}
}
?>