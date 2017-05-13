<?php

//Считываем данные по документам заказчика

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
$query_str = " SELECT `customer_doc`.`customer_doc_id`, `customer_doc`.`zdoc_id`, `accounts`.`accounts_lk`, `accounts`.`accounts_pass`
FROM `customer_doc` INNER JOIN `accounts` ON `customer_doc`.`accounts_lk` = `accounts`.`accounts_lk` 
WHERE `customer_doc`.`doc_type` = 5 AND shipping_doc_id >= 587 AND shipping_doc_id <= 610";
$query_result_doc = $mysqli_ssl->query($query_str);


WHILE ($row = $query_result_doc->fetch_assoc()) {
    echo "again";
    $request = request_xml_107($row['zdoc_id'], $row['accounts_lk'], $row['accounts_pass']);
    //var_dump( htmlentities($request) );
    $request_xml = doRequest($request, $row['accounts_lk']);

    $attr = get_attributes_107($request_xml);

    //$query_str = " TRUNCATE `customer_doc_detail_tmp` ";
    //$query_result = $mysqli_ssl->real_query($query_str);

    $query_str = " TRUNCATE `customer_order_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);

    $query_str = " TRUNCATE `customer_order_row_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    $query_str = " TRUNCATE `customer_struct_addr_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    //$table_type - doc, parcel, f103
    foreach ($attr as $table_type => $table_content) {
        /*
        if ($table_type == 'doc') {
            
            $table_content['customer_doc_id'] = $row['customer_doc_id'];
            $glueFields = glueFields(array_keys($table_content));
            $glueValues = glueValues(array_values($table_content));
            
            $query_str = " INSERT INTO `performer_doc_detail_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
            //var_dump($query_str);
            $query_result = $mysqli_ssl->real_query($query_str);
        }
        */
        if ($table_type == 'order') {
            foreach ($table_content as $customer_order) {
                
                $customer_order['customer_doc_id'] = $row['customer_doc_id'];
                $glueFields = glueFields(array_keys($customer_order));
                $glueValues = glueValues(array_values($customer_order));
            
                $query_str = " INSERT INTO `customer_order_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
                var_dump($query_str);
                $query_result = $mysqli_ssl->real_query($query_str);
            }

        }

        if ($table_type == 'struct_addr') {
            foreach ($table_content as $parcel_key=>$customer_pack) {
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
                $customer_pack['order_id'] = $attr['order'][$parcel_key]['order_id'];
                $glueFields = glueFields(array_keys($customer_pack));
                $glueValues = glueValues(array_values($customer_pack));
            
                $query_str = " INSERT INTO `customer_struct_addr_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
                var_dump($query_str);
                $query_result = $mysqli_ssl->real_query($query_str);
            }
        }
        
        if ($table_type == 'order_row') {
            foreach ($table_content as $customer_order_row) {
                
                $glueFields = glueFields(array_keys($customer_order_row));
                $glueValues = glueValues(array_values($customer_order_row));
            
                $query_str = " INSERT INTO `customer_order_row_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
                var_dump($query_str);
                $query_result = $mysqli_ssl->real_query($query_str);
            }
        }
        
    }
    
    //$query_str = " CALL `integration_betapost`.`update_customer_doc_detail`() ";
    //$query_result = $mysqli_ssl->real_query($query_str);
    echo "call `update_customer_order` ";
    $query_str = " CALL `integration_betapost`.`update_customer_order`() ";
    $query_result = $mysqli_ssl->real_query($query_str);
    echo "call `update_customer_struct_addr` ";
    $query_str = " CALL `integration_betapost`.`update_customer_struct_addr`() ";
    $query_result = $mysqli_ssl->real_query($query_str);
    echo "call `update_customer_order_row` ";
    $query_str = " CALL `integration_betapost`.`update_customer_order_row`() ";
    $query_result = $mysqli_ssl->real_query($query_str);


}

?>