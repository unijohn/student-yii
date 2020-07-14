<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\DbManager;
use yii\web\IdentityInterface;

use yii2tech\ar\position\PositionBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

//class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
   public $id;
   public $uuid;
   public $name;
   public $is_active;
   public $auth_key;
   public $access_token;
   public $created_at;
   public $updated_at;
    
   private $_auth;
   
   public function init()
   {
      parent::init();
      $this->_auth = \Yii::$app->getAuthManager();
   }   

   public static function tableName()
   {
      return '{{tbl_Users}}';
   }


   public static function getUserTableName()
   {
      return User::tableName();
   }
   

   public static function getTempAuthAssignmentTableName()
   {
      return "{{tbl_TempAuthAssignment}}";
   }     
    
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
 
        return [
//            'id' => Yii::t('app', 'ID'),
            'uuid'         => Yii::t('app', 'UUID'),
            '$is_active'   => Yii::t('app', 'Account Status'),
            
//            'auth_key' => Yii::t('app', 'Published'),
//            'access_token' => Yii::t('app', 'Title'),
//            'Description' => Yii::t('app', 'Description'),
//            'Content' => Yii::t('app', 'Content'),
//            'Format' => Yii::t('app', 'Format'),
        ];

    }   

   // explicitly list every field, best used when you want to make sure the changes
   // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
   public function fields()
   {
      return [
         // field name is the same as the attribute name
         'id'     => 'id',
      
         // field name is "email", the corresponding attribute name is "email_address"
         'uuid'   => 'uuid',
   
      ];
   }

   public function behaviors()
   {
      return [
         'timeStampBehavior' => [
            'class' => TimestampBehavior::className(),
            'attributes' => 
            [
               ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
               ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
            ],
            // if you're using datetime instead of UNIX timestamp:
            'value' => date("Y-m-d H:i:s"),
         ],
         
         'softDeleteBehavior' => [
            'class' => SoftDeleteBehavior::className(),
            'softDeleteAttributeValues' => 
            [
               'isDeleted' => true
            ],
            
            // mutate native `delete()` method
            'replaceRegularDelete' => false
         ],         
         
         'positionBehavior' => [
            'class' => PositionBehavior::className(),
            'positionAttribute' => 'position',

/**
             'groupAttributes' => 
             [
                 'categoryId' // multiple lists varying by 'categoryId'
             ],            
 **/
         ],         
      ];
   }


   public function rules()
   {
      return [
         [['uuid'], 'string'],
         [['is_active'], 'integer'],
         [['created_at'], 'safe'],
         [['updated_at'], 'safe'],         
      ];
   }
   

   public static function findIdentity($id)
   {  
      $query_users = (new \yii\db\Query())
         ->select([ 'id', 'uuid', 'name', 'access_token', 'created_at', 'updated_at' ])
         ->from( User::getUserTableName() )
         ->where( 'id=:id' )
            ->addParams( [':id' => $id] )
         ->limit(1);     
     
      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return new static( $user );
      }
 
      return null;       
   }


   public static function findIdentityByAccessToken($token, $type = null)
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'id', 'uuid', 'name', 'access_token', 'created_at', 'updated_at' ])
         ->from( User::getUserTableName() )
         ->where( 'uuid=:uuid' )
            ->addParams( [':accessToken' => $token] )
         ->limit(1);     
     
      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return new static( $user );
      }
 
      return null;     
   }


   public static function findByUUID($uuid)
   {        
      $query_users = (new \yii\db\Query())
         ->select([ 'id', 'uuid', 'name', 'access_token', 'created_at', 'updated_at' ])
         ->from( User::getUserTableName() )
         ->where( 'uuid=:uuid' )
            ->addParams( [':uuid' => $uuid] )
         ->limit(1);     
     
      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return new static( $user );
      }
 
      return null;            
   }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }


   /**
   * {@inheritdoc}
   */
   public function validateAuthKey($auth_key)
   {
      if( empty( $auth_key ) || !isset( $auth_key ) )
      {
         /**
          *  Quick fix for cookie timeout
          *
          *    app\models\User::validateAuthKey(null)
          *    yii\web\User::getIdentityAndDurationFromCookie()
          *    yii\web\User::loginByCookie()
          **/
      
         return false;
      }
   
      return $this->$auth_key === $auth_key;
   }

    /**
     * Validates password
     * Long-term plan is to use CAS, nothing local; hence, this
     * code automatically returns true for now
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return true;
    }


/**
 *
 *  This section handles role and/or user identity swapping for testing purposes
 *
 */

    /**
     * Ultimate permission checker to ensure (10) level access is available if that 
     * administrative user is temporarily assigned to a lower level role
     *
     * @param integer $id tbl_Users.id 
     * @return bool if user is a framework administrator
     */
   public function isFrameworkAdministrator( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'taa.item_name', 'taa.user_id' ])
         ->from(  'tbl_TempAuthAssignment taa' )
         ->where( 'taa.user_id =:user_id and item_name like :name and deleted_at IS NULL ' )
            ->addParams( [':user_id' => $id, ':name' => 'Framework-Administrator'], )
         ->limit(1);

      foreach( $query_users->each() as $user_row )
      {
         return true;
      }

      return false;
   }
   
    /**
     * Checker to determine if user is assigned a temporary role
     *
     * @param integer $id tbl_Users.id 
     * @return bool if user has active temporary role record
     */
   public function isAssignedTemporaryRole( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'taa.item_name', 'taa.user_id' ])
         ->from(  'tbl_TempAuthAssignment taa' )
         ->where( 'taa.user_id =:user_id  and deleted_at IS NULL ' )
            ->addParams( [':user_id' => $id, ], )
         ->limit(1);

      foreach( $query_users->each() as $user_row )
      {
         return true;
      }

      return false;
   }   
   

