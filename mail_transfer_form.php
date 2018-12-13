<?php

$content = "<div id=\"mail_Transfer\">";
            
$content .= "<form id=\"mailTransferForm\" class=\"formFormatting\" name=\"mailTransferForm\">";

//$content .= "<input type=\"hidden\" id=\"internal_number\" name=\"internal_number\" value=\"\"/>";
//$content .= "<input type=\"hidden\" id=\"receiptDate\" name=\"receiptDate\" value=\"\"/>";
//$content .= "<input type=\"hidden\" id=\"documentType\" name=\"documentType\" value=\"\"/>";

$content .= "<div id='border_selection'>";

$content .= "<table><tbody>";
$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> FDA Application Number </label></td><td>";
$content .= "<select name=\"document_type_id\" id=\"document_type_id\">";
$content .= "<option value=\"K\" selected=\"selected\">K</option>";
$content .= "<option value=\"G\">G</option>";
$content .= "<option value=\"Q\">Q</option>";
$content .= "<option value=\"MAF\">MAF</option>";
$content .= "<option value=\"PI\">PI</option>";
$content .= "<option value=\"V\">V</option>";
$content .= "<option value=\"P\">P</option>";
$content .= "<option value=\"D\">D</option>";
$content .= "<option value=\"H\">H</option>";
$content .= "<option value=\"M\">M</option>";
$content .= "<option value=\"N\">N</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "</select>";

$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" size=\"6\" maxlength=\"6\"/> <label id=\"slash\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter\" name=\"fdaAppSupLetter\" >";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" id=\"fdaAppNumberSup\" class=\"move_over\" name=\"fdaAppNumberSup\" size=\"3\" maxlength=\"3\"/>";

$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber2\" name=\"fdaAppNumber2\" size=\"4\" maxlength=\"4\"/> <label id=\"slash2\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter2\" name=\"fdaAppSupLetter2\" >";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>";  
$content .= "<input type=\"text\" id=\"fdaAppNumberSup2\" class=\"move_over\" name=\"fdaAppNumberSup2\" size=\"3\" maxlength=\"3\"/>";

$content .= "<input type=\"text\" class=\"move_over2\" id=\"fdaAppNumber3\" name=\"fdaAppNumber3\" size=\"6\" maxlength=\"6\"/> <label id=\"slash3\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter3\" name=\"fdaAppSupLetter3\" >";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>";  
$content .= "<input type=\"text\" id=\"fdaAppNumberSup3\" class=\"move_over\" name=\"fdaAppNumberSup3\" size=\"3\" maxlength=\"3\"/> <label id=\"slash4\"> / </label>";
$content .= "<select id=\"fdaAppSupLetter4\" name=\"fdaAppSupLetter4\">";
$content .= "<option value=\"\"></option>";
$content .= "<option value=\"A\">A</option>";
$content .= "<option value=\"R\">R</option>";
$content .= "<option value=\"S\">S</option>";
$content .= "<option value=\"E\">E</option>";
$content .= "<option value=\"W\">W</option>";
$content .= "</select>"; 
$content .= "<input type=\"text\" class=\"move_over\" id=\"fdaAppNumberSup4\" name=\"fdaAppNumberSup4\" size=\"3\" maxlength=\"3\"/>";

$content .= "</td></tr>";

$content .= "</tbody></table>";

$content .= "<div class=\"or_position\"> <label class=\"or_position2\"> or </label> </div>";

$content .= "<table><tbody>";

$content .= "<tr><td class=\"tdWidth\"><label class=\"highlight\"> Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" /></td></tr>";
$content .= "<tr><td ><label class=\"highlight\">Document Type</label></td><td>";
$content .= "<select name=\"documentType\">";
$content .= "<option value=\"510K\"> K </option>";
$content .= "<option value=\"IDE\"> G </option>";
$content .= "<option value=\"PMA\"> P </option>";
$content .= "<option value=\"RAD_HEALTH\"> R </option>";
$content .= "<option value=\"513G\"> C </option>";
$content .= "<option value=\"2579\"> NA </option>";
$content .= "</select></td></tr>";
$content .= "<tr><td ><label class=\"highlight\"> Receipt Date </label></td><td><input type=\"text\" id=\"receiptDate\" name=\"receiptDate\" class=\"datepicker\" tabindex=\"-1\" /></td></tr>";
$content .= "</tbody></table>";

