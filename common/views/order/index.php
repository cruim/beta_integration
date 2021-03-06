<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\VtigerSalesorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vtiger Salesorders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vtiger-salesorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vtiger Salesorder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'salesorderid',
            'subject',
            'potentialid',
            'customerno',
            'salesorder_no',
            // 'salesorder_custom',
            // 'quoteid',
            // 'vendorterms',
            // 'contactid',
            // 'vendorid',
            // 'duedate',
            // 'carrier',
            // 'pending',
            // 'type',
            // 'adjustment',
            // 'salescommission',
            // 'exciseduty',
            // 'total',
            // 'subtotal',
            // 'taxtype',
            // 'discount_percent',
            // 'discount_amount',
            // 's_h_amount',
            // 'accountid',
            // 'terms_conditions:ntext',
            // 'purchaseorder',
            // 'sostatus',
            // 'currency_id',
            // 'conversion_rate',
            // 'enable_recurring',
            // 'one_s_id',
            // 'fromsite',
            // 'pre_tax_total',
            // 's_h_percent',
            // 'spcompany',
            // 'sp_dispatch_assigned',
            // 'sp_delivery_assigned',
            // 'sp_subway',
            // 'sp_house',
            // 'sp_flat',
            // 'sp_housing',
            // 'sp_porch',
            // 'sp_floor',
            // 'sp_delivery_service',
            // 'sp_delivery_date',
            // 'sp_delivery_time',
            // 'sp_operator_comment_one',
            // 'sp_client_comment_one',
            // 'sp_dispatch_organization',
            // 'sp_stock',
            // 'sp_so_mark',
            // 'sp_track_number',
            // 'sp_barcode',
            // 'sp_delivery_manager_assigned',
            // 'sp_planned_delivery_date',
            // 'sp_last_call_date',
            // 'sp_departure_date',
            // 'sp_receiving_point_date',
            // 'sp_receiving_date',
            // 'sp_receiving_money_date',
            // 'sp_return_date',
            // 'sp_return_reasons',
            // 'sp_delivery_service_comment:ntext',
            // 'sp_delivery_cost',
            // 'sp_money_transaction_cost',
            // 'sp_return_cost',
            // 'sp_additional_consumption',
            // 'sp_dispatch_doc_num',
            // 'sp_money_rec_doc_num',
            // 'sp_return_registry_num',
            // 'sp_invoice_num',
            // 'sp_utm_source',
            // 'sp_utm_content',
            // 'sp_utm_term',
            // 'sp_net',
            // 'sp_offer',
            // 'sp_landing_type',
            // 'sp_landing_url:url',
            // 'sp_country',
            // 'sp_country_currency_cost',
            // 'sp_ip',
            // 'sp_net_so_number',
            // 'sp_lead_cost_db',
            // 'sp_lead_cost_pp',
            // 'sp_full_name',
            // 'sp_client_mobile',
            // 'sp_additional_phone',
            // 'sp_contact_id',
            // 'sp_firstname',
            // 'sp_middle_name',
            // 'sp_script:ntext',
            // 'sp_objections:ntext',
            // 'sp_product_description:ntext',
            // 'sp_tel_codes:ntext',
            // 'sp_document_number',
            // 'sp_check_status_logistics',
            // 'sp_summary_check_logisticks',
            // 'sp_is_russian_post',
            // 'sp_language',
            // 'sp_utm_medium',
            // 'sp_utm_campaign',
            // 'sp_transaction_id',
            // 'sp_external_id',
            // 'sp_click_id',
            // 'sp_timezone',
            // 'sp_geo_country',
            // 'sp_retailcrm_id',
            // 'sp_operator_comment_two',
            // 'repeat_order',
            // 'language_landing',
            // 'order_processing_date',
            // 'doubles',
            // 'area',
            // 'payment_currency',
            // 'address_note:ntext',
            // 'sp_email:email',
            // 'payment_status',
            // 'sp_cross_sale',
            // 'sp_gender',
            // 'sp_age',
            // 'real_mobile_phone',
            // 'organization_sender',
            // 'fact_payment',
            // 'extcallcenter_id',
            // 'last_update_status',
            // 'term_of_dialer',
            // 'type_shipment',
            // 'label_report',
            // 'manager_control',
            // 'offer_price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
