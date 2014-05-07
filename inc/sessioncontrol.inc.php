<?php
	/**
		This include will simply check if the user is logged or not
		/!\ To include in all files
	*/
	if(!isset($_SESSION['logged'])){
		$_SESSION['logged'] = "false"; // Set default session if not exists
	}
	
	if($_SESSION['logged'] == "false"){
		exit();
	}
?>