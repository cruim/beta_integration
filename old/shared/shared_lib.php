<?php



function getLkData($lk) {

    require_once 'dbconnect.php';
    $mysqli_ssl = new mysqli_ssl;
    $mysqli_ssl->__connect();

    $query_str = " SELECT * FROM `accounts` WHERE `accounts_lk` = '".$lk."'";
    $query_result = $mysqli_ssl->query($query_str);

    $result = NULL;
    if ($query_result) {
        $result = $query_result->fetch_assoc();
    }
    $mysqli_ssl->close();
    
    return $result;
/*
$lkData = array(
	"201"		=> array(
		"pass"		=>		"test",
		"url"		=>		"https://fb.dm-sg.ru:8080/wsrv"
	),
	"267"		=> array(
		"pass"		=>		"u5/*yf;9O2]",
		"url"		=>		"https://fb.dm-sg.ru:8080/wsrv"
	),
	"275"		=> array(
		"pass"		=>		"u5/*yf;9O2]",
		"url"		=>		"https://fb.dm-sg.ru:8080/wsrv"
	),
	"280"		=> array(
		"pass"		=>		"r8/KY9-+Cl",
		"url"		=>		"https://fb.dm-sg.ru:8080/wsrv"
	),
	"843"		=> array(
		"pass"		=>		"5342312",
		"url"		=>		"http://212.5.64.194:8080/bp/hs/wsrv"
	)
);
$result = NULL;
if (isset($lkData[$lk])) {
	$result = $lkData[$lk];
}
*/



}

//152 Получить состояние позиций заказов клиентов
function request_xml_152($order_id, $accounts_lk, $accounts_pass) {

    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");

    $oXMLout->writeAttribute("partner_id", $accounts_lk); //201  //267  //275  //280
    $oXMLout->writeAttribute("password", $accounts_pass); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
    $oXMLout->writeAttribute("request_type", "152");
    $oXMLout->writeAttribute("order_id", $order_id);
    $oXMLout->writeAttribute("active_only", "0");

    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();

    $file = 'request152.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

    return $xml;

}


function get_attribytes_152($xml) {
	$result = array();
	if (strlen($xml) > 0) {

	$xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
    $find_attr = array('ordrow_state', 'ordrow_state_descrip', 'active_reason', 'active_reason_descrip', 'idoc6_id');

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
	}
    return $result;
}


//153=Аннулировать позицию заказа
/*
    order_id
        Аннулировать все позиции указанного заказа клиента
        В случае указания несуществующего заказа позиция игнорируется. Ошибка не выдается
    ordrow_id
        Аннулировать указанную позицию
        В случае указания несуществующей позиции позиция игнорируется. Ошибка не выдается
*/

function request_xml_153($accounts_lk, $accounts_pass, $order_id = NULL, $ordrow_id = NULL) {
    
    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");
    $oXMLout->writeAttribute("partner_id", $accounts_lk); //201  //267  //275  //280
    $oXMLout->writeAttribute("password", $accounts_pass); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
    $oXMLout->writeAttribute("request_type", "153");
    
    if (isset($order_id)) {
        if (!is_array($order_id))
            $order_id = array($order_id);
        
        foreach ($order_id as $order) {
            $oXMLout->startElement("order");    
            $oXMLout->writeAttribute("order_id", $order);
            $oXMLout->endElement(); //order
        }
    }
    
    if (isset($ordrow_id)) {

        if (!is_array($ordrow_id))
            $ordrow_id = array($ordrow_id);
        
        foreach ($ordrow_id as $ordrow) {
            $oXMLout->startElement("order_row");    
            $oXMLout->writeAttribute("ordrow_id", $ordrow);
            $oXMLout->endElement(); //order
        }
    }
    
    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request153.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

    
}


function request_xml_154($order_id, $accounts_lk, $accounts_pass) {
    
    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");
    $oXMLout->writeAttribute("partner_id", $accounts_lk);
    $oXMLout->writeAttribute("password", $accounts_pass);
    $oXMLout->writeAttribute("request_type", "154");
    $oXMLout->writeAttribute("active_only", "0"); //?
    
    if (isset($order_id)) {
        if (!is_array($order_id))
            $order_id = array($order_id);
        
        foreach ($order_id as $order) {
            $oXMLout->startElement("order");    
            $oXMLout->writeAttribute("order_id", $order);
            $oXMLout->endElement(); //order
        }
    }
    
    
    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request154.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

}

