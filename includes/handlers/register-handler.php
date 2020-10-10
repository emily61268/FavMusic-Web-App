<?php 

	function sanitizeFormUsername($inputText){
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		return $inputText;
	}

	function sanitizeFormPassword($inputText){
		$inputText = strip_tags($inputText);
		return $inputText;
	}

	function sanitizeFormString($inputText){
		$inputText = sanitizeFormUsername($inputText);
		$inputText = ucfirst(strtolower($inputText));
		return $inputText;
	}


	if(isset($_POST['registerButton'])){
		//Register button was pressed.
		$username = sanitizeFormUsername($_POST['username']);
		$firstName = sanitizeFormString($_POST['firstName']);
		$lastName = sanitizeFormString($_POST['lastName']);
		$email = sanitizeFormString($_POST['email']);
		$confirmEmail = sanitizeFormString($_POST['emailConfirm']);
		$pwd = sanitizeFormPassword($_POST['pwd']);
		$confirmPwd = sanitizeFormPassword($_POST['confirmPwd']);

		$wasSuccessful = $account -> register($username, $firstName, $lastName, $email, $confirmEmail, $pwd, $confirmPwd);

		echo $wasSuccessful;

		if($wasSuccessful){
			$_SESSION['userLoggedIn'] = $username;
			//Redirect to index.php page
			header("Location: index.php");
		}
	}

 ?>