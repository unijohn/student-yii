<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;

use app\models\BaseModel;


class Courses extends BaseModel
{  

/**
   public $id;
   public $subject_area;
   public $course_number;
   public $section_number;
   public $is_active;
   public $is_hidden;   
   public $created_at;
   public $updated_at;
   public $deleted_at;   
 **/


   public function init()
   {
      parent::init();
   }   


   public static function tableName()
   {
      return '{{tbl_Courses}}';
   }    
    
   
   /**
   * @inheritdoc
   */
   public function attributeLabels()
   {
   
      return [
//         'id' => Yii::t('app', 'ID'),

         'subject_area'    => Yii::t('app','Subject' ),
         'course_number'   => Yii::t('app','Course' ),         
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
      return [
         'timeStampBehavior' => [
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
      $scenarios[self::SCENARIO_INSERT] = [ 'subject_area', 'course_number', 'section_number', 'is_active', 'is_hidden' ];
      $scenarios[self::SCENARIO_UPDATE] = [ 'subject_area', 'course_number', 'section_number', 'is_active', 'is_hidden' ];
   
      return $scenarios;
   }


   /**
   * @inheritdoc
   */
   public function rules()
   {
      return [
         ['is_active', 'default', 'value'    => self::STATUS_ACTIVE        ],
         ['is_active', 'integer', 'min'      => self::STATUS_INACTIVE      ],
         ['is_active', 'filter',  'filter'   => 'intval'                   ],
         ['is_active', 'integer', 'max'      => self::STATUS_ACTIVE_MAX    ],

         ['is_hidden', 'default', 'value'    => self::STATUS_VISIBLE       ],
         ['is_hidden', 'integer', 'min'      => self::STATUS_HIDDEN        ],        
         ['is_hidden', 'filter',  'filter'   => 'intval'                   ],
         ['is_hidden', 'integer', 'max'      => self::STATUS_VISIBLE_MAX   ],
         
         [
            [
               'subject_area', 'course_number', 'section_number', 'is_active', 'is_hidden'
            ], 
            'required', 'on' => self::SCENARIO_UPDATE 
         ],
      ];
   }


   /**
    * Determining if this course already exists in the system
    *
    * @return (TBD)
    */
   public static function existsCourse($id)
   {        
      $query_courses = (new \yii\db\Query())
         ->select([ 'id', 'subject_area', 'course_number', 'section_number', 'created_at', 'updated_at' ])
         ->from( self::tableName() )
         ->where( 'id=:id ' )
            ->addParams([
               ':id' => $id, 
            ])
         ->limit(1);     
     
      foreach( $query_courses->each() as $course_row )
      {
         return new static( $course_row );
      }
 
      return null;            
   }   
   
/**
 *
 *    Relationships & Model section
 *
 **/   
}