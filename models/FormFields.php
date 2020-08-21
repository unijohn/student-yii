<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;

use app\migrations\BaseMigration;

class FormFields extends BaseModel
{
    /**
       public id;
       public type;
       public grouping;
       public grouping_name;
       public description;
       public value;
       public value_int;

       public is_active;
       public is_visible;

       public created_at;
       public updated_at;
       public deleted_at;
     **/
 
    const modelColumns =
    [
        'id', 'type', 'grouping', 'grouping_name', 'description', 'value', 'value_int',
        'is_active', 'is_visible',
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function init()
    {
        parent::init();
    }


    public static function tableName()
    {
        return BaseMigration::getTblFormFieldsName();
    }
    
   
    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return
        [
            'id'            => Yii::t('app', 'ID'),
        
            'type'          => Yii::t('app', 'Type'),
            'grouping'      => Yii::t('app', 'Group Id'),
            'grouping_name' => Yii::t('app', 'Group Name'),
            'description'   => Yii::t('app', 'Description'),
            'value'         => Yii::t('app', 'Value (Number)'),
            'value_int'     => Yii::t('app', 'Value (String)'),
            
            'is_active'     => Yii::t('app', 'Is Active'),
            'is_visible'    => Yii::t('app', 'Is Visible'),
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
        $scenarios[self::SCENARIO_INSERT] = [ 'type', 'grouping', 'grouping_name', 'description', 'is_active', 'is_visible', 'created_at', ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'type', 'grouping', 'grouping_name', 'description', 'is_active', 'is_visible', 'updated_at', ];
   
        return $scenarios;
    }


    /**
    * @inheritdoc
    */
    public function rules()
    {
        return
        [
            ['is_active', 'default', 'value'    => self::STATUS_ACTIVE ],
            ['is_active', 'filter', 'filter'    => 'intval' ],
            ['is_active', 'default', 'min'      => self::STATUS_ACTIVE_MIN ],
            ['is_active', 'default', 'max'      => self::STATUS_ACTIVE_MAX ],
            
            ['is_visible', 'default', 'value'   => self::STATUS_VISIBLE ],
            ['is_visible', 'filter',  'filter'  => 'intval' ],
            ['is_visible', 'default', 'min'     => self::STATUS_VISIBLE_MIN ],
            ['is_visible', 'default', 'max'     => self::STATUS_VISIBLE_MAX ],

            ['type', 'default', 'value'   => self::TYPE_FIELD_SELECT ],
            ['type', 'filter',  'filter'  => 'intval' ],
            ['type', 'default', 'min'     => self::TYPE_FIELD_MIN ],
            ['type', 'default', 'max'     => self::TYPE_FIELD_MAX ],
            
            ['grouping', 'default', 'value'   => self::TYPE_ITEM_CITIZEN_OTHER ],
            ['grouping', 'filter',  'filter'  => 'intval' ],
            ['grouping', 'default', 'min'     => self::TYPE_ITEM_MIN ],
            ['grouping', 'default', 'max'     => self::TYPE_ITEM_MAX ],

            [
                [
                   'type', 'grouping', 'grouping_name', 'description', 'is_active', 'is_visible', 'updated_at'
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
    public static function existsField($id = '')
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(*) FROM ' . self::tableName() . ' WHERE uuid =:uuid ',
            [':id' => $id]
        )->queryScalar();
        
        return ($count == 1 ? true : false);
    }

//GH Test - 2020-003

    /**
     * Determining if this entry already exists in the system by field properties
     *
     * @return (TBD)
     */
    public static function existsFieldByProperties($type = -1, $grouping = -1, $grouping_name = '')
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(*) FROM ' . self::tableName() . ' WHERE type =:type AND grouping =: grouping AND grouping_name =: $grouping_name ',
            [
                ':type '            => $type,
                ':grouping'         => $grouping,
                ':grouping_name'    => $grouping_name
            ]
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
