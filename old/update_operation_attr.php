<?php

//Обновляем атрибуты операции в таблицу shipping_order

header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
ini_set("display_errors", "on");
ini_set("display_startup_errors", "on");
ini_set('max_execution_time', 0);

//mb_internal_encoding("UTF-8");

require_once "shared/dbconnect.php";
$mysqli_ssl = new mysqli_ssl;
$mysqli_ssl->__connect();

require_once "shared/shared_lib.php";

//считываем список кабинетов, и пароли, в которых атрибут операции не проставлен
$query_str = "   SELECT `accounts`.`accounts_lk`, `accounts`.`accounts_pass` FROM `shipping_order` 
 INNER JOIN `shipping_doc` ON `shipping_order`.shipping_doc_id = `shipping_order`.`shipping_doc_id`
 INNER JOIN `accounts` ON `accounts`.`accounts_lk` = `shipping_doc`.`accounts_lk`
 WHERE shipping_order_shipped = 1 AND (ordrow_state is null or (ordrow_state <> 3 AND ordrow_state <> 100)) 
 AND `shipping_doc`.accounts_lk <> 201
 GROUP BY `shipping_doc`.accounts_lk ";

$query_result_lk = $mysqli_ssl->query($query_str);

WHILE ($row_lk = $query_result_lk->fetch_assoc()) {

    echo "Забираем статусы у " . $row_lk['accounts_lk'] . " кабнета";
    echo "<br />";
    echo "<br />";
    
    //$query_str = " SELECT * FROM `shipping_order` WHERE shipping_order_shipped = 1 AND (ordrow_state is null or ordrow_state <> 3) ";
    $query_str = "SELECT `shipping_order`.* FROM `shipping_order` 
    INNER JOIN `shipping_doc` ON
    `shipping_order`.shipping_doc_id = `shipping_doc`.shipping_doc_id
    WHERE shipping_order_shipped = 1 AND (ordrow_state is null or (ordrow_state <>  AND ordrow_state <> 100))
    AND `shipping_doc`.`accounts_lk` = '". $row_lk['accounts_lk'] ."' ";
    $query_result = $mysqli_ssl->query($query_str);

    if ($query_result)
    WHILE ($row = $query_result->fetch_assoc()) {
		
        $shipping_order_order_id = $row['shipping_order_order_id'];
        
        if ($shipping_order_order_id) {
			
            $request_xml = doRequest(request_xml_152($shipping_order_order_id, $row_lk['accounts_lk'], $row_lk['accounts_pass']), $row_lk['accounts_lk']);

            $attr = get_attribytes_152($request_xml);
            if (count($attr) > 0) {

                    $attr_set = '';
                    foreach($attr as $key => $value) {
                        if (strlen($attr_set) > 0)
                            $attr_set = $attr_set.", ";
                        $attr_set = $attr_set.$key." = '".$value."'";
                    }

                    $query_str = " UPDATE `shipping_order` SET ".$attr_set.
                    " WHERE shipping_order_order_id = '".$shipping_order_order_id."'";
                    $query_result_update = $mysqli_ssl->query($query_str);
                    var_dump($query_str);
                    echo "<br />";
                    
            }
        }
    }

}

