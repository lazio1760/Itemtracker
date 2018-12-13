<?php

include ("hrtsDatabaseConnection.php");

include ("trackTime.php");

class checkPassword{
	
	private $hrtsConnect;
	private $hrtsConnection;
	public $emailx;
	public $passwordx;
	
	public function findEmailex(){
		
		$hrtsConnect2 = new databaseConnection();
		$hrtsConnection2 = $hrtsConnect2->hrtsDatabaseConnection();
		
		$this->emailx = trim($_REQUEST['email']);
		
		if($this->emailx == NULL){die("Enter Email Address");}
		
		$this->emailx = filter_var($this->emailx, FILTER_SANITIZE_EMAIL);
			
		//$results = $hrtsConnection2->query("Select * FROM users WHERE email = '$this->email'");
		
		$results = $hrtsConnection2->prepare("Select * FROM users WHERE email = :email");
		
		$results->bindValue(':email', $this->emailx, PDO::PARAM_STR);
		
		$results->execute();
		
		$count = $results->rowCount();
		
		//echo $count;
		
		if($count > 0){ die("Login Successful");}
		
		else { die("Incorrect Username and/or Password");}
		
	
		
		
		
	}


}


?>
