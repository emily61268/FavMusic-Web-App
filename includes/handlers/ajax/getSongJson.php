<?php 

	include("../../config.php");

	if(isset($_POST['songID'])){
		$songID = $_POST['songID'];

		$query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songID'");

		$resultArray = mysqli_fetch_array($query);

		echo json_encode($resultArray);
	}

 ?>