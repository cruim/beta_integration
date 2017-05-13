<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Забираем статусы из беты

header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
ini_set("display_errors", "on");
ini_set("display_startup_errors", "on");
ini_set('max_execution_time', 0);

//mb_internal_encoding("UTF-8");

$serverSQL = 'zdorov.local.mySQL.Server';//'5.167.96.63'; //

require_once "shared/dbconnect.php";
$mysqli_ssl = new mysqli_ssl;
$mysqli_ssl->__connect();

require_once "shared/shared_lib.php";

//считываем список кабинетов, и пароли, в которых есть товары на доставке
$query_str = " SELECT `accounts`.accounts_lk, `accounts`.accounts_pass FROM `crm_betapost_on_way`
INNER JOIN `shipping_order` ON crm_betapost_on_way.order_id = `shipping_order`.order_id
INNER JOIN `shipping_doc` ON `shipping_order`.shipping_doc_id = `shipping_doc`.shipping_doc_id
INNER JOIN `accounts` ON `shipping_doc`.accounts_lk = `accounts`.accounts_lk
WHERE `shipping_doc`.accounts_lk <> 201
GROUP BY `accounts`.accounts_lk ";
$query_result_lk = $mysqli_ssl->query($query_str);

$query_str = " TRUNCATE tracking ";
$query_result_truncate = $mysqli_ssl->real_query($query_str);

//идем по кабинетам
WHILE ($row_lk = $query_result_lk->fetch_assoc()) {
    var_dump($row_lk);
    
    $accounts_lk = $row_lk['accounts_lk'];
    $accounts_pass = $row_lk['accounts_pass'];
            
    $query_str = " SELECT `shipping_order`.shipping_order_order_id   FROM crm_betapost_on_way
    INNER JOIN `shipping_order` ON crm_betapost_on_way.order_id = `shipping_order`.order_id
    INNER JOIN `shipping_doc` ON `shipping_order`.shipping_doc_id = `shipping_doc`.shipping_doc_id
    WHERE `shipping_doc`.accounts_lk = " . $row_lk['accounts_lk'] . "
    AND ordrow_state = 3 ";
    $query_result = $mysqli_ssl->query($query_str);
    
    
    WHILE ($row = $query_result->fetch_assoc()) {
        var_dump($row);
        $xml = request_xml_550($row['shipping_order_order_id'], $accounts_lk, $accounts_pass);
        $res = doRequest($xml, $accounts_lk);
        /*
        $res = '<response state="0">
        <parcel order_id="357348-357348A_128" delivery_type="1" state_code="0" state="Заказ не найден или еще не отгружен"/>
        </response>';
        */
        /*
        echo "<pre>";
        echo $xml;
        echo "</pre>";

        
        echo "<pre>";
        echo $res;
        echo "</pre>";
        */
        $attr = get_attribytes_550($res);
        //var_dump($attr);

        //соответствие полей атрибутов операции и полей в базе данных
        $const_fields = array(
            'order_id'      => 'shipping_order_order_id', 
            'delivery_type' => 'delivery_type', 
            'date_time'     => 'date_time',
            'state_code'    => 'state_code', 
            'state'         => 'state',
            'barcode'       => 'barcode'
            );
        
        //составляем массив полей, которые писать в базу
        $fields = array();
        foreach ($attr as $key => $value) {
            $fields[] = $const_fields[$key];
        }
        
        $glueFields = glueFields($fields);
        $glueValues = glueValues($attr);
        //пишем в трекинг
        $query_str = " INSERT INTO tracking (" . $glueFields . ")
        VALUES (" . $glueValues ." ) ";
        echo "<pre>";
        var_dump($query_str);
        echo "</pre>";
        $query_result_insert = $mysqli_ssl->real_query($query_str);

        //пишем в полный трекинг 
        //1. проверяем есть ли уже такое событие по № заказа, дате/времени события, коду операции
        
        if (isset($attr['date_time']))
            $date_time_find = ' = ' . quoteValue($attr['date_time']);
        else
            $date_time_find = ' is NULL ';
        
        $query_str = " SELECT * FROM tracking_all 
        WHERE `shipping_order_order_id` = " . quoteValue($attr['order_id']) . " AND `date_time` " . $date_time_find . " AND `state_code` = " . quoteValue($attr['state_code']) ;
        $query_result_count = $mysqli_ssl->query($query_str);
        var_dump($query_str);
        //var_dump($query_result_count);
        
        if ($query_result_count->num_rows == 0) {
            echo "Новый статус < /br>";
            $query_str = " INSERT INTO tracking_all (" . $glueFields . ")
            VALUES (" . $glueValues ." ) ";
            $query_result_insert = $mysqli_ssl->real_query($query_str);
            //var_dump($query_str);
            //var_dump($query_result_insert);
        } else {
            echo "Повтор <br />";
        }
        
        
    }
    
    
}

