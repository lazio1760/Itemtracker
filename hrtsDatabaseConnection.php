<?php
	
	class databaseConnection{
		
		private $usernameHost;
		private $passwordHost;
		private $host_address;
		private $database_name;
		private $charset;
		public $connection;
		
		public function hrtsDatabaseConnection(){
			
			$this->usernameHost = 'hrts_admin';
			$this->passwordHost = 'Hrt$@dm1n';
            //$this->usernameHost = 'root';
            //$this->passwordHost = '';
			$this->host_address = 'localhost';
			$this->database_name = 'hrts_database';
			$this->charset = 'utf8';
			
			//$connection = mysql_connect("localhost", $this->usernameHost, $this->passwordHost); /* Creates database connection */

			try{

			$this->connection = new PDO('mysql:host='.$this->host_address.';dbname='.$this->database_name.';charset='.$this->charset, $this->usernameHost, $this->passwordHost);
			}
			
			catch(PDOException $ex){ echo "error found"; }
			
			
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			
			return $this->connection;
			
		}
		
		
	}

?>