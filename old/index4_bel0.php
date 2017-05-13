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
	$result_connect = $mysqli_ssl->real_connect($serverSQL, 'landing', '123', 'integration_betapost', NULL, NULL, MYSQLI_CLIENT_SSL);
	$mysqli_ssl->set_charset("utf8");
	
	$query_str = " 
	SELECT 
        `integration_betapost`.`shipping_order`.`shipping_order_id` AS `shipping_order_id`,
        `integration_betapost`.`shipping_order`.`shipping_order_order_id` AS `shipping_order_order_id`,
		`integration_betapost`.`shipping_order`.`order_id` as `order_id`,
		`varicrm`.`order`.`order_totalSumm` as `order_totalSumm`
    FROM
        `integration_betapost`.`shipping_doc`
        INNER JOIN `integration_betapost`.`shipping_order` ON `integration_betapost`.`shipping_order`.`shipping_doc_id` = `integration_betapost`.`shipping_doc`.`shipping_doc_id`
		INNER JOIN `varicrm`.`order` ON `integration_betapost`.`shipping_order`.`order_id` = `varicrm`.`order`.`order_id`
    WHERE
        `integration_betapost`.`shipping_doc`.`shipping_doc_shipped` = 0
            AND `integration_betapost`.`shipping_order`.`shipping_order_shipped` = 0
	 ";
	 
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
	
	
		//получаем order_totalSumm
		//получаем кол-во банок с ненулевой ценой
		//получаем стоимость доставки (т.н. другие расходы)
		//рассчитываем стоимость 1 банки
	
	
	
	//идем по одному заказу, считываем данные по содержимому Item
	
	$coeff1 = 330.30303030303030;

	//$coeff2 = 276.3476785;
	//$coeff2 = 277.375583182164;
	$coeff2 = 280.667089538415;

	
	
	if ($query_result)
	while ($row = $query_result->fetch_assoc()) {
		var_dump($row['order_id']);
		$itemsDetail = getItemsDetail($mysqli_ssl, $row['order_id']);

		$totalSumm = $row['order_totalSumm'];
		$totalSumm_bel = $totalSumm * $coeff1;
		$deliveryCost = $itemsDetail['deliveryCost'];
		$deliveryCost_bel = $deliveryCost * $coeff1;
		
		//стоимость заказа
		$orderCost_bel = $totalSumm_bel - $deliveryCost_bel;
		//стоимость заказа минус доставка и делить на кол-во банок с ненулевой ценой
		$creamCost_bel = 0;
		if ($itemsDetail['creamCount'] > 0)
		$creamCost_bel = $orderCost_bel / $itemsDetail['creamCount'];

		$deliveryCost_ru = $deliveryCost_bel / $coeff2;
		$creamCost_ru = $creamCost_bel / $coeff2;
		
		//Тут можно узнать, что заказ с нулевой ценой товара и что далее с ним делать?
		
		$ordrow_id = 1;


			$good_id = getGood_id('Флаер 3'); //003
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;

/*
			$good_id = getGood_id('Флаер'); //005
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;
*/

			$good_id = getGood_id('Декларация'); //006
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;

		foreach ($itemsDetail['items'] as $item) {
			
			for ($i = 1; $i <= $item['order_items_quantity']; $i++) {
			
				$good_id = getGood_id($item['order_items_offer_name']);
				
				//наложенный платеж
				$clnt_price = $item['order_items_totalPrice'] * $coeff1 / $coeff2;

				//Если крем с ненулевой ценой, то его стоимость брать из расчетной
				if ($good_id == '009 ' AND $clnt_price > 0) {
					$clnt_price = $creamCost_ru;
				}

				//Если стоимость заказа ноль, то оценочная стоимость 990
				$itemCost = $clnt_price;
				if ($good_id == '009 ' AND $totalSumm == 0)
					$itemCost = 990 * $coeff1 / $coeff2;
				
				//оценочная стоимость
				$itemCost = round($itemCost, 2);
				//наложенный платеж
				$clnt_price = round($clnt_price, 2);
				
				$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
				$query_str = 
				" INSERT INTO `shipping_order_row` ".
				" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`, `shipping_order_row_coeff1`, `shipping_order_row_coeff2`) ".
				" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '".$itemCost."', '".$clnt_price."', '".$coeff1."', '".$coeff2."') ";
				$query_result_insert = $mysqli_ssl->query($query_str);
				var_dump($query_str);
				echo "<br />";
				echo "<br />";
				$ordrow_id++;
			}
		}
		
		
	}
	
	
	$mysqli_ssl->close();	
	
	
	
	function getGood_id($itemName) {
		$result = '';
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('крем')) !== false ) {
			$result = '009 ';
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
		/* Доставка как товар
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('доставка')) !== false ) {
			$result = '004';
		}
		*/
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('доставка')) !== false ) {
			$result = '008';
		}
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('Декларация')) !== false ) {
			$result = '006';
		}
		
		
		return $result;
	}
	
	

	
	function getItemsDetail($mysqli_ssl, $order_id) {
		
		$query_str_items = " 
		SELECT   
		order_items_initialPrice - order_items_discount - ((order_items_initialPrice * order_items_discountPercent) / 100) as order_items_totalPrice,
        `varicrm`.`order_items`.`order_items_quantity` AS `order_items_quantity`,
        `varicrm`.`order_items_offer`.`order_items_offer_name` AS `order_items_offer_name`
		FROM
        `varicrm`.`order` 
        JOIN `varicrm`.`order_items` ON `varicrm`.`order`.`order_id` = `varicrm`.`order_items`.`order_id` 
        JOIN `varicrm`.`order_items_offer` ON `varicrm`.`order_items_offer`.`order_items_id` = `varicrm`.`order_items`.`order_items_id`
		WHERE
		`varicrm`.`order`.`order_id` = '".$order_id."'
		AND (`varicrm`.`order_items`.`order_items_isCanceled` = 0)
		ORDER BY `varicrm`.`order_items`.`order_items_quantity` DESC , `varicrm`.`order_items_offer`.`order_items_offer_name` DESC
		";
		$query_result_items = $mysqli_ssl->query($query_str_items);
		
		$deliveryCost = 0;
		$creamCount = 0;
		
		$items = array ();
		if ($query_result_items)
			$items = $query_result_items->fetch_all(MYSQLI_ASSOC);
		
		//while ($row = $query_result_items->fetch_assoc()) {
		
		foreach ($items as $row) {
			$itemName = $row['order_items_offer_name'];
			//если доставка
			if (mb_strpos(mb_strtolower($itemName), mb_strtolower('доставка')) !== false ) {
				$deliveryCost = $row['order_items_totalPrice'];
			}
			//если крем, считаем кол-во итемов с ненулевой ценой
			if (mb_strpos(mb_strtolower($itemName), mb_strtolower('крем')) !== false ) {
				if ($row['order_items_totalPrice'] > 0)
					$creamCount = $creamCount + $row['order_items_quantity'];
			}
			
		}
		
		$result = array (
			'deliveryCost'	=>	$deliveryCost,
			'creamCount'	=>	$creamCount,
			'items'			=>	$items
		);
		
		return $result;
	}
	
?>