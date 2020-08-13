<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\rbac\DbManager;

use app\models\BaseModel;
use app\models\AuthItem;
use app\models\User;


class AuthAssignment extends BaseModel
{
//   public $item_name;
//   public $user_id;


   public function init()
   {
      parent::init();
   }   


   public static function tableName()
   {
      return '{{auth_assignment}}';
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


   public function rules()
   {
      return [
//         [['uuid', 'name', 'is_active', 'auth_key', 'access_token', 'created_at'], 'required' ],
      ];
   }
   
   
   
/**
 *
 *    Relationships & Model section
 *
 **/   
   public function getUsers()
   {
      return $this->hasMany(User::className(), [ 'id' => 'user_id' ] );
   } 


   public function getRoles()
   {
      return $this->hasMany(AuthItem::className(), [ 'name' => 'item_name' ] );
   }       
}
