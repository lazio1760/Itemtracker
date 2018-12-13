<?php

$content = "<div id=\"mail_Logout\">";
            
$content .= "<form id=\"mailLogoutForm\" class=\"formFormatting\" name=\"mailLogoutForm\">";
$content .= "<table><tbody>";

$content .= "<tr><td class=\"tdWidth\">FDA Number</td><td><input type=\"text\" id=\"fdaAppNumber\" name=\"fdaAppNumber\" /></td></tr>";
$content .= "<tr><td ><label >Document Type</label></td><td>";
$content .= "<select name=\"documentType\">";
$content .= "<option value=\"510K\"> K </option>";
$content .= "<option value=\"IDE\"> G </option>";
$content .= "<option value=\"PMA\"> P </option>";
$content .= "<option value=\"RAD_HEALTH\"> R </option>";
$content .= "<option value=\"NA\"> NA </option>";
$content .= "</select></td></tr>";
$content .= "<tr><td class=\"tdWidth\"><label > Internal Number </label></td><td><input type=\"text\" id=\"internal_number\" name=\"internal_number\" /></td></tr>";

$content .= "<tr><td ><label >Delivery Location</label></td><td>";
$content .= "<select name=\"deliveryLocation\">";
$content .= "<option value=\"Division of Reproductive, Gastro-Renal, and Urological Devices\"> Division of Reproductive, Gastro-Renal, and Urological Devices </option>";
$content .= "<option value=\"Division of Radiological Health\"> Division of Radiological Health </option>";
$content .= "<option value=\"Program Operation Staff\"> Program Operation Staff </option>";
$content .= "<option value=\"Division of Cardiovascular Devices\"> Division of Cardiovascular Devices </option>";
$content .= "<option value=\"Division of Surgery Orthopedic Reconstructive Devices\"> Division of Surgery Orthopedic Reconstructive Devices </option>";
$content .= "<option value=\"Division of Ophthalmic and Ear Nose and Throat Devices\"> Division of Ophthalmic and Ear Nose and Throat Devices </option>";
$content .= "<option value=\"Division of Gastro-Renal and Urological Devices\"> Division of Gastro-Renal and Urological Devices </option>";
$content .= "<option value=\"Office of Compliance\"> Office of Compliance </option>";
$content .= "<option value=\"Office of Surveillance and Biometrics\"> Office of Surveillance and Biometrics </option>";
$content .= "<option value=\"Office of Invitro Diagnostics 5523\"> Office of Invitro Diagnostics </option>";
$content .= "<option value=\"Office of Invitro Diagnostics 5621\"> Office of Invitro Diagnostics </option>";
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

echo $content;

?>
