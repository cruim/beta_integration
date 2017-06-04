<?php

namespace common\models;

use Yii;
use yii\base\Model;

ini_set('max_execution_time', 3600);
require_once(Yii::getAlias('@common') . '/vtiger/vtwsclib/Vtiger/WSClient.php');

class VtigerUpdateInfo extends Model
{
    //обновляем инфу у только что отправленных заказов
    public function updateInfo()
    {
        $login = "integration.betapost@crm.zdorov.top";
        $passw = "zlxMG9MTUviDgJZ";

        $vtigerConnector = new \Vtiger_WSClient('http://crm.zdorov.top/webservice.php');
        $vtigerConnector->doLogin($login, $passw);

        $actual_orders = \common\models\VtigerSalesorder::getOrdersFromIntermediateTable();

        foreach ($actual_orders as $actual_order)
        {
            $orders[] = $actual_order['salesorderid'];
        }

        foreach ($orders as $order)
        {

            $order = array(
                "salesorderid" => $order,
                "sostatus" => "Отправлен",
                "sp_so_mark" => "Beta_Post_Integration",
                "sp_departure_date" => date("Y-m-d"),
                "organization_sender" => "ИП Кулешин"
            );

            $request = array(
                "elementType" => "SalesOrder",
                "element" => $vtigerConnector->toJSONString($order),
            );

            $vtigerConnector->doInvoke('updateOrder', $request);

        }
        $vtigerConnector->doInvoke('logout');
    }

    //обновляем статус заказов в crm
    public function updateOrderStatus()
    {
        $login = "integration.betapost@crm.zdorov.top";
        $passw = "zlxMG9MTUviDgJZ";

        $vtigerConnector = new \Vtiger_WSClient('http://crm.zdorov.top/webservice.php');
        $vtigerConnector->doLogin($login, $passw);

        //получаем список заказов и их статусов, требующих обновления статуса в срм
        $actual_orders = \common\models\OrderStatus::getOrdersForUpdateInCrm();

        foreach ($actual_orders as $actual_order)
        {
            $salesorderid = $actual_order['salesorderid'];
            $order_status = $actual_order['order_status'];

            $order = array(
                "salesorderid" => $salesorderid,
                "sostatus" => $order_status,
            );

            $request = array(
                "elementType" => "SalesOrder",
                "element" => $vtigerConnector->toJSONString($order),
            );

            $vtigerConnector->doInvoke('updateOrder', $request);

        }
        //проставляем флаг у заказов, имеющих конечный статус,чтобы не использовать их в следующих проверках
        OrderStatus::setFlagAfterUpdateStatusInCrm();
        
        $vtigerConnector->doInvoke('logout');
    }

}