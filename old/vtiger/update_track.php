<?php



//header("Content-type: text/html; charset=utf-8");
//error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
//ini_set("display_errors", "on");
//ini_set("display_startup_errors", "on");
//ini_set('max_execution_time', 0);




require_once 'vtwsclib/Vtiger/WSClient.php';

 class VtigerOrderUpdate
{
    function updateInfo()
    {
        $login = "integration.betapost@crm.zdorov.top";
        $passw = "zlxMG9MTUviDgJZ";

        $vtigerConnector = new Vtiger_WSClient('http://crm.zdorov.top/webservice.php');
        $vtigerConnector->doLogin($login, $passw);

//$actual_orders = \common\models\VtigerSalesorder::getOrdersFromIntermediateTable();
//
//foreach ($actual_orders as $actual_order)
//{
//    $orders[] = $actual_order['salesorderid'];
//}
//
//foreach ($orders as $order)
//{

        $order = array(
            "salesorderid" => "1152090",
            "sostatus" => "Отправлен",
            "sp_so_mark" => "Beta_Post_integration",
            "sp_departure_date" => date("Y-m-d")
        );

        $request = array(
            "elementType" => "SalesOrder",
            "element" => $vtigerConnector->toJSONString($order),
        );

        $vtigerConnector->doInvoke('updateOrder', $request);

//}
        $vtigerConnector->doInvoke('logout');
    }
}