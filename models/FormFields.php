<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\position\PositionBehavior;  // https://github.com/yii2tech/ar-position

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
       public order_by;

       public created_at;
       public updated_at;
       public deleted_at;
     **/
 
    const modelColumns =
    [
        'id', 'type', 'grouping', 'grouping_name', 'description', 'value', 'value_int',
        'is_active', 'is_visible', 'order_by',
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
        
            'form_field'    => Yii::t('app', 'Form Field'),
            'grouping'      => Yii::t('app', 'Group Id'),
            'grouping_name' => Yii::t('app', 'Group Name'),
            'description'   => Yii::t('app', 'Description'),
            'value'         => Yii::t('app', 'Value (Str)'),
            'value_int'     => Yii::t('app', 'Value (#)'),
            
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
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'order_by',
                'groupAttributes' => [
                    'grouping' // multiple lists varying by 'categoryId'
                ],
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
        $scenarios[self::SCENARIO_INSERT] = [ 'form_field', 'grouping', 'grouping_name', 'description', 'is_active', 'is_visible', 'order_by', 'created_at', ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'form_field', 'grouping', 'grouping_name', 'description', 'is_active', 'is_visible', 'order_by', 'updated_at', ];
        $scenarios[self::SCENARIO_MOVE]   = [ 'order_by', 'updated_at', ];
   
        return $scenarios;
    }


    /**
    * @inheritdoc
    */
    public function rules()
    {
        return
        [
            [
                'is_active',  'number', 'min' => self::STATUS_ACTIVE_MIN,  'max' => self::STATUS_ACTIVE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'is_visible', 'number', 'min' => self::STATUS_VISIBLE_MIN, 'max' => self::STATUS_VISIBLE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'form_field', 'number', 'min' => self::TYPE_FIELD_MIN,     'max' => self::TYPE_FIELD_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'grouping',   'number', 'min' => self::TYPE_ITEM_MIN,      'max' => self::TYPE_ITEM_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'value', 'default', 'value' => ''
            ],
            [
                'value_int', 'default', 'value' => 0
            ],
            [
                'is_active', 'default', 'value' => self::STATUS_ACTIVE
            ],
            [
                'is_visible', 'default', 'value' => self::STATUS_VISIBLE
            ],

            [
                [
                   'form_field', 'grouping', 'grouping_name', 'description', 'is_active', 'order_by', 'is_visible', 'updated_at'
                ],
                'required', 'on' => self::SCENARIO_UPDATE
            ],
            [
                [
                   'order_by', 'updated_at'
                ],
                'required', 'on' => self::SCENARIO_MOVE
            ],            
        ];
    }


    /**
     * Find an entry in the system by field properties
     *
     * @returns (TBD)
     */
    public static function findFieldByProperties($grouping = -1, $value = '', $value_int = '', $limit_one = true)
    {
        $tbl_formFields = FormFields::tableName();
   
        $query_fields = ( new \yii\db\Query() )
         ->select([  'ff.id', 'ff.form_field', 'ff.grouping', 'ff.grouping_name', 'ff.value', 'ff.value_int', 'ff.is_active', 'ff.is_visible' ])
         ->from($tbl_formFields . ' ff')
         ->where('( ff.value =:value OR ff.value_int =:value_int) AND ff.grouping =:grouping')
            ->addParams([
                'value'     => $value,
                'value_int' => $value_int,
                'grouping'  => $grouping
            ]);
            
        if ($limit_one) {
            $query_fields = $query_fields->limit(1)->one();
        }

        return $query_fields;
    }


    /**
     * Determining if this entry already exists in the system by field properties
     *
     * @return (TBD)
     */
    public static function existsFieldByProperties($form_field = -1, $grouping = -1, $grouping_name = '', $description = '', $value = '', $value_int = -1)
    {
        $params = [];
        $tbl_formFields = FormFields::tableName();
    
        $countSQL  = "SELECT COUNT(*) " ;
        $countSQL .= "FROM " . $tbl_formFields . " WHERE id > 0 ";
        
        if ($form_field > -1) {
            $andWhere = "AND form_field =:form_field ";
      
            $countSQL   .= $andWhere;
         
            $params[':form_field']   = $form_field;
        }
        
        if ($grouping > -1) {
            $andWhere = "AND grouping =:grouping ";
      
            $countSQL   .= $andWhere;
         
            $params[':grouping']   = $grouping;
        }
        
        if ($grouping_name !== '') {
            $andWhere = "AND grouping_name =:grouping_name ";
      
            $countSQL   .= $andWhere;
         
            $params[':grouping_name']   = $grouping_name;
        }
        
        if ($description !== '') {
            $andWhere = "AND description =:description ";
      
            $countSQL   .= $andWhere;
         
            $params[':description']   = $description;
        }

        if ($value !== '') {
            $andWhere = "AND value =:value ";
      
            $countSQL   .= $andWhere;
         
            $params[':value']   = $value;
        }
        
        if ($value_int > -1) {
            $andWhere = "AND value_int =:value_int ";
      
            $countSQL   .= $andWhere;
         
            $params[':value_int']   = $value_int;
        }
   
        $count = Yii::$app->db->createCommand(
            $countSQL,
            $params
        )->queryScalar();
        
        //self::debug( $countSQL, false );
        //self::debug( $count, true );
        
        return ($count == 1 ? true : false);
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getFieldOptions($form_field = -1, $grouping = -1, $grouping_name = "", $prompt = false)
    {
        $tbl_formFields = FormFields::tableName();
   
        $query_fields = ( new \yii\db\Query() )
            ->select([  'ff.id', 'ff.form_field', 'ff.grouping', 'ff.grouping_name', 'ff.description', 'ff.value', 'ff.value_int', 'ff.is_active', 'ff.is_visible' ])
            ->from($tbl_formFields . ' ff')
            ->where('( ff.grouping =:grouping OR ff.grouping_name =:grouping_name) AND ff.form_field =:form_field')
                ->addParams([
                    'grouping'      => $grouping,
                    'grouping_name' => $grouping_name,
                    'form_field'    => $form_field
                ]);

               
        if ($prompt) {
            $query_fields->andWhere([ '!=', 'value_int', -1 ]);
        }

        $query_fields->orderBy('ff.order_by');

//       self::debug( $query_fields->createCommand()->getRawSql(), false );
            
        return $query_fields->all();
    }
    
    
    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getDistinctGroupings()
    {
        $tbl_formFields = FormFields::tableName();
   
        $query_fields = ( new \yii\db\Query() )
            ->select([  'ff.grouping', 'ff.grouping_name' ])
            ->distinct()
            ->from($tbl_formFields . ' ff')
            ->orderBy('ff.grouping')
            ->all();

//       self::debug( $query_fields->createCommand()->getRawSql() );

        $dropDown = [];

        $dropDown[0] = "Select Type";

        foreach ($query_fields as $row) {
            $dropDown[$row['grouping']] = $row['grouping_name'];
        }
        
        return $dropDown;
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getSelectOptions($grouping = -1, $grouping_name = "", $prompt = false)
    {
        $results = FormFields::getFieldOptions(FormFields::TYPE_FIELD_SELECT, $grouping, $grouping_name, $prompt);
        
        $dropDown = [];
        
        foreach ($results as $row) {
            $dropDown[$row['value_int']] = $row['description'];
        }
        
        return $dropDown;
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getFormFieldOptions($grouping = -1, $grouping_name = "", $prompt = false)
    {
        $results = FormFields::getFieldOptions(FormFields::TYPE_FIELD_NOT_SET, $grouping, $grouping_name, $prompt);
        
        $dropDown = [];
        
        foreach ($results as $row) {
            $dropDown[$row['value_int']] = $row['description'];
        }
        
        return $dropDown;
    }


    /**
     *
     *    Relationships & Model section
     *
     **/
}
