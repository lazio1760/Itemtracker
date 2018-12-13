<?php

include ("hrtsDatabaseConnection.php");

$email = "adrbah@heitechservices.com";

$test = new databaseConnection();

$connection = $test->hrtsDatabaseConnection();

$results = $connection->query("Select * FROM users WHERE email = '$email'");

$count = $results->rowCount();

$content ="The rows returned: ". $count;

$content .="<br>";

while($row = $results->fetch(PDO::FETCH_ASSOC)){
	
	  $content .=$row["id"]." ".$row["status"]."<br>";
	
}

echo $content;

?>