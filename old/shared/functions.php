<?php
	
	/*
	 *  Фильтруем ввод $input = $_POST или $_GET, $var - имя переменной
	 */
	function getInput($input, $var) {
		$result ='';
		if (isset($input[$var]))
			$result = $input[$var];
		
		$result = stripslashes($result);
		$result = htmlspecialchars($result);
		$result = trim($result);
		
		return $result;
	}
	
