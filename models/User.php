<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

//class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $uuid;
    public $name;
    public $auth_key;
    public $access_token;
    public $created_at;
    public $updated_at;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
        '102' => [
            'id' => '102',
            'username' => 'testme',
            'password' => 'testme',
            'authKey' => 'test102key',
            'accessToken' => '102-token',
        ],        
    ];

   public static function tableName()
   {
      return 'tbl_Users';
   }

   public static function findIdentity($id)
   {
//      return static::findOne(['id' => $id]);
      
      $query_users = (new \yii\db\Query())
         ->select([ 'id', 'uuid', 'name', 'access_token', 'created_at', 'updated_at' ])
         ->from( 'tbl_Users' )
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
         ->from( 'tbl_Users' )
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
         ->from( 'tbl_Users' )
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
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $auth_key;
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
   
/**  
      $result[] = $query_users->sql;
      $result[] = $query_users->params;
      $result[] = $query_users->queryAll();

      return $result;     
**/

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
   
/**  
      $result[] = $query_users->sql;
      $result[] = $query_users->params;
      $result[] = $query_users->queryAll();

      return $result;     
**/

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
         ->select([ 'u.id', 'u.uuid', 'u.name', 'u.access_token', 'u.created_at', 'u.updated_at' ])
         ->from( 'tbl_Users u' )
         ->innerJoin( 'junction_users_srcd u_srcd', 'u_srcd.users_id = u.id' )
         ->innerJoin( 'junction_systems_roles_careerlevels_departments srcd', 'srcd.id = u_srcd.srcd_id' )
         ->innerJoin( 'tbl_Roles ro', 'ro.id = srcd.roles_id' )                
         ->where( 'u.id =:id AND ro.name =:name ' )
            ->addParams( [':id' => $id, ':name' => 'Administrator'], )
         ->limit(1);  
   
/**  
      $result[] = $query_users->sql;
      $result[] = $query_users->params;
      $result[] = $query_users->queryAll();

      return $result;     
**/

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

/**
      $result[] = $query_users->sql;
      $result[] = $query_users->params;
      $result[] = $query_users->queryAll();

      return $result;     
 **/
 
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

/**
      $result[] = $query_users->sql;
      $result[] = $query_users->params;
      $result[] = $query_users->queryAll();

      return $result;     
 **/
 
      return false;
   }      


    /**
     * {@inheritdoc}
     */
     
/**          
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }
 **/

    /**
     * {@inheritdoc}
     */
/**
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }
 **/

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
     
/**     
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }
 **/

    /**
     * {@inheritdoc}
     */
/**       
    public function getId()
    {
        return $this->id;
    }
 **/
 
    /**
     * {@inheritdoc}
     */
/**       
    public function getAuthKey()
    {
        return $this->authKey;
    }
 **/    

    /**
     * {@inheritdoc}
     */
/**       
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
 **/    

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
/**       
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
 **/    
 
}