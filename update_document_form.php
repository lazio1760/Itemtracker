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
			$content .= "<input type=\"hidden\" id=\"documentType\" name=\"documentType\" value=\"".$row["document_type"]."\" /></td></tr>";
			$content .= "<table><tbody>";
			/*
			if($row["delivery_company"] == "FEDEX"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\" selected=\"selected\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				elseif($row["delivery_company"] == "FEDEXG"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\" selected=\"selected\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				elseif($row["delivery_company"] == "Hogan Lovells"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\" selected=\"selected\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				elseif($row["delivery_company"] == "UPS"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\" selected=\"selected\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				elseif($row["delivery_company"] == "USPS"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\" selected=\"selected\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				elseif($row["delivery_company"] == "DHL"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\" selected=\"selected\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				elseif($row["delivery_company"] == "TNT"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\" selected=\"selected\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				elseif($row["delivery_company"] == "FDA Personnel"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\" selected=\"selected\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" value=\"".$row["delivery_add_info"]."\"/></td></tr>";
				}
				elseif($row["delivery_company"] == "Other"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\" selected=\"selected\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" value=\"".$row["delivery_add_info"]."\"/></td></tr>";
				}
				elseif($row["delivery_company"] == "Gateway/PDF"){
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\" selected=\"selected\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" value=\"".$row["delivery_add_info"]."\"/></td></tr>";
				}
				else{
					$content .= "<tr><td >Delivery Company</td><td>";
					$content .= "<select name=\"deliveryCompany\" id=\"deliveryCompany\">";
					$content .= "<option value=\"DHL\">DHL</option>";
					$content .= "<option value=\"FEDEX\">Fed Ex</option>";
					$content .= "<option value=\"FEDEXG\">Fed Ex Ground</option>";
					$content .= "<option value=\"Hogan Lovells\">Hogan Lovells</option>";
					$content .= "<option value=\"TNT\">TNT Express</option>";
					$content .= "<option value=\"UPS\">UPS</option>";
					$content .= "<option value=\"USPS\">US Postal Service</option>";
					$content .= "<option value=\"FDA Personnel\">FDA Personnel</option>";
					$content .= "<option value=\"Gateway/PDF\">Gateway/PDF</option>";
					$content .= "<option value=\"Other\" selected=\"selected\">Other</option>";
					$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				}
				*/
				
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
			
					if($row["delivery_company"] == $company_name_row["company_name"]){$content .= "<option value=\"".$company_name_row["company_name"]."\" selected=\"selected\">".$company_name_row["company_name"]."</option>";}
					else{ $content .= "<option value=\"".$company_name_row["company_name"]."\">".$company_name_row["company_name"]."</option>"; }	
					
				}
				
				$content .= "</select><input type=\"text\" id=\"moreInfo\" name=\"moreInfo\" /></td></tr>";
				
                $content .= "<tr><td class=\"tdWidth\">Delivery Tracking Number</td><td><input type=\"text\" id=\"deliveryTracking\" name=\"deliveryTracking\" tabindex=\"-1\" value=\"".$row["delivery_tracking_number"]."\"/></td></tr>";
			$content .= "<tr><td class=\"tdWidth\">Manufacturer</td><td><input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" tabindex=\"-1\" value=\"".$row["manufacturer"]."\"/></td></tr>";
			
			$content .= "<tr><td class=\"tdWidth\">FDA Application Number</td><td>";
			
			//$row["fda_application_number"}
			
			$fda_application_number = str_split($row["fda_application_number"]);
			
			$count = count($fda_application_number);
			
			//var_dump($count);
			
			
			if(($fda_application_number[0] == "M") && ($fda_application_number[1] == "A") && ($fda_application_number[2] == "F")){
				
				$document_type_id = "$fda_application_number[0]$fda_application_number[1]$fda_application_number[2]";
				
				$fdaAppNumber = "$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";	
				
				$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]$fda_application_number[11]";
				
			}
			
			elseif(($fda_application_number[0] == "P") && ($fda_application_number[1] == "I")){
				
				$document_type_id = "$fda_application_number[0]$fda_application_number[1]";
				
				$fdaAppNumber = "$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]$fda_application_number[7]";	
				
				$fdaAppNumberSup = "$fda_application_number[9]$fda_application_number[10]$fda_application_number[11]$fda_application_number[12]";
				
			}
			
			elseif($fda_application_number[0] == "P"){
				
				$document_type_id = "$fda_application_number[0]";
				
				$fdaAppNumber = "$fda_application_number[1]$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";	
				
				$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]$fda_application_number[11]";
				
				$fdaAppNumberSup2 = "$fda_application_number[13]$fda_application_number[14]$fda_application_number[15]$fda_application_number[16]";
				
			}
			
			else{
				
				$document_type_id = $fda_application_number[0];
				$fdaAppNumber = "$fda_application_number[1]$fda_application_number[2]$fda_application_number[3]$fda_application_number[4]$fda_application_number[5]$fda_application_number[6]";
				$fdaAppNumberSup = "$fda_application_number[8]$fda_application_number[9]$fda_application_number[10]$fda_application_number[11]";
			}
			
			//die("$document_type_id $fdaAppNumber $fdaAppNumberSup");
			
			if($document_type_id == 'K'){
			
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"K\">K</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> / <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
			}
			
			elseif($document_type_id == 'G'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"G\" selected=\"selected\">G</option>";
				$content .= "<option value=\"Q\">Q</option>";
				$content .= "<option value=\"MAF\">MAF</option>";
				$content .= "<option value=\"PI\">PI</option>";
				$content .= "<option value=\"V\">V</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumber\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			elseif($document_type_id == 'Q'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"G\">G</option>";
				$content .= "<option value=\"Q\" selected=\"selected\">Q</option>";
				$content .= "<option value=\"MAF\">MAF</option>";
				$content .= "<option value=\"PI\">PI</option>";
				$content .= "<option value=\"V\">V</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumber\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			elseif($document_type_id == 'MAF'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"G\">G</option>";
				$content .= "<option value=\"Q\">Q</option>";
				$content .= "<option value=\"MAF\" selected=\"selected\">MAF</option>";
				$content .= "<option value=\"PI\">PI</option>";
				$content .= "<option value=\"V\">V</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumber\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			elseif($document_type_id == 'PI'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"G\">G</option>";
				$content .= "<option value=\"Q\">Q</option>";
				$content .= "<option value=\"MAF\">MAF</option>";
				$content .= "<option value=\"PI\" selected=\"selected\">PI</option>";
				$content .= "<option value=\"V\">V</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumber\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			elseif($document_type_id == 'V'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"G\">G</option>";
				$content .= "<option value=\"Q\">Q</option>";
				$content .= "<option value=\"MAF\">MAF</option>";
				$content .= "<option value=\"PI\">PI</option>";
				$content .= "<option value=\"V\" selected=\"selected\">V</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumber\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			
			elseif($document_type_id == 'P'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"P\" selected=\"selected\">P</option>";
				$content .= "<option value=\"D\">D</option>";
				$content .= "<option value=\"H\">H</option>";
				$content .= "<option value=\"M\">M</option>";
				$content .= "<option value=\"N\">N</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/> <label id=\"slash3\"> / </label> </label> <input type=\"text\" id=\"fdaAppNumberSup3\" name=\"fdaAppNumberSup3\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup2\"/>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\"/>";
				
			}
			elseif($document_type_id == 'D'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"P\">P</option>";
				$content .= "<option value=\"D\" selected=\"selected\">D</option>";
				$content .= "<option value=\"H\">H</option>";
				$content .= "<option value=\"M\">M</option>";
				$content .= "<option value=\"N\">N</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"6\" maxlength=\"6\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash3\"> / </label> </label> <input type=\"text\" id=\"fdaAppNumberSup3\" name=\"fdaAppNumberSup3\" size=\"4\" maxlength=\"4\"/>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			elseif($document_type_id == 'H'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"P\">P</option>";
				$content .= "<option value=\"D\">D</option>";
				$content .= "<option value=\"H\" selected=\"selected\">H</option>";
				$content .= "<option value=\"M\">M</option>";
				$content .= "<option value=\"N\">N</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"6\" maxlength=\"6\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash3\"> / </label> </label> <input type=\"text\" id=\"fdaAppNumberSup3\" name=\"fdaAppNumberSup3\" size=\"4\" maxlength=\"4\"/>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			elseif($document_type_id == 'M'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"P\">P</option>";
				$content .= "<option value=\"D\">D</option>";
				$content .= "<option value=\"H\">H</option>";
				$content .= "<option value=\"M\" selected=\"selected\">M</option>";
				$content .= "<option value=\"N\">N</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"6\" maxlength=\"6\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash3\"> / </label> </label> <input type=\"text\" id=\"fdaAppNumberSup3\" name=\"fdaAppNumberSup3\" size=\"4\" maxlength=\"4\"/>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			
			elseif($document_type_id == 'N'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"P\">P</option>";
				$content .= "<option value=\"D\">D</option>";
				$content .= "<option value=\"H\">H</option>";
				$content .= "<option value=\"M\">M</option>";
				$content .= "<option value=\"N\" selected=\"selected\">N</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"6\" maxlength=\"6\"/> <label id=\"slash2\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup2\" name=\"fdaAppNumberSup2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash3\"> / </label> </label> <input type=\"text\" id=\"fdaAppNumberSup3\" name=\"fdaAppNumberSup3\" size=\"4\" maxlength=\"4\"/>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				
			}
			
			elseif($document_type_id == 'R'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"R\">R</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";
				$content .= "<tr><td class=\"tdWidth\">Report Type</td><td><input type=\"text\" id=\"reportType\" name=\"reportType\" tabindex=\"-1\" value=\"".$row["report_type"]."\"/></td>";	
				
			}
			elseif($document_type_id == 'D'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"D\">D</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";	
				
			}
			elseif($document_type_id == 'C'){
				
				$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
				$content .= "<option value=\"C\">C</option>";
				$content .= "</select>";
				$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\" value=\"$fdaAppNumber\"/> <label id=\"slash\"> / </label> <input type=\"text\" id=\"fdaAppNumberSup\" name=\"fdaAppNumberSup\" size=\"4\" maxlength=\"4\" value=\"$fdaAppNumberSup\"/>";	
				
			}
			
			$content .= "</td></tr>";
			
			$content .= "<tr><td >Number of CDs</td><td><input type=\"text\" id=\"cd\" name=\"cd\" tabindex=\"-1\" value=\"".$row["cd_copies"]."\"/></td></tr>";
			$content .= "<tr><td >Number of USB Drives</td><td><input type=\"text\" id=\"usb\" name=\"usb\" tabindex=\"-1\" value=\"".$row["usb_copies"]."\"/></td></tr>";
			//$content .= "<tr><td >Number of eCopies</td><td><input type=\"text\" id=\"cd\" name=\"cd\" tabindex=\"-1\" value=\"".$row["cd_copies"]."\"/></td></tr>";
			$content .= "<tr><td >Number of Paper Copies</td><td><input type=\"text\" id=\"paper\" name=\"paper\" tabindex=\"-1\" value=\"".$row["paper_copies"]."\"/></td></tr>";
			$content .= "<tr><td >Volume Number</td><td><input type=\"text\" id=\"volume\" name=\"volume\" tabindex=\"-1\" value=\"".$row["volume_number"]."\"/></td></tr>";
			$content .= "<tr><td class=\"tdWidth\"><label> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker2\" tabindex=\"-1\" value=\"".date("m/d/Y", (strtotime($row["date_received"])))."\" readonly=\"readonly\"/></td></tr>";
			
			if($row["document_type"] == '510K'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"K\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($row["document_type"] == 'IDE'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"G\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($row["document_type"] == 'PMA'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"P\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($row["document_type"] == 'RAD_HEALTH'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"R\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($row["document_type"] == '513G'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"C\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($row["document_type"] == 'Mis_Routed'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"MR\" readonly=\"readonly\" /></td></tr>";
			}
			elseif($row["document_type"] == '2579'){
				
				$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td><input type=\"text\" id=\"document_Type\" name=\"document_Type\" value=\"NA\" readonly=\"readonly\" /></td></tr>";
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
			
			$content .= "if(($('#deliveryCompany option:selected').val() == 'Other')||($('#deliveryCompany option:selected').val() == 'FDA Personnel')){ $('#moreInfo').show();}";
			
			$content .= "$('#deliveryCompany').change(function(e){if(($('#deliveryCompany option:selected').val() == 'Other')||($('#deliveryCompany option:selected').val() == 'FDA Personnel')){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";
			
			if($documentType == 'IDE'){
			$content .= "if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide();}";
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
}
?>
