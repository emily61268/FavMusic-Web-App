<?php 
	
	class User {

		private $con;
		private $username;

		public function __construct($con, $username){
			$this -> con = $con;
			$this -> username = $username;
		}

		public function getUsername(){
			return $this -> username;
		}

		public function getEmail(){
			$username = $this -> username;
			$query = mysqli_query($this -> con, "SELECT email FROM users WHERE username='$username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

		public function getFirstAndLastName(){
			$username = $this -> username;
			$query = mysqli_query($this -> con, "SELECT CONCAT(firstName, ' ', lastName) AS 'name' FROM users WHERE username='$username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
			
		}
	}

 ?>