<?php

	header("Content-type: text/html; charset=utf-8");
	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
	ini_set("display_errors", "on");
	ini_set("display_startup_errors", "on");
	ini_set('max_execution_time', 0);

	mb_internal_encoding("UTF-8");
	
require_once "shared/dbconnect.php";
$mysqli_ssl = new mysqli_ssl;
$mysqli_ssl->__connect();
	
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
	var_dump($mysqli_ssl->error_list);
	

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
	
	if ($query_result)
	while ($row = $query_result->fetch_assoc()) {
		var_dump($row['order_id']);
		$itemsDetail = getItemsDetail($mysqli_ssl, $row['order_id']);

		//стоимость заказа
		$orderCost = $row['order_totalSumm'] - $itemsDetail['deliveryCost'];
		//стоимость заказа минус доставка и делить на кол-во банок с ненулевой ценой
		$creamCost = 0;
		if ($itemsDetail['creamCount'] > 0)
		$creamCost = $orderCost / $itemsDetail['creamCount'];

		//Тут можно узнать, что заказ с нулевой ценой товара и что далее с ним делать?
                
                
                //есть ли в перечне товаров простатит и геморрой
		$pg = FALSE;
                foreach ($itemsDetail['items'] as $item) {
                    if (getGood_id($item['order_items_offer_externalId'])=='023') {
                        $pg = TRUE;
                    }
                }
                
                
		$ordrow_id = 1;

                    //если в перечне товаров крем от простатита или геморроя, вкладываем другие флаеры
                    if ($pg) {
			$good_id = getGood_id('Флаер с тубой'); //025
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;

			$good_id = getGood_id('Свидетельство по интимному крему (туба)'); //026
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;
                        
                    } else {
			$good_id = getGood_id('Флаер 3 варианта банок Здоров'); //003
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;

			$good_id = getGood_id('Декларация'); //006
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;

                    }
                    
			$good_id = getGood_id('Флаер выгодная покупка'); //005
			$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
			$query_str = 
			" INSERT INTO `shipping_order_row` ".
			" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
			" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '0', '0') ";
			$query_result_insert = $mysqli_ssl->query($query_str);
			
			$ordrow_id += 1;


		foreach ($itemsDetail['items'] as $item) {
			
			for ($i = 1; $i <= $item['order_items_quantity']; $i++) {
			
				$good_id = getGood_id($item['order_items_offer_externalId']);
				
				//наложенный платеж
				$clnt_price = $item['order_items_totalPrice'];
				//Если крем с ненулевой ценой, то его стоимость брать из расчетной
				if (isCream($item['order_items_offer_externalId']) AND $clnt_price > 0) {
					$clnt_price = $creamCost;
				}
				
				
				//Если стоимость заказа ноль, то оценочная стоимость 990
				$itemCost = $clnt_price;
				if (isCream($item['order_items_offer_externalId'])  AND $orderCost == 0)
					$itemCost = 1;
				
				if (isDelivery($item['order_items_offer_externalId'])) {
					$itemCost = 0;
				}
				
				$clnt_price = round($clnt_price, 2);
				$itemCost = round($itemCost, 2);
                                
				$shipping_order_ordrow_id = $row['shipping_order_order_id'] . '/' . $good_id . '/' . $ordrow_id;
				$query_str = 
				" INSERT INTO `shipping_order_row` ".
				" (`shipping_order_id`, `shipping_order_ordrow_id`, `shipping_order_row_order_id`, `shipping_order_row_good_id`, `shipping_order_row_price`, `shipping_order_row_clnt_price`) ".
				" VALUES ('".$row['shipping_order_id']."', '".$shipping_order_ordrow_id."', '".$ordrow_id."', '".$good_id."', '".$itemCost."', '".$clnt_price."') ";
				$query_result_insert = $mysqli_ssl->query($query_str);
				var_dump($query_str);
				echo "<br />";
				echo "<br />";
				$ordrow_id++;
			}
		}
		
		
	}
	
	
	$mysqli_ssl->close();	
	
