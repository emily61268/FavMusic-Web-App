<?php 
	
	class Artist{

		private $con;
		private $id;

		public function __construct($con, $id){
			$this -> con = $con;
			$this -> id = $id;
		}

		public function getID(){
			return $this -> id;
		}

		public function getName(){
			$id = $this -> id;
			$artistQuery = mysqli_query($this -> con, "SELECT name FROM artists WHERE id='$id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['name'];
		}

		public function getSongIDs(){
			$id = $this -> id;
			$query = mysqli_query($this -> con, "SELECT id FROM songs WHERE artist='$id' ORDER BY plays DESC");

			$array = array();

			while($row = mysqli_fetch_array($query)){
				array_push($array, $row['id']);
			}

			return $array;
		}

	}

 ?>