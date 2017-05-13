<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vtiger_salesorder".
 *
 * @property integer $salesorderid
 * @property string $subject
 * @property integer $potentialid
 * @property string $customerno
 * @property string $salesorder_no
 * @property string $salesorder_custom
 * @property integer $quoteid
 * @property string $vendorterms
 * @property integer $contactid
 * @property integer $vendorid
 * @property string $duedate
 * @property string $carrier
 * @property string $pending
 * @property string $type
 * @property string $adjustment
 * @property string $salescommission
 * @property string $exciseduty
 * @property string $total
 * @property string $subtotal
 * @property string $taxtype
 * @property string $discount_percent
 * @property string $discount_amount
 * @property string $s_h_amount
 * @property integer $accountid
 * @property string $terms_conditions
 * @property string $purchaseorder
 * @property string $sostatus
 * @property integer $currency_id
 * @property string $conversion_rate
 * @property integer $enable_recurring
 * @property string $one_s_id
 * @property integer $fromsite
 * @property string $pre_tax_total
 * @property integer $s_h_percent
 * @property string $spcompany
 * @property string $sp_dispatch_assigned
 * @property string $sp_delivery_assigned
 * @property string $sp_subway
 * @property string $sp_house
 * @property string $sp_flat
 * @property string $sp_housing
 * @property string $sp_porch
 * @property string $sp_floor
 * @property string $sp_delivery_service
 * @property string $sp_delivery_date
 * @property string $sp_delivery_time
 * @property string $sp_operator_comment_one
 * @property string $sp_client_comment_one
 * @property string $sp_dispatch_organization
 * @property string $sp_stock
 * @property string $sp_so_mark
 * @property string $sp_track_number
 * @property string $sp_barcode
 * @property string $sp_delivery_manager_assigned
 * @property string $sp_planned_delivery_date
 * @property string $sp_last_call_date
 * @property string $sp_departure_date
 * @property string $sp_receiving_point_date
 * @property string $sp_receiving_date
 * @property string $sp_receiving_money_date
 * @property string $sp_return_date
 * @property string $sp_return_reasons
 * @property string $sp_delivery_service_comment
 * @property string $sp_delivery_cost
 * @property string $sp_money_transaction_cost
 * @property string $sp_return_cost
 * @property string $sp_additional_consumption
 * @property string $sp_dispatch_doc_num
 * @property string $sp_money_rec_doc_num
 * @property string $sp_return_registry_num
 * @property string $sp_invoice_num
 * @property string $sp_utm_source
 * @property string $sp_utm_content
 * @property string $sp_utm_term
 * @property string $sp_net
 * @property string $sp_offer
 * @property string $sp_landing_type
 * @property string $sp_landing_url
 * @property string $sp_country
 * @property string $sp_country_currency_cost
 * @property string $sp_ip
 * @property string $sp_net_so_number
 * @property string $sp_lead_cost_db
 * @property string $sp_lead_cost_pp
 * @property string $sp_full_name
 * @property string $sp_client_mobile
 * @property string $sp_additional_phone
 * @property string $sp_contact_id
 * @property string $sp_firstname
 * @property string $sp_middle_name
 * @property string $sp_script
 * @property string $sp_objections
 * @property string $sp_product_description
 * @property string $sp_tel_codes
 * @property string $sp_document_number
 * @property string $sp_check_status_logistics
 * @property string $sp_summary_check_logisticks
 * @property string $sp_is_russian_post
 * @property string $sp_language
 * @property string $sp_utm_medium
 * @property string $sp_utm_campaign
 * @property string $sp_transaction_id
 * @property string $sp_external_id
 * @property string $sp_click_id
 * @property string $sp_timezone
 * @property string $sp_geo_country
 * @property string $sp_retailcrm_id
 * @property string $sp_operator_comment_two
 * @property string $repeat_order
 * @property string $language_landing
 * @property string $order_processing_date
 * @property string $doubles
 * @property string $area
 * @property string $payment_currency
 * @property string $address_note
 * @property string $sp_email
 * @property string $payment_status
 * @property string $sp_cross_sale
 * @property string $sp_gender
 * @property string $sp_age
 * @property string $real_mobile_phone
 * @property string $organization_sender
 * @property string $fact_payment
 * @property string $extcallcenter_id
 * @property string $last_update_status
 * @property string $term_of_dialer
 * @property string $type_shipment
 * @property string $label_report
 * @property string $manager_control
 * @property string $offer_price
 */
class VtigerSalesorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtiger_salesorder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesorderid', 'salesorder_custom'], 'required'],
            [['salesorderid', 'potentialid', 'quoteid', 'contactid', 'vendorid', 'accountid', 'currency_id', 'enable_recurring', 'fromsite', 's_h_percent'], 'integer'],
            [['duedate', 'sp_delivery_date', 'sp_planned_delivery_date', 'sp_last_call_date', 'sp_departure_date', 'sp_receiving_point_date', 'sp_receiving_date', 'sp_receiving_money_date', 'sp_return_date', 'order_processing_date', 'last_update_status'], 'safe'],
            [['adjustment', 'salescommission', 'exciseduty', 'total', 'subtotal', 'discount_percent', 'discount_amount', 's_h_amount', 'conversion_rate', 'pre_tax_total', 'sp_delivery_cost', 'sp_money_transaction_cost', 'sp_return_cost', 'sp_additional_consumption', 'sp_country_currency_cost', 'sp_lead_cost_db', 'sp_lead_cost_pp'], 'number'],
            [['terms_conditions', 'sp_delivery_service_comment', 'sp_script', 'sp_objections', 'sp_product_description', 'sp_tel_codes', 'address_note'], 'string'],
            [['subject', 'customerno', 'salesorder_no', 'vendorterms', 'type', 'sp_language'], 'string', 'max' => 100],
            [['salesorder_custom'], 'string', 'max' => 11],
            [['carrier', 'pending', 'purchaseorder', 'sostatus', 'spcompany', 'repeat_order'], 'string', 'max' => 200],
            [['taxtype'], 'string', 'max' => 25],
            [['one_s_id', 'sp_dispatch_assigned', 'sp_delivery_assigned', 'sp_subway', 'sp_house', 'sp_flat', 'sp_housing', 'sp_porch', 'sp_floor', 'sp_delivery_service', 'sp_delivery_time', 'sp_operator_comment_one', 'sp_client_comment_one', 'sp_dispatch_organization', 'sp_stock', 'sp_so_mark', 'sp_track_number', 'sp_barcode', 'sp_delivery_manager_assigned', 'sp_return_reasons', 'sp_dispatch_doc_num', 'sp_money_rec_doc_num', 'sp_return_registry_num', 'sp_invoice_num', 'sp_utm_source', 'sp_utm_content', 'sp_utm_term', 'sp_net', 'sp_offer', 'sp_landing_type', 'sp_landing_url', 'sp_country', 'sp_ip', 'sp_net_so_number', 'sp_full_name', 'sp_client_mobile', 'sp_additional_phone', 'sp_contact_id', 'sp_firstname', 'sp_middle_name', 'sp_document_number', 'sp_check_status_logistics', 'sp_summary_check_logisticks', 'sp_is_russian_post', 'sp_utm_medium', 'sp_utm_campaign', 'sp_transaction_id', 'sp_external_id', 'sp_click_id', 'sp_timezone', 'sp_geo_country', 'doubles', 'area', 'sp_email', 'sp_cross_sale', 'sp_gender', 'sp_age', 'fact_payment', 'type_shipment', 'label_report', 'manager_control', 'offer_price'], 'string', 'max' => 255],
            [['sp_retailcrm_id', 'sp_operator_comment_two', 'language_landing', 'payment_currency', 'payment_status', 'real_mobile_phone', 'organization_sender'], 'string', 'max' => 250],
            [['extcallcenter_id', 'term_of_dialer'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salesorderid' => 'Номер заказа',
            'subject' => 'Subject',
            'potentialid' => 'Potentialid',
            'customerno' => 'Customerno',
            'salesorder_no' => 'Salesorder No',
            'salesorder_custom' => 'salesorder_custom',
            'quoteid' => 'Quoteid',
            'vendorterms' => 'Vendorterms',
            'contactid' => 'Contactid',
            'vendorid' => 'Vendorid',
            'duedate' => 'Duedate',
            'carrier' => 'Carrier',
            'pending' => 'Pending',
            'type' => 'Type',
            'adjustment' => 'Adjustment',
            'salescommission' => 'Salescommission',
            'exciseduty' => 'Exciseduty',
            'total' => 'Итого',
            'subtotal' => 'Subtotal',
            'taxtype' => 'Taxtype',
            'discount_percent' => 'Discount Percent',
            'discount_amount' => 'Discount Amount',
            's_h_amount' => 'S H Amount',
            'accountid' => 'Accountid',
            'terms_conditions' => 'Terms Conditions',
            'purchaseorder' => 'Purchaseorder',
            'sostatus' => 'Sostatus',
            'currency_id' => 'Currency ID',
            'conversion_rate' => 'Conversion Rate',
            'enable_recurring' => 'Enable Recurring',
            'one_s_id' => 'One S ID',
            'fromsite' => 'Fromsite',
            'pre_tax_total' => 'Pre Tax Total',
            's_h_percent' => 'S H Percent',
            'spcompany' => 'Spcompany',
            'sp_dispatch_assigned' => 'Sp Dispatch Assigned',
            'sp_delivery_assigned' => 'Sp Delivery Assigned',
            'sp_subway' => 'Sp Subway',
            'sp_house' => 'Sp House',
            'sp_flat' => 'Sp Flat',
            'sp_housing' => 'Sp Housing',
            'sp_porch' => 'Sp Porch',
            'sp_floor' => 'Sp Floor',
            'sp_delivery_service' => 'Sp Delivery Service',
            'sp_delivery_date' => 'Sp Delivery Date',
            'sp_delivery_time' => 'Sp Delivery Time',
            'sp_operator_comment_one' => 'Sp Operator Comment One',
            'sp_client_comment_one' => 'Sp Client Comment One',
            'sp_dispatch_organization' => 'Sp Dispatch Organization',
            'sp_stock' => 'Sp Stock',
            'sp_so_mark' => 'Sp So Mark',
            'sp_track_number' => 'Sp Track Number',
            'sp_barcode' => 'Sp Barcode',
            'sp_delivery_manager_assigned' => 'Sp Delivery Manager Assigned',
            'sp_planned_delivery_date' => 'Sp Planned Delivery Date',
            'sp_last_call_date' => 'Sp Last Call Date',
            'sp_departure_date' => 'Sp Departure Date',
            'sp_receiving_point_date' => 'Sp Receiving Point Date',
            'sp_receiving_date' => 'Sp Receiving Date',
            'sp_receiving_money_date' => 'Sp Receiving Money Date',
            'sp_return_date' => 'Sp Return Date',
            'sp_return_reasons' => 'Sp Return Reasons',
            'sp_delivery_service_comment' => 'Sp Delivery Service Comment',
            'sp_delivery_cost' => 'Sp Delivery Cost',
            'sp_money_transaction_cost' => 'Sp Money Transaction Cost',
            'sp_return_cost' => 'Sp Return Cost',
            'sp_additional_consumption' => 'Sp Additional Consumption',
            'sp_dispatch_doc_num' => 'Sp Dispatch Doc Num',
            'sp_money_rec_doc_num' => 'Sp Money Rec Doc Num',
            'sp_return_registry_num' => 'Sp Return Registry Num',
            'sp_invoice_num' => 'Sp Invoice Num',
            'sp_utm_source' => 'Sp Utm Source',
            'sp_utm_content' => 'Sp Utm Content',
            'sp_utm_term' => 'Sp Utm Term',
            'sp_net' => 'Sp Net',
            'sp_offer' => 'Sp Offer',
            'sp_landing_type' => 'Sp Landing Type',
            'sp_landing_url' => 'Sp Landing Url',
            'sp_country' => 'Sp Country',
            'sp_country_currency_cost' => 'Sp Country Currency Cost',
            'sp_ip' => 'Sp Ip',
            'sp_net_so_number' => 'Sp Net So Number',
            'sp_lead_cost_db' => 'Sp Lead Cost Db',
            'sp_lead_cost_pp' => 'Sp Lead Cost Pp',
            'sp_full_name' => 'Sp Full Name',
            'sp_client_mobile' => 'Sp Client Mobile',
            'sp_additional_phone' => 'Sp Additional Phone',
            'sp_contact_id' => 'Sp Contact ID',
            'sp_firstname' => 'Sp Firstname',
            'sp_middle_name' => 'Sp Middle Name',
            'sp_script' => 'Sp Script',
            'sp_objections' => 'Sp Objections',
            'sp_product_description' => 'Sp Product Description',
            'sp_tel_codes' => 'Sp Tel Codes',
            'sp_document_number' => 'Sp Document Number',
            'sp_check_status_logistics' => 'Sp Check Status Logistics',
            'sp_summary_check_logisticks' => 'Sp Summary Check Logisticks',
            'sp_is_russian_post' => 'Sp Is Russian Post',
            'sp_language' => 'Sp Language',
            'sp_utm_medium' => 'Sp Utm Medium',
            'sp_utm_campaign' => 'Sp Utm Campaign',
            'sp_transaction_id' => 'Sp Transaction ID',
            'sp_external_id' => 'Sp External ID',
            'sp_click_id' => 'Sp Click ID',
            'sp_timezone' => 'Sp Timezone',
            'sp_geo_country' => 'Sp Geo Country',
            'sp_retailcrm_id' => 'Sp Retailcrm ID',
            'sp_operator_comment_two' => 'Sp Operator Comment Two',
            'repeat_order' => 'Repeat Order',
            'language_landing' => 'Language Landing',
            'order_processing_date' => 'Order Processing Date',
            'doubles' => 'Doubles',
            'area' => 'Area',
            'payment_currency' => 'Payment Currency',
            'address_note' => 'Address Note',
            'sp_email' => 'Sp Email',
            'payment_status' => 'Оплачен',
            'sp_cross_sale' => 'Sp Cross Sale',
            'sp_gender' => 'Sp Gender',
            'sp_age' => 'Sp Age',
            'real_mobile_phone' => 'Контактный телефон',
            'organization_sender' => 'Organization Sender',
            'fact_payment' => 'Fact Payment',
            'extcallcenter_id' => 'Extcallcenter ID',
            'last_update_status' => 'Last Update Status',
            'term_of_dialer' => 'Term Of Dialer',
            'type_shipment' => 'Type Shipment',
            'label_report' => 'Label Report',
            'manager_control' => 'Manager Control',
            'offer_price' => 'Offer Price',
        ];
    }

    public function getAddress()
    {
        return $this->hasOne(VtigerSoshipads::className(), ['soshipaddressid' => 'salesorderid']);
    }

    public function getVtigerCrmentity()
    {
        return $this->hasMany(VtigerCrmentity::className(), ['crmid' => 'salesorderid']);
    }
    
    public function getOffer()
    {
        return $this->hasOne(OfferName::className(), ['sp_offer' => 'sp_offer']);
    }

    public function getInventory()
    {
        return $this->hasMany(VtigerInventoryproductrel::className(), ['id' => 'salesorderid']);
    }

}