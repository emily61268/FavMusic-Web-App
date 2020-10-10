<?php 
	
	include("../../config.php");

	if(isset($_POST['playlistID']) && isset($_POST['songID'])){
		$playlistID = $_POST['playlistID'];
		$songID = $_POST['songID'];

		$query = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistID='$playlistID' AND songID ='$songID'");
	}
	else {
		echo "PlaylistID or songID was not passed into removeFromPlaylist.php.";
	}

 ?>