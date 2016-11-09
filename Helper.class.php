<?php
class Helper {
	
	private $connection;
	//käivitab siia kui on =new User(see jõuab siia)
	function __construct($mysqli){
		
		$this->connection = $mysqli;
	}
	
	
	
	function cleanInput($input) {
		
		// input = "  romil  ";
		$input = trim($input);
		// input = "romil";
		
		// võtab välja \
		$input = stripslashes($input);
		
		// html asendab, nt "<" saab "&lt;"
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
	
}	
?>