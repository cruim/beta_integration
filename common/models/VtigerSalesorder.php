<?php

namespace common\models;

use Yii;
use XMLWriter;
use SimpleXMLElement;

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
            'sp_delivery_date' => 'Дата доставки',
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
            'repeat_order' => 'Повторный заказ',
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
            'fact_payment' => 'Оплачено',
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

    public function getIndex()
    {
        return $this->hasMany(VtigerSoshipads::className(), ['soshipaddressid' => 'salesorderid']);
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

    public function getSalesOrdercf()
    {
        return $this->hasOne(VtigerSalesordercf::className(), ['salesorderid' => 'salesorderid']);
    }

//получение списка клиентов, посылка онлайн
    public static function getClientXMLData()
    {
        $doc_number = vtigerSalesorder::getLastDocNumber();

        foreach ($doc_number as $doc)
        {
            $actual_doc_number = ($doc['doc'] + 1);
        }
        return Yii::$app->getDb()->createCommand(
            "SELECT CONCAT(salesorderid,'_',{$actual_doc_number}) as shipping_order_order_id, intermediate_beta_post.partpost_INDEX as shipping_order_zip,
            fio as shipping_order_clnt_name, real_mobile_phone as shipping_order_clnt_phone,
            intermediate_beta_post.ship_state as shipping_order_region, intermediate_beta_post.ship_city as shipping_order_city,
            intermediate_beta_post.ship_street as shipping_order_street, CONCAT('д. ',sp_house,' ',sp_housing,', кв. ',sp_flat) as shipping_order_house
            FROM integration_betapost.intermediate_beta_post
            inner join integration_betapost.index_posilka_online on intermediate_beta_post.partpost_INDEX = index_posilka_online.post_index"
        )->queryAll();
    }

//получение подробного списка заказов, посылка онлайн
    public static function getOrderXMLData()
    {
        $doc_number = vtigerSalesorder::getLastDocNumber();

        foreach ($doc_number as $doc)
        {
            $actual_doc_number = ($doc['doc'] + 1);
        }
        return Yii::$app->getDb()->createCommand(
            "select concat(intermediate_beta_post.salesorderid,'_','/',shipping_order_row_good_id) as ordrow_id,
            concat(intermediate_beta_post.salesorderid,'_',{$actual_doc_number}) as order_id,
            integration_betapost.goods_to_products.shipping_order_row_good_id as good_id, 
            round((case when (vtiger_products.unit_price = 990 and intermediate_beta_post.payment_status = 'Оплачен') then 1
when(integration_betapost.intermediate_beta_post.repeat_order in ('list','kup')) 
then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))
            when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 1)
						then ((intermediate_beta_post.total-330)/(select (sum(inventory.quantity)-1) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))

when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 0)
						then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))else 0 end),2) as price,
						round((case when (vtiger_products.unit_price = 990 and intermediate_beta_post.payment_status = 'Оплачен') then 0
when(integration_betapost.intermediate_beta_post.repeat_order in ('list','kup')) 
then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))
            when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 1)
						then ((intermediate_beta_post.total-330)/(select (sum(inventory.quantity)-1) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))

