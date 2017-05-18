<?php

header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
ini_set("display_errors", "on");
ini_set("display_startup_errors", "on");
ini_set('max_execution_time', 0);

//mb_internal_encoding("UTF-8");
require_once "shared/dbconnect.php";
$mysqli_ssl = new mysqli_ssl;
$mysqli_ssl->__connect();

$query_str = " SELECT * FROM `shipping_doc` WHERE `shipping_doc_shipped` = 0 ";
$query_result = $mysqli_ssl->query($query_str);
$shipping_docs = $query_result->fetch_all(MYSQLI_ASSOC);

$query_str = " SELECT * FROM `shipping_order` WHERE `shipping_order_shipped` = 0 ";
$query_result = $mysqli_ssl->query($query_str);
$shipping_orders = $query_result->fetch_all(MYSQLI_ASSOC);

$query_str = 
" SELECT `shipping_order_row`.*, `shipping_order`.shipping_order_order_id FROM `shipping_order_row` INNER JOIN `shipping_order` ON `shipping_order_row`.shipping_order_id = `shipping_order`.shipping_order_id ".
" WHERE `shipping_order`.`shipping_order_shipped` = 0 ";
$query_result = $mysqli_ssl->query($query_str);
$shipping_order_rows = $query_result->fetch_all(MYSQLI_ASSOC);
var_dump($shipping_orders);



/*
* Get Shipping info via CURL/XML protocol.
*/

require_once "shared/shared_lib.php";
	
//201  тест  
//275  ООО Здоров 
//267  Кулешин
//280  Баринов
//843  Соловьев
$lk = "267";
$lkData = getLkData($lk);

if (!$lkData) exit;


define('CFG_NL',                       "\n");
define('CFG_REQUEST_POST',             1);
define('CFG_REQUEST_HTTP',             'https://');
define('CFG_REQUEST_HOST',             'fb.dm-sg.ru');
define('CFG_REQUEST_PORT',             8080);
define('CFG_REQUEST_URL',              '/wsrv');
define('CFG_REQUEST_FULLURL',          CFG_REQUEST_HTTP . CFG_REQUEST_HOST . ':' . CFG_REQUEST_PORT . CFG_REQUEST_URL);
define('CFG_REQUEST_TIMEOUT',          30);
define('CFG_CONTENT_TYPE',             'text/xml');
$xml = request_xml($shipping_docs, $shipping_orders, $shipping_order_rows, $lkData["accounts_lk"], $lkData["accounts_pass"]);
define('CFG_TEST_XMLBODY',             $xml);


	$file = 'diagnostika.log';
	$content = "xml";
	$content .= print_r($xml, 1) . chr(13) . chr(10);
	file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

	
$o_Curl = curl_init();
//echo CFG_REQUEST_FULLURL;
curl_setopt($o_Curl, CURLOPT_URL, $lkData["accounts_url"]);  //CFG_REQUEST_FULLURL
curl_setopt($o_Curl, CURLOPT_POST, CFG_REQUEST_POST);
curl_setopt($o_Curl, CURLOPT_CONNECTTIMEOUT,    CFG_REQUEST_TIMEOUT);
curl_setopt($o_Curl, CURLOPT_HTTPHEADER,        array(
    'Content-Type: ' . CFG_CONTENT_TYPE
    , 'Content-Length: ' . strlen(CFG_TEST_XMLBODY)
    , 'Connection: close'
    ));
curl_setopt($o_Curl, CURLOPT_POSTFIELDS,        CFG_TEST_XMLBODY);

curl_setopt($o_Curl, CURLOPT_HEADER,            0);
curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER,    1);
curl_setopt($o_Curl, CURLOPT_SSL_VERIFYHOST,    0);
curl_setopt($o_Curl, CURLOPT_SSL_VERIFYPEER,    0);
$s_Response=curl_exec($o_Curl);


//$s_Response = file_get_contents('response.xml');
	
	//результат засылки сохраним в базу
	foreach ($shipping_docs as $shipping_doc) {
	$query_str = 
	" UPDATE `shipping_doc` SET `shipping_doc`.`shipping_doc_response` = '".$mysqli_ssl->real_escape_string($s_Response)."'";
	" WHERE `shipping_doc`.`shipping_doc_shipped` = 0 AND `shipping_doc`.`shipping_doc_id` = ".$shipping_doc['shipping_doc_id'];
	$query_result = $mysqli_ssl->query($query_str);
	var_dump( htmlentities( $query_str) );
	var_dump($query_result);
	}


