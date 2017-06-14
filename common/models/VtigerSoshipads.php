<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vtiger_soshipads".
 *
 * @property integer $soshipaddressid
 * @property string $ship_city
 * @property string $ship_code
 * @property string $ship_country
 * @property string $ship_state
 * @property string $ship_street
 * @property string $ship_pobox
 * @property string $sp_so_country
 */
class VtigerSoshipads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtiger_soshipads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['soshipaddressid'], 'required'],
            [['soshipaddressid'], 'integer'],
            [['ship_city', 'sp_so_country'], 'string', 'max' => 255],
            [['ship_code', 'ship_country', 'ship_pobox'], 'string', 'max' => 30],
            [['ship_state', 'ship_street'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'soshipaddressid' => 'Soshipaddressid',
            'ship_city' => 'Ship City',
            'ship_code' => 'Ship Code',
            'ship_country' => 'Ship Country',
            'ship_state' => 'Ship State',
            'ship_street' => 'Ship Street',
            'ship_pobox' => 'Ship Pobox',
            'sp_so_country' => 'Sp So Country',
        ];
    }

    public function getPartpost()
    {
        return $this->hasOne(Partpost::className(), ['partpost_INDEX' => 'ship_code']);
        
    }
    
}
