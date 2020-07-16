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
   private $_isUserIdentityEmpty;

   public function init()
   {
      parent::init();
      
      $this->_isUserIdentityEmpty = false;
      
      if( is_null( Yii::$app->user->identity ) )
      {
         $this->_isUserIdentityEmpty = true;
      }
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
      $auth    = Yii::$app->authManager;
      $request = Yii::$app->request;
      
      $data             = [];
      $dataProvider     = [];

      $userModel        = new User();
      
      /**
       *  Quick fix for cookie timeout
       **/
      
      if( $this->_isUserIdentityEmpty )
      {
         return $this->render('users-listing', [
            'data' => $data, 
            'dataProvider' => $dataProvider,
            'model'        => $userModel,
         ]);   
      } 

      $userModel->uuid        = ArrayHelper::getValue($request->get(), 'User.uuid',      '');
      $userModel->is_active   = ArrayHelper::getValue($request->get(), 'User.is_active', '-1');

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
            'pageSize' => 30,
         ],
      ]); 

      return $this->render('users-listing', [
            'data' => $data, 
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
      $auth    = Yii::$app->authManager;
      $request = Yii::$app->request;
      
      $data             = [];
      $dataProvider     = [];

      $userModel        = new User();
      $roleModel        = new AuthAssignment();
      $authItemModel    = new AuthItem();
      
      /**
       *  Quick fix for cookie timeout
       **/
      
      if( $this->_isUserIdentityEmpty )
      {
         return $this->render('user-view', [
            'data' => $data, 
            'dataProvider' => $dataProvider,
            'model'        => $userModel,
            'roles'        => $roleModel,
            'allRoles'     => $authItemModel,
         ]);   
      } 


      $user = User::find()
         ->where(['uuid' => $request->get('uuid', '')])
         ->limit(1)->one();

      $roles      = AuthAssignment::find();

      
      $assignedRoles = [];
      foreach( $user->roles as $role )
      {
         $assignedRoles[] = $role->item_name;
      }
      
      $allRoles   = AuthItem::findbyUnassignedRoles($assignedRoles);      
         
/**
      print( "<h1>What</h1><pre>" );   
      print_r( $user);
      print( "</pre>" );
      die();
 **/

      return $this->render('user-view', [
            'data' => $data, 
            'dataProvider' => $dataProvider,
            'model'        => $user,
            'roles'        => $roles,
            'allRoles'     => $allRoles,
      ]);      
   }   
}