<?php

	/**
		  __     __        _            _   _ _____ _____
		  \ \   / /__ _ __| |_ _____  _| \ | | ____|_   _|
		   \ \ / / _ \ '__| __/ _ \ \/ /  \| |  _|   | |
		    \ V /  __/ |  | ||  __/>  <| |\  | |___  | |
		     \_/ \___|_|   \__\___/_/\_\_| \_|_____| |_|
		              (C++ / PHP based botnet)
		              
		          Coded by DarkCoderSc in few days
		          This project is free, it is forbidden
		          to copy past the code source of this panel.
		          If you dare use some code, don't forget to credits.
		          
		          DarkCoderSc@Unremote.org

	*/
	
	session_start(); // Init sessions
	
	/**
		If the session doesn't exist we turn it to false
	*/
	if(!isset($_SESSION['logged'])){
		$_SESSION['logged'] = "false"; // Set default session if not exists
	}
	
	/**
		Includes from /inc/ dir
	*/
	include('inc/connection.inc.php');
	include('inc/settings.inc.php');
	include('inc/tasksutils.inc.php');
	include('inc/functions.inc.php');
		
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>
       <title>VertexNet v1.2</title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
       <link rel="stylesheet" media="screen" type="text/css" title="style" href="css/style.css" />
       	
       <!-- Javascript library from DarkCoderSc so me :D -->
       <script  type="text/javascript" src="js/jsfunc.js"></script>
   </head>
   <body>
   	
   		<div id="header"></div>
   		
   		<?php
   		/**
   			If we are logged we can display the menu
   		*/
   		if($_SESSION['logged'] == "true"){
				include('menu.php'); // Include the menu so
	  	}
   			
	   	echo "<div class=\"maindiv\" style=\"opacity:0.8;\" >";
	   	
	   	/**
	   		Manage $_GET pages
	   	*/
	   	if($_SESSION['logged'] == "true"){
		   		//Basic including page	
		   		if(isset($_GET['page'])){
		   			$page = $_GET['page']; // get get page
		   			
		   			if($page == "users"){
		   				include('users.php');
		   			}else if($page == "cmds"){
		   				include('commands.php');
		   			}else if($page == "set"){
		   				include('settings.php');
		   			}else if($page == "about"){
		   				include('about.php');
		   			}else if($page == "datalist"){
		   				include('datalist.php');
		   			}else if($page == "upl"){
		   				include('upload.php');
		   			}else if($page == "logoff"){
		   				session_destroy(); // Kill the session
		   				include('login.php');
		   			}else{
		   				include('users.php');
		   			}	
		   		}else{
		   			include('users.php');	
		   		}
		   }else{
		   		include('login.php');	
		   }
				
			echo "</div>";
			include('footer.php');
			
			echo "<br/><br/><br/><br/><br/>"; // This is for the last banner
			
			?>
			
   	  <p class="tutInfo">If you liked this product you might love one of my other free software "<b>DarkComet-RAT</b>
   	  									 (<b>R</b>emote <b>a</b>dministration <b>t</b>ool)", Download it there : 
   	  									 <a href="http://darkcomet-rat.com/"><img style="vertical-align:middle;" src="imgs/getcomet.png"></img></a>
   	  </p> 
   
   </body>
</html>