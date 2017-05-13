<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vtiger_users".
 *
 * @property integer $id
 * @property string $user_name
 * @property string $user_password
 * @property string $user_hash
 * @property string $cal_color
 * @property string $first_name
 * @property string $last_name
 * @property string $reports_to_id
 * @property string $is_admin
 * @property integer $currency_id
 * @property string $description
 * @property string $date_entered
 * @property string $date_modified
 * @property string $modified_user_id
 * @property string $title
 * @property string $department
 * @property string $phone_home
 * @property string $phone_mobile
 * @property string $phone_work
 * @property string $phone_other
 * @property string $phone_fax
 * @property string $email1
 * @property string $email2
 * @property string $secondaryemail
 * @property string $status
 * @property string $signature
 * @property string $address_street
 * @property string $address_city
 * @property string $address_state
 * @property string $address_country
 * @property string $address_postalcode
 * @property string $user_preferences
 * @property string $tz
 * @property string $holidays
 * @property string $namedays
 * @property string $workdays
 * @property integer $weekstart
 * @property string $date_format
 * @property string $hour_format
 * @property string $start_hour
 * @property string $end_hour
 * @property string $activity_view
 * @property string $lead_view
 * @property string $imagename
 * @property integer $deleted
 * @property string $confirm_password
 * @property string $internal_mailer
 * @property string $reminder_interval
 * @property string $reminder_next_time
 * @property string $crypt_type
 * @property string $accesskey
 * @property string $theme
 * @property string $language
 * @property string $time_zone
 * @property string $currency_grouping_pattern
 * @property string $currency_decimal_separator
 * @property string $currency_grouping_separator
 * @property string $currency_symbol_placement
 * @property string $phone_crm_extension
 * @property string $no_of_currency_decimals
 * @property string $truncate_trailing_zeros
 * @property string $dayoftheweek
 * @property string $callduration
 * @property string $othereventduration
 * @property string $calendarsharedtype
 * @property string $default_record_view
 * @property string $leftpanelhide
 * @property string $rowheight
 * @property string $defaulteventstatus
 * @property string $defaultactivitytype
 * @property integer $hidecompletedevents
 * @property string $is_owner
 * @property string $sp_skype
 * @property string $sp_work_status
 * @property string $user_telephony_server
 * @property integer $sp_max_call_day_new_orders
 * @property string $user_department
 * @property integer $user_department_group
 * @property integer $max_new_orders
 *
 * @property VtigerSpCallNewOrders[] $vtigerSpCallNewOrders
 * @property VtigerSpUsersActivity[] $vtigerSpUsersActivities
 */
class VtigerUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtiger_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id', 'weekstart', 'deleted', 'hidecompletedevents', 'sp_max_call_day_new_orders', 'user_department_group', 'max_new_orders'], 'integer'],
            [['description', 'signature', 'user_preferences'], 'string'],
            [['date_entered', 'date_modified'], 'safe'],
            [['user_name', 'sp_work_status', 'user_telephony_server', 'user_department'], 'string', 'max' => 255],
            [['user_password', 'date_format', 'activity_view', 'lead_view', 'time_zone'], 'string', 'max' => 200],
            [['user_hash'], 'string', 'max' => 32],
            [['cal_color', 'status', 'address_country'], 'string', 'max' => 25],
            [['first_name', 'last_name', 'tz', 'workdays', 'hour_format', 'start_hour', 'end_hour'], 'string', 'max' => 30],
            [['reports_to_id', 'modified_user_id', 'accesskey', 'language'], 'string', 'max' => 36],
            [['is_admin', 'internal_mailer', 'truncate_trailing_zeros', 'leftpanelhide'], 'string', 'max' => 3],
            [['title', 'department', 'phone_home', 'phone_mobile', 'phone_work', 'phone_other', 'phone_fax', 'defaulteventstatus', 'defaultactivitytype'], 'string', 'max' => 50],
            [['email1', 'email2', 'secondaryemail', 'address_city', 'address_state', 'reminder_interval', 'reminder_next_time', 'theme', 'currency_grouping_pattern', 'phone_crm_extension', 'dayoftheweek', 'callduration', 'othereventduration', 'calendarsharedtype'], 'string', 'max' => 100],
            [['address_street'], 'string', 'max' => 150],
            [['address_postalcode'], 'string', 'max' => 9],
            [['holidays', 'namedays'], 'string', 'max' => 60],
            [['imagename', 'sp_skype'], 'string', 'max' => 250],
            [['confirm_password'], 'string', 'max' => 300],
            [['crypt_type', 'currency_symbol_placement'], 'string', 'max' => 20],
            [['currency_decimal_separator', 'currency_grouping_separator', 'no_of_currency_decimals'], 'string', 'max' => 2],
            [['default_record_view', 'rowheight'], 'string', 'max' => 10],
            [['is_owner'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'user_password' => 'User Password',
            'user_hash' => 'User Hash',
            'cal_color' => 'Cal Color',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'reports_to_id' => 'Reports To ID',
            'is_admin' => 'Is Admin',
            'currency_id' => 'Currency ID',
            'description' => 'Description',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
            'modified_user_id' => 'Modified User ID',
            'title' => 'Title',
            'department' => 'Department',
            'phone_home' => 'Phone Home',
            'phone_mobile' => 'Phone Mobile',
            'phone_work' => 'Phone Work',
            'phone_other' => 'Phone Other',
            'phone_fax' => 'Phone Fax',
            'email1' => 'Email1',
            'email2' => 'Email2',
            'secondaryemail' => 'Secondaryemail',
            'status' => 'Status',
            'signature' => 'Signature',
            'address_street' => 'Address Street',
            'address_city' => 'Address City',
            'address_state' => 'Address State',
            'address_country' => 'Address Country',
            'address_postalcode' => 'Address Postalcode',
            'user_preferences' => 'User Preferences',
            'tz' => 'Tz',
            'holidays' => 'Holidays',
            'namedays' => 'Namedays',
            'workdays' => 'Workdays',
            'weekstart' => 'Weekstart',
            'date_format' => 'Date Format',
            'hour_format' => 'Hour Format',
            'start_hour' => 'Start Hour',
            'end_hour' => 'End Hour',
            'activity_view' => 'Activity View',
            'lead_view' => 'Lead View',
            'imagename' => 'Imagename',
            'deleted' => 'Deleted',
            'confirm_password' => 'Confirm Password',
            'internal_mailer' => 'Internal Mailer',
            'reminder_interval' => 'Reminder Interval',
            'reminder_next_time' => 'Reminder Next Time',
            'crypt_type' => 'Crypt Type',
            'accesskey' => 'Accesskey',
            'theme' => 'Theme',
            'language' => 'Language',
            'time_zone' => 'Time Zone',
            'currency_grouping_pattern' => 'Currency Grouping Pattern',
            'currency_decimal_separator' => 'Currency Decimal Separator',
            'currency_grouping_separator' => 'Currency Grouping Separator',
            'currency_symbol_placement' => 'Currency Symbol Placement',
            'phone_crm_extension' => 'Phone Crm Extension',
            'no_of_currency_decimals' => 'No Of Currency Decimals',
            'truncate_trailing_zeros' => 'Truncate Trailing Zeros',
            'dayoftheweek' => 'Dayoftheweek',
            'callduration' => 'Callduration',
            'othereventduration' => 'Othereventduration',
            'calendarsharedtype' => 'Calendarsharedtype',
            'default_record_view' => 'Default Record View',
            'leftpanelhide' => 'Leftpanelhide',
            'rowheight' => 'Rowheight',
            'defaulteventstatus' => 'Defaulteventstatus',
            'defaultactivitytype' => 'Defaultactivitytype',
            'hidecompletedevents' => 'Hidecompletedevents',
            'is_owner' => 'Is Owner',
            'sp_skype' => 'Sp Skype',
            'sp_work_status' => 'Sp Work Status',
            'user_telephony_server' => 'User Telephony Server',
            'sp_max_call_day_new_orders' => 'Sp Max Call Day New Orders',
            'user_department' => 'User Department',
            'user_department_group' => 'User Department Group',
            'max_new_orders' => 'Max New Orders',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasMany(V::className(), ['user_id' => 'id']);
    }
    
    

    /**
     * @return \yii\db\ActiveQuery
     */
 
}
