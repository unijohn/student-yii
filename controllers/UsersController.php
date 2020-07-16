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
   private $_request;

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
      $data             = [];
      $dataProvider     = [];

      $userModel        = new User();
      
      /**
       *  Quick fix for cookie timeout
       **/

      $userModel->uuid           = ArrayHelper::getValue($this->_request->get(), 'User.uuid',      '');
      $userModel->is_active      = ArrayHelper::getValue($this->_request->get(), 'User.is_active', '-1');
      $data['paginationCount']   = $this->_request->get( 'pagination_count', 10 );

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

      if( strlen($userModel->uuid) > 0 )
      {
         $sql .= "AND uuid LIKE :uuid ";
         $params[':uuid'] = '%' . $userModel->uuid . '%';      
      }
      
      if( $userModel->is_active > -1 && strlen($userModel->is_active) > 0 )
      {
         $sql .= "AND is_active =:is_active ";
         $params[':is_active'] = $userModel->is_active;
      }
      
      $dataProvider = new SqlDataProvider ([
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
            'pageSize' => $data['paginationCount'],
         ],
      ]); 

      return $this->render('users-listing', [
            'data'         => $data, 
            'dataProvider' => $dataProvider,
            'model'        => $userModel,
      ]);      
   }
   

   /**
    * Displays listing of all users in the system.
    *
    * @return string
    */
   public function actionView()
   {  
      $data             = [];
      $dataProvider     = [];

      $userModel        = new User();
      $roleModel        = new AuthAssignment();
      $authItemModel    = new AuthItem();
      

      $data['uuid']     = $this->_request->get('uuid', '');

      $userModel = User::find()
         ->where(['uuid' => $data['uuid'] ])
         ->limit(1)->one();

      $roleModel  = AuthAssignment::find();
      
      $assignedRoles = [];
      foreach( $userModel->roles as $role )
      {
         $assignedRoles[] = $role->item_name;
      }
      
      $authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);      
         
/**
      print( "<h1>What</h1><pre>" );   
      print_r( $user);
      print( "</pre>" );
      die();
 **/

      return $this->render('user-view', [
            'data' => $data, 
            'dataProvider' => $dataProvider,
            'model'        => $userModel,
            'roles'        => $roleModel,
            'allRoles'     => $authItemModel,
      ]);      
   }
   
   
   /**
    * Saving changes to User and Role information
    *
    * @return (TBD)
    */
   public function actionSave()
   {  
      $data             = [];
      $dataProvider     = [];

      $userModel        = new User();
      $roleModel        = new AuthAssignment();
      $authItemModel    = new AuthItem();

      $data['uuid']           = $this->_request->post('uuid',     '' );
      $data['addRole']        = $this->_request->post('addRole',  '' );
      $data['dropRole']       = $this->_request->post('dropRole', '' );
      $data['authitem']       = $this->_request->post('authitem', '' );
      $data['authassignment'] = $this->_request->post('authassignment', '' );      
      
      
      //$this->_auth->assign( $auth->getRole('Academic-Advisor-Graduate'),       5 ); 

      print_r( $this->_request->post() );

      $userModel = User::find()
         ->where(['uuid' => $data['uuid'] ])
         ->limit(1)->one();

      print( $userModel->id . PHP_EOL );

      if( strlen( $data['addRole'] ) > 0 )
      {
         print( "addRole > 0" );
         $this->_auth->assign( $this->_auth->getRole($data['authitem']['name']), $userModel->id ); 
      }

      if( strlen( $data['dropRole'] ) > 0 )
      {
         print( "dropRole > 0" );
         $this->_auth->revoke ( $this->_auth->getRole($data['authassignment']['item_name']), $userModel->id ); 
      }

      $roleModel  = AuthAssignment::find();
      
      $assignedRoles = [];
      foreach( $userModel->roles as $role )
      {
         $assignedRoles[] = $role->item_name;
      }
      
      $authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);      

      return $this->render('user-view', [
         'data' => $data, 
         'dataProvider' => $dataProvider,
         'model'        => $userModel,
         'roles'        => $roleModel,
         'allRoles'     => $authItemModel,
      ]);
   }
}