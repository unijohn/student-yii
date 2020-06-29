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
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return true;
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