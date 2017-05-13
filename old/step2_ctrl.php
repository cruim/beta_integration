<?php

	header("Content-Type: text/html; charset=utf-8");
	error_reporting(E_ALL);
	ini_set("display_errors", "on");
	ini_set("display_startup_errors", "on");
	ini_set('max_execution_time', 0);

	require_once 'shared/functions.php';
	
	//var_dump($_POST);
	$cmd = getInput($_POST, 'cmd');
	
	//комманда показать заказы с ошибками
	if ($cmd == 'show_not_processed') {
		
		$serverSQL = 'zdorov.local.mySQL.Server'; //'5.167.96.63'; //

		$mysqli_ssl = mysqli_init();
		$mysqli_ssl->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, TRUE);
		$mysqli_ssl->ssl_set(
					__DIR__.'/../shared/certs/client-key.pem',
					__DIR__.'/../shared/certs/client-cert.pem',
					__DIR__.'/../shared/certs/ca.pem',
					NULL,
					NULL);
	
		$mysqli_ssl->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
		$result_connect = $mysqli_ssl->real_connect($serverSQL, 'landing', '123', 'integration_betapost', NULL, NULL, MYSQLI_CLIENT_SSL);
		$mysqli_ssl->set_charset("utf8");
		
		$query_str = " SELECT * FROM `not_processed` ORDER BY import_order_order_number ";
		$query_result = $mysqli_ssl->query($query_str);
		
		$result = array (	'data'	=> array()	);
		if ($query_result)
		while ($row = $query_result->fetch_assoc()) {
			$result['data'][] = $row;
		}
		$mysqli_ssl->close();
		
		$result = json_encode($result);
		echo $result;
	}

