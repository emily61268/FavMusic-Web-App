<?php 

	include("../../config.php");

	if(isset($_POST['playlistID']) && isset($_POST['songID'])){
		$playlistID = $_POST['playlistID'];
		$songID = $_POST['songID'];

		$orderIDQuery = mysqli_query($con, "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM playlistSongs WHERE playlistID='$playlistID'");
		$row = mysqli_fetch_array($orderIDQuery);
		$order = $row['playlistOrder'];

		$query = mysqli_query($con, "INSERT INTO playlistSongs VALUES(NULL, '$songID', '$playlistID', '$order')");
	}
	else {
		echo "PlaylistID or songID was not passed into addToPlaylist.php.";
	}

 ?>