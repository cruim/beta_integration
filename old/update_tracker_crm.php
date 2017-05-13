<?php

//Забираем трекеры и проставляем к ЦРМ, для тех заказов которые отгружены в бета-пост и в ЦРМ у них нету трекера

//1. Выбираем заказы, в которых нету трекера, берем первый, узнаем по операции 152, № документа в системе бета-пост
//2. Из этого документа, по операции 105 проставляем всем заказам, трекеры
//переходим к п.1.


header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL);
ini_set("display_errors", "on");
ini_set("display_startup_errors", "on");
ini_set('max_execution_time', 0);

//mb_internal_encoding("UTF-8");

$serverSQL = 'zdorov.local.mySQL.Server';//'5.167.96.63'; //

require_once "shared/dbconnect.php";
$mysqli_ssl = new mysqli_ssl;
$mysqli_ssl->__connect();

require_once "shared/shared_lib.php";

//Выбираем все кабинеты, в которых заказы находятся в статусе "3", но в ЦРМ нету трекера
$query_str = " CALL `get_crm_barcode_lk` ";
$query_result_lk = $mysqli_ssl->query($query_str);
$rows_lk = $query_result_lk->fetch_all(MYSQLI_ASSOC);

foreach ($rows_lk as $row_lk) {
    
    //изначально предполагаем что есть трекеры, которые нужно проставить
    $exists_empty_barcode = TRUE;

    WHILE ($exists_empty_barcode) {

        $waiting_orders = array();
        
        //очищаем транзакцию
        $mysqli_ssl->next_result();
        $query_str = " CALL `get_crm_barcode` ( '" . $row_lk['accounts_lk'] . "' ) ";
        $query_result = $mysqli_ssl->query($query_str);
        
        if ($query_result->num_rows > 0) {
            //все заказаы с пустым трекером грузим в массив
            $orders = $query_result->fetch_all(MYSQLI_ASSOC);
            //документ исполнителя будем вычитывать по первому попавшемуся заказу
            $row = $orders[0];
            $shipping_order_order_id = $row['shipping_order_order_id'];
            var_dump($shipping_order_order_id);

            if ($shipping_order_order_id) {
                //узнаем номер документа исполнителя, в котором содержится наш заказ без трекера

                //$request_xml = doRequest(request_xml_152($shipping_order_order_id, $row_lk['accounts_lk'], $row_lk['accounts_pass']), $row_lk['accounts_lk']);
                //$idoc6_id = get_idoc6_id($request_xml);
                
                $request_xml = doRequest(request_xml_154($shipping_order_order_id, $row_lk['accounts_lk'], $row_lk['accounts_pass']), $row_lk['accounts_lk']);

                $attr154 = get_attribytes_154($request_xml);

                if (count($attr154) > 0) {
                    $idoc6_id = $attr154[0]["idoc6_id"];
                } else {
                    echo $shipping_order_order_id . " Ошибка request_xml_154 нет данных";
                    exit;
                }

                //если idoc6_id не пришел, нужно что-то делать
                if ($idoc6_id) {
                    //получаем все заказы в документе исполнителя
                    $request_xml = doRequest(request_xml_105($idoc6_id, $row_lk['accounts_lk'], $row_lk['accounts_pass']), $row_lk['accounts_lk']);
                    //пробуем проставить все заказы, содержащиеся в документе исполнителя и не имеющие трекер
                    //на выходе - заказы у которых проставился трекер в CRM
                    $waiting_orders = fill_crm_barcode($request_xml, $orders);
                }

            }
        }
        else {
            $exists_empty_barcode = FALSE;
        }
        //$exists_empty_barcode = FALSE;
        
        echo "<br />Ждем<br />";
        var_dump($waiting_orders);

        //проверить распарсились ли данные из CRM, если еще нет, то ждем sleep
        $parsed_not_all = TRUE;
        WHILE ($parsed_not_all) {
            
            //очищаем транзакцию
            $mysqli_ssl->next_result();
            
            $query_str = " CALL `get_crm_barcode` ('" . $row_lk['accounts_lk'] . "')";
            $query_result = $mysqli_ssl->query($query_str);

            
            $parsed_not_all = FALSE;
            if ($query_result) {
                while ($row = $query_result->fetch_assoc()) {

                    if (In_array_search($row['order_id'], $waiting_orders) !== FALSE) {
                        $parsed_not_all = TRUE;
                        break;
                    }
                }
            }
            if ($parsed_not_all) {
                echo "<br />";
                echo "wait 10 sec...";
                sleep(10);
            }
        }

    }
    
}


function set_barcode($order, $Barcode) {

    require_once "../retailcrm/vendor/autoload.php";

    $retail_client = new RetailCrm\ApiClient(
            'https://varifort.retailcrm.ru',
            'hEZN2dXTGppGCj4KzHM8gjZzUisy4PIx'
    );

    $neworder = array ();
    $neworder["id"] = $order['order_id'];
    $neworder["customFields"]["nomer_otpravleniya"] = $Barcode;
    $neworder["customFields"]["api_mark"] = 'from_BetaPost_API';
    //var_dump($neworder);

    $result = $retail_client->ordersEdit( $neworder, 'id', $order["order_site"] );

    $response = $result->success;
    var_dump($result);
    echo "<br />";

    unset($retail_client);

    return $response;
}

function In_array_search($needle, $haystack) {
    foreach ($haystack as $index => $item) {
        if (in_array($needle, $item)) 
            return $index;
    }
    return FALSE;
}

function fill_crm_barcode($xml, $orders) {
    $result = array();

    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);

    while ($xmlParse->read()) {
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'parcel') {
            $shipping_order_order_id = $xmlParse->getAttribute('order_id');
            $Barcode = $xmlParse->getAttribute('Barcode');

            //var_dump($shipping_order_order_id);
            $order_id_index = In_array_search($shipping_order_order_id, $orders);
            //var_dump($order_id_index);
            if ($order_id_index !== FALSE)
                //если результат засылки заказа success=true
                if (set_barcode($orders[$order_id_index], $Barcode))
                    $result[] = $orders[$order_id_index];
        }
    }
    unset($xmlParse);

    return $result;
}


function get_idoc6_id($xml) {
    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);

    $idoc6_id = FALSE;
    while ($xmlParse->read()) {
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'order_row') {
            $idoc6_id = $xmlParse->getAttribute('idoc6_id');
            break;
        }
    }
    return $idoc6_id;
}



?>