function get_attribytes_154($xml) {
    $result = array();	
	if (strlen($xml) > 0) {
    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);


    while ($xmlParse->read()) {

        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'parcel') {
      	
            $result_attr = array();
/*
            $file = 'xmlDebug.log';
            $content = "";
            $content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
*/
            $res = $xmlParse->moveToFirstAttribute();
            while ($res) {
                $result_attr[$xmlParse->name] = $xmlParse->value;
/*                
                $file = 'xmlDebug.log';
                $content = $xmlParse->name . chr(13) . chr(10);
                $content .= $xmlParse->value . chr(13) . chr(10);
                //$content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
                file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
*/
                $res = $xmlParse->moveToNextAttribute();

            }
            $result[] = $result_attr;
        }
    }
	}
    return $result;
}


function request_xml_161($accounts_lk, $accounts_pass, $good_id = NULL, $good_name = NULL, $good_ean = NULL) {
    
    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");
    $oXMLout->writeAttribute("partner_id", $accounts_lk); //201  //267  //275  //280
    $oXMLout->writeAttribute("password", $accounts_pass); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
    $oXMLout->writeAttribute("request_type", "161");
    
    $oXMLout->startElement("good");
    $oXMLout->writeAttribute("good_id", $good_id);
    $oXMLout->writeAttribute("good_name", $good_name);
    
    $oXMLout->startElement("ean");
    $oXMLout->writeAttribute("mode", 1);
    $oXMLout->writeAttribute("value", $good_ean);
    $oXMLout->endElement(); //ean

    $oXMLout->endElement(); //good
    
    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request161.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

    
}


/*
 * 
 * 
 */
function request_xml_102($accounts_lk, $accounts_pass, $doc_id = NULL) {
    
    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");
    $oXMLout->writeAttribute("partner_id", $accounts_lk); //201  //267  //275  //280
    $oXMLout->writeAttribute("password", $accounts_pass); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
    $oXMLout->writeAttribute("request_type", "102");
    
    if (isset($doc_id)) {
        $oXMLout->startElement("doc");    
        $oXMLout->writeAttribute("zdoc_id", $doc_id);
        $oXMLout->endElement(); //doc
    }

    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request102.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

}

//550=Получить текущие статусы отправлений
function request_xml_550($order_id, $accounts_lk, $accounts_pass) {

    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");

    $oXMLout->writeAttribute("partner_id", $accounts_lk);
    $oXMLout->writeAttribute("password", $accounts_pass);
    $oXMLout->writeAttribute("request_type", "550");

    $oXMLout->startElement("parcel");
    $oXMLout->writeAttribute("order_id", $order_id);
    $oXMLout->endElement(); //parcel
    
    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request550.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

}

function get_attribytes_550($xml) {
	$result = array();
	if (strlen($xml) > 0) {
		
		$xmlParse = new XMLReader();
		$xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
		$find_attr = array('order_id', 'delivery_type', 'date_time', 'state_code', 'state', 'barcode');

		while ($xmlParse->read()) {
			if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'parcel') {
				foreach ($find_attr as $attr) {
					$value = $xmlParse->getAttribute($attr);
					if ($value !== NULL)
					$result[$attr] = $value;
				}
				break;
			}
		}
	}
    return $result;
}

//103=Получить список документов заказчика
function request_xml_103($accounts_lk, $accounts_pass) {

    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");

    $oXMLout->writeAttribute("partner_id", $accounts_lk);
    $oXMLout->writeAttribute("password", $accounts_pass);
    $oXMLout->writeAttribute("request_type", "103");

    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request103.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

}

function get_attribytes_103($xml) {
    $result = array();	
	if (strlen($xml) > 0) {
    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);


    while ($xmlParse->read()) {

        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'doc') {
      	
            $result_attr = array();
/*
            $file = 'xmlDebug.log';
            $content = "";
            $content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
*/
            $res = $xmlParse->moveToFirstAttribute();
            while ($res) {
                $result_attr[$xmlParse->name] = $xmlParse->value;
/*                
                $file = 'xmlDebug.log';
                $content = $xmlParse->name . chr(13) . chr(10);
                $content .= $xmlParse->value . chr(13) . chr(10);
                //$content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
                file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
*/
                $res = $xmlParse->moveToNextAttribute();

            }
            $result[] = $result_attr;
        }
    }
	}
    return $result;
}


