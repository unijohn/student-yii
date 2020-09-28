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
            'id'        => Yii::t('app', 'System ID'),
            'uuid'      => Yii::t('app', 'UUID'),
            
            'is_active'             => Yii::t('app', 'Is Active'),
            'is_active_employee'    => Yii::t('app', 'UofM Employee'),
            'is_active_student'     => Yii::t('app', 'UofM Student'),
            'is_test_account'       => Yii::t('app', 'UofM Student'),            
            
            'access_token'      => Yii::t('app', 'Access Token' ),
            'auth_key'          => Yii::t('app', 'Authorization Key' ),
            
            'created_at'        => Yii::t('app', 'Created'),
            'updated_at'        => Yii::t('app', 'Updated'),
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
        $scenarios[self::SCENARIO_INSERT] = [ 'uuid', 'is_active', 'is_active_employee', 'is_active_student', 'auth_key', 'access_token' ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'is_active', 'is_active_employee', 'is_active_student', 'access_token' ];
   
        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return
        [
            [
                'uuid', 'string', 'min' => 2, 'max' => 10,
            ],
            [
                'is_active',  'number', 'min' => self::STATUS_ACTIVE_MIN,  'max' => self::STATUS_ACTIVE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Is Workdesk account active?',
            ],
            [
                'is_active_employee',  'number', 'min' => self::STATUS_ACTIVE_MIN,  'max' => self::STATUS_ACTIVE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Is user an current employee of UofM?',
            ],
            [
                'is_active_student',  'number', 'min' => self::STATUS_ACTIVE_MIN,  'max' => self::STATUS_ACTIVE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Is user an current student of UofM?',
            ],
            
            [
                'auth_key', 'string', 'min' => 48, 'max' => 48,
            ],
            [
                'access_token', 'string', 'min' => 48, 'max' => 48,
            ],
            [
                [
                   'uuid', 'is_active', 'is_active_employee', 'is_active_student', 'auth_key', 'access_token',
                ],
                'required', 'on' => self::SCENARIO_INSERT
            ],
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
        $this->access_token = Yii::$app->security->generateRandomString(48);
    }


    /**
     *  New user via CAS access; needs User entry
     **/
    public function addUser($uuid = '')
    {
        if (!isset($uuid) || empty($uuid)) {
            self::debug("What...?  How...?: $uuid", false);
            return false;
        }

        $newUser = new User();
        
        $newUser->uuid                  = $uuid;
        $newUser->is_active             = self::STATUS_ACTIVE;
        $newUser->is_active_employee    = self::STATUS_ACTIVE;
        $newUser->is_active_student     = self::STATUS_ACTIVE;
        $newUser->is_test_account       = self::STATUS_INACTIVE;        
        $newUser->generateAuthKey();
        $newUser->generateAccessToken();

        if( !$newUser->validate() ){
            self::debug( $newUser->errors );
        }
    
        return $newUser->save();
    }


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
