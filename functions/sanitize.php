<?php
	function escape($string){
		return htmlentities($string, ENT_QUOTES, 'TIS620');
	}

?>