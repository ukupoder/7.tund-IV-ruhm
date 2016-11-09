<?php
class interest{
	
	private $connection;
	//käivitab siia kui on =new User(see jõuab siia)
	function __construct($mysqli){
		
		$this->connection = $mysqli;
	}
	
	

	function saveInterest ($interest) {
		
		$stmt = $this->connection->prepare("INSERT INTO interests (interest) VALUES (?)");
	
		echo $this->connection->error;
		
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		
	}
	
	
	
	
	function saveUserInterest ($interest) {
	

		$stmt = $this->connection->prepare("SELECT id FROM user_interests WHERE user_id=? AND interest_id=?");
		
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		
		$stmt->execute();
		//kas rida olemas
		if ($stmt->fetch())
		{
			//oli olemas
			echo "juba olemas";
			//pärast returni enam koodi ei vaadata
			return;
			
		}
		
		//kui ei ole, jõuan siia
		$stmt->close();
			
		$stmt = $this->connection->prepare("INSERT INTO user_interests (user_id,interest_id) VALUES (?, ?)");

		echo $this->connection->error;
		
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		
	}
	
	
		function getUserInterests() {
	
	
		$stmt = $this->connection->prepare("
			SELECT user_sample.email, interests.interest
			FROM user_interests
			INNER JOIN user_sample
			on user_interests.user_id=user_sample.id 
			INNER JOIN interests
			on user_interests.interest_id = interests.id where user_sample.id =?
		");
		//SESSION USER ID
		
		$stmt->bind_param("i", $_SESSION["userId"]);
		
		echo $this->connection->error;
		
		$stmt->bind_result($email, $interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		
		return $result;
	}
		
	
	
	function getAllInterests() {
		
	
		$stmt = $this->connection->prepare("
			SELECT id, interest
			FROM interests
		");
		echo $this->connection->error;
		
		$stmt->bind_result($id, $interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->id = $id;
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		
		return $result;
	}
		
	
	
	
	
}
?>