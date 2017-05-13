<?php

//Считываем документы заказчика

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
$query_str = " SELECT `accounts`.`accounts_lk`, `accounts`.`accounts_pass` FROM `accounts` 
 WHERE `accounts`.accounts_lk <> 201 ";
$query_result_lk = $mysqli_ssl->query($query_str);

WHILE ($row_lk = $query_result_lk->fetch_assoc()) {

    echo "Забираем документы у " . $row_lk['accounts_lk'] . " кабнета";
    echo "<br />";
    echo "<br />";

    $request = request_xml_103($row_lk['accounts_lk'], $row_lk['accounts_pass']);

    //var_dump( htmlentities($request) );

    $request_xml = doRequest($request, $row_lk['accounts_lk']);

    //var_dump( htmlentities($request_xml) );
    
    $query_str = " TRUNCATE `customer_doc_tmp` ";
    $query_result = $mysqli_ssl->real_query($query_str);
    
    $attr = get_attribytes_103($request_xml);
    foreach ($attr as $attr_row) {
        
        $attr_row['accounts_lk'] = $row_lk['accounts_lk'];
        $glueFields = glueFields(array_keys($attr_row));
        $glueValues = glueValues(array_values($attr_row));

        $query_str = " INSERT INTO `customer_doc_tmp` (" . $glueFields . ") VALUES (" . $glueValues ." ) ";
        $query_result = $mysqli_ssl->real_query($query_str);
        var_dump($query_result);
    }
    
    $query_str = " CALL `integration_betapost`.`update_customer_doc`() ";
    $query_result = $mysqli_ssl->real_query($query_str);
    var_dump($query_result);
    //var_dump($attr);
    
}
