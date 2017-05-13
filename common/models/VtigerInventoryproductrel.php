<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vtiger_inventoryproductrel".
 *
 * @property integer $id
 * @property integer $productid
 * @property integer $sequence_no
 * @property string $quantity
 * @property string $listprice
 * @property string $discount_percent
 * @property string $discount_amount
 * @property string $comment
 * @property string $description
 * @property integer $incrementondel
 * @property integer $lineitem_id
 * @property string $tax1
 * @property string $tax2
 * @property string $tax3
 * @property string $ws_control_timestamp
 */
class VtigerInventoryproductrel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtiger_inventoryproductrel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'productid', 'sequence_no', 'incrementondel'], 'integer'],
            [['quantity', 'listprice', 'discount_percent', 'discount_amount', 'tax1', 'tax2', 'tax3'], 'number'],
            [['description'], 'string'],
            [['comment'], 'string', 'max' => 500],
            [['ws_control_timestamp'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'productid' => 'Productid',
            'sequence_no' => 'Sequence No',
            'quantity' => 'Quantity',
            'listprice' => 'Listprice',
            'discount_percent' => 'Discount Percent',
            'discount_amount' => 'Discount Amount',
            'comment' => 'Comment',
            'description' => 'Description',
            'incrementondel' => 'Incrementondel',
            'lineitem_id' => 'Lineitem ID',
            'tax1' => 'Tax1',
            'tax2' => 'Tax2',
            'tax3' => 'Tax3',
            'ws_control_timestamp' => 'Ws Control Timestamp',
        ];
    }

    public function getProducts()
    {
        return $this->hasOne(VtigerProducts::className(), ['productid' => 'productid']);
    }
}
