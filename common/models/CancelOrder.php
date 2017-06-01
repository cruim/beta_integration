<?php
namespace common\models;
use Yii;
use yii\base\Model;
use XMLWriter;

class CancelOrder extends Model
{
    public static function request_xml_153($accounts_lk, $accounts_pass, $order_id = NULL, $ordrow_id = NULL)
    {

        $oXMLout = new XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->startDocument('1.0', 'UTF-8');
        $oXMLout->setIndent(true);
        $oXMLout->startElement("request");
        $oXMLout->writeAttribute("partner_id", $accounts_lk); //201  //267  //275  //280
        $oXMLout->writeAttribute("password", $accounts_pass); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
        $oXMLout->writeAttribute("request_type", "153");

        if (isset($order_id))
        {
            if (!is_array($order_id))
                $order_id = array($order_id);

            foreach ($order_id as $order)
            {
                $oXMLout->startElement("order");
                $oXMLout->writeAttribute("order_id", $order);
                $oXMLout->endElement(); //order
            }
        }

        if (isset($ordrow_id))
        {

            if (!is_array($ordrow_id))
                $ordrow_id = array($ordrow_id);

            foreach ($ordrow_id as $ordrow)
            {
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
}