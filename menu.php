<?php
	/**
		Menu Inclusion
		By DarkCoderSc
	*/
	
	include('inc/sessioncontrol.inc.php'); // test if user is logged
?>

<br/>
	<div id="menu">
	<div id="navigation">
 		<ul class="menuUL">
    	<li><a href="index.php?page=users" class=""><span class="usersico">Users list</span></a></li>
    	<li><a href="index.php?page=upl" class=""><span class="upico">Uploads</span></a></li>
     	<li><a href="index.php?page=set" class=""><span class="setico">Settings</span></a></li>
     	<li><a href="index.php?page=cmds" class=""><span class="promptico">Commands</span></a></li>
     	<li><a href="index.php?page=about" class=""><span class="aboutico">About</span></a></li>
     	<li><a href="#" onClick="logoff();" class=""><span class="shutico">Logoff</span></a></li>
 		</ul>
 		<div class="clear"></div>
  </div>
</div>
<br/>