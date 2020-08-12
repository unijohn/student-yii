<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


class Courses extends ActiveRecord
{  
   const STATUS_INACTIVE   = 0;
   const STATUS_ACTIVE     = 1;

   const STATUS_HIDDEN     = 0;
   const STATUS_VISIBLE    = 1;
   
   const SUBJECT_ACCT      = "ACCT";
   const SUBJECT_BA        = "BA";
   const SUBJECT_ECON      = "ECON";
   const SUBJECT_FIR       = "FIR";
   const SUBJECT_MGMT      = "MGMT";
   const SUBJECT_MIS       = "MIS";
   const SUBJECT_MKTG      = "MKTG";
   const SUBJECT_SCMS      = "SCMS";

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
               ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
               ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],           
               ActiveRecord::EVENT_BEFORE_DELETE => ['deleted_at'],
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
   public function rules()
   {
      return [
//         [['name', 'type', ], 'required' ],
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
         ->from( Courses::tableName() )
         ->where( 'id=:id ' )
            ->addParams([
               ':id' => $id, 
            ])
         ->limit(1);     
     
      foreach( $query_courses->each() as $course_row )
      {
         return true;
      }
 
      return false;            
   }   
   
/**
 *
 *    Relationships & Model section
 *
 **/   
}