when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 0)
						then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))
						else round(vtiger_products.unit_price) end),2) 
             as clnt_price,vtiger_inventoryproductrel.quantity
            from integration_betapost.intermediate_beta_post
            inner join vtiger_salesorder as tigr on intermediate_beta_post.salesorderid = tigr.salesorderid
            inner join vtiger_inventoryproductrel on intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
            inner join vtiger_products on vtiger_inventoryproductrel.productid = vtiger_products.productid
            inner join integration_betapost.goods_to_products on vtiger_products.productid = integration_betapost.goods_to_products.productid
            inner join vtiger_soshipads on intermediate_beta_post.salesorderid = vtiger_soshipads.soshipaddressid
            inner JOIN integration_betapost.index_posilka_online on intermediate_beta_post.partpost_INDEX = integration_betapost.index_posilka_online.post_index
        order by ordrow_id desc, clnt_price desc"
        )->queryAll();
    }

    //получение списка клиентов, 1 класс
    public static function getClientXMLDataFirstClass()
    {
        $doc_number = vtigerSalesorder::getLastDocNumber();

        foreach ($doc_number as $doc)
        {
            $actual_doc_number = ($doc['doc'] + 1);
        }
        return Yii::$app->getDb()->createCommand(
            "SELECT CONCAT(salesorderid,'_',{$actual_doc_number}) as shipping_order_order_id, intermediate_beta_post.partpost_INDEX as shipping_order_zip,
            fio as shipping_order_clnt_name, real_mobile_phone as shipping_order_clnt_phone,
            intermediate_beta_post.ship_state as shipping_order_region, intermediate_beta_post.ship_city as shipping_order_city,
            intermediate_beta_post.ship_street as shipping_order_street, CONCAT('д. ',sp_house,' ',sp_housing,', кв. ',sp_flat) as shipping_order_house
            FROM integration_betapost.intermediate_beta_post
            left join integration_betapost.index_posilka_online on intermediate_beta_post.partpost_INDEX = index_posilka_online.post_index
            where index_posilka_online.post_index is null"
        )->queryAll();
    }

    //получение подробного списка заказов, 1 класс
    public static function getOrderXMLDataFirstClass()
    {
        $doc_number = vtigerSalesorder::getLastDocNumber();

        foreach ($doc_number as $doc)
        {
            $actual_doc_number = ($doc['doc'] + 1);
        }
        return Yii::$app->getDb()->createCommand(
            "select concat(intermediate_beta_post.salesorderid,'_','/',shipping_order_row_good_id) as ordrow_id,
            concat(intermediate_beta_post.salesorderid,'_',{$actual_doc_number}) as order_id,
            integration_betapost.goods_to_products.shipping_order_row_good_id as good_id, 
            round((case when (vtiger_products.unit_price = 990 and intermediate_beta_post.payment_status = 'Оплачен') then 1
when(integration_betapost.intermediate_beta_post.repeat_order in ('list','kup')) 
then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))
            when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 1)
						then ((intermediate_beta_post.total-330)/(select (sum(inventory.quantity)-1) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))

when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 0)
						then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))else 0 end),2) as price,
						round((case when (vtiger_products.unit_price = 990 and intermediate_beta_post.payment_status = 'Оплачен') then 0
when(integration_betapost.intermediate_beta_post.repeat_order in ('list','kup')) 
then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))
            when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 1)
						then ((intermediate_beta_post.total-330)/(select (sum(inventory.quantity)-1) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))

