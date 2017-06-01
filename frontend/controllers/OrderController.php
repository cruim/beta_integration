<?php

namespace frontend\controllers;

use common\models\VtigerAddTrackCode;
use common\models\VtigerUpdateInfo;
use common\models\OrderStatus;
use Yii;
use common\models\VtigerSalesorder;
use common\models\VtigerSalesorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use XMLWriter;


/**
 * OrderController implements the CRUD actions for VtigerSalesorder model.
 */
class OrderController extends \common\controllers\OrderController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all VtigerSalesorder models.
     * @return mixed
     */
    public function actionIndex()
    {
//        VtigerSalesorder::getDocNumberFromBeta();
//        exit();
//        $order_id = array("870229_1048","884335-884335A_889","839596-839596A_848","914669-914669A_901");
//        $oXMLout = new XMLWriter();
//        $oXMLout->openMemory();
//        $oXMLout->startDocument('1.0' , 'UTF-8' );
//        $oXMLout->setIndent(true);
//        $oXMLout->startElement("request");
//        $oXMLout->writeAttribute("partner_id", "267");
//        $oXMLout->writeAttribute("password", "u5/*yf;9O2]");
//        $oXMLout->writeAttribute("request_type", "154");
//        $oXMLout->writeAttribute("active_only", "0"); //?
//
//        if (isset($order_id)) {
//            if (!is_array($order_id))
//                $order_id = array($order_id);
//
//            foreach ($order_id as $order) {
//                $oXMLout->startElement("order");
//                $oXMLout->writeAttribute("order_id", $order);
//                $oXMLout->endElement(); //order
//            }
//        }
//
//
//        $oXMLout->endElement(); //request
//
//        $oXMLout->endDocument();
//
//        $xml = $oXMLout->outputMemory();
//
//        $file = 'request154.log';
//        $content = "";
//        $content .= print_r($xml, 1) . chr(13) . chr(10);
//        $content .= chr(13) . chr(10);
//        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
//        VtigerSalesorder::getRemnantsOfGoods();

        ################################
//        $doc_id = array('4925084','4925030','4926566','4944296','4944339','4945877','4946844','4946859','4946867','4930602','4930603','4940525','4940535','4951549','4951650');
//
//        foreach ($doc_id as $idoc_id)
//        {
//            $oXMLout = new XMLWriter();
//            $oXMLout->openMemory();
//            $oXMLout->startDocument('1.0', 'UTF-8');
//            $oXMLout->setIndent(true);
//            $oXMLout->startElement("request");
//
//            $oXMLout->writeAttribute("partner_id", "267"); //201  //267  //275  //280
//            $oXMLout->writeAttribute("password", "u5/*yf;9O2]"); //test  //u5/*yf;9O2]  //u5/*yf;9O2]  //r8/KY9-+Cl
//            $oXMLout->writeAttribute("request_type", "105");
//            $oXMLout->writeAttribute("idoc_id", $idoc_id);
//
//            $oXMLout->endElement(); //request
//
//            $oXMLout->endDocument();
//
//            $xml = $oXMLout->outputMemory();
//
//            $file = 'request105.log';
//            $content = "";
//            $content .= print_r($xml, 1) . chr(13) . chr(10);
//            $content .= chr(13) . chr(10);
//            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
//
////        $magic = ( simplexml_load_string($content,'SimpleXMLElement', LIBXML_NOWARNING));
////        $some = ($magic['state']);
//            print_r(file_put_contents($file, $content, FILE_APPEND | LOCK_EX));
//
//
//            ###################
//
//        $oXMLout = new XMLWriter();
//        $oXMLout->openMemory();
//        $oXMLout->startDocument('1.0' , 'UTF-8' );
//        $oXMLout->setIndent(true);
//        $oXMLout->startElement("request");
//
//        $oXMLout->writeAttribute("partner_id", "267");
//        $oXMLout->writeAttribute("password", "u5/*yf;9O2]");
//        $oXMLout->writeAttribute("from_date", date("y-m-d"));
//        $oXMLout->writeAttribute("doc_type", "6");
//        $oXMLout->writeAttribute("request_type", "104");
//
//        $oXMLout->endElement(); //request
//
//        $oXMLout->endDocument();
//
//        $xml = $oXMLout->outputMemory();
//
//        $file = 'request104.log';
//        $content = "";
//        $content .= print_r($xml, 1) . chr(13) . chr(10);
//        $content .= chr(13) . chr(10);
//        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
////            #####################

////
//            $get_lk = VtigerSalesorder::getLkData();
//
//            foreach ($get_lk as $lk)
//            {
//                $pass = ($lk['accounts_pass']);
//                $partner_id = ($lk['accounts_lk']);
//                $accounts_url = ($lk['accounts_url']);
//            }
//            VtigerSalesorder::sendXMLData($xml, $accounts_url);
//        }
////        return $xml;
//
//        exit();
        ####################
//        $new = new VtigerUpdateInfo();
//        $new->updateInfo();
//        exit();
        ###################
//        $order_data = vtigerSalesorder::getOrderXMLDataFirstClass();
//        foreach ($order_data as $or)
//        {
//            echo"<pre>";print_r($or);echo"</pre>";
//        }
//        exit();
//        $elixir_metabol = VtigerSalesorder::getElixirOffers();
//        foreach ($elixir_metabol as $value)
//        {
//            $elixir_metabol_parse[] = ($value['shipping_order_row_good_id']);
//        }
//        foreach ($elixir_metabol_parse as $el)
//        {
//            print_r($el);
//        }
//        exit();
//        $new = new VtigerAddTrackCode();
//        $new->addTrackCode();
//        exit();
//echo date("Y-m-d");
//        exit();
//
//        $new = new VtigerUpdateInfo();
//        $new->updateOrderStatus();
////        $order_status = new OrderStatus();
////        $order_status->getOrderStatusFromBeta();
//
////                $new = new VtigerUpdateInfo();
////        $new->updateInfo();
//        exit();


        $searchModel = new VtigerSalesorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->get('final_search'))
        {
            //вставка в промежуточную таблицу корректных заказов
            VtigerSalesorder::insertIntoIntermediateTable();
            $dataProvider = $searchModel->finalSearch(Yii::$app->request->queryParams);
            return $this->render('final_list', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        }
        if(isset($_GET['all_search']))
        {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        if(isset($_GET['uncorrect_search']))
        {
            $dataProvider = $searchModel->uncorrectSearch(Yii::$app->request->queryParams);
        }

        if(isset($_GET['pochta_online']))
        {
            $data = VtigerSalesorder::getPostOnlineOrders();
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'sort' => [
                ],
            ]);

            return $this->render('correct_orders',['dataProvider' =>$dataProvider]);
        }

        if(isset($_GET['first_class']))
        {
            $data = VtigerSalesorder::getFirstClassOrders();
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'sort' => [
                ],
            ]);

            return $this->render('correct_orders',['dataProvider' =>$dataProvider]);
        }

        if(isset($_GET['send_orders']))
        {
            $get_lk = VtigerSalesorder::getLkData();

            foreach ($get_lk as $lk)
            {
                $pass = ($lk['accounts_pass']);
                $partner_id = ($lk['accounts_lk']);
                $accounts_url = ($lk['accounts_url']);
            }
            //создаем xml документ почта онлайн
            $xml_post = VtigerSalesorder::createXMLDoc($pass,$partner_id,$partner_id);

            //отправляем почта онлайн
            VtigerSalesorder::sendXMLData($xml_post,$accounts_url);

            //создаем xml документ первый класс
            $xml_first_class = VtigerSalesorder::createXMLDocFirstClass($pass,$partner_id,$partner_id);

            //отправляем первый класс
            VtigerSalesorder::sendXMLData($xml_first_class,$accounts_url);

            $data = VtigerSalesorder::getFirstClassOrders();
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'sort' => [
                ],
            ]);

            return $this->render('correct_orders',['dataProvider' =>$dataProvider]);
        }

        

        //$dataProvider->pagination->pageSize = 50;


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single VtigerSalesorder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VtigerSalesorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VtigerSalesorder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->salesorderid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VtigerSalesorder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->salesorderid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VtigerSalesorder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VtigerSalesorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VtigerSalesorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VtigerSalesorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
