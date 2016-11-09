<?php
class Helper {
	
	private $connection;
	//k�ivitab siia kui on =new User(see j�uab siia)
	function __construct($mysqli){
		
		$this->connection = $mysqli;
	}
	
	
	
	function cleanInput($input) {
		
		// input = "  romil  ";
		$input = trim($input);
		// input = "romil";
		
		// v�tab v�lja \
		$input = stripslashes($input);
		
		// html asendab, nt "<" saab "&lt;"
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
	
}	
?>