//104=Получить список документов исполнителя
function request_xml_104($accounts_lk, $accounts_pass) {

    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");

    $oXMLout->writeAttribute("partner_id", $accounts_lk);
    $oXMLout->writeAttribute("password", $accounts_pass);
    $oXMLout->writeAttribute("request_type", "104");

    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request104.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

}

function get_attribytes_104($xml) {
	$result = array();
	if (strlen($xml) > 0) {
    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);

    
    while ($xmlParse->read()) {

        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'doc') {
      	
            $result_attr = array();
/*
            $file = 'xmlDebug.log';
            $content = "";
            $content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
*/
            $res = $xmlParse->moveToFirstAttribute();
            while ($res) {
                $result_attr[$xmlParse->name] = $xmlParse->value;
/*                
                $file = 'xmlDebug.log';
                $content = $xmlParse->name . chr(13) . chr(10);
                $content .= $xmlParse->value . chr(13) . chr(10);
                //$content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
                file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
*/
                $res = $xmlParse->moveToNextAttribute();

            }
            $result[] = $result_attr;
        }
    }
	}
    return $result;
}

//105=Получить данные по  документу Исполнителя
function request_xml_105($idoc_id, $accounts_lk, $accounts_pass) {

    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");

    $oXMLout->writeAttribute("partner_id", $accounts_lk); //201  //267  //275  //280
    $oXMLout->writeAttribute("password", $accounts_pass); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
    $oXMLout->writeAttribute("request_type", "105");
    $oXMLout->writeAttribute("idoc_id", $idoc_id);

    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request105.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

}

function get_attributes_105($xml) {
    $result = array();
	if (strlen($xml) > 0) {
    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);

    while ($xmlParse->read()) {

        echo $xmlParse->localName . "<br />";
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'doc') {
            //echo "11";
            $result_attr = enum_attributes($xmlParse->expand());
/*
            $file = 'xmlDebug.log';
            $content = "";
            $content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

            $res = $xmlParse->moveToFirstAttribute();
            while ($res) {
                $result_attr[$xmlParse->name] = $xmlParse->value;
                
                $file = 'xmlDebug.log';
                $content = $xmlParse->name . chr(13) . chr(10);
                $content .= $xmlParse->value . chr(13) . chr(10);
                //$content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
                file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

                $res = $xmlParse->moveToNextAttribute();

            }
 
 */
            $result['doc'] = $result_attr;


        }
        
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'parcel') {
            //echo "22";
            $result_attr = enum_attributes($xmlParse->expand());
            
            $result['parcel'][] = $result_attr;
        }
        //pack - запчасть от parcel, кладем ее в послений из добавленных parcel
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'pack') {
            $result_attr = enum_attributes($xmlParse->expand());
            
            $result['pack'][count($result['parcel'])-1] = $result_attr;
        }
        
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'order_row') {
            $result_attr = enum_attributes($xmlParse->expand());
            
            $result['order_row'][] = $result_attr;
        }

        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'f103') {
            $result_attr = enum_attributes($xmlParse->expand());
            
            $result['f103'][] = $result_attr;
        }

        
        
    }
	}
    return $result;
}

//107=Получить данные по  документу заказчика
function request_xml_107($zdoc_id, $accounts_lk, $accounts_pass) {

    $oXMLout = new XMLWriter();
    $oXMLout->openMemory();
    $oXMLout->startDocument('1.0' , 'UTF-8' );
    $oXMLout->setIndent(true);
    $oXMLout->startElement("request");

    $oXMLout->writeAttribute("partner_id", $accounts_lk); //201  //267  //275  //280
    $oXMLout->writeAttribute("password", $accounts_pass); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
    $oXMLout->writeAttribute("request_type", "107");
    $oXMLout->writeAttribute("zdoc_id", $zdoc_id);

    $oXMLout->endElement(); //request

    $oXMLout->endDocument();
    
    $xml = $oXMLout->outputMemory();
    
    $file = 'request107.log';
    $content = "";
    $content .= print_r($xml, 1) . chr(13) . chr(10);
    $content .= chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    
    return $xml;

}

