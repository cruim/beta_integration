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
        $searchModel = new VtigerSalesorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->get('final_search'))
        {
            //вставка в промежуточную таблицу корректных заказов
            VtigerSalesorder::insertIntoIntermediateTable();
            $sql = VtigerSalesorder::getLastDate();
            foreach ($sql as $sq)
            {
                $curdate = ($sq['last_date']);
            }
            if($curdate != date("Y-m-d"))
            {
                VtigerSalesorder::insertIntoBetaPostSendOrders();
            }
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

            //обновляем статусы отправленных заказов
            $new = new VtigerUpdateInfo();
            $new->updateInfo();

            $data = VtigerSalesorder::getFirstClassOrders();
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'sort' => [
                ],
            ]);

            return $this->render('correct_orders',['dataProvider' =>$dataProvider]);
        }

        if(isset($_GET['get_track']))
        {
            OrderStatus::getTrackNumberFromBeta();
            
            $new = new VtigerAddTrackCode();
            $new->addTrackCode();
            
            $data = VtigerSalesorder::getFirstClassOrders();
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'sort' => [
                ],
            ]);

            return $this->render('correct_orders',['dataProvider' =>$dataProvider]);
        }

        if(isset($_GET['update_status']))
        {
            $order_status = new OrderStatus();
            $order_status->getOrderStatusFromBeta();
            
            $update_status_in_crm = new VtigerUpdateInfo();
            $update_status_in_crm->updateOrderStatus();
            
            

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
