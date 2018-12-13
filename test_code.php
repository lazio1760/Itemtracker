<?php

//$current_date = date("Y-m-d", (strtotime('now')));
//$current_time = date("h:i:s A", (strtotime('now')));

$current_date = date("Y-m-d", (strtotime('now') - (60*60*5)));
$current_time = date("h:i:s A", (strtotime('now') - (60*60*5)));
die("$current_date and $current_time ");

?>