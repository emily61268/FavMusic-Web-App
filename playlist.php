<?php include("includes/includedFiles.php"); 

	if(isset($_GET['id'])){
		$playlistID = $_GET['id'];
	}
	else {
		header("Location: index.php");
	}

	$playlist = new Playlist($con, $playlistID);
	$owner = new User($con, $playlist -> getOwner());
?>

<div class="entityInfo">
	<div class="leftSection">
		<div class="playlistImage">
			<img src="assets/images/icons/playlist.png">
		</div>
	</div>

	<div class="rightSection">
		<h2><?php echo $playlist -> getName(); ?></h2>
		<p>By <?php echo $playlist -> getOwner(); ?></p>
		<p><?php echo $playlist -> getNumberOfSongs(); ?> songs</p>
		<button class="button" onclick="deletePlaylist('<?php echo $playlistID ?>')">DELETE PLAYLIST</button>
	</div>
</div>

<div class="trackListContainer">
	<ul class="trackList">
		<?php 

			$songIDArray = $playlist -> getSongIDs();
			$count = 1;

			foreach($songIDArray as $songID){
				$playlistSong = new Song($con, $songID);
				$songArtist = $playlistSong -> getArtist();

				echo "<li class='trackListRow'>
						<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' alt='Play' onclick='setTrack(\"" . $playlistSong -> getID() . "\", tempPlaylist, true)'>
							<span class='trackNumber'>$count</span>
						</div>

						<div class='trackInfo'>
							<span class='trackName'>" . $playlistSong -> getTitle() . "</span>
							<span class='artistName'>" . $songArtist -> getName() . "</span>
						</div>

						<div class='trackOptions'>
							<input type='hidden' class='songID' value='" . $playlistSong -> getID() . "'>
							<img class='optionsButton' src='assets/images/icons/more.png' alt='More' onclick='showOptionsMenu(this)'>
						</div>

						<div class='trackDuration'>
							<span class='duration'>" . $playlistSong -> getDuration() . "</span>
						</div>

					</li>";

				$count++;
			}

		 ?>


		 <script>
		 	
		 	var tempSongIDs = '<?php echo json_encode($songIDArray); ?>';
		 	tempPlaylist = JSON.parse(tempSongIDs);

		 </script>

	</ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songID">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn -> getUsername()); ?>

	<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistID; ?>')">Remove from playlist</div>
</nav>