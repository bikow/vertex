<?php

	/**
		Settings feed by database
		by DarkCoderSc
	*/
	
	$sock = getDBSock(); // getting new socket
	$sql = "SELECT * FROM vn_settings";
	$result = mysql_query($sql, $sock) or die(mysql_error());
	
	/**
		Getting settings as array instead of row, cuz more easy when using *
	*/
	$data = mysql_fetch_array($result);
	
	/**
		Getting our global vars now
	*/
	$GLOBALS["usersperpage"] 	= $data['usersperpage']; // Number of users per page
	$GLOBALS["userswidth"] 		= $data['userswidth'];   // Users table height
	$GLOBALS["usersdead"] 		= $data['usersdead'];    // Users is dead after
	$GLOBALS["showdead"] 			= $data['showdead'];     // show dead users
	$GLOBALS["showofflines"]  = $data['showofflines']; // Show offline users
 	$GLOBALS["username"]		  = $data['username'];     // Current username
	$GLOBALS["usegeoip"] 	    = $data['usegeoip'];     // Using geo ip

	mysql_close($sock); // Closing
	
?>