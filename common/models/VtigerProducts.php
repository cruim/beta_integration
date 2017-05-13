<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vtiger_products".
 *
 * @property integer $productid
 * @property string $product_no
 * @property string $productname
 * @property string $productcode
 * @property string $productcategory
 * @property string $manufacturer
 * @property string $qty_per_unit
 * @property string $unit_price
 * @property string $weight
 * @property integer $pack_size
 * @property string $sales_start_date
 * @property string $sales_end_date
 * @property string $start_date
 * @property string $expiry_date
 * @property integer $cost_factor
 * @property string $commissionrate
 * @property string $commissionmethod
 * @property integer $discontinued
 * @property string $usageunit
 * @property integer $reorderlevel
 * @property string $website
 * @property string $taxclass
 * @property string $mfr_part_no
 * @property string $vendor_part_no
 * @property string $serialno
 * @property string $qtyinstock
 * @property string $productsheet
 * @property integer $qtyindemand
 * @property string $glacct
 * @property integer $vendor_id
 * @property string $imagename
 * @property integer $currency_id
 * @property string $manuf_country
 * @property string $customs_id
 * @property string $manuf_country_code
 * @property string $unit_code
 * @property string $one_s_id
 * @property string $sp_product_offer
 * @property string $sp_vendor_code
 * @property string $sp_cost_price
 * @property string $sp_stock_id
 * @property string $sp_name_for_ukraine
 * @property string $sp_cost_for_ukraine
 * @property string $sp_name_for_kz
 * @property string $sp_cost_for_kz
 * @property string $sp_name_for_russia
 * @property string $sp_cost_for_russia
 */
class VtigerProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtiger_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productid', 'product_no'], 'required'],
            [['productid', 'pack_size', 'cost_factor', 'discontinued', 'reorderlevel', 'qtyindemand', 'vendor_id', 'currency_id'], 'integer'],
            [['qty_per_unit', 'unit_price', 'weight', 'commissionrate', 'qtyinstock'], 'number'],
            [['sales_start_date', 'sales_end_date', 'start_date', 'expiry_date'], 'safe'],
            [['imagename'], 'string'],
            [['product_no', 'productname', 'website', 'manuf_country', 'customs_id', 'manuf_country_code', 'unit_code'], 'string', 'max' => 100],
            [['productcode'], 'string', 'max' => 40],
            [['productcategory', 'manufacturer', 'usageunit', 'taxclass', 'mfr_part_no', 'vendor_part_no', 'serialno', 'productsheet', 'glacct'], 'string', 'max' => 200],
            [['commissionmethod'], 'string', 'max' => 50],
            [['one_s_id', 'sp_product_offer', 'sp_vendor_code', 'sp_cost_price', 'sp_stock_id', 'sp_name_for_ukraine', 'sp_cost_for_ukraine', 'sp_name_for_kz', 'sp_cost_for_kz', 'sp_name_for_russia', 'sp_cost_for_russia'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productid' => 'Productid',
            'product_no' => 'Product No',
            'productname' => 'Productname',
            'productcode' => 'Productcode',
            'productcategory' => 'Productcategory',
            'manufacturer' => 'Manufacturer',
            'qty_per_unit' => 'Qty Per Unit',
            'unit_price' => 'Unit Price',
            'weight' => 'Weight',
            'pack_size' => 'Pack Size',
            'sales_start_date' => 'Sales Start Date',
            'sales_end_date' => 'Sales End Date',
            'start_date' => 'Start Date',
            'expiry_date' => 'Expiry Date',
            'cost_factor' => 'Cost Factor',
            'commissionrate' => 'Commissionrate',
            'commissionmethod' => 'Commissionmethod',
            'discontinued' => 'Discontinued',
            'usageunit' => 'Usageunit',
            'reorderlevel' => 'Reorderlevel',
            'website' => 'Website',
            'taxclass' => 'Taxclass',
            'mfr_part_no' => 'Mfr Part No',
            'vendor_part_no' => 'Vendor Part No',
            'serialno' => 'Serialno',
            'qtyinstock' => 'Qtyinstock',
            'productsheet' => 'Productsheet',
            'qtyindemand' => 'Qtyindemand',
            'glacct' => 'Glacct',
            'vendor_id' => 'Vendor ID',
            'imagename' => 'Imagename',
            'currency_id' => 'Currency ID',
            'manuf_country' => 'Manuf Country',
            'customs_id' => 'Customs ID',
            'manuf_country_code' => 'Manuf Country Code',
            'unit_code' => 'Unit Code',
            'one_s_id' => 'One S ID',
            'sp_product_offer' => 'Sp Product Offer',
            'sp_vendor_code' => 'Sp Vendor Code',
            'sp_cost_price' => 'Sp Cost Price',
            'sp_stock_id' => 'Sp Stock ID',
            'sp_name_for_ukraine' => 'Sp Name For Ukraine',
            'sp_cost_for_ukraine' => 'Sp Cost For Ukraine',
            'sp_name_for_kz' => 'Sp Name For Kz',
            'sp_cost_for_kz' => 'Sp Cost For Kz',
            'sp_name_for_russia' => 'Sp Name For Russia',
            'sp_cost_for_russia' => 'Sp Cost For Russia',
        ];
    }
}
