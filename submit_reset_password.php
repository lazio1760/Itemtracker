<?php

include ("hrtsDatabaseConnection.php");


$id = trim($_REQUEST['id']);
$modified = trim($_REQUEST['modified']);

//die("id = $id <br> modified = $modified");

$password = "ch@ng3PW";

$new_password = md5($password);

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
			die("<script type=\"text/javascript\"> alert('Check log for password reset data error.'); </script>");
			
		}
		
		if($update_password_results->rowCount() == 1){
			
			try{
			
				$results = $hrtsConnection->prepare("SELECT * FROM `users` WHERE id = :id");
							
				$results->bindValue(':id', $id, PDO::PARAM_INT);
				$results->execute();
			}
			
			catch(PDOException $exeception){
				
				$document = 'errors/error_report.txt';
				$handle = fopen($document, 'w');
				fwrite($handle,$exeception->getMessage());
				fclose($handle);
				die("<script type=\"text/javascript\"> alert('Check log for password reset data error.'); </script>");
				
			}
			
			$row = $results->fetch(PDO::FETCH_ASSOC);
			
			die("<script type=\"text/javascript\"> alert('".$row["firstName"]." ".$row["lastName"]." password has been successfully reset.'); </script>");	
		}
		else{ die("<script type=\"text/javascript\"> alert('User password has not been reset.'); </script>"); }
		
	}
}

?>