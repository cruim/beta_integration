<?php
namespace common\models;

use Yii;
use yii\base\Model;
use XMLWriter;

ini_set('max_execution_time', 3600);

class OrderStatus extends Model
{
    public static function getOrderStatusFromBeta()
    {
        $get_lk = VtigerSalesorder::getLkData();

        foreach ($get_lk as $lk)
        {
            $pass = ($lk['accounts_pass']);
            $partner_id = ($lk['accounts_lk']);
            $accounts_url = ($lk['accounts_url']);
        }
        //список заказов для проверки статуса заказа
        $check_orders = OrderStatus::getOrdersForStatusCheck();
        foreach ($check_orders as $che)
        {
            $oXMLout = new XMLWriter();
            $oXMLout->openMemory();
            $oXMLout->startDocument('1.0', 'UTF-8');
            $oXMLout->setIndent(true);
            $oXMLout->startElement("request");

            $oXMLout->writeAttribute("partner_id", "267");
            $oXMLout->writeAttribute("password", "u5/*yf;9O2]");
            $oXMLout->writeAttribute("request_type", "550");

            $oXMLout->startElement("parcel");
            $oXMLout->writeAttribute("order_id", implode($che));
            $oXMLout->endElement(); //parcel

            $oXMLout->endElement(); //request

            $oXMLout->endDocument();

            $xml = $oXMLout->outputMemory();

            $file = 'request550.log';
            $content = "";
            $content .= print_r($xml, 1) . chr(13) . chr(10);
            $content .= chr(13) . chr(10);
            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);


            $o_Curl = curl_init();

            $header = array(
                'Content-Type: text/xml'
            , 'Content-Length: ' . strlen($xml)
            , 'Connection: close'
            );

            curl_setopt($o_Curl, CURLOPT_URL, $accounts_url);
            curl_setopt($o_Curl, CURLOPT_POST, 1);
            curl_setopt($o_Curl, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($o_Curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($o_Curl, CURLOPT_POSTFIELDS, $xml);

            curl_setopt($o_Curl, CURLOPT_HEADER, 0);
            curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($o_Curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($o_Curl, CURLOPT_SSL_VERIFYPEER, 0);

            $s_Response = curl_exec($o_Curl);

            $magic = (simplexml_load_string($s_Response, 'SimpleXMLElement', LIBXML_NOWARNING));

            foreach ($magic as $it)
            {
                $beta_order_id = $it->attributes()->order_id;
                $state_code = $it->attributes()->state_code;

                OrderStatus::updateOrderStatusInTable($state_code, $beta_order_id);
            }
        }
    }

    public function getTrackNumberFromBeta()
    {
        //получаем номера документов в системе беты
        $oXMLout = new XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->startDocument('1.0', 'UTF-8');
        $oXMLout->setIndent(true);
        $oXMLout->startElement("request");

        $oXMLout->writeAttribute("partner_id", "267");
        $oXMLout->writeAttribute("password", "u5/*yf;9O2]");
        $oXMLout->writeAttribute("from_date", date("Y-m-d"));
        $oXMLout->writeAttribute("doc_type", "6");
        $oXMLout->writeAttribute("request_type", "104");

        $oXMLout->endElement(); //request

        $oXMLout->endDocument();

        $xml = $oXMLout->outputMemory();

        $file = 'request104.log';
        $content = "";
        $content .= print_r($xml, 1) . chr(13) . chr(10);
        $content .= chr(13) . chr(10);
        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

        $get_lk = VtigerSalesorder::getLkData();

        foreach ($get_lk as $lk)
        {
            $pass = ($lk['accounts_pass']);
            $partner_id = ($lk['accounts_lk']);
            $accounts_url = ($lk['accounts_url']);
        }

        $o_Curl = curl_init();

        $header = array(
            'Content-Type: text/xml'
        , 'Content-Length: ' . strlen($xml)
        , 'Connection: close'
        );

        curl_setopt($o_Curl, CURLOPT_URL, $accounts_url);
        curl_setopt($o_Curl, CURLOPT_POST, 1);
        curl_setopt($o_Curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($o_Curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($o_Curl, CURLOPT_POSTFIELDS, $xml);

        curl_setopt($o_Curl, CURLOPT_HEADER, 0);
        curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($o_Curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($o_Curl, CURLOPT_SSL_VERIFYPEER, 0);

        $s_Response = curl_exec($o_Curl);

        $magic = (simplexml_load_string($s_Response, 'SimpleXMLElement', LIBXML_NOWARNING));

        foreach ($magic as $item)
        {
            $bb[] = ($item->attributes()->idoc_id);
        }
        
        
//                exit();

        //получаем трек коды товаров,которые находятся в полученных документах
        foreach ($bb as $idoc_id)
        {
            $oXMLout = new XMLWriter();
            $oXMLout->openMemory();
            $oXMLout->startDocument('1.0', 'UTF-8');
            $oXMLout->setIndent(true);
            $oXMLout->startElement("request");

            $oXMLout->writeAttribute("partner_id", "267"); //201  //267  //275  //280
            $oXMLout->writeAttribute("password", "u5/*yf;9O2]"); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
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
            $o_Curl = curl_init();

            $header = array(
                'Content-Type: text/xml'
            , 'Content-Length: ' . strlen($xml)
            , 'Connection: close'
            );

            curl_setopt($o_Curl, CURLOPT_URL, $accounts_url);
            curl_setopt($o_Curl, CURLOPT_POST, 1);
            curl_setopt($o_Curl, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($o_Curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($o_Curl, CURLOPT_POSTFIELDS, $xml);

            curl_setopt($o_Curl, CURLOPT_HEADER, 0);
            curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($o_Curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($o_Curl, CURLOPT_SSL_VERIFYPEER, 0);

            $s_Response = curl_exec($o_Curl);

            $magic = (simplexml_load_string($s_Response, 'SimpleXMLElement', LIBXML_NOWARNING));

            $final = array();
            foreach ($magic->doc[0]->parcel as $item)
            {
                $final[md5($item->attributes()->parcel_id)] = [$item->attributes()->order_id, $item->attributes()->Barcode];
            }
            foreach ($final as $key => $fn)
            {
                $salesorderid = substr($fn[0], 0, -5);
                $track_number = substr($fn[1], 0);
                $beta_order_id = substr($fn[0], 0);
                $sql =
                    "insert into integration_betapost.test_track
            values(null,'{$salesorderid}','{$beta_order_id}','{$track_number}',null,null)";
                \Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }

    //выбираем только заказы,которые не имеют конечного статуса для проверки в Бете
    public static function getOrdersForStatusCheck()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT beta_order_id
            FROM integration_betapost.`test_track`
            where order_status not in (4,5,6,7) or order_status is null"
        )->queryAll();
    }

    //обновляем статусы у заказов
    public static function updateOrderStatusInTable($state_code, $beta_order_id)
    {
        $sql =
            "update integration_betapost.`test_track`
            set order_status = '{$state_code}'
            where `beta_order_id` = '{$beta_order_id}'
            ";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    //получаем все заказы, у которых статус равен 3,4,6
    public static function getOrdersForUpdateInCrm()
    {
        return Yii::$app->getDb()->createCommand(
            "select salesorderid,state_code.crm_status as order_status
            from integration_betapost.test_track
            inner join integration_betapost.state_code on test_track.order_status = state_code.state_code
            where order_status in (3,4,6)
            and is_status_update_in_crm is null"
        )->queryAll();
    }

    //ставим метку у заказов,статус которых равен 3,чтобы не использовать их в следующей выборке
    public static function setFlagAfterUpdateStatusInCrm()
    {
        $sql =
            "update integration_betapost.test_track
            set is_status_update_in_crm = 1
            where order_status not in (0,1,2,3)";
        \Yii::$app->db->createCommand($sql)->execute();
    }
}