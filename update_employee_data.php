<?php

include ("hrtsDatabaseConnection.php");

if(empty($_REQUEST["first_name"])){
	
	die("<script type=\"text/javascript\"> alert('Please enter First Name.'); </script>");
	
}

if(empty($_REQUEST["last_name"])){
	
	die("<script type=\"text/javascript\"> alert('Please enter Last Name.'); </script>");
	
}
/*
if(empty($_REQUEST["password"])){
	
	die("<script type=\"text/javascript\"> alert('Please enter Password.'); </script>");
	
}
*/
$first_name = trim($_REQUEST["first_name"]);
$last_name = trim($_REQUEST["last_name"]);
$email = trim(strtolower($_REQUEST["email"]));
//$password = trim($_REQUEST["password"]);
$role = trim($_REQUEST["role"]);
$group = trim($_REQUEST["group"]);
$organization = trim($_REQUEST["organization"]);
$status = trim($_REQUEST["status"]);
$modified = trim($_REQUEST["modified"]);
$id = $_REQUEST["id"];

$employee = new new_employee();

//$employee->add_employee($first_name,$last_name,$email,$password,$role,$group,$organization,$status,$modified,$id);
$employee->add_employee($first_name,$last_name,$email,$role,$group,$organization,$status,$modified,$id);


class new_employee{
	
	//public function add_employee($first_name,$last_name,$email,$password,$role,$group,$organization,$status,$modified,$id){
	public function add_employee($first_name,$last_name,$email,$role,$group,$organization,$status,$modified,$id){
		
		$hrtsConnect = new databaseConnection();
		$hrtsConnection = $hrtsConnect->hrtsDatabaseConnection();
		
		try{
			
			//$update_employee_results = $hrtsConnection->prepare("UPDATE `users` SET firstName = :first_name,lastName = :last_name,email = :email,password = :password,role = :role,`group` = :group,organization = :organization,status = :status,modified_by = :modified WHERE id = :id");
			
			$update_employee_results = $hrtsConnection->prepare("UPDATE `users` SET firstName = :first_name,lastName = :last_name,email = :email,role = :role,`group` = :group,organization = :organization,status = :status,modified_by = :modified WHERE id = :id");
						
			$update_employee_results->bindValue(':first_name', $first_name, PDO::PARAM_STR);
			$update_employee_results->bindValue(':last_name', $last_name, PDO::PARAM_STR);
			$update_employee_results->bindValue(':email', $email, PDO::PARAM_STR);
			//$update_employee_results->bindValue(':password', $password, PDO::PARAM_STR);
			$update_employee_results->bindValue(':role', $role, PDO::PARAM_STR);
			$update_employee_results->bindValue(':group', $group, PDO::PARAM_STR);
			$update_employee_results->bindValue(':organization', $organization, PDO::PARAM_STR);
			$update_employee_results->bindValue(':status', $status, PDO::PARAM_STR);
			$update_employee_results->bindValue(':modified', $modified, PDO::PARAM_STR);
			$update_employee_results->bindValue(':id', $id, PDO::PARAM_INT);
			$update_employee_results->execute();
		}
		
		catch(PDOException $exeception){
			
			$document = 'errors/error_report.txt';
			$handle = fopen($document, 'w');
			fwrite($handle,$exeception->getMessage());
			fclose($handle);
			die("<script type=\"text/javascript\"> alert('Check log for update employee data error.'); </script>");
			
		}
		
		if($update_employee_results->rowCount() == 1){
			
			die("<script type=\"text/javascript\"> alert('$first_name $last_name has been successfully updated.'); </script>");
			
		}
		else{ die("<script type=\"text/javascript\"> alert('$first_name $last_name was not updated.'); </script>"); }
		
	}
	
	
}

?>