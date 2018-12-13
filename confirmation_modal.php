<?php

session_start();

//die('works');

//$firstName = $_SESSION["firstName"];

$content = "<div id=\"confirmation\" align=\"center\">";
            
$content .="<div id=\"lunch_statement\">". $_SESSION["firstName"]." ".$_SESSION["lastName"]." is the information in the form correct? </div>"; 

$content .="</div>";

/*$content .="<script type=\"text/javascript\"> adjust_statement(); </script>";*/
	
die($content);

?>