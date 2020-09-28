<?php

namespace app\controllers;

use yii;

use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;

use app\controllers\BaseController;

use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\FormFields;
use app\models\SystemCodes;
use app\models\SystemCodesChild;
use app\models\User;
use app\models\UsersPersonal;

class UsersController extends BaseController
{
    const dropDownOptsKeys  = [ 'pageCount', ];
   
    const dropDownOpts      =
    [
      'pageCount' =>
      [
         '10'  => '10',
         '25'  => '25',
         '50'  => '50',
         '100' => '100',
      ],
   ];

    private $_authItemModel;

    private $_roleModel;
    private $_userModel;
    private $_userPersonalModel;
   
    private $_tbl_SystemCodes;
    private $_tbl_SystemCodesChild;
   
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->_userModel        = new User();
        $this->_roleModel        = new AuthAssignment();
        $this->_authItemModel    = new AuthItem();
      
        $this->_tbl_SystemCodes       = SystemCodes::tableName();
        $this->_tbl_SystemCodesChild  = SystemCodesChild::tableName();
           
        /**
         *    Capturing the possible post() variables used in this controller
         **/
        if (!isset($this->_data['uuid']) || empty($this->_data['uuid'])) {
            $this->_data['uuid']   = $this->_request->get('uuid', '');
        }
      