$content .= "</div>";

$content .= "<table><tbody>";
$content .= "<tr><td ><label >From Location</label></td><td>";
$content .= "<select name=\"fromLocation\" id=\"fromLocation\">";
$content .= "<option value=\"Division of Reproductive, Gastro-Renal, and Urological Devices (DRGUD - G201)\">  Reproductive, Gastro-Renal, & Urological Devices (G201)</option>";
$content .= "<option value=\"Division of Radiological Health\">  Radiological Health (DRAD/DRH - G303) </option>";
$content .= "<option value=\"Program Operation Staff (POS - 1617)\"> Program Operation Staff (POS - 1617)</option>";
$content .= "<option value=\"Division of Cardiovascular Devices (DCD - 1217)\">  Cardiovascular Devices (DCD - 1217) </option>";
$content .= "<option value=\"Division of Surgery Orthopedic Reconstructive Devices (DOD - 1523)\">  Surgery Orthopedic Reconstructive Devices (DOD - 1523) </option>";
$content .= "<option value=\"Division of Surgery Orthopedic Reconstructive Devices (DOD - 1423)\">  Surgery Orthopedic Reconstructive Devices (DSD - 1423) </option>";
$content .= "<option value=\"Division of Ophthalmic and Ear Nose and Throat Devices (DOED, DNPMD, DONED - 2423)\">  Ophthalmic and Ear Nose & Throat Devices (2423) </option>";
$content .= "<option value=\"Division of Gastro-Renal and Urological Devices (DAGRID/DAGID - 2523)\">  Gastro-Renal and Urological Devices (2523) </option>";
$content .= "<option value=\"Office of Compliance (OC - 2621)\"> Office of Compliance (OC - 2621) </option>";
$content .= "<option value=\"Office of Surveillance and Biometrics (OSB - 4201)\"> Office of Surveillance and Biometrics (OSB - 4201) </option>";
$content .= "<option value=\"Office of Invitro Diagnostics (OIVD - 5523)\"> Office of Invitro Diagnostics (OIVD - 5523)</option>";
$content .= "<option value=\"Office of Invitro Diagnostics (OIVD - 5621)\"> Office of Invitro Diagnostics (OIVD - 5621)</option>";
$content .= "<option value=\"Scanning\"> Scanning </option>";
$content .= "<option value=\"Document Room Staff\" selected=\"selected\"> Document Room Staff </option>";
$content .= "<option value=\"Document Room Hold Shelf\"> Document Room Hold Shelf </option>";
$content .= "<option value=\"Review\"> Review </option>";
$content .= "</select>";
$content .= "<label id=\"reviewer_label\">Reviewer Name</label><input type=\"text\" id=\"reviewer\" name=\"reviewer\" />";
$content .= "<label id=\"POS_label\">Staff Name</label><input type=\"text\" id=\"staff_name\" name=\"staff_name\" />";
$content .= "</td></tr>";

