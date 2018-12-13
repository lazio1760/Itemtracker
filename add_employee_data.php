<?php

include ("hrtsDatabaseConnection.php");

if(empty($_REQUEST["first_name"])){
	
	die("<script type=\"text/javascript\"> alert('Please enter First Name.'); </script>");
	
}

if(empty($_REQUEST["last_name"])){
	
	die("<script type=\"text/javascript\"> alert('Please enter Last Name.'); </script>");
	
}

if(empty($_REQUEST["email"])){
	
	die("<script type=\"text/javascript\"> alert('Please enter email address.'); </script>");
	
}

$first_name = trim($_REQUEST["first_name"]);
$last_name = trim($_REQUEST["last_name"]);
$email = trim(strtolower($_REQUEST["email"]));
$pass = 'ch@ng3PW';
$password = md5($pass);
$role = trim($_REQUEST["role"]);
$group = trim($_REQUEST["group"]);
$organization = trim($_REQUEST["organization"]);
$status = trim($_REQUEST["status"]);
$modified = trim($_REQUEST["modified"]);

$employee = new new_employee();

$employee->add_employee($first_name,$last_name,$email,$password,$role,$group,$organization,$status,$modified);


class new_employee{
	
	public function add_employee($first_name,$last_name,$email,$password,$role,$group,$organization,$status,$modified){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			$check_employee_results = $hrtsConnection->prepare("SELECT * FROM `users` WHERE firstName = :first_name AND lastName = :last_name");
			
			$check_employee_results->bindValue(':first_name', $first_name, PDO::PARAM_STR);
			$check_employee_results->bindValue(':last_name', $last_name, PDO::PARAM_STR);
			$check_employee_results->execute();
		}
		
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for add employee data error.'); </script>");
			
		}
		
		if($check_employee_results->rowCount() > 0){
			
			die("<script type=\"text/javascript\"> alert('$first_name $last_name already exist.'); </script>");
		}
		
		try{
			$add_employee_results = $hrtsConnection->prepare("INSERT INTO `users` (firstName,lastName,email,password,role,`group`,organization,status,modified_by) VALUES (:first_name,:last_name,:email,:password,:role,:group,:organization,:status,:modified)");
						
			$add_employee_results->bindValue(':first_name', $first_name, PDO::PARAM_STR);
			$add_employee_results->bindValue(':last_name', $last_name, PDO::PARAM_STR);
			$add_employee_results->bindValue(':email', $email, PDO::PARAM_STR);
			$add_employee_results->bindValue(':password', $password, PDO::PARAM_STR);
			$add_employee_results->bindValue(':role', $role, PDO::PARAM_STR);
			$add_employee_results->bindValue(':group', $group, PDO::PARAM_STR);
			$add_employee_results->bindValue(':organization', $organization, PDO::PARAM_STR);
			$add_employee_results->bindValue(':status', $status, PDO::PARAM_STR);
			$add_employee_results->bindValue(':modified', $modified, PDO::PARAM_STR);
			$add_employee_results->execute();
		}
		
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for add employee data error.'); </script>");
			
		}
		
		if($add_employee_results->rowCount() == 1){
			
			die("<script type=\"text/javascript\"> alert('$first_name $last_name has been successfully added.'); </script>");	
		}
		else{ die("<script type=\"text/javascript\"> alert('$first_name $last_name was not added.'); </script>"); }
		
	}
	
	
}

?>