/**
 *
 *  This section handles basic role checking to see if a user holds a particular role
 *  before determining if they have access to this system
 *
 */

   public function isApprovalUser( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'u.id', 'u.uuid', 'u.name', 'u.access_token', 'u.created_at', 'u.updated_at' ])
         ->from( 'tbl_Users u' )
         ->innerJoin( 'junction_users_srcd u_srcd', 'u_srcd.users_id = u.id' )
         ->innerJoin( 'junction_systems_roles_careerlevels_departments srcd', 'srcd.id = u_srcd.srcd_id' )
         ->innerJoin( 'tbl_Roles ro', 'ro.id = srcd.roles_id' )                
         ->where( 'u.id =:id AND (ro.name =:name OR ro.name OR' )
            ->addParams( [':id' => $id, ':name' => 'Approval User'], )
         ->limit(1);

      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return $user;
      }

      return false;
   }  


   public function isSuperUser( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'u.id', 'u.uuid', 'u.name', 'u.access_token', 'u.created_at', 'u.updated_at' ])
         ->from( 'tbl_Users u' )
         ->innerJoin( 'junction_users_srcd u_srcd', 'u_srcd.users_id = u.id' )
         ->innerJoin( 'junction_systems_roles_careerlevels_departments srcd', 'srcd.id = u_srcd.srcd_id' )
         ->innerJoin( 'tbl_Roles ro', 'ro.id = srcd.roles_id' )                
         ->where( 'u.id =:id AND ro.name =:name ' )
            ->addParams( [':id' => $id, ':name' => 'Super User'], )
         ->limit(1);  

      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return $user;
      }

      return false;
   }        


   public function isAdministrator( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'a_a.item_name', 'a_a.user_id' ])
         ->from( 'auth_assignment a_a' )
         ->innerJoin( 'tbl_Users u', 'a_a.user_id = u.id' )
         ->where( 'u.id =:id AND a_a.item_name =:name ' )
            ->addParams( [':id' => $id, ':name' => 'Framework-Administrator-10'], )
         ->limit(1);  

      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return $user;
      }

      return false;
   }    


