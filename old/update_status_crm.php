<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Проставляем статусы в retailcrm согласно таблице разрешенных переходов статусов

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


$query_str = " SELECT t1.order_id, t1.order_site, t5.mapping_order_status_from, t5.mapping_order_status_to, t3.date_time, 
t1.order_number, t1.order_status_name, t2.shipping_order_order_id, t3.state, t1.order_customFields_nomer_otpravleniya
FROM crm_betapost_on_way t1
INNER JOIN shipping_order t2 ON t1.order_id = t2.order_id
INNER JOIN tracking t3 ON t3.shipping_order_order_id = t2.shipping_order_order_id
INNER JOIN mapping_order_status_state_code t4 ON t3.state_code = t4.state_code
INNER JOIN mapping_order_status t5 ON t1.order_status_code = t5.mapping_order_status_from AND t4.order_status_code = t5.mapping_order_status_to
";
$query_result = $mysqli_ssl->query($query_str);

require_once "shared/csvClient.php";

if ($query_result) {

    // UTC+3 зимнее время без перехода на зимнее время
    if (function_exists('date_default_timezone_set'))
    date_default_timezone_set('Etc/GMT-3');

    $date = date('Y-m-d_H.i.s');
    //$csv_post->saveCsv('log/log_'.$date.'.csv');
    //$csv_query->saveCsv('log/log_query_'.$date.'.csv');
    
    //пишем в csv результаты засылки в RetailCrm
    $csv_post = new csvClient('log/log_'.$date.'.csv');
    //пишем в csv результаты запроса
    $csv_query = new csvClient('log/log_query_'.$date.'.csv');

    require_once "../retailcrm/vendor/autoload.php";

    $retail_client = new RetailCrm\ApiClient(
            'https://varifort.retailcrm.ru',
            'hEZN2dXTGppGCj4KzHM8gjZzUisy4PIx'
    );
    
    while ($row = $query_result->fetch_assoc()) {
		
        $csv_query->addHeader(array_keys($row));
        $csv_query->addRow($row);
        
        var_dump($row);
        echo "<br />";
        $neworder = array ();
        $neworder["id"] = $row['order_id'];
        $neworder["status"] = $row['mapping_order_status_to'];
        $neworder["customFields"]["api_mark"] = 'from_BetaPost_API';

        //Если дата/время не пустое, тогда пишем в поля retailcrm
        if ($row['date_time']) {
            $date_time = strtotime($row['date_time']);
            $date_obj = new DateTime();
            $date_obj->setTimestamp($date_time);
        
            switch ($row['mapping_order_status_to']) {
                case 'delivered':
                    $neworder["customFields"]["date_of_delivery"] = $date_obj->format("Y-m-d");
                    break;
                case 'parcel-on-a-place':
                    $neworder["customFields"]["date_of_arrival"] = $date_obj->format("Y-m-d");
                    break;
            }
        }
        var_dump($neworder);

        $result = $retail_client->ordersEdit( $neworder, 'id', $row["order_site"] );

        //$response = $result->success;
        //var_dump($result);
        echo "<br />";

        $order_csv = array();

        //переводим $neworder в одномерный
        array_walk_recursive($neworder, function($value, $key) use (&$order_csv){
            $order_csv = array_merge($order_csv, array($key => $value)); // тут возвращаете как вам хочется
        });

        $order_csv = array_merge($order_csv, array('statusCode' => $result->getStatusCode()));
        $order_csv = array_merge($order_csv, array('success' => $result->__get('success')) );
        $order_csv = array_merge($order_csv, array('set_order_id' => $result->__get('id')) );
        var_dump($order_csv);

        $csv_post->addHeader(array_keys($order_csv));
        $csv_post->addRow($order_csv);


    }
    
    unset($retail_client);
    
}
