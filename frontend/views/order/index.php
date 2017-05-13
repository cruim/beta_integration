<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models;
use common\controllers;
/* @var $this yii\web\View */
/* @var $searchModel common\models\VtigerSalesorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vtiger Salesorders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vtiger-salesorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'salesorderid',

            [
                'header' => 'Покупатель',

                 'value' => function ($model)
            {
                return $model->sp_full_name . ' ' . $model->sp_firstname . ' ' . $model->sp_middle_name;
            }
            ],

            [
                'header' => 'Сумма заказа',
                'value' => function ($model)
            {
                $round_total = $model->total;
                return round($round_total);
            }
            ],

            'real_mobile_phone',

            [
                'header' => 'Регион',
                'value' => function($model)
                {
                    return $model->address->ship_state;
                }
            ],

            [
                'header' => 'Город',
                'value' => function($model)
                {
                    return $model->address->ship_city;
                }
            ],

            [
                'header' => 'Улица',
                'value' => function($model)
                {
                    return $model->address->ship_street;
                }
            ],

            [
                'header' => 'Индекс',
                'value' => function($model)
                {
                    return $model->address->ship_code;
                }
            ],

            [
                'header' => 'Регион',
                'value' => function($model)
                {
                   return $model->address->ship_state;
                }
            ],

            [
                'header' => 'Адрес доставки',
                'value' => function($model)
                {
                    return $model->address->ship_code . ', ' . $model->address->sp_so_country . ', ' .  $model->address->ship_state . ', ' .
                           $model->address->ship_city . ', ' . $model->address->ship_street . ', ' . 'д.' . $model->sp_house  . $model->sp_housing . ', ' .
                     'кв.'.$model->sp_flat . ', ' . 'Район:' . $model->area;
                }
            ],

            [
                'header' => 'Менеджер',
                'value' => function($model)
                {
                    foreach ($model->vtigerCrmentity as $request)
                    {
                        $manager =  $request->manager->last_name;
                    }
                    return $manager;
                }
            ],

            'payment_status',
            'sp_operator_comment_one',
            [
                'header' => 'Комментарий оператора',
                'value' => function($model)
                {
                    return $model->sp_operator_comment_one . '.' . $model->sp_operator_comment_two;
                }
            ],

            [
                'header' => 'Состав',
                'value' => function($model)
                {
                    $result = '';

                    foreach ($model->inventory as $request)
                    {
                        $product[] = $request->products->productname . ' ' . round($request->quantity) . 'шт.';
                    }

                    foreach ($product as $value)
                    {
                        $result .=  (strlen($result))?', ': '';
                        $result .= $value;
                    }
                    return $result;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
