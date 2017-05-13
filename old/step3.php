<?php

	header("Content-type: text/html; charset=utf-8");
	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
	ini_set("display_errors", "on");
	ini_set("display_startup_errors", "on");
	ini_set('max_execution_time', 0);

	//mb_internal_encoding("UTF-8");
	
	$serverSQL = 'zdorov.local.mySQL.Server';//'5.167.96.63'; //

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
	
	$query_str = " CALL `integration_betapost`.`fill_shipping_doc`() ";
	$query_result = $mysqli_ssl->query($query_str);
	
	$query_str = " CALL `integration_betapost`.`fill_shipping_order`() ";
	$query_result = $mysqli_ssl->query($query_str);

	$query_str = " SELECT * FROM `shipping_doc` WHERE shipping_doc_shipped = 0 ";
	$query_result = $mysqli_ssl->query($query_str);
	
	$shipping_doc_zdoc_id = '';
	$shipping_doc_id = '';
	if ($query_result) {
		$row = $query_result->fetch_assoc();
		$shipping_doc_zdoc_id = $row['shipping_doc_zdoc_id'];
		$shipping_doc_id = $row['shipping_doc_id'];
	}
	
	$query_str = " SELECT count(shipping_order_id) FROM integration_betapost.shipping_order WHERE shipping_doc_id = ".$shipping_doc_id;
	$query_result = $mysqli_ssl->query($query_str);
	$shipping_order_count = 0;
	if ($query_result) {
		$row = $query_result->fetch_array();
		$shipping_order_count = $row[0];
	}
	
	$mysqli_ssl->close();

?>
<html>
<head>
	<title>Создание документа</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
	
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>


</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p>Документ на отгрузку создан. Номер документа: <?php echo $shipping_doc_zdoc_id ?></p>
			<p>Количество заказов: <?php echo $shipping_order_count ?></p>
			<a href="step4.php">
			<button type="button" class="btn btn-default">Далее</button>
			</a>
		</div>
	</div>
</div>
	


</body>

</html>