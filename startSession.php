<?php

include ("checkLogin.php");

$credential = new checkLogin();

$credential->findEmail();

?>