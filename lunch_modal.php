<?php

session_start();

//die('works');

//$firstName = $_SESSION["firstName"];

$content = "<div id=\"at_lunch\" align=\"center\">";
            
$content .="<div id=\"lunch_statement\">". $_SESSION["firstName"]." ".$_SESSION["lastName"]." is currently logout for lunch. </div>"; 

$content .="</div>";

/*$content .="<script type=\"text/javascript\"> adjust_statement(); </script>";*/
	
die($content);

?>