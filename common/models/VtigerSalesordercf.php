<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vtiger_salesordercf".
 *
 * @property integer $salesorderid
 * @property string $cf_1070
 * @property string $cf_1207
 * @property string $cf_1209
 * @property string $cf_1361
 * @property string $cf_1363
 * @property string $cf_1365
 * @property string $cf_1367
 * @property string $cf_1387
 * @property string $cf_1396
 * @property string $cf_1398
 * @property string $cf_1452
 * @property string $cf_1454
 * @property string $cf_1464
 * @property string $cf_1490
 * @property string $cf_1492
 * @property string $cf_1496
 * @property string $cf_1498
 * @property string $cf_1600
 * @property string $cf_1606
 */
class VtigerSalesordercf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtiger_salesordercf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesorderid'], 'required'],
            [['salesorderid'], 'integer'],
            [['cf_1070', 'cf_1365', 'cf_1492'], 'string'],
            [['cf_1452'], 'safe'],
            [['cf_1207', 'cf_1209', 'cf_1363', 'cf_1367', 'cf_1387', 'cf_1398', 'cf_1454', 'cf_1464', 'cf_1490', 'cf_1496', 'cf_1498', 'cf_1600', 'cf_1606'], 'string', 'max' => 255],
            [['cf_1361'], 'string', 'max' => 50],
            [['cf_1396'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salesorderid' => 'Salesorderid',
            'cf_1070' => 'Cf 1070',
            'cf_1207' => 'Cf 1207',
            'cf_1209' => 'Cf 1209',
            'cf_1361' => 'Cf 1361',
            'cf_1363' => 'Cf 1363',
            'cf_1365' => 'Cf 1365',
            'cf_1367' => 'Cf 1367',
            'cf_1387' => 'Cf 1387',
            'cf_1396' => 'Cf 1396',
            'cf_1398' => 'Cf 1398',
            'cf_1452' => 'Cf 1452',
            'cf_1454' => 'Cf 1454',
            'cf_1464' => 'Cf 1464',
            'cf_1490' => 'Cf 1490',
            'cf_1492' => 'Cf 1492',
            'cf_1496' => 'Cf 1496',
            'cf_1498' => 'Cf 1498',
            'cf_1600' => 'Cf 1600',
            'cf_1606' => 'Cf 1606',
        ];
    }
}
