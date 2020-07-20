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
use app\models\UserSearch;


class UsersController extends Controller
{
   private $_auth;
   private $_authItemModel;
   private $_data;
   private $_dataProvider;
   private $_request;
   private $_roleModel;
   private $_userModel;
   

   public function init()
   {
      parent::init();
      
      /**
       *  Quick fix for cookie timeout
       **/      
      
      if( is_null( Yii::$app->user->identity ) )
      {
         return $this->redirect(['home']);
      }
      
      $this->_auth      = Yii::$app->authManager;
      $this->_request   = Yii::$app->request;  
      
      $this->_data             = [];
      $this->_dataProvider     = [];

      $this->_userModel        = new User();
      $this->_roleModel        = new AuthAssignment();
      $this->_authItemModel    = new AuthItem();
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
    * Displays listing of all users in the system.
    *
    * @return string
    */
   public function actionIndex()
   {      
//      $data             = [];
//      $dataProvider     = [];

//      $userModel        = new User();
      
      /**
       *  Quick fix for cookie timeout
       **/

      $this->_userModel->uuid           = ArrayHelper::getValue($this->_request->get(), 'User.uuid',      '');
      $this->_userModel->is_active      = ArrayHelper::getValue($this->_request->get(), 'User.is_active', '-1');
      $this->_data['paginationCount']   = $this->_request->get( 'pagination_count', 10 );

      $count = Yii::$app->db->createCommand(
         'SELECT COUNT(*) FROM tbl_Users WHERE id >=:id ',
         [':id' => 1])->queryScalar();
      
/**
     
      $sql  =  "SELECT  id, uuid, name, is_active, ";
      $sql .=  "        datetime(created_at, 'unixepoch') as created_at, datetime(updated_at, 'unixepoch') as updated_at " ;
      $sql .= "FROM tbl_Users WHERE id >=:id ";
 **/
       
      $sql  = "SELECT  id, uuid, name, is_active, created_at, updated_at " ;
      $sql .= "FROM tbl_Users WHERE id >=:id ";
      
      $params[':id'] = 1;

      if( strlen($this->_userModel->uuid) > 0 )
      {
         $sql .= "AND uuid LIKE :uuid ";
         $params[':uuid'] = '%' . $this->_userModel->uuid . '%';      
      }
      
      if( $this->_userModel->is_active > -1 && strlen($this->_userModel->is_active) > 0 )
      {
         $sql .= "AND is_active =:is_active ";
         $params[':is_active'] = $this->_userModel->is_active;
      }
      
      $this->_dataProvider = new SqlDataProvider ([
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
            'pageSize' => $this->_data['paginationCount'],
         ],
      ]); 

      return $this->render('users-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_userModel,
      ]);      
   }
   

   /**
    * Displays listing of all users in the system.
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
         
/**
      print( "<h1>What</h1><pre>" );   
      print_r( $user);
      print( "</pre>" );
      die();
 **/

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
      $this->_userModel->uuid       = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '' );
      $this->_userModel->name       = $this->_userModel->uuid;
      $this->_userModel->is_active  = 1;      
      $this->_userModel->created_at = time();
            
      $this->_userModel->generateAuthKey();
      $this->_userModel->generateAccessToken();
      
      $this->_data['addUser']          = ArrayHelper::getValue($this->_request->post(), 'User.addUser',     '' );
      $this->_data['lookupUser']       = ArrayHelper::getValue($this->_request->post(), 'User.lookupUser',  '' );
      $this->_data['paginationCount']  = $this->_request->get( 'pagination_count', 10 );
      $this->_data['errors']           = [];   

      print( "<pre>" );
      print_r( $this->_request->post() );
      print_r( $this->_data );      
      
      print( "is_not_empty: " . !empty( $this->_data['addUser'] ) . PHP_EOL );
      print( "is_set: "       . isset(  $this->_data['addUser'] ) . PHP_EOL );      
      
      if( isset($this->_data['addUser'] ) && !empty( $this->_data['addUser'] ) )
      {
         $this->_data['saveUser'] = false;
      
         if( isset($this->_userModel->uuid ) && !empty( $this->_userModel->uuid ) )
         {
            $this->_data['saveUser'] = $this->_userModel->save();
         }
         else
         {
            $this->_data['errors']['uuid'] = "is null";
         }
      }

      if( $this->_data['saveUser'] )
      {
         Yii::$app->response->redirect(['users/index']);
      }
      else
      {
         print( "Save failed:"  );
         print_r( $this->_data['errors'] );
         die();
      }

/**
      return $this->render('users-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_userModel,
      ]);   
 **/
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