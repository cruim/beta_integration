<?php

require_once 'shared/dbconnect.php';
$mysqli_ssl = new mysqli_ssl;
$mysqli_ssl->__connect();

//var_dump($mysqli_ssl);

$query_str = " SELECT * FROM `shipping_doc`";
$query_result = $mysqli_ssl->query($query_str);
$shipping_docs = $query_result->fetch_all(MYSQLI_ASSOC);

var_dump($shipping_docs);

exit;

require_once "shared/shared_lib.php";

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<request partner_id="280" password="r8/KY9-+Cl" request_type="550">
<parcel order_id="587550-587550A_560"/>
</request>';
$xml = '<?xml version="1.0" encoding="UTF-8"?>
<request partner_id="280" password="r8/KY9-+Cl" request_type="152" order_id="604879-604879A_587" active_only="0"/>';
var_dump($xml);

$request_xml = doRequest($xml, "280");

var_dump($request_xml);

exit;


//mb_internal_encoding("UTF-8");

$serverSQL = 'zdorov.local.mySQL.Server';//'5.167.96.63'; //

$mysqli_ssl = mysqli_init();
$mysqli_ssl->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, TRUE);
$mysqli_ssl->ssl_set(
                    __DIR__.'/../shared/certs/client-key.pem',
                    __DIR__.'/../shared/certs/client-cert.pem',
                    __DIR__.'/../shared/certs/ca.pem',
                    NULL,
                    NULL);

$mysqli_ssl->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$result_connect = $mysqli_ssl->real_connect($serverSQL, 'landing', '123', 'integration_betapost', NULL, NULL, MYSQLI_CLIENT_SSL);
var_dump($mysqli_ssl);

$mysqli_ssl->set_charset("utf8");

exit;






//Обновляем атрибуты операции в таблицу shipping_order

header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
ini_set("display_errors", "on");
ini_set("display_startup_errors", "on");
ini_set('max_execution_time', 0);

    const MYSQL_ATTR_SSL_KEY = "/../shared/certs/client-key.pem";
    const MYSQL_ATTR_SSL_CERT = "/../shared/certs/client-cert.pem";
    const MYSQL_ATTR_SSL_CA = "/../shared/certs/ca.pem";

        $dsn = "mysql:dbname=integration_betapost;host=zdorov.local.mySQL.Server;charset=UTF8";
        $user = "landing";
        $password = "123";
        $options = array (
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_KEY => __DIR__ . MYSQL_ATTR_SSL_KEY,
            PDO::MYSQL_ATTR_SSL_CERT => __DIR__ . MYSQL_ATTR_SSL_CERT,
            PDO::MYSQL_ATTR_SSL_CA => __DIR__ . MYSQL_ATTR_SSL_CA
        );
        
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            echo "<pre>";
            var_dump($e);
            echo "</pre>";
            //echo 'Подключение не удалось: ' . $e->getMessage();
        }
var_dump($dbh);



exit;









require_once 'shared_lib.php';

//считываем список кабинетов, и пароли, в которых атрибут операции не проставлен
$query_str = "   SELECT `accounts`.`accounts_lk`, `accounts`.`accounts_pass` FROM `shipping_order` 
 INNER JOIN `shipping_doc` ON `shipping_order`.shipping_doc_id = `shipping_order`.`shipping_doc_id`
 INNER JOIN `accounts` ON `accounts`.`accounts_lk` = `shipping_doc`.`accounts_lk`
 WHERE shipping_order_shipped = 1 AND (ordrow_state is null or ordrow_state <> 3 AND ordrow_state <> 100) 
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
    WHERE shipping_order_shipped = 1 AND (ordrow_state is null or ordrow_state <> 3 AND ordrow_state <> 100)
    AND `shipping_doc`.`accounts_lk` = '". $row_lk['accounts_lk'] ."' ";
    $query_result = $mysqli_ssl->query($query_str);

    if ($query_result)
    WHILE ($row = $query_result->fetch_assoc()) {

        $shipping_order_order_id = $row['shipping_order_order_id'];
        
        if ($shipping_order_order_id) {
            $request_xml = doRequest(request_xml_152($shipping_order_order_id, $row_lk['accounts_lk'], $row_lk['accounts_pass']));
            $attr = get_attribytes($request_xml);
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


function get_attribytes($xml) {
    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
    $find_attr = array('ordrow_state', 'ordrow_state_descrip', 'active_reason', 'active_reason_descrip', 'idoc6_id');

    $result = array();
    while ($xmlParse->read()) {
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'order_row') {
            foreach ($find_attr as $attr) {
                $value = $xmlParse->getAttribute($attr);
                if ($value !== NULL)
                $result[$attr] = $value;
            }
            break;
        }
    }
    return $result;
}


?>
