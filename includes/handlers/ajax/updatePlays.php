<?php 

	include("../../config.php");

	if(isset($_POST['songID'])){
		$songID = $_POST['songID'];

		$query = mysqli_query($con, "UPDATE songs SET plays = plays + 1 WHERE id='$songID'");
	}

 ?>