/**
 *
 *  This section handles feature permissions for quick, easy way to determine if a user can perform a particular function
 *  before determining if they have access to this system
 *
 */

   public function canInsertById( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'u.id', 'u.uuid', 'u.name', 'u.access_token', 'u.created_at', 'u.updated_at' ])
         ->from( 'tbl_Users u' )
         ->innerJoin( 'junction_users_srcd u_srcd', 'u_srcd.users_id = u.id' )
         ->innerJoin( 'junction_systems_roles_careerlevels_departments srcd', 'srcd.id = u_srcd.srcd_id' )
         ->innerJoin( 'tbl_Roles ro', 'ro.id = srcd.roles_id' )                
         ->where( 'u.id =:id AND ro.role & ( SELECT bit FROM tbl_Permissions WHERE name =:action )' )
            ->addParams( [':id' => $id, ':action' => 'Insert'], )
         ->limit(1);  
   
      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return $user;
      }

/**
      $result[] = $query_users->sql;
      $result[] = $query_users->params;
      $result[] = $query_users->queryAll();

      return $result;     
 **/
 
      return false;
   }   
   
   public function canUpdateById( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'u.id', 'u.uuid', 'u.name', 'u.access_token', 'u.created_at', 'u.updated_at' ])
         ->from( 'tbl_Users u' )
         ->innerJoin( 'junction_users_srcd u_srcd', 'u_srcd.users_id = u.id' )
         ->innerJoin( 'junction_systems_roles_careerlevels_departments srcd', 'srcd.id = u_srcd.srcd_id' )
         ->innerJoin( 'tbl_Roles ro', 'ro.id = srcd.roles_id' )                
         ->where( 'u.id =:id AND ro.role & ( SELECT bit FROM tbl_Permissions WHERE name =:action )' )
            ->addParams( [':id' => $id, ':action' => 'Update'], )
         ->limit(1);  
   
      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return $user;
      }

/**
      $result[] = $query_users->sql;
      $result[] = $query_users->params;
      $result[] = $query_users->queryAll();

      return $result;     
 **/
 
      return false;
   }   
   
   public function canSoftDeleteById( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'u.id', 'u.uuid', 'u.name', 'u.access_token', 'u.created_at', 'u.updated_at' ])
         ->from( 'tbl_Users u' )
         ->innerJoin( 'junction_users_srcd u_srcd', 'u_srcd.users_id = u.id' )
         ->innerJoin( 'junction_systems_roles_careerlevels_departments srcd', 'srcd.id = u_srcd.srcd_id' )
         ->innerJoin( 'tbl_Roles ro', 'ro.id = srcd.roles_id' )                
         ->where( 'u.id =:id AND ro.role & ( SELECT bit FROM tbl_Permissions WHERE name =:action )' )
            ->addParams( [':id' => $id, ':action' => 'Flag-Delete'], )
         ->limit(1);  
   
      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return $user;
      }
 
      return false;
   }  

   public function canHardDeleteById( $id )
   {
      $query_users = (new \yii\db\Query())
         ->select([ 'u.id', 'u.uuid', 'u.name', 'u.access_token', 'u.created_at', 'u.updated_at' ])
         ->from( 'tbl_Users u' )
         ->innerJoin( 'junction_users_srcd u_srcd', 'u_srcd.users_id = u.id' )
         ->innerJoin( 'junction_systems_roles_careerlevels_departments srcd', 'srcd.id = u_srcd.srcd_id' )
         ->innerJoin( 'tbl_Roles ro', 'ro.id = srcd.roles_id' )                
         ->where( 'u.id =:id AND ro.role & ( SELECT bit FROM tbl_Permissions WHERE name =:action )' )
            ->addParams( [':id' => $id, ':action' => 'Full-Delete'], )
         ->limit(1);  
   
      foreach( $query_users->each() as $user_row )
      {
         $user = $user_row;
         return $user;
      }

      return false;
   }
}