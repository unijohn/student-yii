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
        
            'form_field'    => Yii::t('app', 'Form Field Type'),
            'type'          => Yii::t('app', 'Data Type'),
            'type_str'      => Yii::t('app', 'Data Type (Str)'),
            'description'   => Yii::t('app', 'Description'),
            'value'         => Yii::t('app', 'Value'),
            'value_str'     => Yii::t('app', 'Value (Str)'),
            
            'is_active'     => Yii::t('app', 'Is Active'),
            'is_visible'    => Yii::t('app', 'Is Visible'),
            
            'created_at'    => Yii::t('app', 'Created'),
            'updated_at'    => Yii::t('app', 'Updated'),
            'deleted_at'    => Yii::t('app', 'Deleted'),
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
                    'type' // multiple lists varying by 'categoryId'
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
        $scenarios[self::SCENARIO_INSERT] = [ 'form_field', 'type', 'type_str', 'description', 'value', 'value_str', 'is_active', 'is_visible', 'order_by', 'created_at', ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'form_field', 'type', 'type_str', 'description', 'value', 'value_str', 'is_active', 'is_visible', 'order_by', ];
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
                'type',   'number', 'min' => self::TYPE_ITEM_MIN,      'max' => self::TYPE_ITEM_MAX,
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
                'type_str',     'string', 'length' => [0, 64],
            ],
            [
                'description',  'string', 'length' => [0, 64],
            ],
            [
                'value_str',    'string', 'length' => [0, 64],
            ],

            [
                [
                   'form_field', 'type', 'type_str', 'description', 'is_active', 'order_by', 'is_visible', 'updated_at'
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
    public static function findFieldByProperties($type = -1, $value_str = '', $value = '', $limit_one = true)
    {
        $tbl_formFields = FormFields::tableName();
   
        $query_fields = ( new \yii\db\Query() )
         ->select([  'ff.id', 'ff.form_field', 'ff.type', 'ff.type_str', 'ff.value', 'ff.value_int', 'ff.is_active', 'ff.is_visible' ])
         ->from($tbl_formFields . ' ff')
         ->where('( ff.value_str =:value_str OR ff.value =:value) AND ff.type =:type')
            ->addParams([
                'value_str' => $value_str,
                'value'     => $value,
                'type'      => $type
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
    public static function existsFieldByProperties($form_field = -1, $type = -1, $type_str = '', $description = '', $value_str = '', $value = -1)
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
        
        if ($type > -1) {
            $andWhere = "AND type =:type ";
      
            $countSQL   .= $andWhere;
         
            $params[':type']   = $type;
        }
        
        if ($type_str !== '') {
            $andWhere = "AND type_str =:type_str ";
      
            $countSQL   .= $andWhere;
         
            $params[':type_str']   = $type_str;
        }
        
        if ($description !== '') {
            $andWhere = "AND description =:description ";
      
            $countSQL   .= $andWhere;
         
            $params[':description']   = $description;
        }

        if ($value_str !== '') {
            $andWhere = "AND value_str =:value_str ";
      
            $countSQL   .= $andWhere;
         
            $params[':value_str']   = $value_str;
        }
        
        if ($value > -1) {
            $andWhere = "AND value =:value";
      
            $countSQL   .= $andWhere;
         
            $params[':value']   = $value;
        }
   
        $count = Yii::$app->db->createCommand(
            $countSQL,
            $params
        )->queryScalar();

        /*
                self::debug( Yii::$app->db->createCommand(
                    $countSQL,
                    $params
                )->getRawSql() );
         */
        
        //self::debug( $countSQL, false );
        //self::debug( $count, true );
        
        return ($count == 1 ? true : false);
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getFieldOptions($form_field = -1, $type = -1, $type_str = "", $prompt = false)
    {
        $tbl_formFields = FormFields::tableName();
   
        $query_fields = ( new \yii\db\Query() )
            ->select([  'ff.id', 'ff.form_field', 'ff.type', 'ff.type_str', 'ff.description', 'ff.value', 'ff.value_str', 'ff.is_active', 'ff.is_visible' ])
            ->from($tbl_formFields . ' ff')
            ->where('( ff.type =:type OR ff.type_str =:type_str) AND ff.form_field =:form_field')
                ->addParams([
                    'type'          => $type,
                    'type_str'      => $type_str,
                    'form_field'    => $form_field
                ]);

               
        if (!$prompt) {
            $query_fields->andWhere([ '!=', 'value', -1 ]);
        }

        $query_fields->orderBy('ff.order_by');

//        self::debug( $query_fields->createCommand()->getRawSql(), false );

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
            ->select([  'ff.type', 'ff.type_str' ])
            ->distinct()
            ->from($tbl_formFields . ' ff')
            ->orderBy('ff.type')
            ->all();

//        self::debug( $query_fields->createCommand()->getRawSql() );

        $dropDown = [];

        $dropDown[0] = "Select Type";

        foreach ($query_fields as $row) {
            $dropDown[$row['type']] = $row['type_str'];
        }
        
        return $dropDown;
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getSelectOptions($type= -1, $type_str = "", $prompt = false)
    {
        $results = FormFields::getFieldOptions(FormFields::TYPE_FIELD_SELECT, $type, $type_str, $prompt);
        
        $dropDown = [];
        
        foreach ($results as $row) {
            $dropDown[$row['value']] = $row['description'];
        }
        
        //self::debug( $dropDown );
               
        return $dropDown;
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getFormFieldOptions($type = -1, $type_str = "", $prompt = false)
    {
        $results = FormFields::getFieldOptions(FormFields::TYPE_FIELD_HTML_OPTS, $type, $type_str, $prompt);
        
        $dropDown = [];
        
        foreach ($results as $row) {
            $dropDown[$row['value']] = $row['description'];
        }
        
        return $dropDown;
    }


    /**
     *
     *    Relationships & Model section
     *
     **/
}
