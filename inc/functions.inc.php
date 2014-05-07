<?php

	function getLastPathSegment($url) {
        $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
        $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
        $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

        if (substr($path, -1) !== '/') {
            array_pop($pathTokens);
        }
        return end($pathTokens); // get the last segment
   }
   
	function selfURL() {
		$s = empty($_SERVER["HTTPS"]) ? ''
			: ($_SERVER["HTTPS"] == "on") ? "s"
			: "";
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
			: (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port."/".getLastPathSegment($_SERVER['REQUEST_URI']);
	}
	function strleft($s1, $s2) {
		return substr($s1, 0, strpos($s1, $s2));
	}
	
	function DeleteFile($filepath,$filename) {
	$success = FALSE;
	if (file_exists($filepath.$filename)&&$filename!=""&&$filename!="n/a") {
		unlink ($filepath.$filename);
		$success = TRUE;
	}
	return $success;	
  }
  
  //By DarkCoderSc
  function genHtmlErr($str){
  	echo "<br/>";
		echo "<div id=\"errmsg\">";
		echo "<p class=\"errico\"><b>Error :</b> $str </p>";
		echo "</div>";	
  }
  
  function genHtmlOk($str){
  	echo "<br/>";
		echo "<div id=\"okmsg\">";
		echo "<p class=\"okico\"><b>Success :</b> $str </p>";
		echo "</div>";	
  }

?>