<?php include("includes/includedFiles.php"); 

	if(isset($_GET['id'])){
		$albumID = $_GET['id'];
	}
	else {
		header("Location: index.php");
	}

	$album = new Album($con, $albumID);
	$artist = $album -> getArtist();
	$artistID = $artist -> getID();
?>

<div class="entityInfo">
	<div class="leftSection">
		<img src="<?php echo $album -> getArtworkPath(); ?>">
	</div>

	<div class="rightSection">
		<h2><?php echo $album -> getTitle(); ?></h2>
		<p role="link" tabindex="0" onclick="openPage('artist.php?id='+'<?php echo $artistID ?>')">By <?php echo $artist -> getName(); ?></p>
		<p><?php echo $album -> getNumberOfSongs(); ?> songs</p>
	</div>
</div>

<div class="trackListContainer">
	<ul class="trackList">
		<?php 

			$songIDArray = $album -> getSongIDs();
			$count = 1;

			foreach($songIDArray as $songID){
				$albumSong = new Song($con, $songID);
				$albumArtist = $albumSong -> getArtist();

				echo "<li class='trackListRow'>
						<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' alt='Play' onclick='setTrack(\"" . $albumSong -> getID() . "\", tempPlaylist, true)'>
							<span class='trackNumber'>$count</span>
						</div>

						<div class='trackInfo'>
							<span class='trackName'>" . $albumSong -> getTitle() . "</span>
							<span class='artistName'>" . $albumArtist -> getName() . "</span>
						</div>

						<div class='trackOptions'>
							<input type='hidden' class='songID' value='" . $albumSong -> getID() . "'>
							<img class='optionsButton' src='assets/images/icons/more.png' alt='More' onclick='showOptionsMenu(this)'>
						</div>

						<div class='trackDuration'>
							<span class='duration'>" . $albumSong -> getDuration() . "</span>
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
</nav>
























