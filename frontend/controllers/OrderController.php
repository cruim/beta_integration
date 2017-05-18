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
        $data = vtigerSalesorder::getOrderXMLData();


        $final_array = array();

        foreach ($data as $val)
        {
            $count = 0;
            for($i = 0; $i < $val['quantity']; $i++)
            {
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $val['ordrow_id'] = $val['ordrow_id'] . '/' . $count;
                $final_array[] = $val;
                $val['ordrow_id'] = $intermediate;
            }
        }

//        foreach ($final_array as $final)
//        {
//            echo"<pre>";print_r($final);echo"</pre>";
//        }
//        echo count($final_array);
//
//        exit();



        $oXMLout = new XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->startDocument('1.0' , 'UTF-8' );
        $oXMLout->setIndent(true);
        $oXMLout->startElement("request");

        //$oXMLout->writeElement("request", "hello world");
        $oXMLout->writeAttribute("partner_id", 'lk');
        $oXMLout->writeAttribute("password", 'pass');
        $oXMLout->writeAttribute("request_type", "101");


        foreach ($final_array as $shipping_order_row) {
            $oXMLout->startElement("order_row");
            $oXMLout->writeAttribute("ordrow_id", 	$shipping_order_row['ordrow_id']);
            $oXMLout->writeAttribute("order_id", 	$shipping_order_row['order_id']);
            $oXMLout->writeAttribute("good_id", 	$shipping_order_row['good_id']);
            $oXMLout->writeAttribute("price", 		$shipping_order_row['price']);
            $oXMLout->writeAttribute("clnt_price", 	$shipping_order_row['clnt_price']);
            $oXMLout->endElement(); //order_row
        }

//
//
//
//            foreach ($data as $shipping_order) {
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
        $oXMLout->endElement(); //request

        $oXMLout->endDocument();
        echo htmlentities($oXMLout->outputMemory());


//        $oXMLout->writeRaw();

    





        exit();

//        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $searchModel = new VtigerSalesorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->get('final_search'))
        {
            $dataProvider = $searchModel->finalSearch(Yii::$app->request->queryParams);
        }
        if(isset($_GET['all_search']))
        {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        if(isset($_GET['uncorrect_search']))
        {
            $dataProvider = $searchModel->uncorrectSearch(Yii::$app->request->queryParams);
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
