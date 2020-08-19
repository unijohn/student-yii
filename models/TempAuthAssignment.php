<?php

namespace app\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\DbManager;

use yii2tech\ar\softdelete\SoftDeleteBehavior;

use app\models\BaseModel;

class TempAuthAssignment extends BaseModel
{
    //   protected $id;
    //   public $item_name;
    //   public $temp_item_name;
    //   public $user_id;
    //   public $created_at;
    //   public $deleted_at;
    
    private $_auth;
    private $_identity;
    private $_userId;

   
    public function init()
    {
        parent::init();
      
        $this->_auth      = \Yii::$app->getAuthManager();
        $this->_identity  = \Yii::$app->user->identity;
      
        $this->_userId  = $this->_identity->getId();
    }

    public static function tableName()
    {
        return '{{tbl_TempAuthAssignment}}';
    }
    
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        /**
                return [
                    'id' => Yii::t('app', 'ID'),
                    'uuid' => Yii::t('app', 'Authors ID'),
                    'name' => Yii::t('app', 'Last Edited'),
                    'auth_key' => Yii::t('app', 'Published'),
                    'access_token' => Yii::t('app', 'Title'),
                    'Description' => Yii::t('app', 'Description'),
                    'Content' => Yii::t('app', 'Content'),
                    'Format' => Yii::t('app', 'Format'),
                ];
         **/
    }

    // explicitly list every field, best used when you want to make sure the changes
    // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
    public function fields()
    {
        return [
         /**
          *   Examples
          **/
          
//         // field name is "email", the corresponding attribute name is "email_address"
//         'email' => 'email_address',
         
        // field name is "name", its value is defined by a PHP callback
//        'name' => function () {
//            return $this->first_name . ' ' . $this->last_name;
//        },
      
         // field name is the same as the attribute name
         'id'              => 'id',
      
         'user_id'         => 'user_id',
         
         'original_role'   => 'item_name',
         'temp_role'       => 'temp_item_name',
   
      ];
    }
   

    public function rules()
    {
        return [
      ];
    }
   

    public function behaviors()
    {
        return [
         'timeStampBehavior' => [
            'class' => TimestampBehavior::className(),
            'attributes' =>
            [
               self::EVENT_BEFORE_INSERT => ['created_at',],
               self::EVENT_BEFORE_DELETE => ['deleted_at',],
            ],
            // if you're using datetime instead of UNIX timestamp:
            'value' => time(),
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
      ];
    }
   
   
    /**
      * Checks to see if a termporary roles has already been assigned
      *
      * @param integer $id tbl_Users.id
      * @return bool if user has switched to another role
      */
    public function existsTemporaryEntries()
    {
        if (empty($this->_userId) || !isset($this->_userId)) {
            return false;
        }
   

        $activeTempAssignmentCount = self::find()
         ->where([
            'user_id'            => $this->_userId,
            'deleted_at'         => null,
         ])
         ->count();
      
        return ($activeTempAssignmentCount > 0);
    }


    /**
     * Stores original role assignments when swapping to a different
     * role to test permissions and access issues
     *
     * @param integer $id tbl_Users.id
     * @param string $new_role auth_item.name, type = 1 role assignment
     * @return bool if storing roles was successful
     */
    public function storePermanentRoles($id, $new_role = '')
    {
        if (empty($new_role) || !isset($new_role) ||
          empty($this->_userId) || !isset($this->_userId)
      ) {
            return false;
        }
   
        if (!empty($this->_userId) && isset($this->_userId)) {
            $activeTempAssignmentCount = TempAuthAssignment::find()
            ->where([
               'user_id'            => $this->_userId,
               'deleted_at'         => null,
            ])
            ->count();
         
            if ($activeTempAssignmentCount > 0) {
                return false;
            }
      
            $transaction = TempAuthAssignment::getDb()->beginTransaction();
            try {
                foreach ($this->_auth->getRolesByUser($this->_userId) as $key => $roles) {
                    $currentRole = new TempAuthAssignment();
               
                    $currentRole->item_name       = $roles->name;
                    $currentRole->temp_item_name  = $new_role;
                    $currentRole->user_id         = $this->_userId;
 
                    $currentRole->save();
                }
            
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
   
        return false;
    }


    /**
     * Revokes roles in auth_item to convert user to temporary role
     *
     * @param integer $id tbl_Users.id
     * @return bool if revoking roles was was successful
     */
    public function revokeRoles($id)
    {
        if (empty($this->_userId) || !isset($this->_userId)) {
            return false;
        }
      
        return $this->_auth->revokeAll($this->_userId);
    }

   
    /**
     * Assigns temporary role to test out permissions and access issues
     *
     * @param integer $id tbl_Users.id
     * @param string $new_role auth_item.name, type = 1 role assignment
     * @return bool if revoking roles was was successful
     */
    public function assignTemporaryRole($new_role = '')
    {
        if (empty($new_role) || !isset($new_role) ||
          empty($this->_userId) || !isset($this->_userId)
      ) {
            return false;
        }
      
        if ($this->_auth->getAssignment($new_role, $this->_userId)) {
            return false;
        }
      
        return $this->_auth->assign($this->_auth->getRole($new_role), $this->_userId);
    }
      
   
    /**
     * Restores original role assignments when returning from a different
     * role to test permissions and access issues
     *
     * @param integer $id tbl_Users.id
     * @return bool if storing roles was successful
     */
    public function restorePermanentRoles()
    {
        if (!empty($this->_userId) && isset($this->_userId)) {
            $temporaryRoleCount = TempAuthAssignment::find()
            ->where([
               'user_id' => $this->_userId,
               'deleted_at' => null,
            ])->count();

            if ($temporaryRoleCount < 1) {
                return false;
            }

            $activeTempAssignment = (new \yii\db\Query())
            ->select([ 'taa.item_name', 'taa.temp_item_name', 'taa.user_id' ])
            ->from('tbl_TempAuthAssignment taa')
            ->where('taa.user_id =:user_id and deleted_at IS NULL ')
               ->addParams([':user_id' => $this->_userId, ])
            ->limit(1);

            $transaction = self::getDb()->beginTransaction();
         
            try {
                $this->revokeRoles($this->_userId);
            
                foreach ($activeTempAssignment->each() as $user) {
                    $this->_auth->assign($this->_auth->getRole($user['item_name']), $this->_userId);
               
                    $tempRole = self::find()
                  ->where([
                     'user_id' => $this->_userId,
                     'deleted_at' => null,
                  ])->limit(1)->one();

                    print_r("Before: " . is_null($tempRole->deleted_at) . PHP_EOL);
                  
                    $tempRole->deleted_at = time();
                    print_r("After: " . $tempRole->deleted_at . PHP_EOL);
               
                    $tempRole->save();
               
//               print_r( $tempRole->getErrors() );
//               die();
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
                return false;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
                return false;
            }
        }
   
        return true;
    }
}
