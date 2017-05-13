<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VtigerSalesorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vtiger-salesorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'salesorderid') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'potentialid') ?>

    <?= $form->field($model, 'customerno') ?>

    <?= $form->field($model, 'salesorder_no') ?>

    <?php // echo $form->field($model, 'salesorder_custom') ?>

    <?php // echo $form->field($model, 'quoteid') ?>

    <?php // echo $form->field($model, 'vendorterms') ?>

    <?php // echo $form->field($model, 'contactid') ?>

    <?php // echo $form->field($model, 'vendorid') ?>

    <?php // echo $form->field($model, 'duedate') ?>

    <?php // echo $form->field($model, 'carrier') ?>

    <?php // echo $form->field($model, 'pending') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'adjustment') ?>

    <?php // echo $form->field($model, 'salescommission') ?>

    <?php // echo $form->field($model, 'exciseduty') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'taxtype') ?>

    <?php // echo $form->field($model, 'discount_percent') ?>

    <?php // echo $form->field($model, 'discount_amount') ?>

    <?php // echo $form->field($model, 's_h_amount') ?>

    <?php // echo $form->field($model, 'accountid') ?>

    <?php // echo $form->field($model, 'terms_conditions') ?>

    <?php // echo $form->field($model, 'purchaseorder') ?>

    <?php // echo $form->field($model, 'sostatus') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'conversion_rate') ?>

    <?php // echo $form->field($model, 'enable_recurring') ?>

    <?php // echo $form->field($model, 'one_s_id') ?>

    <?php // echo $form->field($model, 'fromsite') ?>

    <?php // echo $form->field($model, 'pre_tax_total') ?>

    <?php // echo $form->field($model, 's_h_percent') ?>

    <?php // echo $form->field($model, 'spcompany') ?>

    <?php // echo $form->field($model, 'sp_dispatch_assigned') ?>

    <?php // echo $form->field($model, 'sp_delivery_assigned') ?>

    <?php // echo $form->field($model, 'sp_subway') ?>

    <?php // echo $form->field($model, 'sp_house') ?>

    <?php // echo $form->field($model, 'sp_flat') ?>

    <?php // echo $form->field($model, 'sp_housing') ?>

    <?php // echo $form->field($model, 'sp_porch') ?>

    <?php // echo $form->field($model, 'sp_floor') ?>

    <?php // echo $form->field($model, 'sp_delivery_service') ?>

    <?php // echo $form->field($model, 'sp_delivery_date') ?>

    <?php // echo $form->field($model, 'sp_delivery_time') ?>

    <?php // echo $form->field($model, 'sp_operator_comment_one') ?>

    <?php // echo $form->field($model, 'sp_client_comment_one') ?>

    <?php // echo $form->field($model, 'sp_dispatch_organization') ?>

    <?php // echo $form->field($model, 'sp_stock') ?>

    <?php // echo $form->field($model, 'sp_so_mark') ?>

    <?php // echo $form->field($model, 'sp_track_number') ?>

    <?php // echo $form->field($model, 'sp_barcode') ?>

    <?php // echo $form->field($model, 'sp_delivery_manager_assigned') ?>

    <?php // echo $form->field($model, 'sp_planned_delivery_date') ?>

    <?php // echo $form->field($model, 'sp_last_call_date') ?>

    <?php // echo $form->field($model, 'sp_departure_date') ?>

    <?php // echo $form->field($model, 'sp_receiving_point_date') ?>

    <?php // echo $form->field($model, 'sp_receiving_date') ?>

    <?php // echo $form->field($model, 'sp_receiving_money_date') ?>

    <?php // echo $form->field($model, 'sp_return_date') ?>

    <?php // echo $form->field($model, 'sp_return_reasons') ?>

    <?php // echo $form->field($model, 'sp_delivery_service_comment') ?>

    <?php // echo $form->field($model, 'sp_delivery_cost') ?>

    <?php // echo $form->field($model, 'sp_money_transaction_cost') ?>

    <?php // echo $form->field($model, 'sp_return_cost') ?>

    <?php // echo $form->field($model, 'sp_additional_consumption') ?>

    <?php // echo $form->field($model, 'sp_dispatch_doc_num') ?>

    <?php // echo $form->field($model, 'sp_money_rec_doc_num') ?>

    <?php // echo $form->field($model, 'sp_return_registry_num') ?>

    <?php // echo $form->field($model, 'sp_invoice_num') ?>

    <?php // echo $form->field($model, 'sp_utm_source') ?>

    <?php // echo $form->field($model, 'sp_utm_content') ?>

    <?php // echo $form->field($model, 'sp_utm_term') ?>

    <?php // echo $form->field($model, 'sp_net') ?>

    <?php // echo $form->field($model, 'sp_offer') ?>

    <?php // echo $form->field($model, 'sp_landing_type') ?>

    <?php // echo $form->field($model, 'sp_landing_url') ?>

    <?php // echo $form->field($model, 'sp_country') ?>

    <?php // echo $form->field($model, 'sp_country_currency_cost') ?>

    <?php // echo $form->field($model, 'sp_ip') ?>

    <?php // echo $form->field($model, 'sp_net_so_number') ?>

    <?php // echo $form->field($model, 'sp_lead_cost_db') ?>

    <?php // echo $form->field($model, 'sp_lead_cost_pp') ?>

    <?php // echo $form->field($model, 'sp_full_name') ?>

    <?php // echo $form->field($model, 'sp_client_mobile') ?>

    <?php // echo $form->field($model, 'sp_additional_phone') ?>

    <?php // echo $form->field($model, 'sp_contact_id') ?>

    <?php // echo $form->field($model, 'sp_firstname') ?>

    <?php // echo $form->field($model, 'sp_middle_name') ?>

    <?php // echo $form->field($model, 'sp_script') ?>

    <?php // echo $form->field($model, 'sp_objections') ?>

    <?php // echo $form->field($model, 'sp_product_description') ?>

    <?php // echo $form->field($model, 'sp_tel_codes') ?>

    <?php // echo $form->field($model, 'sp_document_number') ?>

    <?php // echo $form->field($model, 'sp_check_status_logistics') ?>

    <?php // echo $form->field($model, 'sp_summary_check_logisticks') ?>

    <?php // echo $form->field($model, 'sp_is_russian_post') ?>

    <?php // echo $form->field($model, 'sp_language') ?>

    <?php // echo $form->field($model, 'sp_utm_medium') ?>

    <?php // echo $form->field($model, 'sp_utm_campaign') ?>

    <?php // echo $form->field($model, 'sp_transaction_id') ?>

    <?php // echo $form->field($model, 'sp_external_id') ?>

    <?php // echo $form->field($model, 'sp_click_id') ?>

    <?php // echo $form->field($model, 'sp_timezone') ?>

    <?php // echo $form->field($model, 'sp_geo_country') ?>

    <?php // echo $form->field($model, 'sp_retailcrm_id') ?>

    <?php // echo $form->field($model, 'sp_operator_comment_two') ?>

    <?php // echo $form->field($model, 'repeat_order') ?>

    <?php // echo $form->field($model, 'language_landing') ?>

    <?php // echo $form->field($model, 'order_processing_date') ?>

    <?php // echo $form->field($model, 'doubles') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'payment_currency') ?>

    <?php // echo $form->field($model, 'address_note') ?>

    <?php // echo $form->field($model, 'sp_email') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'sp_cross_sale') ?>

    <?php // echo $form->field($model, 'sp_gender') ?>

    <?php // echo $form->field($model, 'sp_age') ?>

    <?php // echo $form->field($model, 'real_mobile_phone') ?>

    <?php // echo $form->field($model, 'organization_sender') ?>

    <?php // echo $form->field($model, 'fact_payment') ?>

    <?php // echo $form->field($model, 'extcallcenter_id') ?>

    <?php // echo $form->field($model, 'last_update_status') ?>

    <?php // echo $form->field($model, 'term_of_dialer') ?>

    <?php // echo $form->field($model, 'type_shipment') ?>

    <?php // echo $form->field($model, 'label_report') ?>

    <?php // echo $form->field($model, 'manager_control') ?>

    <?php // echo $form->field($model, 'offer_price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
