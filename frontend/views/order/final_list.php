<?php

use yii\helpers\Html;
//use kartik\export\ExportMenu;
use yii\grid\GridView;
use common\models;
use common\controllers;
use bluezed\floatThead\FloatThead;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VtigerSalesorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Корректные заказы';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="vtiger-salesorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php
    $gridColumns =
        [
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
                'header' => 'Индекс',
                'value' => function($model)
                {
                    foreach ($model->index as $request)
                    {
                        $index =  $request->partpost->partpost_INDEX;
                    }
                    return $index;
                },

            ],

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
                'header' => 'Дом',
                'value' => function($model)
                {
                    return $model->sp_house;
                }
            ],

            [
                'header' => 'Строение',
                'value' => function($model)
                {
                    return $model->sp_housing;
                }
            ],


            [
                'header' => 'Квартира',
                'value' => function($model)
                {
                    return $model->sp_flat;
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

            [
                'header' => 'Комментарий оператора',
                'value' => function($model)
                {
                    return $model->salesOrdercf->cf_1365;
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
            'payment_status',
            'repeat_order',
            'sp_delivery_date',
        ];

//    echo ExportMenu::widget([
//        'dataProvider' => $dataProvider,
//        'columns' => $gridColumns,
//        'columnSelectorOptions'=>[
//            'label' => 'Columns',
//            'class' => 'btn btn-info'
//        ],
//    ]);
//    ?>

    <!--    --><?php
    //    FloatThead::widget(
    //        [
    //            'tableId' => 'myTable',
    //            'options' => [
    //                'top' => 50
    //            ]
    //        ]
    //    );
    //    ?>

    <?= GridView::widget([
        'tableOptions' => [
            'id' => 'myTable',
            'class' => 'table table-striped table-bordered',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model)
        {
            if($model->address->ship_city == '' or $model->address->ship_street == '' or $model->sp_house == '' or $model->address->ship_state == '' or $model->total <= 330)
            {
                return ['class' => 'danger'];
            }
            foreach ($model->index as $request)
            {
                $index =  $request->partpost->partpost_INDEX;
            }

            if($index == '')
            {
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
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
                'header' => 'Индекс',
                'value' => function($model)
                {
                    foreach ($model->index as $request)
                    {
                        $index =  $request->partpost->partpost_INDEX;
                    }
                    return $index;
                },

            ],

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
                'header' => 'Дом',
                'value' => function($model)
                {
                    return $model->sp_house;
                }
            ],

            [
                'header' => 'Строение',
                'value' => function($model)
                {
                    return $model->sp_housing;
                }
            ],


            [
                'header' => 'Квартира',
                'value' => function($model)
                {
                    return $model->sp_flat;
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

            [
                'header' => 'Комментарий оператора',
                'value' => function($model)
                {
                    return $model->salesOrdercf->cf_1365;
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
            'payment_status',
            'repeat_order',
            'sp_delivery_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <?= Html::a( ' Все Заказы', ['order/index', 'all_search' => 1],['class' => 'btn btn-primary btn-md glyphicon glyphicon-search']); ?>
    <?= Html::a( ' Корректные Заказы', ['order/index', 'final_search' => 2],['class' => 'btn btn-success btn-md glyphicon glyphicon-thumbs-up']); ?>
    <?= Html::a( ' Некорректные Заказы', ['order/index', 'uncorrect_search' => 3],['class' => 'btn btn-danger btn-md glyphicon glyphicon-thumbs-down']); ?>
    <?= Html::a( ' Почта Онлайн', ['order/index', 'pochta_online' => 4],['class' => 'btn btn-info btn-md glyphicon glyphicon-envelope']); ?>
    <?= Html::a( ' Бандероль 1 класс', ['order/index', 'first_class' => 5],['class' => 'btn btn-warning btn-md glyphicon glyphicon-send']); ?>

  
</div>
