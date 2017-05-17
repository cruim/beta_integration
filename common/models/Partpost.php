<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partpost".
 *
 * @property string $partpost_INDEX
 * @property string $partpost_OPSNAME
 * @property string $partpost_OPSTYPE
 * @property string $partpost_OPSSUBM
 * @property string $partpost_REGION
 * @property string $partpost_AUTONOM
 * @property string $partpost_AREA
 * @property string $partpost_CITY
 * @property string $partpost_CITY_1
 * @property string $partpost_ACTDATE
 * @property string $partpost_INDEXOLD
 */
class Partpost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partpost';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partpost_INDEX'], 'required'],
            [['partpost_ACTDATE'], 'safe'],
            [['partpost_INDEX', 'partpost_OPSSUBM', 'partpost_INDEXOLD'], 'string', 'max' => 6],
            [['partpost_OPSNAME', 'partpost_REGION', 'partpost_AUTONOM', 'partpost_AREA', 'partpost_CITY', 'partpost_CITY_1'], 'string', 'max' => 60],
            [['partpost_OPSTYPE'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'partpost_INDEX' => 'Partpost  Index',
            'partpost_OPSNAME' => 'Partpost  Opsname',
            'partpost_OPSTYPE' => 'Partpost  Opstype',
            'partpost_OPSSUBM' => 'Partpost  Opssubm',
            'partpost_REGION' => 'Partpost  Region',
            'partpost_AUTONOM' => 'Partpost  Autonom',
            'partpost_AREA' => 'Partpost  Area',
            'partpost_CITY' => 'Partpost  City',
            'partpost_CITY_1' => 'Partpost  City 1',
            'partpost_ACTDATE' => 'Partpost  Actdate',
            'partpost_INDEXOLD' => 'Partpost  Indexold',
        ];
    }
}