function isDelivery($itemExternalId) {
    $result = FALSE;
    
    switch ($itemExternalId) {
        case "delivery-002-1": //Доставка
            $result = TRUE;
            break;
    }
    return $result;
}
        
function isCream($itemExternalId) {
    $result = FALSE;
    
    switch ($itemExternalId) {
        case "cream-004-1": //Крем для Суставов
        case "cream-004-2": //Крем для Суставов в подарок
        case "cream-001-1":	//Крем от Варикоза
        case "cream-001-3":	//Крем от Варикоза в подарок
        case "cream-002-1":	//Крем от Геморроя
        case "cream-002-2":	//Крем от Геморроя в подарок
        case "cream-003-1": //Крем от Простатита
        case "cream-003-2": //Крем от Простатита в подарок
        case "cream-007-1": //Крем от Остеохрндроза не используется
        case "cream-007-2": //Крем от Остеохрндроза в подарок не используется
        case "cream-005-1": //Крем от псориаза
        case "cream-005-2": //Крем от псориаза в подарок
        case "cream-008-1": //Крем от Мастопатии
        case "cream-008-2": //Крем от Мастопатии в подарок
        case "cream-009-1": //Крем от Морщин
        case "cream-009-2": //Крем от Морщин в подарок
        case "cream-010-1": //Крем от грибка
        case "cream-010-2": //Крем от грибка в подарок
        case "cream-011-1": //Крем от целлюлита
        case "cream-011-2": //Крем от целлюлита в подарок
        case "cream-012-1": //Крем от Эректильной дисфункции
        case "cream-012-2": //Крем от Эректильной дисфункции в подарок

            $result = TRUE;
            break;
    }
    return $result;
}

