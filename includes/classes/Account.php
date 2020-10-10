<?php 
	
	class Account{

		private $con;

		private $errorArray;

		public function __construct($con){
			$this -> con = $con;
			$this -> errorArray = array();
		}


		public function login($un, $pw){
			$pw = md5($pw);

			$query = mysqli_query($this -> con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

			if(mysqli_num_rows($query) == 1){
				return true;
			}
			else {
				array_push($this -> errorArray, Constants::$loginFailed);
				return false;
			}
		}


		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
			$this -> validateUsername($un);
			$this -> validateFirstName($fn);
			$this -> validateLastName($ln);
			$this -> validateEmails($em, $em2);
			$this -> validatePasswords($pw, $pw2);

			if(empty($this -> errorArray)){
				//Insert into DB
				return $this -> insertUserDetails($un, $fn, $ln, $em, $pw);
			} else {
				return false;
			}
		}



		public function getError($error){
			if(!in_array($error, $this -> errorArray)){
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}


		private function insertUserDetails($un, $fn, $ln, $em, $pw){
			//Password encryption
			$encryptedPw = md5($pw);
			$profilePic = "assets/images/profile-pics/profile-pic.jpg";
			$date = date("Y-m-d");

			//This query will return true or false value to indicate if the values are successfully added in the db or not.
			$result = mysqli_query($this -> con, "INSERT INTO users VALUES(NULL, '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");

			return $result;
		}



		private function validateUsername($un){
			if(strlen($un) > 25 || strlen($un) < 5){
				array_push($this -> errorArray, Constants::$usernameInvalid);
				return;
			}

			$checkUsernameQuery = mysqli_query($this -> con, "SELECT username FROM users WHERE username='$un'");

			if(mysqli_num_rows($checkUsernameQuery) != 0){
				array_push($this -> errorArray, Constants::$usernameUsed);
				return;
			}		
		}

		private function validateFirstName($fn){
			if(strlen($fn) > 25 || strlen($fn) < 2){
				array_push($this -> errorArray, Constants::$firstNameInvalid);
				return;
			}
		}

		private function validateLastName($ln){
			if(strlen($ln) > 25 || strlen($ln) < 2){
				array_push($this -> errorArray, Constants::$lastNameInvalid);
				return;
			}
		}

		private function validateEmails($em, $em2){
			if($em != $em2){
				array_push($this -> errorArray, Constants::$emailsNotMatch);
				return;
			}

			if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
				array_push($this -> errorArray, Constants::$emailInvalid);
				return;	
			}

			$checkEmailQuery = mysqli_query($this -> con, "SELECT email FROM users WHERE email='$em'");

			if(mysqli_num_rows($checkEmailQuery) != 0){
				array_push($this -> errorArray, Constants::$emailUsed);
				return;
			}	
		}

		private function validatePasswords($pw, $pw2){
			if($pw != $pw2){
				array_push($this -> errorArray, Constants::$pwsNotMatch);
				return;
			}

			$containsLetter  = preg_match('/[a-zA-Z]/', $pw);
			$containsDigit   = preg_match('/\d/', $pw);
			$containsSpecial = preg_match('/[^a-zA-Z\d]/', $pw);
			$containsAll = $containsLetter && $containsDigit && $containsSpecial;

			if(!$containsAll){
				array_push($this -> errorArray, Constants::$pwInvalid);
				return;
			}

			if(strlen($pw) < 8){
				array_push($this -> errorArray, Constants::$pwTooShort);
				return;
			}
		}

	}



 ?>