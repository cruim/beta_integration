<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vtiger_crmentity".
 *
 * @property integer $crmid
 * @property integer $smcreatorid
 * @property integer $smownerid
 * @property integer $modifiedby
 * @property string $setype
 * @property string $description
 * @property string $createdtime
 * @property string $modifiedtime
 * @property string $viewedtime
 * @property string $status
 * @property integer $version
 * @property integer $presence
 * @property integer $deleted
 * @property string $label
 *
 * @property VtigerAssets $vtigerAssets
 * @property VtigerPbxmanagerPhonelookup[] $vtigerPbxmanagerPhonelookups
 * @property VtigerSenotesrel[] $vtigerSenotesrels
 * @property VtigerService $vtigerService
 */
class VtigerCrmentity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtiger_crmentity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crmid', 'setype', 'createdtime', 'modifiedtime'], 'required'],
            [['crmid', 'smcreatorid', 'smownerid', 'modifiedby', 'version', 'presence', 'deleted'], 'integer'],
            [['description'], 'string'],
            [['createdtime', 'modifiedtime', 'viewedtime'], 'safe'],
            [['setype'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 50],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crmid' => 'Crmid',
            'smcreatorid' => 'Smcreatorid',
            'smownerid' => 'Smownerid',
            'modifiedby' => 'Modifiedby',
            'setype' => 'Setype',
            'description' => 'Description',
            'createdtime' => 'Createdtime',
            'modifiedtime' => 'Modifiedtime',
            'viewedtime' => 'Viewedtime',
            'status' => 'Status',
            'version' => 'Version',
            'presence' => 'Presence',
            'deleted' => 'Deleted',
            'label' => 'Label',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVtigerAssets()
    {
        return $this->hasOne(VtigerAssets::className(), ['assetsid' => 'crmid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVtigerPbxmanagerPhonelookups()
    {
        return $this->hasMany(VtigerPbxmanagerPhonelookup::className(), ['crmid' => 'crmid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVtigerSenotesrels()
    {
        return $this->hasMany(VtigerSenotesrel::className(), ['crmid' => 'crmid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVtigerService()
    {
        return $this->hasOne(VtigerService::className(), ['serviceid' => 'crmid']);
    }

    public function getManager()
    {
        return $this->hasOne(VtigerUsers::className(), ['id' => 'smownerid']);
    }
}
