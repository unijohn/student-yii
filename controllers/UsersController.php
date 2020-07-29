<?php

namespace app\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\data\SQLDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;

use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\User;
//use app\models\UserSearch;


class UsersController extends Controller
{
   private $_auth;
   private $_authItemModel;
   private $_data;
   private $_dataProvider;
   private $_request;
   private $_roleModel;
   private $_userModel;
   

    /**
     * {@inheritdoc}
     */
   public function init()
   {
      parent::init();
      
      /**
       *  Quick fix for cookie timeout
       **/      
      
      if( is_null( Yii::$app->user->identity ) )
      {
         /* /site/index works but trying to learn named routes syntax */
         return $this->redirect(['/site/index']);
      }
      
      $this->_auth      = Yii::$app->authManager;
      $this->_request   = Yii::$app->request;  
      
      $this->_data             = [];
      $this->_dataProvider     = [];

      $this->_userModel        = new User();
      $this->_roleModel        = new AuthAssignment();
      $this->_authItemModel    = new AuthItem();
      
      $this->_data['filterForm']['uuid']              = ArrayHelper::getValue($this->_request->get(), 'User.uuid',      '');
      $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'User.is_active', -1);
      $this->_data['filterForm']['paginationCount']   = $this->_request->get( 'pagination_count', 10 );
      
      /**
       *    Capturing the possible post() variables used in this controller
       **/      
      
      $this->_data['post']['uuid']           = $this->_request->post('uuid',     '' );
      
      if( strlen( $this->_data['post']['uuid'] ) < 1 )
      {
         $this->_data['post']['uuid']        = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '' ); 
      }
      
      $this->_data['post']['addRole']        = $this->_request->post('addRole',        '' );
      $this->_data['post']['dropRole']       = $this->_request->post('dropRole',       '' );
      $this->_data['post']['authitem']       = $this->_request->post('authitem',       '' );
      $this->_data['post']['authassignment'] = $this->_request->post('authassignment', '' );                      
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

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
         [':id' => $params[':id']])->queryScalar();
      