function get_attributes_107($xml) {
    $result = array();
	if (strlen($xml) > 0) {
    $xmlParse = new XMLReader();
    $xmlParse->xml($xml, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);

    while ($xmlParse->read()) {

        echo $xmlParse->localName . "<br />";
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'doc') {
            //echo "11";
            $result_attr = enum_attributes($xmlParse->expand());
/*
            $file = 'xmlDebug.log';
            $content = "";
            $content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

            $res = $xmlParse->moveToFirstAttribute();
            while ($res) {
                $result_attr[$xmlParse->name] = $xmlParse->value;
                
                $file = 'xmlDebug.log';
                $content = $xmlParse->name . chr(13) . chr(10);
                $content .= $xmlParse->value . chr(13) . chr(10);
                //$content .= print_r($xmlParse->readOuterXml(), 1) . chr(13) . chr(10);
                file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

                $res = $xmlParse->moveToNextAttribute();

            }
 
 */
            $result['doc'] = $result_attr;


        }
        
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'order') {
            //echo "22";
            $result_attr = enum_attributes($xmlParse->expand());
            
            $result['order'][] = $result_attr;
        }
        //pack - запчасть от parcel, кладем ее в послений из добавленных parcel
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'struct_addr') {
            $result_attr = enum_attributes($xmlParse->expand());
            
            $result['struct_addr'][count($result['order'])-1] = $result_attr;
        }
        
        if ($xmlParse->nodeType == XMLReader::ELEMENT && $xmlParse->localName == 'order_row') {
            $result_attr = enum_attributes($xmlParse->expand());
            
            $result['order_row'][] = $result_attr;
        }


        
        
    }
	}
    return $result;
}

//разбор DOM node на аттрибуты
function enum_attributes($node) {
    $result_attr = array();
    foreach ($node->attributes as $attr) {
        $result_attr[$attr->localName] = $attr->value;
    }
    return $result_attr;
}

function doRequest($xml, $lk) {

    $lkData = getLkData($lk);
    
    $o_Curl = curl_init();
	
    $header = array(
                    'Content-Type: text/xml'
                    , 'Content-Length: ' . strlen($xml)
                    , 'Connection: close'
                    );

    curl_setopt($o_Curl, CURLOPT_URL,               $lkData["accounts_url"]);
    curl_setopt($o_Curl, CURLOPT_POST,              1);
    curl_setopt($o_Curl, CURLOPT_CONNECTTIMEOUT,    60);
    curl_setopt($o_Curl, CURLOPT_HTTPHEADER,        $header);
    curl_setopt($o_Curl, CURLOPT_POSTFIELDS,        $xml);

    curl_setopt($o_Curl, CURLOPT_HEADER,            0);
    curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER,    1);
    curl_setopt($o_Curl, CURLOPT_SSL_VERIFYHOST,    0);
    curl_setopt($o_Curl, CURLOPT_SSL_VERIFYPEER,    0);
    $s_Response = curl_exec($o_Curl);
	//var_dump(curl_error($o_Curl));
	//var_dump(curl_errno($o_Curl));
    $file = 'doRequest.log';
    $content = "";
    $content .= print_r($s_Response, 1) . chr(13) . chr(10);
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

    return $s_Response;

}



//оборачиват одно поле в кавычки ``
function quoteField($fieldName) {
    $result = $fieldName;
    //var_dump(substr($fieldName, 0, 1));
    if (substr($fieldName, 0, 1) != "`")
        $result = "`" . $result;
    //var_dump(substr($fieldName, -1, 1));
    if (substr($fieldName, -1, 1) != "`")
        $result = $result . "`";
    return $result;
}

//оборачивает массив значений в кавычки ``
function quoteFields($fieldsArray) {
    $result = array ();
    foreach ($fieldsArray as $fieldName) {
        $result[] = quoteField($fieldName);
    }
    return $result;
}

//склеивает имена полей
function glueFields($fieldsArray) {
    //echo "</br>";
    //var_dump(quoteFields($fieldsArray));
    return implode(", ", quoteFields($fieldsArray));
}

//оборачиват одно поле в кавычки ''
function quoteValue($fieldValue) {
    $result = $fieldValue;
    //var_dump($fieldValue);
    if (substr($fieldValue, 0, 1) != "'")
        $result = "'" . $result;
    if (substr($fieldValue, -1, 1) != "'")
        $result = $result . "'";
    if ($result == '') {
        $result = 'NULL';
    }
    return $result;
}

//оборачивает массив значений в кавычки ''
function quoteValues($fieldsArray) {
    $result = array ();
    foreach ($fieldsArray as $fieldName) {
        $result[] = quoteValue($fieldName);
    }
    return $result;
}

//склеивает значения
function glueValues($valuesArray) {
    return implode(", ", quoteValues($valuesArray));
}

