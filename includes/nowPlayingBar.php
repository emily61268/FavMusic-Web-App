<?php 

	$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

	$resultArray = array();

	while($row = mysqli_fetch_array($songQuery)){
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);

 ?>

<script>

	$(document).ready(function(){
		var newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);



		//Prevent controls from highlighting texts on mouse drag
		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
			e.preventDefault();
		});


		//Drag playback progress bar: mousedown
		$(".playbackBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		//Drag playback progress bar: mousemove
		$(".playbackBar .progressBar").mousemove(function(e){
			if(mouseDown){
				//Set time of song, depending on position of mouse
				timeFromOffset(e, this);
			}
		});

		//Drag playback progress bar: mouseup
		$(".playbackBar .progressBar").mouseup(function(e){
			timeFromOffset(e, this);
		});




		//Drag volume bar: mousedown
		$(".volumeBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		//Drag volume bar: mousemove
		$(".volumeBar .progressBar").mousemove(function(e){
			if(mouseDown){
				var percentage = e.offsetX / $(this).width();
				if(percentage >= 0 && percentage <= 1){
					audioElement.audio.volume = percentage;
				}
			}
		});

		//Drag volume bar: mouseup
		$(".volumeBar .progressBar").mouseup(function(e){
			var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <= 1){
				audioElement.audio.volume = percentage;
			}
		});




		$(document).mouseup(function(){
			mouseDown = false;
		});


	});


	function timeFromOffset(mouse, progressBar){
		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var secs = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(secs);
	}


	function prevSong(){
		if(audioElement.audio.currentTime >= 15 || currentIndex == 0){
			audioElement.setTime(0);
		}
		else {
			currentIndex = --currentIndex;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
		}
	}


	function nextSong(){
		audioElement.audio.autoplay = true;
		if(repeat){
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlaylist.length - 1){
			currentIndex = 0;
		}
		else {
			++currentIndex;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];

		setTrack(trackToPlay, currentPlaylist, true);
	}


	function setRepeat(){
		audioElement.audio.autoplay = true;
		repeat = !repeat;
		var imageName = repeat ? "repeat-active.png" : "repeat.png";
		$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
	}


	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted;
		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
		$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
	}


	function setShuffle(){
		audioElement.audio.autoplay = true;
		shuffle = !shuffle;
		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);


		if(shuffle){
			//Randomize playlist
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
		else {
			//Shuffle has been deactivated
			//Go back to regular order
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
	}


	function shuffleArray(a) {
	    var j, x, i;
	    for (i = a.length - 1; i >= 0; i--) {
	        j = Math.floor(Math.random() * (i + 1));
	        x = a[i];
	        a[i] = a[j];
	        a[j] = x;
	    }
	}


	function setTrack(trackID, newPlaylist, play){

		if(newPlaylist != currentPlaylist){
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice();
			shuffleArray(shufflePlaylist);
		}

		if(shuffle){
			currentIndex = shufflePlaylist.indexOf(trackID);
		}
		else {
			currentIndex = currentPlaylist.indexOf(trackID);
		}
		
		pauseSong();


		//AJAX call to get song data from the database
		$.post("includes/handlers/ajax/getSongJson.php", { songID: trackID }, function(data){

			var track = JSON.parse(data);

			$(".trackName span").text(track.title);


			//Second AJAX call to get the artist info
			$.post("includes/handlers/ajax/getArtistJson.php", { artistID: track.artist }, function(data){
				var artist = JSON.parse(data);
				$(".trackInfo .artistName span").text(artist.name);
				$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
			});


			//Third AJAX call to get the album info
			$.post("includes/handlers/ajax/getAlbumJson.php", { albumID: track.album }, function(data){
				var album = JSON.parse(data);
				$(".content .albumLink img").attr("src", album.artworkPath);
				$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
				$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			});


			audioElement.setTrack(track);
			
			if(play){
				playSong();
			}

		});


	}

	function playSong(){
		audioElement.audio.autoplay = true;
		if(audioElement.audio.currentTime == 0){
			$.post("includes/handlers/ajax/updatePlays.php", { songID: audioElement.currentlyPlaying.id });
		}

		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong(){
		audioElement.audio.autoplay = false;
		$(".controlButton.play").show();
		$(".controlButton.pause").hide();
		audioElement.pause();
	}

</script>


<div id="nowPlayingBarContainer">
		
	<div id="nowPlayingBar">

		<div id="nowPlayingLeft">
			
			<div class="content">
				<span class="albumLink">
					<img role="link" tabindex="0" src="" class="albumArtwork">
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link" tabindex="0"></span>
					</span>

					<span class="artistName">
						<span role="link" tabindex="0"></span>
					</span>
				</div>
			</div>

		</div>

		<div id="nowPlayingCenter">
			
			<div class="content playerControls">
				
				<div class="buttons">
					
					<button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous" onclick="prevSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause" style="display: none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat" onclick="setRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>

				</div>

				<div class="playbackBar">
					<span class="progressTime current">0.00</span>
					<div class="progressBar">
						<div class="progressBarBG">
							<div class="progress"></div>
						</div>
					</div>
					<span class="progressTime remaining">0.00</span>
				</div>

			</div>
			
		</div>

		<div id="nowPlayingRight">
			
			<div class="volumeBar">
				<button class="controlButton volume" title="Volume" onclick="setMute()">
					<img src="assets/images/icons/volume.png" alt="Volume">
				</button>

				<div class="progressBar">
					<div class="progressBarBG">
						<div class="progress"></div>
					</div>
				</div>
			</div>
			
		</div>
		
	</div>

</div>