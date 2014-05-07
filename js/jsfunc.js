/***
	------------------
	This file is for all javascript control of the application.
	Coded by DarkCoderSc for VertexNet-Loader.
	------------------
*/


/**
	This crap will check who's need to do something and submit
  in the hidden text in the end of the page.
*/
function processSubmit(){
	var numb = document.getElementById("numid").value;
	var targets = ""; //Our target uid'z
	for(i=0; i<numb; i++){
		//If we check a checkbox then we wana send a cmd to him
		if(document.getElementById("check"+(i+1)).checked){
			targets += document.getElementById("uid"+(i+1)).value + "|"; //concat it
		}	
	}
	
	if(targets.length > 0){
 		targets = targets.substring(0,targets.length-1); //Remove last delimitaY
  	document.getElementById("content").value = targets;
  	document.actionform.submit(); //aaa We can submit
  	return true;
  }else{
  	alert("Please select minimum 1 user in the list !"); //Fag -_-"
  	return false;
  }
  
}

/**
	Assign a shortcut to the command textbox
*/
function processChange(object){
	document.getElementById('cmd').value = object.value;
}

/**
	Turn all checkboxes on or off
*/
function checkboxall(object){
	var myBools = false;
	var numb = document.getElementById("numid").value;
	if(object.checked) myBools = true; //If checked then myBalls = true
	for(i=0; i<numb; i++){
		document.getElementById("check"+(i+1)).checked = myBools; //check or uncheck	
	} 
	return true;		
}

/**
	Confirm function
*/
function Confirm(message) {
   if (confirm(message)) {
      return true;
   }else{
   		return false;		
   }
}

/**
	To log off
*/
function logoff(){
	if (Confirm("This action will unconnect you from the panel, are you sure ?")) 
		window.location = 'index.php?page=logoff';
	return true;
}