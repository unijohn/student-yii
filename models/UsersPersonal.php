<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;

use app\migrations\BaseMigration;

class UsersPersonal extends BaseModel
{
 
    /**
       public uuid;
       public uNbr;
       public firstNm;
       public $middleNm;         
       public lastNm;
       public salutation;
       public us_citizen;
       public citizen_other;
       public visa_type;

       public created_at;
       public updated_at;
       public deleted_at;
     **/
     
 
 
    const modelColumns =
    [
        'uuid', 'uNbr', 'firstNm', 'middleNm', 'lastNm', 'salutation', 'us_citizen', 'visa_type',
        'created_at', 'updated_at', 'deleted_at'
    ];

 

    public function init()
    {
        parent::init();
    }


    public static function tableName()
    {
        return BaseMigration::getTblUserPersonalName();
    }
    
   
    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return
        [
//          'id' => Yii::t('app', 'ID'),
        
            'uuid'          => Yii::t('app', 'UUID'),
            'uNbr'          => Yii::t('app', 'U Number'),
            'firstNm'       => Yii::t('app', 'First Name'),
            'middleNm'      => Yii::t('app', 'Middle Name'),
            'lastNm'        => Yii::t('app', 'Last Name'),
            'us_citizen'    => Yii::t('app', 'US Citizen'),
            'citizen_other' => Yii::t('app', 'Foreign Citizenship'),            
            'visa_type'     => Yii::t('app', 'Visa Type'),             
        ];
    }


    // explicitly list every field, best used when you want to make sure the changes
    // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
    public function fields()
    {
        /**
        return [
            // field name is the same as the attribute name
            'id'     => 'id',
        ];
        **/
    }


    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return
        [
            'timeStampBehavior' =>
            [
                'class' => TimestampBehavior::className(),
                'attributes' =>
                [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                    self::EVENT_BEFORE_DELETE => ['deleted_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => time(),
            ],
/**
         'softDeleteBehavior' => [
            'class' => SoftDeleteBehavior::className(),
            'softDeleteAttributeValues' =>
            [
               'isDeleted' => true
            ],

            // mutate native `delete()` method
            'replaceRegularDelete' => false
         ],
 **/
        ];
    }


    /**
    * @inheritdoc
    */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_INSERT] = [ 'uuid', 'uNbr', 'firstNm', 'lastNm', 'us_citizen', 'citizen_other', 'created_at', ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'uNbr', 'firstNm', 'lastNm', 'us_citizen', 'citizen_other', 'updated_at', ];
   
        return $scenarios;
    }


    /**
    * @inheritdoc
    */
    public function rules()
    {
        return
        [
            ['us_citizen', 'default', 'value'   => self::CITIZEN_US_YES ],
            ['us_citizen', 'integer', 'min'     => self::CITIZEN_US_NO  ],
            ['us_citizen', 'filter',  'filter'  => 'intval'             ],
            ['us_citizen', 'integer', 'max'     => self::CITIZEN_US_MAX ],
            
            ['citizen_other', 'default', 'value'   => self::CITIZEN_OTHER_NO  ],
            ['citizen_other', 'string',  'min'     => self::CITIZEN_OTHER_MIN ],
            ['citizen_other', 'string',  'max'     => self::CITIZEN_OTHER_MAX ],
            
            ['visa_type', 'default', 'value'   => self::VISA_NO  ],
            ['visa_type', 'integer', 'min'     => self::VISA_NO  ],
            ['visa_type', 'filter',  'filter'  => 'intval'       ],
            ['visa_type', 'integer', 'max'     => self::VISA_MAX ],
         
            [
                [
                   'firstNm', 'lastNm', 'us_citizen', 'citizen_other', 'visa_type'
                ],
                'required', 'on' => self::SCENARIO_UPDATE
            ],
        ];
    }


    /**
     * Determining if this entry already exists in the system
     *
     * @return (TBD)
     */
    public static function existsPersonal($uuid = '')
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(*) FROM ' . self::tableName() . ' WHERE uuid =:uuid ',
            [':uuid' => $uuid]
        )->queryScalar();
        
        return ($count == 1 ? true : false);
    }


    /**
     *
     *    Relationships & Model section
     *
     **/
    public function getUserInformation()
    {
        return $this->hasOne(User::className(), ['uuid' => 'uuid']);
    }
}
