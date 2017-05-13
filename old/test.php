<?php

/*
* Get Shipping info via CURL/XML protocol.
*/


define('CFG_NL',                       "\n");
define('CFG_REQUEST_POST',             1);
define('CFG_REQUEST_HTTP',             'https://');
define('CFG_REQUEST_HOST',             'fb.dm-sg.ru');
define('CFG_REQUEST_PORT',             8080);
define('CFG_REQUEST_URL',              '/wsrv');
define('CFG_REQUEST_FULLURL',          CFG_REQUEST_HTTP . CFG_REQUEST_HOST . ':' . CFG_REQUEST_PORT . CFG_REQUEST_URL);
define('CFG_REQUEST_TIMEOUT',          5);
define('CFG_CONTENT_TYPE',             'text/xml');
$xml = request_xml();
define('CFG_TEST_XMLBODY',             $xml);


	$file = 'diagnostika.log';
	$content = "xml";
	$content .= print_r($xml, 1) . chr(13) . chr(10);
	file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

$o_Curl = curl_init();
//echo CFG_REQUEST_FULLURL;
curl_setopt($o_Curl, CURLOPT_URL, CFG_REQUEST_FULLURL);
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

	$file = 'diagnostika.log';
	$content = "dia";
	$content .= print_r($s_Response, 1) . chr(13) . chr(10);
	file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

//var_dump($s_Response);
//echo $s_Response . CFG_NL;

curl_close($o_Curl);


	function request_xml() {

		$oXMLout = new XMLWriter();
		$oXMLout->openMemory();
		$oXMLout->startElement("request");
		//$oXMLout->writeElement("request", "hello world");
		$oXMLout->writeAttribute("partner_id", "275");
		$oXMLout->writeAttribute("password", "u5/*yf;9O2]");
		$oXMLout->writeAttribute("request_type", "56");
		$oXMLout->endElement();
		return $oXMLout->outputMemory();

		$memory = xmlwriter_open_memory();
		xmlwriter_start_element  ($memory, 'request'); // <request>
		xmlwriter_write_attribute($memory, 'partner_id', '201');
		xmlwriter_write_attribute($memory, 'password', 'test');
//		xmlwriter_write_attribute($memory, 'request_type', '3');
		xmlwriter_write_attribute($memory, 'request_type', '56');
//		xmlwriter_text($memory, 'Hello world');
		xmlwriter_end_element($memory); // </request>
		$xml = xmlwriter_output_memory($memory,true);
		return $xml;
		
	}

?>