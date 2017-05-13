<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "integration_betapost.offer_name".
 *
 * @property integer $id
 * @property string $sp_offer
 * @property string $name
 */
class OfferName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integration_betapost.offer_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sp_offer', 'name'], 'required'],
            [['sp_offer', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sp_offer' => 'Sp Offer',
            'name' => 'Name',
        ];
    }
}