$content .= "<tr><td ><label >To Location</label></td><td>";
$content .= "<select name=\"toLocation\" id=\"toLocation\">";
$content .= "<option value=\"Division of Reproductive, Gastro-Renal, and Urological Devices (DRGUD - G201)\">  Reproductive, Gastro-Renal, & Urological Devices (G201)</option>";
$content .= "<option value=\"Division of Radiological Health\">  Radiological Health (DRAD/DRH - G303) </option>";
$content .= "<option value=\"Program Operation Staff (POS - 1617)\"> Program Operation Staff (POS - 1617)</option>";
$content .= "<option value=\"Division of Cardiovascular Devices (DCD - 1217)\">  Cardiovascular Devices (DCD - 1217) </option>";
$content .= "<option value=\"Division of Surgery Orthopedic Reconstructive Devices (DOD - 1523)\">  Surgery Orthopedic Reconstructive Devices (DOD - 1523) </option>";
$content .= "<option value=\"Division of Surgery Orthopedic Reconstructive Devices (DOD - 1423)\">  Surgery Orthopedic Reconstructive Devices (DSD - 1423) </option>";
$content .= "<option value=\"Division of Ophthalmic and Ear Nose and Throat Devices (DOED, DNPMD, DONED - 2423)\">  Ophthalmic and Ear Nose & Throat Devices (2423) </option>";
$content .= "<option value=\"Division of Gastro-Renal and Urological Devices (DAGRID/DAGID - 2523)\">  Gastro-Renal and Urological Devices (2523) </option>";
$content .= "<option value=\"Office of Compliance (OC - 2621)\"> Office of Compliance (OC - 2621) </option>";
$content .= "<option value=\"Office of Surveillance and Biometrics (OSB - 4201)\"> Office of Surveillance and Biometrics (OSB - 4201) </option>";
$content .= "<option value=\"Office of Invitro Diagnostics (OIVD - 5523)\"> Office of Invitro Diagnostics (OIVD - 5523)</option>";
$content .= "<option value=\"Office of Invitro Diagnostics (OIVD - 5621)\"> Office of Invitro Diagnostics (OIVD - 5621)</option>";
$content .= "<option value=\"Return to Delivery Company\"> Return to Delivery Company </option>";
$content .= "<option value=\"Scanning\"> Scanning </option>";
$content .= "<option value=\"Document Room Staff\"> Document Room Staff </option>";
$content .= "<option value=\"Document Room Hold Shelf\"> Document Room Hold Shelf </option>";
$content .= "<option value=\"Review\"> Review </option>";
$content .= "</select>";
$content .= "<label id=\"reviewer_label2\">Reviewer Name</label><input type=\"text\" id=\"reviewer2\" name=\"reviewer2\" />";
$content .= "<label id=\"POS_label2\">Staff Name</label><input type=\"text\" id=\"staff_name2\" name=\"staff_name2\" />";
$content .= "</td></tr>";

$content .= "<tr><td ><label >Reason</label></td><td>";
$content .= "<select name=\"reason\">";
$content .= "<option value=\"Transfer\"> Transfer </option>";
$content .= "<option value=\"Misrouted\"> Misrouted </option>";
$content .= "<option value=\"Processing Error\"> Processing Error </option>";
$content .= "<option value=\"Delivery Error\"> Delivery Error </option>";
$content .= "<option value=\"Completed\"> Completed </option>";
//$content .= "<option value=\"Hold\"> Hold </option>";
//$content .= "<option value=\"eCopy Hold\"> eCopy Hold </option>";
$content .= "<option value=\"Dropout\"> Dropout </option>";
$content .= "<option value=\"Dropout\"> FDA Clarification </option>";
$content .= "<option value=\"Delivery\" selected=\"selected\"> Delivery </option>";
$content .= "</select></td></tr>";

$content .= "<tr><td ><label > Delivery Date </label></td><td><input type=\"text\" id=\"deliveryDate\" name=\"deliveryDate\" class=\"datepicker\" /></td></tr>";

$content .= "<tr><td ><label > Delivery Time </label></td><td>";
$content .= "<select name=\"deliveryTimeHour\">";
$content .= "<option value=\"01\">01</option>";
$content .= "<option value=\"02\">02</option>";
$content .= "<option value=\"03\">03</option>";
$content .= "<option value=\"04\">04</option>";
$content .= "<option value=\"05\">05</option>";
$content .= "<option value=\"06\">06</option>";
$content .= "<option value=\"07\">07</option>";
$content .= "<option value=\"08\">08</option>";
$content .= "<option value=\"09\">09</option>";
$content .= "<option value=\"10\">10</option>";
$content .= "<option value=\"11\">11</option>";
$content .= "<option selected=\"selected\" value=\"12\">12</option>";
$content .= "</select>";

