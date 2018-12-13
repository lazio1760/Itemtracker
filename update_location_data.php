<?php

include ("hrtsDatabaseConnection.php");

$fdaAppNumber = $_REQUEST['fdaAppNumber'];
$documentType = $_REQUEST['documentType'];
$k_number = $_REQUEST['internalK'];
$dueInDate = date("Y-m-d", (strtotime($_REQUEST['dueInDate'])));
$checkedOutDate = date("Y-m-d", (strtotime($_REQUEST['checkedOutDate'])));
$whoCheckedOut = $_REQUEST['whoCheckedOut'];
$checkoutLocation = $_REQUEST['checkoutLocation'];
$checkedInDate = date("Y-m-d", (strtotime($_REQUEST['checkedInDate'])));
$shelfLocation = $_REQUEST['shelfLocation'];
$status = $_REQUEST['status'];

//echo($k_number."<br>".$dueInDate."<br>".$checkedOutDate."<br>".$whoCheckedOut."<br>".$checkoutLocation."<br>".$checkedInDate."<br>".$shelfLocation."<br>".$status);




$search = new update_location_data();

$search->update_location($k_number,$dueInDate,$checkedOutDate,$whoCheckedOut,$checkoutLocation,$checkedInDate,$shelfLocation,$status,$fdaAppNumber,$documentType);

class update_location_data{
	
	public function update_location($k_number,$dueInDate,$checkedOutDate,$whoCheckedOut,$checkoutLocation,$checkedInDate,$shelfLocation,$status,$fdaAppNumber,$documentType){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		$results = $hrtsConnection->prepare("UPDATE `document_location` SET status = :status, shelf_location = :shelfLocation, out_location = :checkoutLocation, out_person = :whoCheckedOut, check_out_date = :checkedOutDate, check_in_date = :checkedInDate, k_number = :k_number, due_date = :dueInDate WHERE fda_application_number = :fdaAppNumber AND document_type = :documentType");
		
		$results->bindValue(':status', $status, PDO::PARAM_STR);
		$results->bindValue(':shelfLocation', $shelfLocation, PDO::PARAM_STR);
		$results->bindValue(':checkoutLocation', $checkoutLocation, PDO::PARAM_STR);
		$results->bindValue(':whoCheckedOut', $whoCheckedOut, PDO::PARAM_STR);
		$results->bindValue(':checkedOutDate', $checkedOutDate, PDO::PARAM_STR);
		$results->bindValue(':checkedInDate', $checkedInDate, PDO::PARAM_STR);
		$results->bindValue(':k_number', $k_number, PDO::PARAM_STR);
		$results->bindValue(':dueInDate', $dueInDate, PDO::PARAM_STR);
		$results->bindValue(':documentType', $documentType, PDO::PARAM_STR);
		$results->bindValue(':fdaAppNumber', $fdaAppNumber, PDO::PARAM_STR);
		$results->execute();
		
		if($results->rowCount() == 1){
		
			die("<script type=\"text/javascript\"> alert('FDA Application Number: $fdaAppNumber has been successfully updated.'); </script>");	
			
		}
		
		else{
			
			die("Update Failed <br>".$k_number."<br>".$dueInDate."<br>".$checkedOutDate."<br>".$whoCheckedOut."<br>".$checkoutLocation."<br>".$checkedInDate."<br>".$shelfLocation."<br>".$status);
			
		}

	}
}

?>