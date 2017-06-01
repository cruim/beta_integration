<?php

namespace common\models;
use Yii;
use yii\base\Model;

ini_set('max_execution_time', 3600);
require_once(Yii::getAlias('@common'). '/vtiger/vtwsclib/Vtiger/WSClient.php');

class VtigerAddTrackCode extends Model
{
    public function addTrackCode()
    {
        $login = "integration.betapost@crm.zdorov.top";
        $passw = "zlxMG9MTUviDgJZ";

        $vtigerConnector = new \Vtiger_WSClient('http://crm.zdorov.top/webservice.php');
        $vtigerConnector->doLogin($login, $passw);

        $actual_orders = \common\models\VtigerSalesorder::getTrackCodes();

        foreach ($actual_orders as $actual_order)
        {
            $orders[] = $actual_order['salesorderid'];
        }

        foreach ($actual_orders as $order)
        {
            $order = array(
                "salesorderid" => $order['order'],
                "sp_track_number" => $order['track'],
            );

            $request = array(
                "elementType" => "SalesOrder",
                "element" => $vtigerConnector->toJSONString($order),
            );

            $vtigerConnector->doInvoke('updateOrder', $request);

        }
        $vtigerConnector->doInvoke('logout');
    }

}