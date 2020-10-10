<?php 

	include("includes/includedFiles.php");

	if(isset($_GET['id'])){
		$artistID = $_GET['id'];
	}
	else {
		header("Location: index.php");
	}

	$artist = new Artist($con, $artistID);

 ?>

 <div class="entityInfo borderBottom">
 	
 	<div class="centerSection">
 		
 		<div class="artistInfo">
 			
 			<h1 class="artistName"><?php echo $artist -> getName(); ?></h1>

 			<div class="headerButtons">
 				<button class="button lightblue" onclick="playFirstSong()">PLAY</button>
 			</div>

 		</div>

 	</div>

 </div>

 <div class="trackListContainer borderBottom">
 	<h2>SONGS</h2>
	<ul class="trackList">
		<?php 

			$songIDArray = $artist -> getSongIDs();
			$count = 1;

			foreach($songIDArray as $songID){
				if($count > 5) break;

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


<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php 

		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistID'");

		while($row = mysqli_fetch_array($albumQuery)){
			echo "<div class='gridViewItem'>
 					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>" 

							. $row['title'] .

					   "</div>
					 </span>
				</div>";
		}

	 ?>
	
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songID">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn -> getUsername()); ?>
</nav>
