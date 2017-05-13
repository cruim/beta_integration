<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Считываем инфу по документам "Оплата от клиентов"

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

//считываем список кабинетов, и пароли
$query_str = " SELECT `performer_doc`.`performer_doc_id`, `performer_doc`.`idoc_id`, `accounts`.`accounts_lk`,  `accounts`.`accounts_pass`
FROM `performer_doc` INNER JOIN `accounts` ON `performer_doc`.`accounts_lk` = `accounts`.`accounts_lk`
WHERE doc_type = 8 ";
$query_result_doc = $mysqli_ssl->query($query_str);



WHILE ($row = $query_result_doc->fetch_assoc()) {
    echo "1";
    $request = request_xml_105($row['idoc_id'], $row['accounts_lk'], $row['accounts_pass']);
    //var_dump( htmlentities($request) );
    $request_xml = doRequest($request, $row['accounts_lk']);

    $attr = get_attributes_105($request_xml);

    $query_str = " TRUNCATE `performer_doc_detail_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);

    $query_str = " TRUNCATE `performer_order_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);

    //$table_type - doc, parcel
    foreach ($attr as $table_type => $table_content) {
        if ($table_type == 'doc') {
            
            $table_content['performer_doc_id'] = $row['performer_doc_id'];
            $glueFields = glueFields(array_keys($table_content));
            $glueValues = glueValues(array_values($table_content));
            
            $query_str = " INSERT INTO `performer_doc_detail_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
            //var_dump($query_str);
            $query_result = $mysqli_ssl->real_query($query_str);
        }
        
        if ($table_type == 'parcel') {
            foreach ($table_content as $performer_order) {
                
                $performer_order['performer_doc_id'] = $row['performer_doc_id'];
                $glueFields = glueFields(array_keys($performer_order));
                $glueValues = glueValues(array_values($performer_order));
            
                $query_str = " INSERT INTO `performer_order_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
                //var_dump($query_str);
                $query_result = $mysqli_ssl->real_query($query_str);
            }
        }
    }
    
    $query_str = " CALL `integration_betapost`.`update_performer_doc_detail`() ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    $query_str = " CALL `integration_betapost`.`update_performer_order`() ";
    $query_result = $mysqli_ssl->real_query($query_str);


}