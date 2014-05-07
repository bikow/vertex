<?php 
	
	/*
		This shit is to loggin to panel
		passwd are secured by MD5 ofc
		by DarkCoderSc
	*/
	
	/**
		If a user attemp to login
	*/
	if(isset($_POST['login']) && isset($_POST['pwd'])){
		$sock = getDBSock(); // Get a new connection pool 
		
		/**
			Secure against SQL vuln injections
		*/
		$login = mysql_real_escape_string($_POST['login']);
		$pwd = mysql_real_escape_string($_POST['pwd']);
		$pwd = md5($pwd); //to md5 for comparison
		
		$sql = "SELECT username,passwd FROM vn_settings WHERE username = '$login' AND passwd = '$pwd'";
		$result = mysql_query($sql, $sock) or die(mysql_error());
		
		/**
			User check loop
		*/
		while($data = mysql_fetch_array($result)) {
			if(($data['username'] == $login) && ($data['passwd'] == $pwd)){
				$_SESSION['logged'] = "true"; // we are logged
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=index.php">';
			}
		}

		mysql_close($sock); // Close connection	  
	}
?>

<br/><br/>
<div id="logindiv">
	<div align="center">
		<br/>
		<img style="margin-top:5px;" src="imgs/lockicon.png"></img>
	</div><br/>
	<div style="width:250px; margin-left: auto; margin-right: auto; position: relative;">
		<form action="index.php" method="POST">
			<table>
				<tr>
					<td><label for="login">Username : </label></td><td><input id="login" name="login" type="text"></input></td>
				</tr>
				<tr>
					<td><label for="pwd">Password : </label></td><td><input id="pwd" name="pwd" type="password"></input></td>
				</tr>
			</table>
			<br/>
			<div align="center">
				<input type="submit" value="Login to panel"></input><input type="reset" value="Reset inputs"></input>
			</div>
		</form>
		<br/>
	</div>
</div>
<br/><br/>