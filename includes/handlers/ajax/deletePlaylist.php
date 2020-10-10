<?php 

	include("../../config.php");

	if(isset($_POST['playlistID'])){
		$playlistID = $_POST['playlistID'];

		$playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistID'");
		$songsQuery = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistID='$playlistID'");
	}
	else {
		echo "PlaylistID was not passed into deletePlaylist.php.";
	}

 ?>