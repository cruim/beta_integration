<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VtigerSalesorder;

/**
 * VtigerSalesorderSearch represents the model behind the search form about `common\models\VtigerSalesorder`.
 */
class VtigerSalesorderSearch extends VtigerSalesorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesorderid', 'potentialid', 'quoteid', 'contactid', 'vendorid', 'accountid', 'currency_id', 'enable_recurring', 'fromsite', 's_h_percent'], 'integer'],
            [['subject', 'customerno', 'salesorder_no', 'salesorder_custom', 'vendorterms', 'duedate', 'carrier', 'pending', 'type', 'taxtype', 'terms_conditions', 'purchaseorder', 'sostatus', 'one_s_id', 'spcompany', 'sp_dispatch_assigned', 'sp_delivery_assigned', 'sp_subway', 'sp_house', 'sp_flat', 'sp_housing', 'sp_porch', 'sp_floor', 'sp_delivery_service', 'sp_delivery_date', 'sp_delivery_time', 'sp_operator_comment_one', 'sp_client_comment_one', 'sp_dispatch_organization', 'sp_stock', 'sp_so_mark', 'sp_track_number', 'sp_barcode', 'sp_delivery_manager_assigned', 'sp_planned_delivery_date', 'sp_last_call_date', 'sp_departure_date', 'sp_receiving_point_date', 'sp_receiving_date', 'sp_receiving_money_date', 'sp_return_date', 'sp_return_reasons', 'sp_delivery_service_comment', 'sp_dispatch_doc_num', 'sp_money_rec_doc_num', 'sp_return_registry_num', 'sp_invoice_num', 'sp_utm_source', 'sp_utm_content', 'sp_utm_term', 'sp_net', 'sp_offer', 'sp_landing_type', 'sp_landing_url', 'sp_country', 'sp_ip', 'sp_net_so_number', 'sp_full_name', 'sp_client_mobile', 'sp_additional_phone', 'sp_contact_id', 'sp_firstname', 'sp_middle_name', 'sp_script', 'sp_objections', 'sp_product_description', 'sp_tel_codes', 'sp_document_number', 'sp_check_status_logistics', 'sp_summary_check_logisticks', 'sp_is_russian_post', 'sp_language', 'sp_utm_medium', 'sp_utm_campaign', 'sp_transaction_id', 'sp_external_id', 'sp_click_id', 'sp_timezone', 'sp_geo_country', 'sp_retailcrm_id', 'sp_operator_comment_two', 'repeat_order', 'language_landing', 'order_processing_date', 'doubles', 'area', 'payment_currency', 'address_note', 'sp_email', 'payment_status', 'sp_cross_sale', 'sp_gender', 'sp_age', 'real_mobile_phone', 'organization_sender', 'fact_payment', 'extcallcenter_id', 'last_update_status', 'term_of_dialer', 'type_shipment', 'label_report', 'manager_control', 'offer_price'], 'safe'],
            [['adjustment', 'salescommission', 'exciseduty', 'total', 'subtotal', 'discount_percent', 'discount_amount', 's_h_amount', 'conversion_rate', 'pre_tax_total', 'sp_delivery_cost', 'sp_money_transaction_cost', 'sp_return_cost', 'sp_additional_consumption', 'sp_country_currency_cost', 'sp_lead_cost_db', 'sp_lead_cost_pp'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VtigerSalesorder::find()
            ->andWhere(['sostatus' => "Отправлен"])
            ->joinWith('address')
            ->andWhere(['sp_delivery_service' => "Beta Post"]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'salesorderid' => $this->salesorderid,
            'potentialid' => $this->potentialid,
            'quoteid' => $this->quoteid,
            'contactid' => $this->contactid,
            'vendorid' => $this->vendorid,
            'duedate' => $this->duedate,
            'adjustment' => $this->adjustment,
            'salescommission' => $this->salescommission,
            'exciseduty' => $this->exciseduty,
            'total' => $this->total,
            'subtotal' => $this->subtotal,
            'discount_percent' => $this->discount_percent,
            'discount_amount' => $this->discount_amount,
            's_h_amount' => $this->s_h_amount,
            'accountid' => $this->accountid,
            'currency_id' => $this->currency_id,
            'conversion_rate' => $this->conversion_rate,
            'enable_recurring' => $this->enable_recurring,
            'fromsite' => $this->fromsite,
            'pre_tax_total' => $this->pre_tax_total,
            's_h_percent' => $this->s_h_percent,
            'sp_delivery_date' => $this->sp_delivery_date,
            'sp_planned_delivery_date' => $this->sp_planned_delivery_date,
            'sp_last_call_date' => $this->sp_last_call_date,
            'sp_departure_date' => $this->sp_departure_date,
            'sp_receiving_point_date' => $this->sp_receiving_point_date,
            'sp_receiving_date' => $this->sp_receiving_date,
            'sp_receiving_money_date' => $this->sp_receiving_money_date,
            'sp_return_date' => $this->sp_return_date,
            'sp_delivery_cost' => $this->sp_delivery_cost,
            'sp_money_transaction_cost' => $this->sp_money_transaction_cost,
            'sp_return_cost' => $this->sp_return_cost,
            'sp_additional_consumption' => $this->sp_additional_consumption,
            'sp_country_currency_cost' => $this->sp_country_currency_cost,
            'sp_lead_cost_db' => $this->sp_lead_cost_db,
            'sp_lead_cost_pp' => $this->sp_lead_cost_pp,
            'order_processing_date' => $this->order_processing_date,
            'last_update_status' => $this->last_update_status,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'customerno', $this->customerno])
            ->andFilterWhere(['like', 'salesorder_no', $this->salesorder_no])
            ->andFilterWhere(['like', 'salesorder_custom', $this->salesorder_custom])
            ->andFilterWhere(['like', 'vendorterms', $this->vendorterms])
            ->andFilterWhere(['like', 'carrier', $this->carrier])
            ->andFilterWhere(['like', 'pending', $this->pending])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'taxtype', $this->taxtype])
            ->andFilterWhere(['like', 'terms_conditions', $this->terms_conditions])
            ->andFilterWhere(['like', 'purchaseorder', $this->purchaseorder])
            ->andFilterWhere(['like', 'sostatus', $this->sostatus])
            ->andFilterWhere(['like', 'one_s_id', $this->one_s_id])
            ->andFilterWhere(['like', 'spcompany', $this->spcompany])
            ->andFilterWhere(['like', 'sp_dispatch_assigned', $this->sp_dispatch_assigned])
            ->andFilterWhere(['like', 'sp_delivery_assigned', $this->sp_delivery_assigned])
            ->andFilterWhere(['like', 'sp_subway', $this->sp_subway])
            ->andFilterWhere(['like', 'sp_house', $this->sp_house])
            ->andFilterWhere(['like', 'sp_flat', $this->sp_flat])
            ->andFilterWhere(['like', 'sp_housing', $this->sp_housing])
            ->andFilterWhere(['like', 'sp_porch', $this->sp_porch])
            ->andFilterWhere(['like', 'sp_floor', $this->sp_floor])
            ->andFilterWhere(['like', 'sp_delivery_service', $this->sp_delivery_service])
            ->andFilterWhere(['like', 'sp_delivery_time', $this->sp_delivery_time])
            ->andFilterWhere(['like', 'sp_operator_comment_one', $this->sp_operator_comment_one])
            ->andFilterWhere(['like', 'sp_client_comment_one', $this->sp_client_comment_one])
            ->andFilterWhere(['like', 'sp_dispatch_organization', $this->sp_dispatch_organization])
            ->andFilterWhere(['like', 'sp_stock', $this->sp_stock])
            ->andFilterWhere(['like', 'sp_so_mark', $this->sp_so_mark])
            ->andFilterWhere(['like', 'sp_track_number', $this->sp_track_number])
            ->andFilterWhere(['like', 'sp_barcode', $this->sp_barcode])
            ->andFilterWhere(['like', 'sp_delivery_manager_assigned', $this->sp_delivery_manager_assigned])
            ->andFilterWhere(['like', 'sp_return_reasons', $this->sp_return_reasons])
            ->andFilterWhere(['like', 'sp_delivery_service_comment', $this->sp_delivery_service_comment])
            ->andFilterWhere(['like', 'sp_dispatch_doc_num', $this->sp_dispatch_doc_num])
            ->andFilterWhere(['like', 'sp_money_rec_doc_num', $this->sp_money_rec_doc_num])
            ->andFilterWhere(['like', 'sp_return_registry_num', $this->sp_return_registry_num])
            ->andFilterWhere(['like', 'sp_invoice_num', $this->sp_invoice_num])
            ->andFilterWhere(['like', 'sp_utm_source', $this->sp_utm_source])
            ->andFilterWhere(['like', 'sp_utm_content', $this->sp_utm_content])
            ->andFilterWhere(['like', 'sp_utm_term', $this->sp_utm_term])
            ->andFilterWhere(['like', 'sp_net', $this->sp_net])
            ->andFilterWhere(['like', 'sp_offer', $this->sp_offer])
            ->andFilterWhere(['like', 'sp_landing_type', $this->sp_landing_type])
            ->andFilterWhere(['like', 'sp_landing_url', $this->sp_landing_url])
            ->andFilterWhere(['like', 'sp_country', $this->sp_country])
            ->andFilterWhere(['like', 'sp_ip', $this->sp_ip])
            ->andFilterWhere(['like', 'sp_net_so_number', $this->sp_net_so_number])
            ->andFilterWhere(['like', 'sp_full_name', $this->sp_full_name])
            ->andFilterWhere(['like', 'sp_client_mobile', $this->sp_client_mobile])
            ->andFilterWhere(['like', 'sp_additional_phone', $this->sp_additional_phone])
            ->andFilterWhere(['like', 'sp_contact_id', $this->sp_contact_id])
            ->andFilterWhere(['like', 'sp_firstname', $this->sp_firstname])
            ->andFilterWhere(['like', 'sp_middle_name', $this->sp_middle_name])
            ->andFilterWhere(['like', 'sp_script', $this->sp_script])
            ->andFilterWhere(['like', 'sp_objections', $this->sp_objections])
            ->andFilterWhere(['like', 'sp_product_description', $this->sp_product_description])
            ->andFilterWhere(['like', 'sp_tel_codes', $this->sp_tel_codes])
            ->andFilterWhere(['like', 'sp_document_number', $this->sp_document_number])
            ->andFilterWhere(['like', 'sp_check_status_logistics', $this->sp_check_status_logistics])
            ->andFilterWhere(['like', 'sp_summary_check_logisticks', $this->sp_summary_check_logisticks])
            ->andFilterWhere(['like', 'sp_is_russian_post', $this->sp_is_russian_post])
            ->andFilterWhere(['like', 'sp_language', $this->sp_language])
            ->andFilterWhere(['like', 'sp_utm_medium', $this->sp_utm_medium])
            ->andFilterWhere(['like', 'sp_utm_campaign', $this->sp_utm_campaign])
            ->andFilterWhere(['like', 'sp_transaction_id', $this->sp_transaction_id])
            ->andFilterWhere(['like', 'sp_external_id', $this->sp_external_id])
            ->andFilterWhere(['like', 'sp_click_id', $this->sp_click_id])
            ->andFilterWhere(['like', 'sp_timezone', $this->sp_timezone])
            ->andFilterWhere(['like', 'sp_geo_country', $this->sp_geo_country])
            ->andFilterWhere(['like', 'sp_retailcrm_id', $this->sp_retailcrm_id])
            ->andFilterWhere(['like', 'sp_operator_comment_two', $this->sp_operator_comment_two])
            ->andFilterWhere(['like', 'repeat_order', $this->repeat_order])
            ->andFilterWhere(['like', 'language_landing', $this->language_landing])
            ->andFilterWhere(['like', 'doubles', $this->doubles])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'payment_currency', $this->payment_currency])
            ->andFilterWhere(['like', 'address_note', $this->address_note])
            ->andFilterWhere(['like', 'sp_email', $this->sp_email])
            ->andFilterWhere(['like', 'payment_status', $this->payment_status])
            ->andFilterWhere(['like', 'sp_cross_sale', $this->sp_cross_sale])
            ->andFilterWhere(['like', 'sp_gender', $this->sp_gender])
            ->andFilterWhere(['like', 'sp_age', $this->sp_age])
            ->andFilterWhere(['like', 'real_mobile_phone', $this->real_mobile_phone])
            ->andFilterWhere(['like', 'organization_sender', $this->organization_sender])
            ->andFilterWhere(['like', 'fact_payment', $this->fact_payment])
            ->andFilterWhere(['like', 'extcallcenter_id', $this->extcallcenter_id])
            ->andFilterWhere(['like', 'term_of_dialer', $this->term_of_dialer])
            ->andFilterWhere(['like', 'type_shipment', $this->type_shipment])
            ->andFilterWhere(['like', 'label_report', $this->label_report])
            ->andFilterWhere(['like', 'manager_control', $this->manager_control])
            ->andFilterWhere(['like', 'offer_price', $this->offer_price]);

        return $dataProvider;
    }
}
