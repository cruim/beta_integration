<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Считываем инфу по документам "Отгрузка клиентам"

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

//считываем список кабинетов, и пароли
$query_str = " SELECT `performer_doc`.`performer_doc_id`, `performer_doc`.`idoc_id`, `accounts`.`accounts_lk`,  `accounts`.`accounts_pass`
FROM `performer_doc` INNER JOIN `accounts` ON `performer_doc`.`accounts_lk` = `accounts`.`accounts_lk`
WHERE doc_type = 6 ";
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

    $query_str = " TRUNCATE `performer_f103_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);

    $query_str = " TRUNCATE `performer_order_row_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    $query_str = " TRUNCATE `performer_pack_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    //$table_type - doc, parcel, f103
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

        if ($table_type == 'f103') {
            foreach ($table_content as $performer_f103) {
                
                $performer_f103['performer_doc_id'] = $row['performer_doc_id'];
                $glueFields = glueFields(array_keys($performer_f103));
                $glueValues = glueValues(array_values($performer_f103));
            
                $query_str = " INSERT INTO `performer_f103_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
                //var_dump($query_str);
                $query_result = $mysqli_ssl->real_query($query_str);
            }
        }
    
        
        if ($table_type == 'pack') {
            foreach ($table_content as $parcel_key=>$performer_pack) {
/*                
 * Если связывать по id внутри моих таблиц, то нужно искать их id
 * и делать это после CALL `integration_betapost`.`update_performer_order`()
                $query_str = "SELECT performer_order_id FROM `performer_order` WHERE performer_doc_id=".$row['performer_doc_id']." AND 
                parcel_id='".$attr['parcel'][$parcel_key]['parcel_id']."' AND order_id='".$attr['parcel'][$parcel_key]['order_id']."'";

                $query_result_order_id = $mysqli_ssl->query($query_str);
                var_dump($query_result_order_id);
                $row_order_id = $query_result_order_id->fetch_assoc();

                $performer_pack['performer_order_id'] = $row_order_id['performer_order_id'];
 */
                $performer_pack['parcel_id'] = $attr['parcel'][$parcel_key]['parcel_id'];
                $glueFields = glueFields(array_keys($performer_pack));
                $glueValues = glueValues(array_values($performer_pack));
            
                $query_str = " INSERT INTO `performer_pack_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
                //var_dump($query_str);
                $query_result = $mysqli_ssl->real_query($query_str);
            }
            
        }
        
        if ($table_type == 'order_row') {
            foreach ($table_content as $performer_order_row) {
                
                $glueFields = glueFields(array_keys($performer_order_row));
                $glueValues = glueValues(array_values($performer_order_row));
            
                $query_str = " INSERT INTO `performer_order_row_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
                //var_dump($query_str);
                $query_result = $mysqli_ssl->real_query($query_str);
            }
            
        }
        
        
        
    }
    
    $query_str = " CALL `integration_betapost`.`update_performer_doc_detail`() ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    $query_str = " CALL `integration_betapost`.`update_performer_order`() ";
    $query_result = $mysqli_ssl->real_query($query_str);

    $query_str = " CALL `integration_betapost`.`update_performer_f103`() ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    $query_str = " CALL `integration_betapost`.`update_performer_pack`() ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    $query_str = " CALL `integration_betapost`.`update_performer_order_row`() ";
    $query_result = $mysqli_ssl->real_query($query_str);

    

}