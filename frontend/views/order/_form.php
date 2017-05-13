<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VtigerSalesorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vtiger-salesorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'salesorderid')->textInput() ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'potentialid')->textInput() ?>

    <?= $form->field($model, 'customerno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salesorder_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salesorder_custom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quoteid')->textInput() ?>

    <?= $form->field($model, 'vendorterms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactid')->textInput() ?>

    <?= $form->field($model, 'vendorid')->textInput() ?>

    <?= $form->field($model, 'duedate')->textInput() ?>

    <?= $form->field($model, 'carrier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pending')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adjustment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salescommission')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exciseduty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxtype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_percent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's_h_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountid')->textInput() ?>

    <?= $form->field($model, 'terms_conditions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'purchaseorder')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sostatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id')->textInput() ?>

    <?= $form->field($model, 'conversion_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enable_recurring')->textInput() ?>

    <?= $form->field($model, 'one_s_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fromsite')->textInput() ?>

    <?= $form->field($model, 'pre_tax_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's_h_percent')->textInput() ?>

    <?= $form->field($model, 'spcompany')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_dispatch_assigned')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_delivery_assigned')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_subway')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_house')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_flat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_housing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_porch')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_floor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_delivery_service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_delivery_date')->textInput() ?>

    <?= $form->field($model, 'sp_delivery_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_operator_comment_one')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_client_comment_one')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_dispatch_organization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_stock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_so_mark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_track_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_barcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_delivery_manager_assigned')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_planned_delivery_date')->textInput() ?>

    <?= $form->field($model, 'sp_last_call_date')->textInput() ?>

    <?= $form->field($model, 'sp_departure_date')->textInput() ?>

    <?= $form->field($model, 'sp_receiving_point_date')->textInput() ?>

    <?= $form->field($model, 'sp_receiving_date')->textInput() ?>

    <?= $form->field($model, 'sp_receiving_money_date')->textInput() ?>

    <?= $form->field($model, 'sp_return_date')->textInput() ?>

    <?= $form->field($model, 'sp_return_reasons')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_delivery_service_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sp_delivery_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_money_transaction_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_return_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_additional_consumption')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_dispatch_doc_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_money_rec_doc_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_return_registry_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_invoice_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_utm_source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_utm_content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_utm_term')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_net')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_offer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_landing_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_landing_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_country_currency_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_net_so_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_lead_cost_db')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_lead_cost_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_client_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_additional_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_contact_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_script')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sp_objections')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sp_product_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sp_tel_codes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sp_document_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_check_status_logistics')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_summary_check_logisticks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_is_russian_post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_utm_medium')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_utm_campaign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_transaction_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_external_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_click_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_timezone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_geo_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_retailcrm_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_operator_comment_two')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeat_order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_landing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_processing_date')->textInput() ?>

    <?= $form->field($model, 'doubles')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sp_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_cross_sale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_age')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'real_mobile_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_sender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fact_payment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'extcallcenter_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_update_status')->textInput() ?>

    <?= $form->field($model, 'term_of_dialer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_shipment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label_report')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_control')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'offer_price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