        if (!isset($this->_data['uuid']) || empty($this->_data['uuid'])) {
            $this->_data['uuid']   = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '');
        }
        
        if (isset($this->_data['uuid']) && !empty($this->_data['uuid'])) {
            $this->_userPersonalModel = UsersPersonal::findOne($this->_data['uuid']);
        }

      
        $this->_data['filterForm']['uuid']              = ArrayHelper::getValue($this->_request->get(), 'User.uuid', '');
        $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'User.is_active', -1);
        $this->_data['filterForm']['paginationCount']   = ArrayHelper::getValue($this->_request->get(), 'User.pagination_count', 10);
      
        $this->_data['post']['addRole']        = $this->_request->post('addRole', '');
        $this->_data['post']['dropRole']       = $this->_request->post('dropRole', '');
        $this->_data['post']['authitem']       = $this->_request->post('authitem', '');
        $this->_data['post']['authassignment'] = $this->_request->post('authassignment', '');
      
        $this->_data['User']['is_active']           = ArrayHelper::getValue($this->_request->post(), 'User.is_active', -1);
        $this->_data['User']['is_active_employee']  = ArrayHelper::getValue($this->_request->post(), 'User.is_active_employee', -1);
        $this->_data['User']['is_active_student']   = ArrayHelper::getValue($this->_request->post(), 'User.is_active_student', -1);
        $this->_data['User']['is_test_account']     = ArrayHelper::getValue($this->_request->post(), 'User.is_test_account', -1);
        $this->_data['User']['access_token']        = ArrayHelper::getValue($this->_request->post(), 'User.access_token', -1);
        $this->_data['User']['saveUser']            = ArrayHelper::getValue($this->_request->post(), 'User.saveUser', -1);
      
        $this->_data['addRole']          = $this->_request->post('addRole', '');
        $this->_data['dropRole']         = $this->_request->post('dropRole', '');
        $this->_data['authitem']         = $this->_request->post('authitem', '');
        $this->_data['authassignment']   = $this->_request->post('authassignment', '');
      
        $this->_data['addUser']          = ArrayHelper::getValue($this->_request->post(), 'User.addUser', '');
        $this->_data['lookupUser']       = ArrayHelper::getValue($this->_request->post(), 'User.lookupUser', '');
        $this->_data['saveUser']         = false;
    }


    /**
     * {@inheritdoc}
     */
    /**
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['logout'],
                    'rules' => [
                        [
                            'actions' => ['logout'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ];
        }
     **/


    /**
     * Centralizing the query for building the User GridView
     *
     * @return SqlDataProvider
     */
    private function getUserGridView()
    {
        $params[':id'] = 1;
      
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(*) FROM tbl_Users WHERE id >=:id ',
            [':id' => $params[':id']]
        )->queryScalar();
            
        $sql  = "SELECT  id, uuid, is_active, created_at, updated_at " ;
        $sql .= "FROM tbl_Users WHERE id >=:id ";

        if (strlen($this->_data['filterForm']['uuid']) > 0) {
            $sql .= "AND uuid LIKE :uuid ";
            $params[':uuid'] = '%' . $this->_data['filterForm']['uuid'] . '%';
        }
      
        if ($this->_data['filterForm']['is_active'] > -1 && strlen($this->_data['filterForm']['is_active']) > 0) {
            $sql .= "AND is_active =:is_active ";
            $params[':is_active']   = $this->_data['filterForm']['is_active'];
        }
      
        $UserSDP = new SqlDataProvider([
         'sql'          => $sql,
         'params'       => $params,
         'totalCount'   => $count,
         'sort' => [
            'attributes' =>
            [
               'uuid' =>
               [
                  'default' => SORT_ASC,
                  'label' => 'UUID',
               ],
/**
               'name' => [
                  'default' => SORT_ASC,
                  'label' => 'Name',
               ],

               'is_active' => [
                  'default' => SORT_ASC,
                  'label' => 'Status',
               ],
 **/
               'created_at',
               'updated_at',
            ],
         ],
         'pagination' =>
         [
            'pageSize' => $this->_data['filterForm']['paginationCount'],
         ]
      ]);
      
        return $UserSDP;
    }


    /**
     *  Centralized render('users-listing') call
     *
     *  returns void
     **/
    private function renderListing()
    {
        $this->_dataProvider = $this->getUserGridView();

        return $this->render(
            'users-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_userModel
            ]
        );
    }

    /**
     *  Centralized render('users-view') call
     *
     *  returns void
     **/
    private function renderView()
    {
        return $this->render(
            'user-view',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_userModel,
                'roles'        => $this->_roleModel,
                'allRoles'     => $this->_authItemModel,
                'userPersonal' => $this->_userPersonalModel,
            ]
        );
    }

    /**
     * Displays listing of all users in the system.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderListing();
    }
   

    /**
     * Displays selected UUID ( 1 record ).
     *
     * @return string
     */
    public function actionView()
    {
//        $this->_data['uuid']     = $this->_request->get('uuid', '');

        $this->_userModel = User::find()
            ->where(['uuid' => $this->_data['uuid'] ])
            ->limit(1)->one();

        $this->_roleModel  = AuthAssignment::find();
      
        $assignedRoles = [];
        foreach ($this->_userModel->roles as $role) {
            $assignedRoles[] = $role->item_name;
        }
      
        $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);

        return $this->renderView();
    }


    /**
     * Adding new User and Role information
     *
     * @return (TBD)
     */
    public function actionAdd()
    {
        $this->_dataProvider = $this->getUserGridView();
   
        $this->_userModel->uuid          = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '');
      
        $uuidExists = User::existsUUID($this->_userModel->uuid);
      
        if ($uuidExists) {
            if (isset($this->_data['addUser']) && !empty($this->_data['addUser'])) {
                $this->_data['errors']['Add User'] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];

                $this->_data['errors']['uuid'] =
                [
                    'value' => "already exists",
                ];
            }
        } else {
//         $this->_userModel->name       = $this->_userModel->uuid;
            $this->_userModel->is_active  = 1;
            $this->_userModel->created_at = time();
            
            $this->_userModel->generateAuthKey();
            $this->_userModel->generateAccessToken();
        }
      
        if (!$uuidExists) {
            if (isset($this->_data['addUser']) && !empty($this->_data['addUser'])) {
                if (isset($this->_userModel->uuid) && !empty($this->_userModel->uuid)) {
                    $this->_data['saveUser'] = $this->_userModel->save();
                } else {
                    $this->_data['errors']['Add User'] =
                    [
                        'value'     => "was unsuccessful",
                        'htmlTag'   => 'h4',
                        'class'     => 'alert alert-danger',
                    ];
               
                    $this->_data['errors']['uuid'] =
                    [
                        'value'     => "is null",
                    ];
                }
            }
        }

        if ($this->_data['saveUser']) {
            $this->_data['success']['Add User'] =
            [
                'value'     => "was successful",
                'bValue'    => true,
                'htmlTag'   => 'h4',
                'class'     => 'alert alert-success',
            ];
         
            $this->_data['success'][$this->_userModel->uuid] =
            [
                'value'     => "was added",
                'bValue'    => true,
            ];
        }

        return $this->renderListing();
    }
   
   
    /**
     * Saving changes to User and Role information
     *
     * @return (TBD)
     */
    public function actionSave()
    {
        $exitEarly = false;
        
        $msgAddTagHeader    = "Add Role";
        $msgRemoveTagHeader = "Remove Role";
        $msgHeader          = "Save User";

        $this->_userModel = User::find()
         ->where(['uuid' => $this->_data['uuid'] ])
         ->limit(1)->one();

        $roleTag = "";
      
        if (isset($this->_data['authitem']['name']) && !empty($this->_data['authitem']['name'])) {
            $roleTag = $this->_data['authitem']['name'];
        } elseif (isset($this->_data['authassignment']['item_name']) && !empty($this->_data['authassignment']['item_name'])) {
            $roleTag = $this->_data['authassignment']['item_name'];
        }

        if (strlen($this->_data['addRole']) > 0) {
            if (AuthAssignment::existsRoleAssigned($this->_userModel->id, $roleTag)) {
                $this->_data['errors'][$msgAddTagHeader] =
                [
                   'value'     => "was unsuccessful",
                   'bValue'    => false,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors'][$this->_userModel->uuid] =
                [
                    'value' => "is already assigned this role ( " . $roleTag. " )",
                ];
            } elseif ($this->_auth->assign($this->_auth->getRole($roleTag), $this->_userModel->id)) {
                $this->_data['success'][$msgAddTagHeader] =
                [
                   'value'        => "was successful",
                   'bValue'       => true,
                   'htmlTag'      => 'h4',
                   'class'        => 'alert alert-success',
                ];
            
                $this->_data['success'][$roleTag] =
                [
                    'value' => "was added",
                ];
            } else {
                $this->_data['errors'][$msgAddTagHeader] =
                [
                   'value'     => "was unsuccessful",
                   'bValue'    => false,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors'][$roleTag] =
                [
                    'value' => "was not added.",
                ];
            }
         
            $exitEarly = true;
        }

        if (strlen($this->_data['dropRole']) > 0) {
            if ($this->_auth->revoke($this->_auth->getRole($roleTag), $this->_userModel->id)) {
                $this->_data['success'][$msgRemoveTagHeader] =
                [
                   'value'        => "was successful",
                   'bValue'       => true,
                   'htmlTag'      => 'h4',
                   'class'        => 'alert alert-success',
                ];
            
                $this->_data['success'][$roleTag] =
                [
                    'value' => "was removed",
                ];
            } else {
                $this->_data['errors'][$msgRemoveTagHeader] =
                [
                   'value'     => "was unsuccessful",
                   'bValue'    => false,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors'][$roleTag] =
                [
                    'value' => "was not removed.",
                ];
            }
         
            $exitEarly = true;
        }

        /**
         * Tag only update; exiting early
         **/

        if ($exitEarly) {
            $roleModel  = AuthAssignment::find();
         
            $assignedRoles = [];
            foreach ($this->_userModel->roles as $role) {
                $assignedRoles[] = $role->item_name;
            }
         
            $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);
      
            return $this->renderView();
        }
      
        /**
         * User model update
         **/
        $exitEarly = false;
        $uuidExists = User::existsUUID($this->_data['uuid']);
      
        if (!$uuidExists) {
            if (isset($this->_data['saveUser']) && !empty($this->_data['saveUser'])) {
                $this->_data['errors'][$msgHeader] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];

                $this->_data['errors']['uuid'] =
                [
                    'value' => " ( " . $this->_data['uuid'] . " ) does not exist",
                ];
            }
         
            $roleModel  = AuthAssignment::find();
         
            $assignedRoles = [];
            foreach ($this->_userModel->roles as $role) {
                $assignedRoles[] = $role->item_name;
            }
         
            $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);
      
            return $this->renderView();
        }

        $updateModel            = $this->_userModel;
      
        $updateModel->scenario  = User::SCENARIO_UPDATE;

        $updateModel->is_active             = $this->_data['User']['is_active'];
        $updateModel->is_active_employee    = $this->_data['User']['is_active_employee'];
        $updateModel->is_active_student     = $this->_data['User']['is_active_student'];
        $updateModel->is_test_account       = $this->_data['User']['is_test_account'];
        
        $updateModel->access_token  = $this->_data['User']['access_token'];
        
        if (!$updateModel->validate()) {
            $this->_data['errors'][$msgHeader] =
            [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];

            $this->_data['errors']['description'] =
            [
                'value' => $updateModel->errors,
            ];

            $this->_data['errors']['useSession'] = true;
            
            self::debug($updateModel->errors);
        }

        $this->_data['User']['Update']   = $updateModel->save();
      
        $updateColumns = $updateModel->afterSave(false, $this->_data['User']['Update']);
      
        if ($this->_data['User']['Update'] && is_array($updateColumns)) {
            if (count($updateColumns) > 0) {
                foreach ($updateColumns as $key => $val) {
                    $keyIndex = ucwords(strtolower(str_replace("_", " ", $key)));
            
                    if ($key !== "updated_at" && $key !== "deleted_at") {
                        if ($val == $this->_data['User'][$key]) {
                            // For some reason, afterSave() is stating that the value for this key has updated
                            // e.g. is_active, is_visible :: Basically any "-1" == -1 situation
                            continue;
                        } else {
                            // Avoid setting this success header multiple times
                            if (!isset($this->_data['success'][$msgHeader])) {
                                $this->_data['success']['useSession'] = true;
                            
                                $this->_data['success'][$msgHeader] =
                                [
                                   'value'      => "was successful",
                                   'bValue'     => true,
                                   'htmlTag'    => 'h4',
                                   'class'      => 'alert alert-success',
                                ];
                            }
                        }
                        
                        $lookupNew = $this->keyLookup($key, $val);
                        $lookupOld = $this->keyLookup($key, $this->_data['User'][$key]);
                        
                        //                            self::debug( $lookupNew . " vs. " . $lookupOld, true );
                        
                        $labels = $this->_userModel->attributeLabels();
                        
                        //                            self::debug( $labels );
               
                        $this->_data['success'][$labels[$key]] =
                        [
                            'value'     => "was updated ( <strong>" . $val . "</strong> -> <strong>" . $this->_data['User'][$key] . "</strong> )",
                            'bValue'    => true,
                        ];
    
                        if (strpos($lookupNew, "Unknown") !== 0) {
                            $this->_data['success'][$labels[$key]] =
                            [
                                'value'  => "was updated ( <strong>" . $lookupNew . "</strong> -> <strong>" . $lookupOld . "</strong> )",
                            ];
                        }
                    }
                }
                
                //                    self::debug( $this->_data['success'] );
            }
        }

        return $this->redirect(['users/view', 'uuid' => $this->_data['uuid'] ]);
    }
   
   
    /**
      * TBD
      *
      * @return (TBD)
      */
    private function keyLookup($key, $value)
    {
        $isActive       = FormFields::getSelectOptions(-1, CodesController::IS_ACTIVE_TYPE_STR, true);
        $isEmployee     = FormFields::getSelectOptions(-1, CodesController::IS_YES_NO_TYPE_STR, true);
        $isStudent      = FormFields::getSelectOptions(-1, CodesController::IS_YES_NO_TYPE_STR, true);
        $isTestAccount  = FormFields::getSelectOptions(-1, CodesController::IS_YES_NO_TYPE_STR, true);
      
        if ($key == 'is_active'  && array_key_exists($value, $isActive)) {
            return $isActive[$value ];
        } elseif ($key == 'is_active_employee' && array_key_exists($value, $isEmployee)) {
            return $isEmployee[$value];
        } elseif ($key == 'is_active_student' && array_key_exists($value, $isStudent)) {
            return $isStudent[$value];
        } elseif ($key == 'is_test_account' && array_key_exists($value, $isTestAccount)) {
            return $isTestAccount[$value];
        }
   
        return "Unknown key : " . $key . " :: " . $value;
    }
       
   
    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getDropDownOpts($key = "", $prompt = false)
    {
        $dropDownOpts     = self::dropDownOpts;
   
        if (!isset($key) || empty($key)) {
            return $dropDownOpts;
        } elseif (!in_array($key, self::dropDownOptsKeys)) {
            return $dropDownOpts;
        }
      
        if (!$prompt) {
            if (isset($dropDownOpts[$key])) {
                unset($dropDownOpts[$key][-1]);
            }
        }

        return $dropDownOpts[$key];
    }
}