function getGood_id($itemExternalId) {
    $result = '';

    switch ($itemExternalId) {

/*
        //для 267 кабинета
        // обычные крема			
        case "cream-002-1":	//Крем от Геморроя
        case "cream-002-2":	//Крем от Геморроя в подарок
        case "cream-003-1": //Крем от Простатита
        case "cream-003-2": //Крем от Простатита в подарок
        case "cream-007-1": //Крем от Остеохрндроза не используется
        case "cream-007-2": //Крем от Остеохрндроза в подарок не используется
        case "cream-004-1": //Крем для Суставов
        case "cream-004-2": //Крем для Суставов в подарок
        case "cream-001-1":	//Крем от Варикоза
        case "cream-001-3":	//Крем от Варикоза в подарок
            $result = '009 ';
            break;

*/

        //для 843 или 280 кабинета
        case "cream-004-1": //Крем для Суставов
        case "cream-004-2": //Крем для Суставов в подарок
        case "cream-007-1": //Крем от Остеохрндроза не используется
        case "cream-007-2": //Крем от Остеохрндроза в подарок не используется
            $result = '020';
            break;

        case "cream-001-1":	//Крем от Варикоза
        case "cream-001-3":	//Крем от Варикоза в подарок
            $result = '021';
            break;

        case "cream-012-1": //Крем от Эректильной дисфункции
        case "cream-012-2": //Крем от Эректильной дисфункции в подарок
            $result = '022';
            break;
/*
        // обычные крема			
        case "cream-002-1":	//Крем от Геморроя
        case "cream-002-2":	//Крем от Геморроя в подарок
        case "cream-003-1": //Крем от Простатита
        case "cream-003-2": //Крем от Простатита в подарок
            $result = '009';
            break;
*/
        //Крем интимный туба пг
        case "cream-002-1":	//Крем от Геморроя
        case "cream-002-2":	//Крем от Геморроя в подарок
        case "cream-003-1": //Крем от Простатита
        case "cream-003-2": //Крем от Простатита в подарок
            $result = '023';
            break;
        
        // Псориаз крема
        case "cream-005-1": //Крем от псориаза
        case "cream-005-2": //Крем от псориаза в подарок
            $result = '019';
            break;

        //015 мастопатия пластик
        case "cream-008-1": //Крем от Мастопатии
        case "cream-008-2": //Крем от Мастопатии в подарок
            $result = '015';
            break;

        case "cream-009-1": //Крем от Морщин
        case "cream-009-2": //Крем от Морщин в подарок
            $result = '014';
            break;


        case "cream-010-1": //Крем от грибка
        case "cream-010-2": //Крем от грибка в подарок
            $result = '016';
            break;

        case "cream-011-1": //Крем от целлюлита
        case "cream-011-2": //Крем от целлюлита в подарок
            $result = '017';
            break;

        case "delivery-002-1": //Доставка
            $result = '008';
            break;


        case "Купон":
            $result = '002';
            break;

        case "Флаер 3 варианта банок Здоров":
            $result = '003';
            break;

        case "Флаер выгодная покупка":
            $result = '005';
            break;

        case "Декларация":
            $result = '006';
            break;
        
        case "Флаер с тубой":
            $result = '025';
            break;
        
        case "Свидетельство по интимному крему (туба)":
            $result = '026';
            break;
        
    }
    return $result;
}

	function getGood_id_old($itemName) {
		$result = '';
		/*
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('крем')) !== false ) {
			$result = '001';
		}
		*/
		
		// обычные крема
		if	(
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от Варикоза')) !== false ) OR
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от Геморроя')) !== false ) OR
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем для Суставов')) !== false ) OR
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от Простатита')) !== false ) OR
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от Остеохрндроза')) !== false )
			)
		{
			$result = '009';
		}
		// Псориаз крема
		if 	(
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от псориаза')) !== false )
			)
		{
			$result = '019';
		}
		
		if 	(
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от мастопатии')) !== false )
			)
		{
			//011 мастопатия стекло
			//$result = '011';
			//015 мастопатия пластик
			$result = '015';
		}
/*
		if 	(
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от Остеохрндроза')) !== false )
			)
		{
			$result = '012';
		}
*/
		if 	(
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от Морщин')) !== false )
			)
		{
			$result = '014';
		}

		if 	(
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от грибка')) !== false )
			)
		{
			$result = '016';
		}

		if 	(
			(mb_strpos(mb_strtolower($itemName), mb_strtolower('Крем от целлюлита')) !== false )
			)
		{
			$result = '017';
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
		// доставка в 267 кабинете
		/*
		if (mb_strpos(mb_strtolower($itemName), mb_strtolower('доставка')) !== false ) {
			$result = '004';
		}
		*/
		
		//Доставка в 275 кабинете и 280
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
        `varicrm`.`order_items_offer`.`order_items_offer_name` AS `order_items_offer_name`,
		`varicrm`.`order_items_offer`.`order_items_offer_externalId` as `order_items_offer_externalId`
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
			/*
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
			*/
			
			$itemExternalId = $row['order_items_offer_externalId'];
			switch ($itemExternalId) {
			
			case "delivery-002-1":
				$deliveryCost = $row['order_items_totalPrice'];
				break;

			case "cream-001-1":	//Крем от Варикоза
			case "cream-002-1":	//Крем от Геморроя
			case "cream-003-1": //Крем от Простатита
			case "cream-004-1": //Крем для Суставов
			case "cream-005-1": //Крем от псориаза
			case "cream-007-1": //Крем от Остеохрндроза не используется
			case "cream-008-1": //Крем от Мастопатии
			case "cream-009-1": //Крем от Морщин
			case "cream-010-1": //Крем от грибка
			case "cream-011-1": //Крем от целлюлита
                        case "cream-012-1": //Крем от Эректильной дисфункции
				$creamCount = $creamCount + $row['order_items_quantity'];
				break;
			}
		}
		
		$result = array (
			'deliveryCost'	=>	$deliveryCost,
			'creamCount'	=>	$creamCount,
			'items'			=>	$items
		);
		
		return $result;
	}
	
