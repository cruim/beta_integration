<?php

namespace frontend\controllers;

use Yii;
use common\models\VtigerSalesorder;
use common\models\VtigerSalesorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
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
        $get_lk = VtigerSalesorder::getLkData();
        foreach ($get_lk as $lk)
        {
            $pass = ($lk['accounts_pass']);
            $partner_id = ($lk['accounts_lk']);
            $accounts_url = ($lk['accounts_url']);
        }
        $xml = VtigerSalesorder::createXMLDoc($pass,$partner_id);

        VtigerSalesorder::sendXMLData($xml,$accounts_url);

//        $o_Curl = curl_init();
//
//        $header = array(
//            'Content-Type: text/xml'
//        , 'Content-Length: ' . strlen($xml)
//        , 'Connection: close'
//        );
//
//        curl_setopt($o_Curl, CURLOPT_URL,               $accounts_url);
//        curl_setopt($o_Curl, CURLOPT_POST,              1);
//        curl_setopt($o_Curl, CURLOPT_CONNECTTIMEOUT,    60);
//        curl_setopt($o_Curl, CURLOPT_HTTPHEADER,        $header);
//        curl_setopt($o_Curl, CURLOPT_POSTFIELDS,        $xml);
//
//        curl_setopt($o_Curl, CURLOPT_HEADER,            0);
//        curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER,    1);
//        curl_setopt($o_Curl, CURLOPT_SSL_VERIFYHOST,    0);
//        curl_setopt($o_Curl, CURLOPT_SSL_VERIFYPEER,    0);
//        $s_Response = curl_exec($o_Curl);
//        //var_dump(curl_error($o_Curl));
//        //var_dump(curl_errno($o_Curl));
//        $file = 'doRequest.log';
//        $content = "";
//        $content .= print_r($s_Response, 1) . chr(13) . chr(10);
//        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
//
//        return $s_Response;


        exit();

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