if ($s_Response) {
	
	//<response xmlns="FBox/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="response" state="0"/>
	$xmlParse = new XMLReader();
	$xmlParse->xml($s_Response, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
	
	$file = 'xmlParse.log';
	$content = $s_Response . chr(13) . chr(10);
	$content .= print_r($xmlParse->readOuterXML(), 1) . chr(13) . chr(10);
	file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
	
	//$xmlParse->xml($s_Response);
	$state = -1;
	$i = 0;
	while ($xmlParse->read()) {
		if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'response') {
				$state = $xmlParse->getAttribute('state');
			}
		if ($xmlParse->nodeType == XMLReader::END_ELEMENT && $xmlParse->localName == 'response')
			break;

		var_dump($i);
		$i++;
	}

	$file = 'xmlParse.log';
	$content = "";
	$content .= print_r($xmlParse->readOuterXML(), 1) . chr(13) . chr(10);
	file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
	
	// после удачной засылки заказов, отмечаем у себя в базе "отгружен"
	
	if ($state == "0") {
		foreach ($shipping_docs as $shipping_doc) {
		$query_str = 
		" UPDATE `shipping_order` SET `shipping_order`.`shipping_order_shipped` = 1 ".
		" WHERE `shipping_order`.`shipping_order_shipped` = 0 AND `shipping_order`.`shipping_doc_id` = ".$shipping_doc['shipping_doc_id'];
		$query_result = $mysqli_ssl->query($query_str);
		
		$query_str = 
		" UPDATE `shipping_doc` SET `shipping_doc`.`shipping_doc_shipped` = 1 ".
		" WHERE `shipping_doc`.`shipping_doc_shipped` = 0 AND `shipping_doc`.`shipping_doc_id` = ".$shipping_doc['shipping_doc_id'];
		$query_result = $mysqli_ssl->query($query_str);
		}
	}
	
	// после удачной засылки заказов, заказы в ЦРМ переводим в статус "отправлен", дата отправления - текущая
	// и переключаем способ доставки "Cream", служба доставки "BetaPost" = 37
	
	
}
	
	$file = 'diagnostika.log';
	$content = "dia";
	$content .= print_r($s_Response, 1) . chr(13) . chr(10);
	file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

//var_dump($s_Response);
//echo $s_Response . CFG_NL;

curl_close($o_Curl);


	function request_xml($shipping_docs, $shipping_orders, $shipping_order_rows, $lk, $pass) {

		$oXMLout = new XMLWriter();
		$oXMLout->openMemory();
		$oXMLout->startDocument('1.0' , 'UTF-8' );
		$oXMLout->setIndent(true);
		$oXMLout->startElement("request");

		//$oXMLout->writeElement("request", "hello world");
		$oXMLout->writeAttribute("partner_id", $lk); 
		$oXMLout->writeAttribute("password", $pass);
		$oXMLout->writeAttribute("request_type", "101");
		
			foreach($shipping_docs as $shipping_doc) {
			$oXMLout->startElement("doc");
			$oXMLout->writeAttribute("doc_type", "5");
			$oXMLout->writeAttribute("zdoc_id", $shipping_doc['shipping_doc_zdoc_id']);
			$oXMLout->writeAttribute("doc_txt", "");
				
				
				foreach ($shipping_orders as $shipping_order) {
				$oXMLout->startElement("order");
				//$oXMLout->writeAttribute("dev1mail_type", "16"); // 16= Бандероль 1 класса
                                $oXMLout->writeAttribute("dev1mail_type", "23"); // 23= Посылка онлайн
				$oXMLout->writeAttribute("delivery_type", "1");
				$oXMLout->writeAttribute("order_id",	$shipping_order['shipping_order_order_id']	);
				$oXMLout->writeAttribute("zip",			$shipping_order['shipping_order_zip']		);
				$oXMLout->writeAttribute("clnt_name",	$shipping_order['shipping_order_clnt_name']	);
				$oXMLout->writeAttribute("clnt_phone",	$shipping_order['shipping_order_clnt_phone']    );
				
					$oXMLout->startElement("struct_addr");
					$oXMLout->writeAttribute("region", 	$shipping_order['shipping_order_region']	);
					$oXMLout->writeAttribute("city", 	$shipping_order['shipping_order_city']		);
					$oXMLout->writeAttribute("street",	$shipping_order['shipping_order_street']	);
					$oXMLout->writeAttribute("house",	$shipping_order['shipping_order_house']		);
					$oXMLout->endElement(); //struct_addr
				$oXMLout->endElement(); //order
				}

				foreach ($shipping_order_rows as $shipping_order_row) {
				$oXMLout->startElement("order_row");
				$oXMLout->writeAttribute("ordrow_id", 	$shipping_order_row['shipping_order_ordrow_id']);
				$oXMLout->writeAttribute("order_id", 	$shipping_order_row['shipping_order_order_id']);
				$oXMLout->writeAttribute("good_id", 	$shipping_order_row['shipping_order_row_good_id']);
				$oXMLout->writeAttribute("price", 		$shipping_order_row['shipping_order_row_price']);
				$oXMLout->writeAttribute("clnt_price", 	$shipping_order_row['shipping_order_row_clnt_price']);
				$oXMLout->endElement(); //order_row
				}
				
			$oXMLout->endElement(); //doc
			}
			
		$oXMLout->endElement(); //request
		
		$oXMLout->endDocument();
		
		return $oXMLout->outputMemory();
		
	}

	

