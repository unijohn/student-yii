<?php

namespace app\models;


use Yii;
use yii\base\model;
use yii\rbac\DbManager;


class SystemCodes extends \yii\db\ActiveRecord
{
   const TYPE_PERMIT       = 1;
   const TYPE_DEPARTMENT   = 2;
   const TYPE_CAREERLEVEL  = 3;
   const TYPE_MASTERS      = 4;
   
   const STATUS_INACTIVE   = 0;
   const STATUS_ACTIVE     = 1;


   public $id;
   public $type;
   public $code;
   public $description;
   public $is_active
   public $created_at;
   public $updated_at;
   public $deleted_at;   


   public function init()
   {
      parent::init();
   }   


   public static function tableName()
   {
      return '{{tbl_SystemCodes}}';
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
     * @returns model filtered by TYPE_PERMIT
     */
   public static function findbyPermit()
   {
      return AuthItem::find()
         ->where(['type' => SystemCodes::TYPE_PERMIT ])
         ->all();
   }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_DEPARTMENT
     */
   public static function findbyDepartment()
   {
      return AuthItem::find()
         ->where(['type' => SystemCodes::TYPE_DEPARTMENT ])
         ->all();
   }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_CAREERLEVEL
     */
   public static function findbyCareerLevel()
   {
      return AuthItem::find()
         ->where(['type' => SystemCodes::TYPE_CAREERLEVEL ])
         ->all();
   }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_MASTERS
     */
   public static function findbyMasters()
   {
      return AuthItem::find()
         ->where(['type' => SystemCodes::TYPE_MASTERS ])
         ->all();
   }
   

/*
   public static function findbyUnassignedRoles( $assignedRoles = '' )
   {
      return AuthItem::find()
         ->where([ 'type' => AuthItem::TYPE_ROLE ]) 
         ->andWhere([ 'not in' , 'name', $assignedRoles ])
         ->all();         
   }   


   public static function findbyPermissions()
   {
      return AuthItem::find()
         ->where(['type' => AuthItem::TYPE_PERMISSION ])
         ->all();
   }
 */
   
   
/**
 *
 *    Relationships & Model section
 *
 **/   

/*
   public function getAssignments()
   {
      return $this->hasMany(AuthAssignment::className(), [ 'item_name' => 'name' ] );
   }
 */
}