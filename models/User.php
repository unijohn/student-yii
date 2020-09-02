<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\rbac\DbManager;
use yii\web\IdentityInterface;

//use yii2tech\ar\position\PositionBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

use app\models\BaseModel;
use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\TempAuthAssignment;
use app\models\UsersPersonal;

//class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
class User extends BaseModel implements IdentityInterface
{
    /**
       Using these declarations breaks the ActiveRecord functionality
       I have no idea why as of right now.

       public $id;
       public $uuid;
       public $name;
       public $is_active;
       public $auth_key;
       public $access_token;
       public $created_at;
       public $updated_at;
     **/

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
        return self::tableName();
    }
   

    public static function getTempAuthAssignmentTableName()
    {
        return TempAuthAssignment::tableName();
    }
    
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
            'uuid'      => Yii::t('app', 'UUID'),
            'is_active' => Yii::t('app', 'Account Status'),
            
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
         'timeStampBehavior' => [
            'class' => TimestampBehavior::className(),
            'attributes' =>
            [
               self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
               self::EVENT_BEFORE_UPDATE => ['updated_at'],
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

         'positionBehavior' => [
            'class' => PositionBehavior::className(),
            'positionAttribute' => 'position',
             'groupAttributes' =>
             [
                 'categoryId' // multiple lists varying by 'categoryId'
             ],
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
        $scenarios[self::SCENARIO_INSERT] = [ 'uuid', 'is_active', 'auth_key', 'access_token' ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'is_active', 'access_token' ];
   
        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
         [ 'uuid', 'string', 'min' => 2, 'max' => 16 ],
         [ 'uuid', 'unique' ],
         [ 'uuid', 'default', 'value' => null ],

         ['is_active', 'default', 'value'    => self::STATUS_ACTIVE     ],
         ['is_active', 'integer', 'min'      => self::STATUS_INACTIVE   ],
         ['is_active', 'integer', 'max'      => self::TYPE_MAX          ],
         ['is_active', 'filter',  'filter'   => 'intval'],
         
         [['is_active'], 'required' ],
      ];
    }


    /**
     *
     *    \yii\web\IdentityInterface Section
     *
     **/
 
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
            }
            return true;
        }
        return false;
    }


    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString(48);
    }


    /**
     * Generates "remember me" authentication key
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString(32);
    }


    /**
     *  New user via CAS access; needs User entry
     **/
    public function addUser( $uuid = '' ) {
        
        if( !isset( $uuid ) || empty( $uuid ) ) {
            return false;
        }

        $newUser = new User();
        
        $newUser->uuid = $uuid;
        $newUser->isActive = self::STATUS_ACTIVE;
        $newUser->generateAuthKey();
        $newUser->generateAccessToken();
        
        return $newUser->save();
    
    }

'is_active', 'auth_key', 'access_token'

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $query_users = (new \yii\db\Query())
         ->select([ 'id', 'uuid', 'access_token', 'created_at', 'updated_at' ])
         ->from(User::tableName())
         ->where('id=:id')
            ->addParams([':id' => $id])
         ->limit(1);
     
        foreach ($query_users->each() as $user_row) {
            $user = $user_row;
            return new static($user);
        }
 
        return null;
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        $query_users = (new \yii\db\Query())
         ->select([ 'id', 'uuid', 'access_token', 'created_at', 'updated_at' ])
         ->from(self::tableName())
         ->where('access_token=:access_token')
            ->addParams([':access_token' => $token])
         ->limit(1);
     
        foreach ($query_users->each() as $user_row) {
            $user = $user_row;
            return new static($user);
        }
 
        return null;
    }


    public static function findByUUID($uuid)
    {
        $query_users = (new \yii\db\Query())
         ->select([ 'id', 'uuid', 'access_token', 'created_at', 'updated_at' ])
         ->from(self::tableName())
         ->where('uuid=:uuid')
            ->addParams([':uuid' => $uuid])
         ->limit(1);
     
        foreach ($query_users->each() as $user_row) {
            $user = $user_row;
            return new static($user);
        }
 
        return null;
    }


    public static function existsUUID($uuid)
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(*) FROM ' . self::tableName() . ' WHERE uuid=:uuid ',
            [':uuid' => $uuid]
        )->queryScalar();
        
        return ($count == 1 ? true : false);
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
        if (empty($auth_key) || !isset($auth_key)) {
            /**
             *  Quick fix for cookie timeout
             *
             *    app\models\User::validateAuthKey(null)
             *    yii\web\User::getIdentityAndDurationFromCookie()
             *    yii\web\User::loginByCookie()
             **/
      
            return false;
        }
   
        return $this->auth_key === $auth_key;
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
     *    Relationships & Model section
     *
     **/
    public function getRoles()
    {
        return $this->hasMany(AuthAssignment::className(), [ 'user_id' => 'id' ]);
    }

    public function getPersonalInformation()
    {
        return $this->hasOne(UsersPersonal::className(), [ 'uuid' => 'uuid' ]);
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
    public function isFrameworkAdministrator($id)
    {
        $tbl_TAA  = self::getTempAuthAssignmentTableName() . " taa";
   
        $query_users = (new \yii\db\Query())
         ->select([ 'taa.item_name', 'taa.user_id' ])
         ->from($tbl_TAA)
         ->where('taa.user_id =:user_id and item_name like :item_name and deleted_at IS NULL ')
            ->addParams([':user_id' => $id, ':item_name' => 'Framework-Administrator'])
         ->limit(1);

        foreach ($query_users->each() as $user_row) {
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
    public function isAssignedTemporaryRole($id)
    {
        $tbl_TAA  = self::getTempAuthAssignmentTableName() . " taa";
   
        $query_users = (new \yii\db\Query())
         ->select([ 'taa.item_name', 'taa.user_id' ])
         ->from($tbl_TAA)
         ->where('taa.user_id =:user_id  and deleted_at IS NULL ')
            ->addParams([':user_id' => $id, ])
         ->limit(1);

        foreach ($query_users->each() as $user_row) {
            return true;
        }

        return false;
    }
}
