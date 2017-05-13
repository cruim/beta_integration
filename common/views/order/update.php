<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VtigerSalesorder */

$this->title = 'Update Vtiger Salesorder: ' . $model->salesorderid;
$this->params['breadcrumbs'][] = ['label' => 'Vtiger Salesorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->salesorderid, 'url' => ['view', 'id' => $model->salesorderid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vtiger-salesorder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