/**
      $sql  =  "SELECT  id, uuid, name, is_active, ";
      $sql .=  "        datetime(created_at, 'unixepoch') as created_at, datetime(updated_at, 'unixepoch') as updated_at " ;
      $sql .= "FROM tbl_Users WHERE id >=:id ";
 **/
       
      $sql  = "SELECT  id, uuid, name, is_active, created_at, updated_at " ;
      $sql .= "FROM tbl_Users WHERE id >=:id ";

      if( strlen ($this->_data['filterForm']['uuid'] ) > 0 )
      {
         $sql .= "AND uuid LIKE :uuid ";
         $params[':uuid'] = '%' . $this->_data['filterForm']['uuid'] . '%';      
      }
      
      if(  $this->_data['filterForm']['is_active'] > -1 && strlen(  $this->_data['filterForm']['is_active'] ) > 0 )
      {
         $sql .= "AND is_active =:is_active ";
         $params[':is_active']   = $this->_data['filterForm']['is_active'];         
      }
      
      $UserSDP = new SqlDataProvider ([
         'sql'          => $sql,
         'params'       => $params,
         'totalCount'   => $count,
         'sort' => [
            'attributes' => [
               'uuid' => [
                  'default' => SORT_ASC,
                  'label' => 'UUID',
               ],
               'name' => [
                  'default' => SORT_ASC,
                  'label' => 'Name',
               ],
/**               
               'is_active' => [
                  'default' => SORT_ASC,
                  'label' => 'Status',
               ],
 **/               
               'created_at',
               'updated_at',                              
            ],
         ],         
         'pagination' => [
            'pageSize' => $this->_data['filterForm']['paginationCount'],
         ],
      ]); 
      
      return $UserSDP;
   }

   /**
    * Displays listing of all users in the system.
    *
    * @return string
    */
   public function actionIndex()
   {
      $this->_dataProvider = $this->getUserGridView();

      return $this->render('users-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_userModel,
      ]);      
   }
   

   /**
    * Displays selected UUID ( 1 record ).
    *
    * @return string
    */
   public function actionView()
   {  
      $this->_data['uuid']     = $this->_request->get('uuid', '');

      $this->_userModel = User::find()
         ->where(['uuid' => $this->_data['uuid'] ])
         ->limit(1)->one();

      $this->_roleModel  = AuthAssignment::find();
      
      $assignedRoles = [];
      foreach( $this->_userModel->roles as $role )
      {
         $assignedRoles[] = $role->item_name;
      }
      
      $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);      

      return $this->render('user-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_userModel,
            'roles'        => $this->_roleModel,
            'allRoles'     => $this->_authItemModel,
      ]);      
   }


   /**
    * Adding new User and Role information
    *
    * @return (TBD)
    */
   public function actionAdd()
   {
      $this->_dataProvider = $this->getUserGridView();   
   
      $this->_data['addUser']          = ArrayHelper::getValue($this->_request->post(), 'User.addUser',     '' );
      $this->_data['lookupUser']       = ArrayHelper::getValue($this->_request->post(), 'User.lookupUser',  '' );
      $this->_data['saveUser']         = false;
      $this->_data['errors']           = [];   
      $this->_data['success']          = [];
   
      $this->_userModel->uuid          = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '' );
      
      $uuidExists = User::existsUUID( $this->_userModel->uuid );
      
      if( $uuidExists )
      {
         if( isset( $this->_data['addUser'] ) && !empty( $this->_data['addUser'] ) )
         {
            $this->_data['errors']['Add User'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];

         }
         $this->_data['errors']['uuid'] = [
            'value' => "already exists",      
         ];
      }
      else
      {
         $this->_userModel->name       = $this->_userModel->uuid;
         $this->_userModel->is_active  = 1;      
         $this->_userModel->created_at = time();
            
         $this->_userModel->generateAuthKey();
         $this->_userModel->generateAccessToken();
      } 
      
      if( !$uuidExists )
      {      
         if( isset($this->_data['addUser'] ) && !empty( $this->_data['addUser'] ) )
         {        
            if( isset($this->_userModel->uuid ) && !empty( $this->_userModel->uuid ) )
            {
               $this->_data['saveUser'] = $this->_userModel->save();
            }
            else
            {
               $this->_data['errors']['Add User'] = [
                  'value'     => "was unsuccessful",
                  'htmlTag'   => 'h4',
                  'class'     => 'alert alert-danger',
               ];
               
               $this->_data['errors']['uuid'] = [
                  'value'     => "is null",
               ];               
            }
         }
      }

      if( $this->_data['saveUser'] )
      {
         $this->_data['success']['Add User'] = [
            'value'     => "was successful",
            'bValue'    => true,
            'htmlTag'   => 'h4',
            'class'     => 'alert alert-success',
         ];
         
         $this->_data['success'][$this->_userModel->uuid] = [
            'value'     => "was added",
            'bValue'    => true,
         ];         
      }

      return $this->render('users-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_userModel,
      ]);   
   }
   
   /**
    * Saving changes to User and Role information
    *
    * @return (TBD)
    */
   public function actionSave()
   {  
      $this->_data['uuid']           = $this->_request->post('uuid',     '' );
      $this->_data['addRole']        = $this->_request->post('addRole',  '' );
      $this->_data['dropRole']       = $this->_request->post('dropRole', '' );
      $this->_data['authitem']       = $this->_request->post('authitem', '' );
      $this->_data['authassignment'] = $this->_request->post('authassignment', '' );      
      
      //$this->_auth->assign( $auth->getRole('Academic-Advisor-Graduate'),       5 ); 

      print_r( $this->_request->post() );

      $this->_userModel = User::find()
         ->where(['uuid' => $this->_data['uuid'] ])
         ->limit(1)->one();

      print( $this->_userModel->id . PHP_EOL );

      if( strlen( $this->_data['addRole'] ) > 0 )
      {
         print( "addRole > 0" );
         $this->_auth->assign( $this->_auth->getRole($this->_data['authitem']['name']), $this->_userModel->id ); 
      }

      if( strlen( $this->_data['dropRole'] ) > 0 )
      {
         print( "dropRole > 0" );
         $this->_auth->revoke ( $this->_auth->getRole($this->_data['authassignment']['item_name']), $this->_userModel->id ); 
      }

      $roleModel  = AuthAssignment::find();
      
      $assignedRoles = [];
      foreach( $this->_userModel->roles as $role )
      {
         $assignedRoles[] = $role->item_name;
      }
      
      $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);      

      return $this->render('user-view', [
         'data'         => $this->_data, 
         'dataProvider' => $this->_dataProvider,
         'model'        => $this->_userModel,
         'roles'        => $this->_roleModel,
         'allRoles'     => $this->_authItemModel,
      ]);
   }
}