when (intermediate_beta_post.payment_status != 'Оплачен' and shipping_order_row_good_id != '008' and 
(CASE WHEN (SELECT COUNT(*)FROM integration_betapost.intermediate_beta_post 
			INNER JOIN vtiger_inventoryproductrel  ON intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
			INNER JOIN vtiger_products  ON vtiger_inventoryproductrel.productid = vtiger_products.productid
			WHERE intermediate_beta_post.salesorderid = tigr.salesorderid
			AND vtiger_products.productname IN ('Доставка')) > 0 THEN 1 ELSE 0 END) = 0)
						then ((intermediate_beta_post.total)/(select (sum(inventory.quantity)) from vtiger_inventoryproductrel as inventory where inventory.id = intermediate_beta_post.salesorderid))
						else round(vtiger_products.unit_price) end),2) 
             as clnt_price,vtiger_inventoryproductrel.quantity
            from integration_betapost.intermediate_beta_post
            inner join vtiger_salesorder as tigr on intermediate_beta_post.salesorderid = tigr.salesorderid
            inner join vtiger_inventoryproductrel on intermediate_beta_post.salesorderid = vtiger_inventoryproductrel.id
            inner join vtiger_products on vtiger_inventoryproductrel.productid = vtiger_products.productid
            inner join integration_betapost.goods_to_products on vtiger_products.productid = integration_betapost.goods_to_products.productid
            inner join vtiger_soshipads on intermediate_beta_post.salesorderid = vtiger_soshipads.soshipaddressid
            left JOIN integration_betapost.index_posilka_online on intermediate_beta_post.partpost_INDEX = integration_betapost.index_posilka_online.post_index
						where integration_betapost.index_posilka_online.post_index is null
        order by ordrow_id desc, clnt_price desc"
        )->queryAll();
    }

    //получение номера последнего документа
    public static function getLastDocNumber()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT max(shipping_doc_id) as doc
            FROM integration_betapost.`shipping_doc`"
        )->queryAll();
    }

   

    //вставка строки в shipping_doc
    public static function insertIntoShippingDoc($partner_id)
    {
        $sql =
            "insert into integration_betapost.shipping_doc
            SELECT (max(shipping_doc_id)+1) as max_id,null,null, null, null, null, null, null, null, {$partner_id}
            FROM integration_betapost.`shipping_doc`";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    //получение номера zdoc_id для xml
    public static function getZdocId()
    {
        $doc_number = vtigerSalesorder::getLastDocNumber();

        foreach ($doc_number as $doc)
        {
            $actual_doc_number = ($doc['doc'] + 1);
        }
        return Yii::$app->getDb()->createCommand(
            "SELECT concat(min(salesorderid),'-',max(salesorderid),'_',{$actual_doc_number}) as shipping_doc_zdoc_id
            FROM integration_betapost.`intermediate_beta_post`"
        )->queryAll();
    }

    //список эректильных оферов
    public static function getErectOffers()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT shipping_order_row_good_id 
            FROM integration_betapost.goods
            where is_erect = 1"
        )->queryAll();
    }

    //список обычных оферов
    public static function getNonErectOffers()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT shipping_order_row_good_id 
            FROM integration_betapost.goods
            where is_erect = 0"
        )->queryAll();
    }

    //список эликсиров оферов
    public static function getElixirOffers()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT shipping_order_row_good_id 
            FROM integration_betapost.goods
            where is_erect = 2"
        )->queryAll();
    }

    //формирование xml документа, посылка онлайн
    public static function createXMLDoc($pass, $partner_id)
    {
        $order_data = vtigerSalesorder::getOrderXMLData();
        $client_data = vtigerSalesorder::getClientXMLData();
        $doc_number = vtigerSalesorder::getLastDocNumber();
        $shipping_doc = vtigerSalesorder::getZdocId();

        foreach ($shipping_doc as $mg)
        {
            $docs = ($mg['shipping_doc_zdoc_id']);
        }

        vtigerSalesorder::insertIntoShippingDoc($partner_id);


        foreach ($doc_number as $doc)
        {
            $actual_doc_number = ($doc['doc'] + 1);
        }

        $simple_collection = vtigerSalesorder::getNonErectOffers();
        $erect_collection = vtigerSalesorder::getErectOffers();
        $elixir_collection = VtigerSalesorder::getElixirOffers();

        foreach ($simple_collection as $value)
        {
            $simple_collection_parse[] = ($value['shipping_order_row_good_id']);
        }

        foreach ($erect_collection as $value)
        {
            $erect_collection_parse[] = ($value['shipping_order_row_good_id']);
        }

        foreach ($elixir_collection as $value)
        {
            $elixir_collection_parse[] = ($value['shipping_order_row_good_id']);
        }


        $final_array = array();
        $count = 0;
        $count2 = 0;
        $count3 = 0;

        $reg = null;
        foreach ($order_data as $val)
        {
            $inter = $val['good_id'];
            $clnt_price = $val['clnt_price'];
            $ordrow_id = $val['ordrow_id'];
            $nc = strrpos($ordrow_id, "_");
            $ordrow_id = substr($ordrow_id, 0, $nc + 1) . $actual_doc_number . substr($ordrow_id, $nc + 1);
            $val['ordrow_id'] = $ordrow_id;

            if ($reg != substr_replace($val['ordrow_id'], '', -3))
            {
                $count = 0;
            }
            if ($reg != substr_replace($val['ordrow_id'], '', -3))
            {
                $count2 = 0;
            }
            if ($reg != substr_replace($val['ordrow_id'], '', -3))
            {
                $count3 = 0;
            }

            if (in_array($val['good_id'], $elixir_collection_parse) and $count == 0 and $clnt_price != 0)
            {
                $some = $val['good_id'];
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '031', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '031';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '035';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                if ($inter == "028")
                {
                    $intermediate = substr_replace($intermediate, '032', -5);
                    $val['ordrow_id'] = $intermediate . '/' . $count;

                    $val['price'] = 0;
                    $val['clnt_price'] = 0;
                    $val['good_id'] = '032';
                    $final_array[] = $val;
                }
                if ($inter == "029")
                {
                    $intermediate = substr_replace($intermediate, '033', -5);
                    $val['ordrow_id'] = $intermediate . '/' . $count;

                    $val['price'] = 0;
                    $val['clnt_price'] = 0;
                    $val['good_id'] = '033';
                    $final_array[] = $val;
                }
                if ($inter == "030")
                {
                    $intermediate = substr_replace($intermediate, '034', -5);
                    $val['ordrow_id'] = $intermediate . '/' . $count;

                    $val['price'] = 0;
                    $val['clnt_price'] = 0;
                    $val['good_id'] = '034';
                    $final_array[] = $val;
                }


                $val = $repo;
            }

            if (in_array($val['good_id'], $erect_collection_parse) and $count2 == 0 and $clnt_price != 0)
            {
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '035';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '025', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '025';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '026', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '026';
                $final_array[] = $val;

                $val = $repo;
            }
            if (in_array($val['good_id'], $simple_collection_parse) and $count3 == 0 and $clnt_price != 0)
            {
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '003', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '003';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '035';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '006', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '006';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $val = $repo;
            }

            if (in_array($val['good_id'], $erect_collection_parse) and $count == 0)
            {
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '035';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '025', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '025';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '026', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '026';
                $final_array[] = $val;

                $val = $repo;
            }
            if (in_array($val['good_id'], $simple_collection_parse) and $count == 0)
            {
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '003', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '003';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '035';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '006', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '006';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $val = $repo;
            }

            for ($i = 0; $i < $val['quantity']; $i++)
            {
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $val['ordrow_id'] = $val['ordrow_id'] . '/' . $count;
                $final_array[] = $val;
                $val['ordrow_id'] = $intermediate;
            }
            $reg = substr_replace($intermediate, '', -3);
        }


        $oXMLout = new XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->startDocument('1.0', 'UTF-8');
        $oXMLout->setIndent(true);
        $oXMLout->startElement("request");

        //$oXMLout->writeElement("request", "hello world");
        $oXMLout->writeAttribute("partner_id", $partner_id);
        $oXMLout->writeAttribute("password", $pass);
        $oXMLout->writeAttribute("request_type", "101");

        foreach ($shipping_doc as $shipping_docs)
        {
            $oXMLout->startElement("doc");
            $oXMLout->writeAttribute("doc_type", "5");
            $oXMLout->writeAttribute("zdoc_id", $shipping_docs['shipping_doc_zdoc_id']);
            $oXMLout->writeAttribute("doc_txt", "");
//
//
            foreach ($final_array as $shipping_order_row)
            {
                $oXMLout->startElement("order_row");
                $oXMLout->writeAttribute("ordrow_id", $shipping_order_row['ordrow_id']);
                $oXMLout->writeAttribute("order_id", $shipping_order_row['order_id']);
                $oXMLout->writeAttribute("good_id", $shipping_order_row['good_id']);
                $oXMLout->writeAttribute("price", $shipping_order_row['price']);
                $oXMLout->writeAttribute("clnt_price", $shipping_order_row['clnt_price']);
                $oXMLout->endElement(); //order_row
            }

            foreach ($client_data as $shipping_order)
            {
                $oXMLout->startElement("order");
                //$oXMLout->writeAttribute("dev1mail_type", "16"); // 16= Бандероль 1 класса
                $oXMLout->writeAttribute("dev1mail_type", "23"); // 23= Посылка онлайн
                $oXMLout->writeAttribute("delivery_type", "1");
                $oXMLout->writeAttribute("order_id", $shipping_order['shipping_order_order_id']);
                $oXMLout->writeAttribute("zip", $shipping_order['shipping_order_zip']);
                $oXMLout->writeAttribute("clnt_name", $shipping_order['shipping_order_clnt_name']);
                $oXMLout->writeAttribute("clnt_phone", $shipping_order['shipping_order_clnt_phone']);

                $oXMLout->startElement("struct_addr");
                $oXMLout->writeAttribute("region", $shipping_order['shipping_order_region']);
                $oXMLout->writeAttribute("city", $shipping_order['shipping_order_city']);
                $oXMLout->writeAttribute("street", $shipping_order['shipping_order_street']);
                $oXMLout->writeAttribute("house", $shipping_order['shipping_order_house']);
                $oXMLout->endElement(); //struct_addr
                $oXMLout->endElement(); //order
            }
            $oXMLout->endElement(); //doc
        }

        $oXMLout->endElement(); //request

        $oXMLout->endDocument();

        return $oXMLout->outputMemory();
    }

    //формирование xml документа для 1 класса
    public static function createXMLDocFirstClass($pass, $partner_id, $partner_id)
    {
        $order_data = vtigerSalesorder::getOrderXMLDataFirstClass();
        $client_data = vtigerSalesorder::getClientXMLDataFirstClass();
        $doc_number = vtigerSalesorder::getLastDocNumber();
        $shipping_doc = vtigerSalesorder::getZdocId();
        foreach ($shipping_doc as $mg)
        {
            $docs = ($mg['shipping_doc_zdoc_id']);
        }

        vtigerSalesorder::insertIntoShippingDoc($partner_id);


        foreach ($doc_number as $doc)
        {
            $actual_doc_number = ($doc['doc'] + 1);
        }

        $simple_collection = vtigerSalesorder::getNonErectOffers();
        $erect_collection = vtigerSalesorder::getErectOffers();
        $elixir_collection = VtigerSalesorder::getElixirOffers();
        foreach ($simple_collection as $value)
        {
            $simple_collection_parse[] = ($value['shipping_order_row_good_id']);
        }

        foreach ($erect_collection as $value)
        {
            $erect_collection_parse[] = ($value['shipping_order_row_good_id']);
        }

        foreach ($elixir_collection as $value)
        {
            $elixir_collection_parse[] = ($value['shipping_order_row_good_id']);
        }


        $final_array = array();
        $count = 0;
        $count2 = 0;
        $count3 = 0;

        $reg = null;
        foreach ($order_data as $val)
        {
            $inter = $val['good_id'];
            $clnt_price = $val['clnt_price'];
            $ordrow_id = $val['ordrow_id'];
            $nc = strrpos($ordrow_id, "_");
            $ordrow_id = substr($ordrow_id, 0, $nc + 1) . $actual_doc_number . substr($ordrow_id, $nc + 1);
            $val['ordrow_id'] = $ordrow_id;

            if ($reg != substr_replace($val['ordrow_id'], '', -3))
            {
                $count = 0;
            }
            if ($reg != substr_replace($val['ordrow_id'], '', -3))
            {
                $count2 = 0;
            }
            if ($reg != substr_replace($val['ordrow_id'], '', -3))
            {
                $count3 = 0;
            }

            if (in_array($val['good_id'], $elixir_collection_parse) and $count == 0 and $clnt_price != 0)
            {
                $some = $val['good_id'];
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '031', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '031';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '035';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                if ($inter == "028")
                {
                    $intermediate = substr_replace($intermediate, '032', -5);
                    $val['ordrow_id'] = $intermediate . '/' . $count;

                    $val['price'] = 0;
                    $val['clnt_price'] = 0;
                    $val['good_id'] = '032';
                    $final_array[] = $val;
                }
                if ($inter == "029")
                {
                    $intermediate = substr_replace($intermediate, '033', -5);
                    $val['ordrow_id'] = $intermediate . '/' . $count;

                    $val['price'] = 0;
                    $val['clnt_price'] = 0;
                    $val['good_id'] = '033';
                    $final_array[] = $val;
                }
                if ($inter == "030")
                {
                    $intermediate = substr_replace($intermediate, '034', -5);
                    $val['ordrow_id'] = $intermediate . '/' . $count;

                    $val['price'] = 0;
                    $val['clnt_price'] = 0;
                    $val['good_id'] = '034';
                    $final_array[] = $val;
                }


                $val = $repo;
            }

            if (in_array($val['good_id'], $erect_collection_parse) and $count2 == 0 and $clnt_price != 0)
            {
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '035';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '025', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '025';
                $final_array[] = $val;

                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '026', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;

                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $val['good_id'] = '026';
                $final_array[] = $val;

                $val = $repo;
            }
            if (in_array($val['good_id'], $simple_collection_parse) and $count3 == 0 and $clnt_price != 0)
            {
                $repo = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '003', -3);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '003';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '035', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '035';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $intermediate = substr_replace($intermediate, '006', -5);
                $val['ordrow_id'] = $intermediate . '/' . $count;
                $val['good_id'] = '006';
                $val['price'] = 0;
                $val['clnt_price'] = 0;
                $final_array[] = $val;
                $val = $repo;
            }

            for ($i = 0; $i < $val['quantity']; $i++)
            {
                $count++;
                $val['count'] = $count;
                $intermediate = $val['ordrow_id'];
                $val['ordrow_id'] = $val['ordrow_id'] . '/' . $count;
                $final_array[] = $val;
                $val['ordrow_id'] = $intermediate;
            }
            $reg = substr_replace($intermediate, '', -3);
        }


        $oXMLout = new XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->startDocument('1.0', 'UTF-8');
        $oXMLout->setIndent(true);
        $oXMLout->startElement("request");

        //$oXMLout->writeElement("request", "hello world");
        $oXMLout->writeAttribute("partner_id", $partner_id);
        $oXMLout->writeAttribute("password", $pass);
        $oXMLout->writeAttribute("request_type", "101");

        foreach ($shipping_doc as $shipping_docs)
        {
            $oXMLout->startElement("doc");
            $oXMLout->writeAttribute("doc_type", "5");
            $oXMLout->writeAttribute("zdoc_id", $shipping_docs['shipping_doc_zdoc_id']);
            $oXMLout->writeAttribute("doc_txt", "");
//
//
            foreach ($final_array as $shipping_order_row)
            {
                $oXMLout->startElement("order_row");
                $oXMLout->writeAttribute("ordrow_id", $shipping_order_row['ordrow_id']);
                $oXMLout->writeAttribute("order_id", $shipping_order_row['order_id']);
                $oXMLout->writeAttribute("good_id", $shipping_order_row['good_id']);
                $oXMLout->writeAttribute("price", $shipping_order_row['price']);
                $oXMLout->writeAttribute("clnt_price", $shipping_order_row['clnt_price']);
                $oXMLout->endElement(); //order_row
            }

            foreach ($client_data as $shipping_order)
            {
                $oXMLout->startElement("order");
                $oXMLout->writeAttribute("dev1mail_type", "16"); // 16= Бандероль 1 класса
//                $oXMLout->writeAttribute("dev1mail_type", "23"); // 23= Посылка онлайн
                $oXMLout->writeAttribute("delivery_type", "1");
                $oXMLout->writeAttribute("order_id", $shipping_order['shipping_order_order_id']);
                $oXMLout->writeAttribute("zip", $shipping_order['shipping_order_zip']);
                $oXMLout->writeAttribute("clnt_name", $shipping_order['shipping_order_clnt_name']);
                $oXMLout->writeAttribute("clnt_phone", $shipping_order['shipping_order_clnt_phone']);

                $oXMLout->startElement("struct_addr");
                $oXMLout->writeAttribute("region", $shipping_order['shipping_order_region']);
                $oXMLout->writeAttribute("city", $shipping_order['shipping_order_city']);
                $oXMLout->writeAttribute("street", $shipping_order['shipping_order_street']);
                $oXMLout->writeAttribute("house", $shipping_order['shipping_order_house']);
                $oXMLout->endElement(); //struct_addr
                $oXMLout->endElement(); //order
            }
            $oXMLout->endElement(); //doc
        }

        $oXMLout->endElement(); //request

        $oXMLout->endDocument();

        return $oXMLout->outputMemory();
    }


    //формирование промежуточной таблицы с корректными заказами
    public static function insertIntoIntermediateTable()
    {
        $sql = "truncate table integration_betapost.intermediate_beta_post; 
insert into integration_betapost.intermediate_beta_post
select vtiger_salesorder.salesorderid, concat(sp_full_name,' ',sp_firstname,' ',sp_middle_name) as fio, total, real_mobile_phone, partpost.partpost_INDEX,
vtiger_soshipads.ship_state, vtiger_soshipads.ship_city, vtiger_soshipads.ship_street, sp_house, sp_housing, sp_flat,
concat(vtiger_soshipads.ship_code,', ',vtiger_soshipads.sp_so_country,', ',vtiger_soshipads.ship_state,', ',vtiger_soshipads.ship_city,', ',
vtiger_soshipads.ship_street, ', д.',sp_house,sp_housing,', кв.',sp_flat,', Район:',area) as full_address,
vtiger_users.last_name as manager, payment_status,vtiger_salesordercf.cf_1365 as operator_comment,
 (
  SELECT
   GROUP_CONCAT(
    DISTINCT CONCAT(
     products.productname,
     ' ',
     ROUND(
      inventoryproductrel.quantity
     ),
     ' шт.'
    ) SEPARATOR ', '
   )
FROM
   vtiger_salesorder salesorder
  LEFT JOIN vtiger_inventoryproductrel inventoryproductrel ON salesorder.salesorderid = inventoryproductrel.id
  LEFT JOIN vtiger_products products ON products.productid = inventoryproductrel.productid
  WHERE
   vtiger_salesorder.salesorderid = salesorder.salesorderid
  GROUP BY
   inventoryproductrel.id
 ) AS consist,
fact_payment,repeat_order,sp_delivery_date,null

from vtiger_salesorder
inner join vtiger_soshipads on vtiger_salesorder.salesorderid=vtiger_soshipads.soshipaddressid
left join integration_betapost.partpost on vtiger_soshipads.ship_code=integration_betapost.partpost.partpost_INDEX 
inner join vtiger_crmentity on vtiger_salesorder.salesorderid = vtiger_crmentity.crmid
inner join vtiger_users on vtiger_crmentity.smownerid = vtiger_users.id
inner join vtiger_salesordercf on vtiger_salesorder.salesorderid = vtiger_salesordercf.salesorderid
inner join vtiger_inventoryproductrel on vtiger_salesorder.salesorderid = vtiger_inventoryproductrel.id
inner join vtiger_products on vtiger_inventoryproductrel.productid = vtiger_products.productid
where sostatus = 'Отправлять'
and sp_delivery_service = 'Beta Post'
and integration_betapost.partpost.partpost_INDEX is not NULL
and sp_house != ''
and vtiger_soshipads.ship_street != ''
and vtiger_soshipads.ship_city != ''
and vtiger_soshipads.ship_state != ''
and total != 330
group by vtiger_salesorder.salesorderid";

        \Yii::$app->db->createCommand($sql)->execute();
    }

    //вставка в финальную таблицу
    public static function insertIntoFinalTable()
    {
        $sql = "
insert into integration_betapost.betapost_send_orders
select vtiger_salesorder.salesorderid, concat(sp_full_name,' ',sp_firstname,' ',sp_middle_name) as fio, total, real_mobile_phone, partpost.partpost_INDEX,
vtiger_soshipads.ship_state, vtiger_soshipads.ship_city, vtiger_soshipads.ship_street, sp_house, sp_housing, sp_flat,
concat(vtiger_soshipads.ship_code,', ',vtiger_soshipads.sp_so_country,', ',vtiger_soshipads.ship_state,', ',vtiger_soshipads.ship_city,', ',
vtiger_soshipads.ship_street, ', д.',sp_house,sp_housing,', кв.',sp_flat,', Район:',area) as full_address,
vtiger_users.last_name as manager, payment_status,vtiger_salesordercf.cf_1365 as operator_comment,
 (
  SELECT
   GROUP_CONCAT(
    DISTINCT CONCAT(
     products.productname,
     ' ',
     ROUND(
      inventoryproductrel.quantity
     ),
     ' шт.'
    ) SEPARATOR ', '
   )
FROM
   vtiger_salesorder salesorder
  LEFT JOIN vtiger_inventoryproductrel inventoryproductrel ON salesorder.salesorderid = inventoryproductrel.id
  LEFT JOIN vtiger_products products ON products.productid = inventoryproductrel.productid
  WHERE
   vtiger_salesorder.salesorderid = salesorder.salesorderid
  GROUP BY
   inventoryproductrel.id
 ) AS consist,
fact_payment,repeat_order,sp_delivery_date

from vtiger_salesorder
inner join vtiger_soshipads on vtiger_salesorder.salesorderid=vtiger_soshipads.soshipaddressid
left join integration_betapost.partpost on vtiger_soshipads.ship_code=integration_betapost.partpost.partpost_INDEX 
inner join vtiger_crmentity on vtiger_salesorder.salesorderid = vtiger_crmentity.crmid
inner join vtiger_users on vtiger_crmentity.smownerid = vtiger_users.id
inner join vtiger_salesordercf on vtiger_salesorder.salesorderid = vtiger_salesordercf.salesorderid
inner join vtiger_inventoryproductrel on vtiger_salesorder.salesorderid = vtiger_inventoryproductrel.id
inner join vtiger_products on vtiger_inventoryproductrel.productid = vtiger_products.productid
where sostatus = 'Отправлять'
and sp_delivery_service = 'Beta Post'
and integration_betapost.partpost.partpost_INDEX is not NULL
and sp_house != ''
and vtiger_soshipads.ship_street != ''
and vtiger_soshipads.ship_city != ''
and vtiger_soshipads.ship_state != ''
and total != 330
group by vtiger_salesorder.salesorderid";

        \Yii::$app->db->createCommand($sql)->execute();
    }

    //формирование грида для "посылка онлайн"
    public static function getPostOnlineOrders()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT * 
            FROM integration_betapost.`intermediate_beta_post`
            INNER JOIN integration_betapost.index_posilka_online on integration_betapost.intermediate_beta_post.partpost_INDEX = integration_betapost.index_posilka_online.post_index"
        )->queryAll();
    }

    //формирование грида для "1 класс"
    public static function getFirstClassOrders()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT * 
            FROM integration_betapost.`intermediate_beta_post`
            LEFT JOIN integration_betapost.index_posilka_online on intermediate_beta_post.partpost_INDEX = integration_betapost.index_posilka_online.post_index
            where integration_betapost.index_posilka_online.post_index is null"
        )->queryAll();
    }

    public static function getLkData()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT * 
            FROM integration_betapost.`accounts` 
            WHERE `accounts_lk` = '868'"
        )->queryAll();
    }

    public function getTestData()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT salesorderid 
            FROM integration_betapost.`track_and_status_from_beta`"
        )->queryAll();
    }

    //посылка сформированного xml файла
    public static function sendXMLData($xml, $accounts_url)
    {
        $o_Curl = curl_init();

        $header = array(
            'Content-Type: text/xml'
        , 'Content-Length: ' . strlen($xml)
        , 'Connection: close'
        );

        curl_setopt($o_Curl, CURLOPT_URL, $accounts_url);
        curl_setopt($o_Curl, CURLOPT_POST, 1);
        curl_setopt($o_Curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($o_Curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($o_Curl, CURLOPT_POSTFIELDS, $xml);

        curl_setopt($o_Curl, CURLOPT_HEADER, 0);
        curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($o_Curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($o_Curl, CURLOPT_SSL_VERIFYPEER, 0);
        $s_Response = curl_exec($o_Curl);


        
        $file = 'doRequest.log';
        $content = "";
        $content .= print_r($s_Response, 1) . chr(13) . chr(10);
        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
        return $s_Response;
    }

    //получение остатков по товарам
    public static function getRemnantsOfGoods()
    {
        $oXMLout = new XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->startDocument('1.0', 'UTF-8');
        $oXMLout->setIndent(true);
        $oXMLout->startElement("request");
        $oXMLout->writeAttribute("partner_id", "868");
        $oXMLout->writeAttribute("password", "jhi308qr");
        $oXMLout->writeAttribute("request_type", "151");

        $oXMLout->endElement(); //request

        $oXMLout->endDocument();

        $xml = $oXMLout->outputMemory();

        $file = 'request154.log';
        $content = "";
        $content .= print_r($xml, 1) . chr(13) . chr(10);
        $content .= chr(13) . chr(10);
        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

//        return $xml;

    }

    //получения списка заказов, для последующего изменения статуса на 'Отправлен'
    public static function getOrdersFromIntermediateTable()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT salesorderid 
            FROM integration_betapost.`intermediate_beta_post`"
        )->queryAll();
    }

    //проверка, вставлялись ли данные сегодня
    public static function getLastDate()
    {
        return Yii::$app->getDb()->createCommand(
            "SELECT max(DATE(add_time)) as last_date
            FROM integration_betapost.`betapost_send_orders`"
        )->queryAll();
    }

    public static function insertIntoBetaPostSendOrders()
    {
        $sql =
            "insert into integration_betapost.betapost_send_orders
            select * from integration_betapost.intermediate_beta_post";
        \Yii::$app->db->createCommand($sql)->execute();
    }
   

    
}