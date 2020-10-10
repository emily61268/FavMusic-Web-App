<?php 
	
	class Album{

		private $con;
		private $id;
		private $title;
		private $artistID;
		private $genre;
		private $artworkPath;

		public function __construct($con, $id){
			$this -> con = $con;
			$this -> id = $id;
			// $id = $this -> id;
			$query = mysqli_query($this -> con, "SELECT * FROM albums WHERE id='$id'");
			$album = mysqli_fetch_array($query);

			$this -> title = $album['title'];
			$this -> artistID = $album['artist'];
			$this -> genre = $album['genre'];
			$this -> artworkPath = $album['artworkPath'];
		}

		public function getTitle(){
			return $this -> title;
		}

		public function getArtist(){
			return new Artist($this -> con, $this -> artistID);
		}

		public function getArtworkPath(){
			return $this -> artworkPath;
		}

		public function getGenre(){
			return $this -> genre;
		}

		public function getNumberOfSongs(){
			$id = $this -> id;
			$query = mysqli_query($this -> con, "SELECT id FROM songs WHERE album='$id'");
			return mysqli_num_rows($query);
		}

		public function getSongIDs(){
			$id = $this -> id;
			$query = mysqli_query($this -> con, "SELECT id FROM songs WHERE album='$id' ORDER BY albumOrder ASC");

			$array = array();

			while($row = mysqli_fetch_array($query)){
				array_push($array, $row['id']);
			}

			return $array;
		}
		
	}

 ?>