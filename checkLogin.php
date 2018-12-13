<?php

include ("hrtsDatabaseConnection.php");

include ("trackTime.php");

class checkLogin{
	
	private $hrtsConnect;
	private $hrtsConnection;
	public $email;
	public $password;
	
	public function findEmail(){
		
		$hrtsConnect2 = new databaseConnection();
		$hrtsConnection2 = $hrtsConnect2->hrtsDatabaseConnection();
		
		$this->email = trim($_REQUEST['email']);
		
		if($this->email == NULL){die("Enter Email Address");}
		
		$this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
			
		//$results = $hrtsConnection2->query("Select * FROM users WHERE email = '$this->email'");
		
		$results = $hrtsConnection2->prepare("Select * FROM users WHERE email = :email");
		
		$results->bindValue(':email', $this->email, PDO::PARAM_STR);
		
		$results->execute();
		
		$count = $results->rowCount();
		
		//echo $count;
		
		if($count > 0){ $this->findPassword();}
		
		else { die("Incorrect Username and/or Password");}
		
	}
	
	public function findPassword(){
		
		$hrtsConnect2 = new databaseConnection();
		$hrtsConnection2 = $hrtsConnect2->hrtsDatabaseConnection();
       
		
		$this->password = md5(trim($_REQUEST['password']));
        
		
		//$results = $hrtsConnection2->query("Select * FROM users WHERE email = '$this->email' AND password = '$this->password'");
		
		$results = $hrtsConnection2->prepare("Select * FROM users WHERE email = :email AND password = :password");
		
		$results->bindValue(':email', $this->email, PDO::PARAM_STR);
		$results->bindValue(':password', $this->password, PDO::PARAM_STR);
		$results->execute();
		
		$count = $results->rowCount();
		
		if($count > 0){
			
			session_start();
			
			while($row = $results->fetch(PDO::FETCH_ASSOC)){
				
				$_SESSION['firstName'] = $row['firstName'];
				$_SESSION['lastName'] = $row['lastName'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['role'] = $row['role'];
				$_SESSION['group'] = $row['group'];
				$id = $_SESSION['id'];
				$session_result = $hrtsConnection2->query("Select * FROM session");
				$hidden_row = $session_result->fetch(PDO::FETCH_ASSOC);
				$_SESSION['variable'] = $hidden_row['variable']; 
				if($row['status'] == 'Inactive') {session_destroy(); 
                die("Access Denied");}
			}
			
			$logTime = new loginTime();
			
			$logTime->login_time($id);
		
			die("Login Successful");
			
		}
		
		else { die("Incorrect Email Address and/or Password");}
		
	}


}


?>