$content .= ":";

$content .= "<select name=\"deliveryTimeMinute\">";
$content .="<option value=\"00\">00</option>";
$content .="<option value=\"01\">01</option>";
$content .="<option value=\"02\">02</option>";
$content .="<option value=\"03\">03</option>";
$content .="<option value=\"04\">04</option>";
$content .="<option value=\"05\">05</option>";
$content .="<option value=\"06\">06</option>";
$content .="<option value=\"07\">07</option>";
$content .="<option value=\"08\">08</option>";
$content .="<option value=\"09\">09</option>";
$content .="<option value=\"10\">10</option>";
$content .="<option value=\"11\">11</option>";
$content .="<option value=\"12\">12</option>";
$content .="<option value=\"13\">13</option>";
$content .="<option value=\"14\">14</option>";
$content .="<option value=\"15\">15</option>";
$content .="<option value=\"16\">16</option>";
$content .="<option value=\"17\">17</option>";
$content .="<option value=\"18\">18</option>";
$content .="<option value=\"19\">19</option>";
$content .="<option value=\"20\">20</option>";
$content .="<option value=\"21\">21</option>";
$content .="<option value=\"22\">22</option>";
$content .="<option value=\"23\">23</option>";
$content .="<option value=\"24\">24</option>";
$content .="<option value=\"25\">25</option>";
$content .="<option value=\"26\">26</option>";
$content .="<option value=\"27\">27</option>";
$content .="<option value=\"28\">28</option>";
$content .="<option value=\"29\">29</option>";
$content .="<option value=\"30\">30</option>";
$content .="<option value=\"31\">31</option>";
$content .="<option value=\"32\">32</option>";
$content .="<option value=\"33\">33</option>";
$content .="<option value=\"34\">34</option>";
$content .="<option value=\"35\">35</option>";
$content .="<option value=\"36\">36</option>";
$content .="<option value=\"37\">37</option>";
$content .="<option value=\"38\">38</option>";
$content .="<option value=\"39\">39</option>";
$content .="<option value=\"40\">40</option>";
$content .="<option value=\"41\">41</option>";
$content .="<option value=\"42\">42</option>";
$content .="<option value=\"43\">43</option>";
$content .="<option value=\"44\">44</option>";
$content .="<option value=\"45\">45</option>";
$content .="<option value=\"46\">46</option>";
$content .="<option value=\"47\">47</option>";
$content .="<option value=\"48\">48</option>";
$content .="<option value=\"49\">49</option>";
$content .="<option value=\"50\">50</option>";
$content .="<option value=\"51\">51</option>";
$content .="<option value=\"52\">52</option>";
$content .="<option value=\"53\">53</option>";
$content .="<option value=\"54\">54</option>";
$content .="<option value=\"55\">55</option>";
$content .="<option value=\"56\">56</option>";
$content .="<option value=\"57\">57</option>";
$content .="<option value=\"58\">58</option>";
$content .="<option value=\"59\">59</option>";
$content .="</select>";

$content .=" ";

$content .= "<select name=\"deliveryTimeAmPm\">";
$content .="<option value=\"AM\"> AM </option>";
$content .="<option selected=\"selected\" value=\"PM\"> PM </option>";
$content .="</select>";

$content .= "</td></tr>";

$content .= "</tbody></table>";
$content .= "</form>";
            
$content .= "</div>";

$content .= "<script type=\"text/javascript\">"; 

$content .= "$('#POS_label').hide();";
$content .= "$('#staff_name').hide();";
$content .= "$('#POS_label2').hide();";
$content .= "$('#staff_name2').hide();";

