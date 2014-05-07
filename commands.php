<?php
	/**
		Have commands help
		By DarkCoderSc
	*/
	
	include('inc/sessioncontrol.inc.php'); // test if user is logged
	
	echo "<h1 class=\"promptico\">Command list</h1>";

	/**
		Connect to database
	*/
	$sock = getDBSock(); // get new database socket

	/**
		Submit query
	*/
	$sql = "SELECT * FROM vn_cmds";
	$result = mysql_query($sql,$sock) or die(mysql_error());
  if (!$result) {
		die('SELECT error : '.mysql_error()); // Display sql error
		exit; // Don't go to far if it fails
	}
	
	/**
		Iterate in database
	*/
	while($data = mysql_fetch_array($result)) {
		echo "<div class=\"divcmds\">";
		echo "<div id=\"upage\">".$data['title']."<span style=\"float:right; margin-right:5px;\">".$data['type']."</span></div>";
		echo "<div style=\"margin:5px;\">".nl2br($data['desc'])."</div>";
		echo "</div>";
		echo "<br/>";
  }
	mysql_close($sock); // we don't forget to close our new socket
	
	echo "<br/>";
?>

