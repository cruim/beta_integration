<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
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
            [
                'header' => 'Номер заказа',
                'value' => 'salesorderid',
            ],

            [
                'header' => 'ФИО',
                'value' => 'fio'
            ],

            [
                'header' => 'Сумма заказа',
                'value' => 'total'
            ],

            [
                'header' => 'Мобильный телефон',
                'value' => 'real_mobile_phone'
            ],

            [
                'header' => 'Почтовый индекс',
                'value' => 'partpost_INDEX'
            ],

            [
                'header' => 'Город',
                'value' => 'ship_city'
            ],

            [
                'header' => 'Улица',
                'value' => 'ship_street'
            ],

            [
                'header' => 'Дом',
                'value' => 'sp_house'
            ],

            [
                'header' => 'Строение',
                'value' => 'sp_housing'
            ],

            [
                'header' => 'Квартира',
                'value' => 'sp_flat'
            ],

            [
                'header' => 'Полный адрес',
                'value' => 'full_address'
            ],

            [
                'header' => 'Менеджер',
                'value' => 'manager'
            ],

            [
                'header' => 'Статус оплаты',
                'value' => 'payment_status'
            ],

            [
                'header' => 'Комментарий',
                'value' => 'operator_comment'
            ],

            [
                'header' => 'Состав заказа',
                'value' => 'consist'
            ],

            [
                'header' => 'Оплата',
                'value' => 'fact_payment'
            ],

            [
                'header' => 'Повторный заказ',
                'value' => 'repeat_order'
            ],

            [
                'header' => 'Дата доставки',
                'value' => 'sp_delivery_date'
            ],
        ];

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'columnSelectorOptions'=>[
            'label' => 'Columns',
            'class' => 'btn btn-info'
        ],
    ]);
    ?>

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
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],

            [
                'header' => 'Номер заказа',
                'value' => 'salesorderid',
            ],

            [
                'header' => 'ФИО',
                'value' => 'fio'
            ],

            [
                'header' => 'Сумма заказа',
                'value' => 'total'
            ],

            [
                'header' => 'Мобильный телефон',
                'value' => 'real_mobile_phone'
            ],

            [
                'header' => 'Почтовый индекс',
                'value' => 'partpost_INDEX'
            ],

            [
                'header' => 'Город',
                'value' => 'ship_city'
            ],

            [
                'header' => 'Улица',
                'value' => 'ship_street'
            ],

            [
                'header' => 'Дом',
                'value' => 'sp_house'
            ],

            [
                'header' => 'Строение',
                'value' => 'sp_housing'
            ],

            [
                'header' => 'Квартира',
                'value' => 'sp_flat'
            ],

            [
                'header' => 'Полный адрес',
                'value' => 'full_address'
            ],

            [
                'header' => 'Менеджер',
                'value' => 'manager'
            ],

            [
                'header' => 'Статус оплаты',
                'value' => 'payment_status'
            ],

            [
                'header' => 'Комментарий',
                'value' => 'operator_comment'
            ],

            [
                'header' => 'Состав заказа',
                'value' => 'consist'
            ],

            [
                'header' => 'Оплата',
                'value' => 'fact_payment'
            ],

            [
                'header' => 'Повторный заказ',
                'value' => 'repeat_order'
            ],

            [
                'header' => 'Дата доставки',
                'value' => 'sp_delivery_date'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <?= Html::a( ' Все Заказы', ['order/index', 'all_search' => 1],['class' => 'btn btn-primary btn-lg glyphicon glyphicon-search']); ?>
    <?= Html::a( ' Корректные Заказы', ['order/index', 'final_search' => 2],['class' => 'btn btn-success btn-lg glyphicon glyphicon-thumbs-up']); ?>
    <?= Html::a( ' Некорректные Заказы', ['order/index', 'uncorrect_search' => 3],['class' => 'btn btn-danger btn-lg glyphicon glyphicon-thumbs-down']); ?>
    <?= Html::a( ' Почта Онлайн', ['order/index', 'pochta_online' => 4],['class' => 'btn btn-info btn-lg glyphicon glyphicon-envelope']); ?>
    <?= Html::a( ' Бандероль 1 класс', ['order/index', 'first_class' => 5],['class' => 'btn btn-warning btn-lg glyphicon glyphicon-send']); ?>
</div>