$content .= "$('#fromLocation').change(function(e){if($('#fromLocation option:selected').val() == 'Review'){ $('#reviewer').show(); $('#reviewer_label').show();} else{ $(\"#reviewer\").hide(); $(\"#reviewer_label\").hide(); } e.preventDefault();});";

$content .= "$('#toLocation').change(function(e){if($('#toLocation option:selected').val() == 'Review'){ $('#reviewer2').show(); $('#reviewer_label2').show();} else{ $(\"#reviewer2\").hide(); $(\"#reviewer_label2\").hide(); } e.preventDefault();});";

$content .= "$('#fromLocation').change(function(e){if($('#fromLocation option:selected').val() == 'Program Operation Staff (POS - 1617)'){ $('#POS_label').show(); $('#staff_name').show();} else{ $(\"#POS_label\").hide(); $(\"#staff_name\").hide(); } e.preventDefault();});";

$content .= "$('#toLocation').change(function(e){if($('#toLocation option:selected').val() == 'Program Operation Staff (POS - 1617)'){ $('#POS_label2').show(); $('#staff_name2').show();} else{ $(\"#POS_label2\").hide(); $(\"#staff_name2\").hide(); } e.preventDefault();});";
 
$content .= "$('#moreInfo').hide();";
$content .= "$('#fdaAppNumber2').hide();";
$content .= "$('#fdaAppNumberSup2').hide();";
$content .= "$('#slash2').hide();";
$content .= "$('#fdaAppSupLetter2').hide();";
$content .= "$('#fdaAppNumber3').hide();";
$content .= "$('#fdaAppNumberSup3').hide();";
$content .= "$('#slash3').hide();";
$content .= "$('#fdaAppSupLetter3').hide();";
//$content .= "$('#fdaAppNumber4').hide();";
$content .= "$('#fdaAppNumberSup4').hide();";
$content .= "$('#slash4').hide();";
$content .= "$('#fdaAppSupLetter4').hide();";

$content .= "$('#deliveryCompany').change(function(e){if($('#deliveryCompany option:selected').val() == 'Other'){ $('#moreInfo').show(); } else{ $(\"#moreInfo\").hide(); } e.preventDefault();});";

$content .= "$('#document_type_id').change(function(e){if($('#document_type_id option:selected').val() == 'MAF'){ $('#fdaAppNumber2').show(); $('#fdaAppNumberSup2').show(); $('#slash2').show(); $('#fdaAppSupLetter2').show(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide(); $('#fdaAppSupLetter').hide(); $('#fdaAppNumber3').hide(); $('#fdaAppNumberSup3').hide(); $('#slash3').hide(); $('#fdaAppSupLetter3').hide(); $('#fdaAppNumberSup4').hide(); $('#slash4').hide(); $('#fdaAppSupLetter4').hide();} else if($('#document_type_id option:selected').val() == 'P'){ $('#fdaAppNumber3').show(); $('#fdaAppNumberSup3').show(); $('#slash3').show(); $('#fdaAppSupLetter3').show(); $('#fdaAppNumberSup4').show(); $('#slash4').show(); $('#fdaAppSupLetter4').show(); $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppSupLetter2').hide(); $('#fdaAppNumber').hide(); $('#fdaAppNumberSup').hide(); $('#slash').hide(); $('#fdaAppSupLetter').hide(); } else{ $('#fdaAppNumber2').hide(); $('#fdaAppNumberSup2').hide(); $('#slash2').hide(); $('#fdaAppSupLetter2').hide(); $('#fdaAppNumber3').hide(); $('#fdaAppNumberSup3').hide(); $('#slash3').hide(); $('#fdaAppSupLetter3').hide(); $('#fdaAppNumberSup4').hide(); $('#slash4').hide(); $('#fdaAppSupLetter4').hide(); $('#fdaAppNumber').show(); $('#fdaAppNumberSup').show(); $('#slash').show(); $('#fdaAppSupLetter').show();} e.preventDefault();});";

$content .="</script>";

echo $content;

?>
