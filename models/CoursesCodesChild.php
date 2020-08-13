<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;

use app\models\BaseModel;
use app\models\Courses;
use app\models\SystemCodes;


class CoursesCodesChild extends BaseModel
{
//   public $parent;
//   public $child;


   public function init()
   {
      parent::init();
   }   


   public static function tableName()
   {
      return '{{tbl_CoursesCodesChild}}';
   }  
    
   
   /**
   * @inheritdoc
   */
   public function attributeLabels()
   {
      return [
//         'id' => Yii::t('app', 'ID'),
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
               self::EVENT_BEFORE_INSERT => ['created_at',],
//               ActiveRecord::EVENT_BEFORE_DELETE => ['deleted_at',],
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
     * TBD
     *
     * @param integer Row $id value for parent entries
     * @returns model || false if $id is invalid
     */
   public static function findTagsById( $id = "" )
   {  
      if( empty( $id ) || !is_string($id) )
      {
         return false;
      }
   
      $tbl_CoursesCodesChild  = self::tableName();
      $tbl_SystemCodes        = SystemCodes::tableName();
   
      $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description' ])
         ->from(     $tbl_SystemCodes . ' sc' )
         ->innerJoin( $tbl_CoursesCodesChild . ' ccc',  'sc.id = ccc.child ' )
         ->where( 'ccc.parent =:id AND sc.is_active =:is_active' )
            ->addParams([ ':id' => $id, 'is_active' => self::STATUS_ACTIVE ])
         ->all();
 
      return $query_codes;
   }

   
/**
 *
 *    Relationships & Model section
 *
 **/   
   public function getCourses()
   {
      return $this->hasMany(Courses::className(), [ 'parent' => 'id' ] );
   }


   public function getSystemCodes()
   {
      return $this->hasMany(SystemCodes::className(), [ 'child' => 'id' ] );
   }
}