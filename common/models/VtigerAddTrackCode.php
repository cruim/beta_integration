<?php

namespace common\models;
use Yii;
use yii\base\Model;

ini_set('max_execution_time', 0);
require_once(Yii::getAlias('@common'). '/vtiger/vtwsclib/Vtiger/WSClient.php');

class VtigerAddTrackCode extends Model
{
    public function addTrackCode()
    {
        $login = "integration.betapost@crm.zdorov.top";
        $passw = "zlxMG9MTUviDgJZ";

        $vtigerConnector = new \Vtiger_WSClient('http://crm.zdorov.top/webservice.php');
        $vtigerConnector->doLogin($login, $passw);

        $actual_orders = VtigerAddTrackCode::getTrackCodes();

        foreach ($actual_orders as $order)
        {
            $order = array(
                "salesorderid" => $order['salesorderid'],
                "sp_track_number" => $order['track_number'],
            );

            $request = array(
                "elementType" => "SalesOrder",
                "element" => $vtigerConnector->toJSONString($order),
            );

            $vtigerConnector->doInvoke('updateOrder', $request);

        }
        $vtigerConnector->doInvoke('logout');
    }

    public static function getTrackCodes()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT * FROM integration_betapost.`track_and_status_from_beta`
            where order_status is null"
        )->queryAll();
    }

}