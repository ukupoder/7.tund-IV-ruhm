<?php 

	require("../../config.php");
	session_start();
	
	$database = "if16_ukupode";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

?>