<?

	header("Content-type: text/html; charset=utf-8");
	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
	ini_set("display_errors", "on");
	ini_set("display_startup_errors", "on");
	ini_set('max_execution_time', 0);

	mb_internal_encoding("UTF-8");
	
	$serverSQL = 'zdorov.local.mySQL.Server'; //'5.167.96.63';

	$mysqli_ssl = mysqli_init();
	$mysqli_ssl->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
	$mysqli_ssl->ssl_set(
					__DIR__.'/../shared/certs/client-key.pem',
					__DIR__.'/../shared/certs/client-cert.pem',
					__DIR__.'/../shared/certs/ca.pem',
					NULL,
					NULL);
	
	$mysqli_ssl->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
	$result_connect = $mysqli_ssl->real_connect($serverSQL, 'landing', '123', 'integration_betapost', null, null, MYSQLI_CLIENT_SSL);
	$mysqli_ssl->set_charset("utf8");
	
	$query_str = " SELECT * FROM `pre_shipping_row_order` ";
	$query_result = $mysqli_ssl->query($query_str);
	var_dump($query_result);
	
/*
		var_dump($itemName);
		echo "<br />";
		var_dump(mb_strtolower('крем'));
		echo "<br />";
*/
	/*
	$query_str = " SELECT * FROM `pre_shipping_row_order_count` ";
	$query_result_count = $mysqli_ssl->query($query_str);
	
	$shipping_order_count = array ();
	if ($query_result_count)
		$shipping_order_count = $query_result_count->fetch_all(MYSQLI_ASSOC);
	var_dump($shipping_order_count);
	*/
	
	
	
	
	$prev_shipping_order_id = '';
	$ordrow_id = 1;
	
	//идем по одному заказу, считываем данные по содержимому Item
	
	if ($query_result)
	while ($row = $query_result->fetch_assoc()) {
		/*
		foreach ($shipping_order_count as $shipping_order_count_elem) {
			if ($shipping_order_count_elem['shipping_order_order_id'] == $row['shipping_order_order_id']) {
				$count_order_items_id = $shipping_order_count_elem['count_order_items_id'];
				break;
			}
		}
		*/
		
		//получаем order_totalSumm
		//получаем кол-во банок с ненулевой ценой
		//получаем стоимость доставки (т.н. другие расходы)
		//рассчитываем стоимость 1 банки
		
		
		
		if ($prev_shipping_order_id != $row['shipping_order_id']) {
			
			$ordrow_id = 1;
			$good_id = getGood_id('Флаер');
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0') ";
			//$query_result_insert = $mysqli_ssl->query($query_str);
			
			//$ordrow_id += 1;

			$good_id = getGood_id('Флаер 3');
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0') ";
			//$query_result_insert = $mysqli_ssl->query($query_str);
			
			//$ordrow_id += 1;
			
			$prev_shipping_order_id = $row['shipping_order_id'];
		}

		
		for ($i = 1; $i <= $row['order_items_quantity']; $i++) {
			$good_id = getGood_id($row['order_items_offer_name']);
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '".$row['order_items_initialPrice']."') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;
		}
		
	}
	
	
	
	
	
	
	function getGood_id($itemName) {
		$result = '';
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('крем')) !== false ) {
			$result = '001';
		}
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('Купон')) !== false ) {
			$result = '002';
		}
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('Флаер 3')) !== false ) {
			$result = '003';
		} else
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('Флаер')) !== false ) {
			$result = '005';
		}
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('доставка')) !== false ) {
			$result = '004';
		}
		return $result;
	}
	
	
	$mysqli_ssl->close();
	
?>