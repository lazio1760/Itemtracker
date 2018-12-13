<?php

require_once ("hrtsDatabaseConnection.php");

$new_password = trim($_REQUEST['new_password']);
$new_password_again = trim($_REQUEST['new_password_again']);
$id = trim($_REQUEST['id']);
$modified = trim($_REQUEST['modified']);

if(strlen($new_password) < 6){
	
	die("<script type=\"text/javascript\"> alert('Password does not meet the required character length. Please try again'); change_password(); </script>");
	
}

if($new_password != $new_password_again){
	
	die("<script type=\"text/javascript\"> alert('Passwords enter do not match. Please try again'); change_password(); </script>");	
	
}

$new_password = md5($new_password_again);

//die("password = $new_password <br> re password = $new_password_again <br> id = $id <br> modified by = $modified");

$update_Password = new update_password();

$update_Password->update_user_password($new_password,$id,$modified);

class update_password{
	
	public function update_user_password($new_password,$id,$modified){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			
			$update_password_results = $hrtsConnection->prepare("UPDATE `users` SET password = :password, modified_by = :modified WHERE id = :id");
						
			$update_password_results->bindValue(':modified', $modified, PDO::PARAM_STR);
			$update_password_results->bindValue(':password', $new_password, PDO::PARAM_STR);
			$update_password_results->bindValue(':id', $id, PDO::PARAM_INT);
			$update_password_results->execute();
		}
		
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for password update data error.'); </script>");
			
		}
		
		if($update_password_results->rowCount() == 1){
			
			die("<script type=\"text/javascript\"> alert('Your password has been successfully changed.'); </script>");	
		}
		else{ die("<script type=\"text/javascript\"> alert('Your password has not been change.'); </script>"); }
		
	}
}

?>