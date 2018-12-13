<?php

class loginTime{
	
	public $hrtsConnect2;
	public $hrtsConnection2;
	
	
	public function login_time($id){
		
		$this->hrtsConnect2 = new databaseConnection();
		$this->hrtsConnection2 = $this->hrtsConnect2->hrtsDatabaseConnection();
		
		$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
		
		$current_time = date("h:i:s A", (strtotime('now')));
		
		$results = $this->hrtsConnection2->query("Select * FROM users_time WHERE id = $id and date = '$current_date'");
		
		$count = $results->rowCount();
		//echo $count;
		
		if($count == 0){ 
			
			$affected_rows = $this->hrtsConnection2->exec("INSERT INTO users_time (id, date, login_time) VALUES ('$id', '$current_date', '$current_time')");
		
		}
		
	}	
	
	
}

class logoutTime{
	
	public $hrtsConnect3;
	public $hrtsConnection3;
	
	public function logout_time($id){
		
		$this->hrtsConnect3 = new databaseConnection();
		$this->hrtsConnection3 = $this->hrtsConnect3->hrtsDatabaseConnection();
		
		$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
		
		$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));
		
		$results_logout = $this->hrtsConnection3->query("Select * FROM users_time WHERE id = $id and date = '$current_date'");
		
		if($results_logout->rowCount() == 1){ 
			
			$affected_rows = $this->hrtsConnection3->exec("UPDATE users_time SET logout_time = '$current_time' WHERE id = $id and date = '$current_date'");
		}	
		
	}
	
}
	
class startLunch{

	public function start_lunch($id){
	
		$hrtsConnect7 = new databaseConnection();
		$hrtsConnection7 = $hrtsConnect7->hrtsDatabaseConnection();
		
		$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
		$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));	
		
		$results_start_lunch = $hrtsConnection7->query("Select * FROM users_time WHERE id = $id and date = '$current_date'");
		
		
		$row = $results_start_lunch->fetch(PDO::FETCH_ASSOC);
		
		//if(($results_start_lunch->rowCount() == 1)&&(empty($row["on_lunch"]))){
		if(($results_start_lunch->rowCount() == 1)){
			
			$affected_rows = $hrtsConnection7->exec("UPDATE users_time SET on_lunch = '$current_time' WHERE id = $id and date = '$current_date'");
		}	
		
	}
	
}
		
class endLunch{
	
	public function end_lunch($id){
	
		$hrtsConnect7 = new databaseConnection();
		$hrtsConnection7 = $hrtsConnect7->hrtsDatabaseConnection();
		
		$current_date = date("Y-m-d", (strtotime('now') - (60*60*4)));
		$current_time = date("h:i:s A", (strtotime('now') - (60*60*4)));	
		
		$results_end_lunch = $hrtsConnection7->query("Select * FROM users_time WHERE id = $id and date = '$current_date'");
		
		$row = $results_end_lunch->fetch(PDO::FETCH_ASSOC);
		
		//if(($results_end_lunch->rowCount() == 1)&&(empty($row["off_lunch"]))){ 
		if(($results_end_lunch->rowCount() == 1)){ 
			
			$affected_rows = $hrtsConnection7->exec("UPDATE users_time SET off_lunch = '$current_time' WHERE id = $id and date = '$current_date'");
		}	
		
	}
	
}


?>