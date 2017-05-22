<?php

namespace frontend\controllers;

use Yii;
use common\models\VtigerSalesorder;
use common\models\VtigerSalesorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use XMLWriter;
use yii\data\ArrayDataProvider;

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
//        $order_data = vtigerSalesorder::getOrderXMLData();
//        $client_data = vtigerSalesorder::getClientXMLData();
//        foreach ($client_data as $client)
//        {
//            $array[] = $client;
//        }
//        print_r($array);
//        exit();
//        $doc_number = vtigerSalesorder::getLastDocNumber();
//        foreach ($doc_number as $doc)
//        {
//            $actual_doc_number = ($doc['doc']+1);
//        }
//        print_r($actual_doc_number);
//        exit();
//
//        $simple_collection = vtigerSalesorder::getNonErectOffers();
//        $erect_collection = vtigerSalesorder::getErectOffers();
//        foreach ($simple_collection as $value)
//        {
//            $simple_collection_parse[] = ($value['shipping_order_row_good_id']);
//        }
//
//        foreach ($erect_collection as $value)
//        {
//            $erect_collection_parse[] = ($value['shipping_order_row_good_id']);
//        }
//        $erect_collection = array('023','024');
//
//
//        $final_array = array();
//        $count = 0;
//        $reg = null;
//        foreach ($order_data as $val)
//        {
//            $ordrow_id = $val['ordrow_id'];
//            $nc=strrpos($ordrow_id,"_");
//            $ordrow_id=substr($ordrow_id,0,$nc+1). $actual_doc_number .substr($ordrow_id,$nc+1);
//            $val['ordrow_id'] = $ordrow_id;
//
//            if($reg != substr_replace($val['ordrow_id'], '', -3))
//            {
//                $count = 0;
//            }
//            if(in_array($val['good_id'],$erect_collection) and $count == 0)
//            {
//                $repo = $val;
//                $count++;
//                $val['count'] = $count;
//                $intermediate = $val['ordrow_id'];
//                $intermediate = substr_replace($intermediate, '005', -3);
//                $val['ordrow_id'] = $intermediate . '/' . $count;
//
//                $val['price'] = 0;
//                $val['clnt_price'] = 0;
//                $val['good_id'] = '005';
//                $final_array[] = $val;
//
//                $count++;
//                $val['count'] = $count;
//                $intermediate = $val['ordrow_id'];
//                $intermediate = substr_replace($intermediate, '025', -5);
//                $val['ordrow_id'] = $intermediate . '/' . $count;
//
//                $val['price'] = 0;
//                $val['clnt_price'] = 0;
//                $val['good_id'] = '025';
//                $final_array[] = $val;
//
//                $count++;
//                $val['count'] = $count;
//                $intermediate = $val['ordrow_id'];
//                $intermediate = substr_replace($intermediate, '026', -5);
//                $val['ordrow_id'] = $intermediate . '/' . $count;
//
//                $val['price'] = 0;
//                $val['clnt_price'] = 0;
//                $val['good_id'] = '026';
//                $final_array[] = $val;
//
//                $val = $repo;
//            }
//            if(in_array($val['good_id'],$simple_collection_parse)  and $count == 0)
//            {
//                $repo = $val;
//                $count++;
//                $val['count'] = $count;
//                $intermediate = $val['ordrow_id'];
//                $intermediate = substr_replace($intermediate, '003', -3);
//                $val['ordrow_id'] = $intermediate . '/' . $count;
//                $val['good_id'] = '003';
//                $val['price'] = 0;
//                $val['clnt_price'] = 0;
//                $final_array[] = $val;
//                $count++;
//                $val['count'] = $count;
//                $intermediate = $val['ordrow_id'];
//                $intermediate = substr_replace($intermediate, '005', -5);
//                $val['ordrow_id'] = $intermediate . '/' . $count;
//                $val['good_id'] = '005';
//                $val['price'] = 0;
//                $val['clnt_price'] = 0;
//                $final_array[] = $val;
//                $count++;
//                $val['count'] = $count;
//                $intermediate = $val['ordrow_id'];
//                $intermediate = substr_replace($intermediate, '006', -5);
//                $val['ordrow_id'] = $intermediate . '/' . $count;
//                $val['good_id'] = '006';
//                $val['price'] = 0;
//                $val['clnt_price'] = 0;
//                $final_array[] = $val;
//                $val = $repo;
//            }
//
//            for($i = 0; $i < $val['quantity']; $i++)
//            {
//                $count++;
//                $val['count'] = $count;
//                $intermediate = $val['ordrow_id'];
//                $val['ordrow_id'] = $val['ordrow_id'] . '/' . $count;
//                $final_array[] = $val;
//                $val['ordrow_id'] = $intermediate;
//            }
//            $reg = substr_replace($intermediate, '', -3);
//        }
//
////
////        foreach ($final_array as $final)
////        {
////            echo"<pre>";print_r($final);echo"</pre>";
////        }
////        echo count($final_array);
//
////        exit();
////
////
////
//        $oXMLout = new XMLWriter();
//        $oXMLout->openMemory();
//        $oXMLout->startDocument('1.0' , 'UTF-8' );
//        $oXMLout->setIndent(true);
//        $oXMLout->startElement("request");
//
//        //$oXMLout->writeElement("request", "hello world");
//        $oXMLout->writeAttribute("partner_id", 'lk');
//        $oXMLout->writeAttribute("password", 'pass');
//        $oXMLout->writeAttribute("request_type", "101");
////
////
//        foreach ($final_array as $shipping_order_row) {
//            $oXMLout->startElement("order_row");
//            $oXMLout->writeAttribute("ordrow_id", 	$shipping_order_row['ordrow_id']);
//            $oXMLout->writeAttribute("order_id", 	$shipping_order_row['order_id']);
//            $oXMLout->writeAttribute("good_id", 	$shipping_order_row['good_id']);
//            $oXMLout->writeAttribute("price", 		$shipping_order_row['price']);
//            $oXMLout->writeAttribute("clnt_price", 	$shipping_order_row['clnt_price']);
//            $oXMLout->endElement(); //order_row
//        }
//
//
//
//
//            foreach ($client_data as $shipping_order) {
//                $oXMLout->startElement("order");
//                //$oXMLout->writeAttribute("dev1mail_type", "16"); // 16= Бандероль 1 класса
//                $oXMLout->writeAttribute("dev1mail_type", "23"); // 23= Посылка онлайн
//                $oXMLout->writeAttribute("delivery_type", "1");
//                $oXMLout->writeAttribute("order_id",	$shipping_order['shipping_order_order_id']	);
//                $oXMLout->writeAttribute("zip",			$shipping_order['shipping_order_zip']		);
//                $oXMLout->writeAttribute("clnt_name",	$shipping_order['shipping_order_clnt_name']	);
//                $oXMLout->writeAttribute("clnt_phone",	$shipping_order['shipping_order_clnt_phone']    );
//
//                $oXMLout->startElement("struct_addr");
//                $oXMLout->writeAttribute("region", 	$shipping_order['shipping_order_region']	);
//                $oXMLout->writeAttribute("city", 	$shipping_order['shipping_order_city']		);
//                $oXMLout->writeAttribute("street",	$shipping_order['shipping_order_street']	);
//                $oXMLout->writeAttribute("house",	$shipping_order['shipping_order_house']		);
//                $oXMLout->endElement(); //struct_addr
//                $oXMLout->endElement(); //order
//            }
//
//        $oXMLout->endElement(); //request
//
//        $oXMLout->endDocument();
//        echo htmlentities($oXMLout->outputMemory());
////
////
////        $oXMLout->writeRaw();
//
//exit();

//        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $searchModel = new VtigerSalesorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->get('final_search'))
        {
            //вставка в промежуточную таблицу корректных заказов
            VtigerSalesorder::insertIntoIntermediateTable();
            $dataProvider = $searchModel->finalSearch(Yii::$app->request->queryParams);
            return $this->render('correct_orders', [
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
