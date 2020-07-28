<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\rbac\DbManager;

use app\models\AuthAssignment;


class AuthItem extends \yii\db\ActiveRecord
{
   const TYPE_ROLE         = 1;
   const TYPE_PERMISSION   = 2;


   public $name;
   public $type;
   public $description;
   public $created_at;
   public $updated_at;


   public function init()
   {
      parent::init();
   }   


   public static function tableName()
   {
      return '{{auth_item}}';
   }  
    
   
   /**
   * @inheritdoc
   */
   public function attributeLabels()
   {
   
      return [
//         'id' => Yii::t('app', 'ID'),
//         'uuid'         => Yii::t('app', 'UUID'),
//         '$is_active'   => Yii::t('app', 'Account Status'),
   
//         'auth_key' => Yii::t('app', 'Published'),
//         'access_token' => Yii::t('app', 'Title'),
//         'Description' => Yii::t('app', 'Description'),
//         'Content' => Yii::t('app', 'Content'),
//         'Format' => Yii::t('app', 'Format'),
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
      
         // field name is "email", the corresponding attribute name is "email_address"
         'uuid'   => 'uuid',
   
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

   
   public static function findbyRoles()
   {
      return AuthItem::find()
         ->where(['type' => AuthItem::TYPE_ROLE ])
         ->all();
   }

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
   
   
/**
 *
 *    Relationships & Model section
 *
 **/   

   public function getAssignments()
   {
      return $this->hasMany(AuthAssignment::className(), [ 'item_name' => 'name' ] );
   }
}