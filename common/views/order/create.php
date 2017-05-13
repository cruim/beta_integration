<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VtigerSalesorder */

$this->title = 'Create Vtiger Salesorder';
$this->params['breadcrumbs'][] = ['label' => 'Vtiger Salesorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vtiger-salesorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
