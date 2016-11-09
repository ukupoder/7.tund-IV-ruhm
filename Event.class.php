<?php
class event{
	
	private $connection;
	//k�ivitab siia kui on =new User(see j�uab siia)
	function __construct($mysqli){
		
		$this->connection = $mysqli;
	}
	
	
	function saveEvent($age, $color) {
				
		$stmt = $this->connection->prepare("INSERT INTO whistle (age, color) VALUE (?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("is", $age, $color);
		
		if ( $stmt->execute() ) {
			echo "�nnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function getAllPeople($q) {
		
		if($q != ""){
			
			echo "otsin: ".$q;
			//otsin
			$stmt = $this->connection->prepare("
			SELECT id, age, color
			FROM whistle
			WHERE deleted IS NULL
			AND (age LIKE ? OR color LIKE ?)
			");

			$searchWord= "%".$q."%";
			$stmt->bind_param("ss", $searchWord, $searchWord);

			
		}else{
			//ei otsi
			$stmt = $this->connection->prepare("
			SELECT id, age, color
			FROM whistle
			WHERE deleted IS NULL
			");
			
			
		}
		
		
		$stmt->bind_result($id, $age, $color);
		$stmt->execute();
		
		$results = array();
		
		// ts�kli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->age = $age;
			$human->lightColor = $color;
			
			
			//echo $color."<br>";
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
	
	
	function getSinglePerosonData($edit_id){
    
	
		$stmt = $this->connection->prepare("SELECT age, color FROM whistle WHERE id=?");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($age, $color);
		$stmt->execute();
		
		//tekitan objekti
		$p = new Stdclass();
		
		//saime �he rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$p->age = $age;
			$p->color = $color;
			
			
		}else{
			// ei saanud rida andmeid k�tte
			// sellist id'd ei ole olemas
			// see rida v�ib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		return $p;
		
	}


	function updatePerson($id, $age, $color){
    	
		$stmt = $this->connection->prepare("UPDATE whistle SET age=?, color=? WHERE id=?");
		$stmt->bind_param("isi",$age, $color, $id);
		
		// kas �nnestus salvestada
		if($stmt->execute()){
			// �nnestus
			echo "salvestus �nnestus!";
		}
		
		$stmt->close();
	}
	
	function deleteButton($id){
		

		$stmt = $mysqli->prepare("UPDATE whistle SET deleted =NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $id);
		
		// kas �nnestus salvestada
		if($stmt->execute()){
			// �nnestus
			echo "kustutatud";
		}
		
		$stmt->close();
	}
	
	
	
	
	
	
}
?>