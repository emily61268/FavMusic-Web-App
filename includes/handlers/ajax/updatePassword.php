<?php 
	
	include("../../config.php");

	if(!isset($_POST['username'])){
		echo "ERROR: Could not set username.";
		exit();
	}
	
	if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])){
		echo "ERROR: Not all passwords have been set.";
		exit();
	}

	if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == ""){
		echo "ERROR: Please fill in all fields.";
		exit();
	}

	$username = $_POST['username'];
	$oldPassword = $_POST['oldPassword'];
	$newPassword1 = $_POST['newPassword1'];
	$newPassword2 = $_POST['newPassword2'];

	$oldMd5 = md5($oldPassword);

	$passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$oldMd5'");

	if(mysqli_num_rows($passwordCheck) != 1){
		echo "ERROR: Password is incorrect.";
		exit();
	}

	if($newPassword1 != $newPassword2){
		echo "ERROR: New passwords don't match.";
		exit();
	}

	$containsLetter  = preg_match('/[a-zA-Z]/', $newPassword1);
	$containsDigit   = preg_match('/\d/', $newPassword1);
	$containsSpecial = preg_match('/[^a-zA-Z\d]/', $newPassword1);
	$containsAll = $containsLetter && $containsDigit && $containsSpecial;

	if(!$containsAll){
		echo "ERROR: Your password must contain at least ONE uppercase, ONE lowercase, ONE number, and ONE of the special characters (!@#$%^&+=?><~).";
		exit();
	}

	if(strlen($newPassword1) < 8){
		echo "ERROR: Your password must be at least 8 characters.";
		exit();
	}

	$newMd5 = md5($newPassword1);

	$query = mysqli_query($con, "UPDATE users SET password='$newMd5' WHERE username='$username'");
	echo "Update successful!";

 ?>