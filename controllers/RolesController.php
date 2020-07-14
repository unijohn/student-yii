<?php

namespace app\controllers;

use yii;
use yii\data\ActiveDataProvider;
use yii\data\SQLDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;


use app\models\User;
use app\models\UserSearch;
use app\models\TempAuthAssignment;


class RolesController extends Controller
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
    public function behaviors()
    {  
       return [
           'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'index'  => ['get'],
/**                
                   'view'   => ['get'],
                   'create' => ['get', 'post'],
                   'update' => ['get', 'put', 'post'],
                   'delete' => ['post', 'delete'],
 **/
               ],
           ],
      ];
   }
  

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
   /**
   * [Documentation needed]
   *
   * @return [value]
   */
   public function actionSwitch()
   {
      $auth    = Yii::$app->authManager;
      $request = Yii::$app->request;
      
      $data = [];

      /**
       *  Quick fix for cookie timeout
       **/
      
      if( $this->_isUserIdentityEmpty )
      {
         return $this->render('testRole', [
            'data' => $data,
         ]);   
      }      
      
      $userId  = Yii::$app->user->identity->getId();
      $newRole = $request->get( 'role', 'missing' );
   
/*      
      if( !empty( $userId ) && isset( $userId ) )
      {      
         $data = 
         [
            'getRoles' => [ 
               $auth->getRolesByUser($userId)
            ],
         ];
      }
 */
 
      $currentRole = new TempAuthAssignment();

 /**
      print_r( $newRole . PHP_EOL );
      print_r( "atR(): " . $currentRole->assignTemporaryRole( $newRole ) );
      die();  
  **/
      
      if( !empty( $userId ) && isset( $userId ) )
      { 
         $isStored = $currentRole->storePermanentRoles( $userId, $request->get('role') );      
      
         if( $isStored )
         {
            $currentRoles = $auth->getRolesByUser($userId);
            
            $currentRole->revokeRoles( $userId );
         
            foreach( $currentRoles as $key => $roles )
            {
               $data['getRole'][$key] = [ 
                  'type'         => $roles->type,
                  'description'  => $roles->description,
               ];
            }

            if( $currentRole->assignTemporaryRole( $newRole ) )
            {            
               $data['newRole'][$newRole] = [
                  'type'            => 1,
                  'description'     => $newRole,
               ];
            }
            else 
            {
               $data['newRole'][$newRole] = [
                  'type'            => -1,
                  'description'     => 'assignTempRoleFailed',
               ];
            }
         }
         else
         {
            $data['getRole']['TempRoleAssigned'] = [ 
               'type'            => 'N/A',
               'description'     => 'Unable to complete; restore roles before assuming another role',
            ];  
         }          
      }
      
      return $this->render('actionRole', [
         'data' => $data,
      ]);      
   }
   

   /**
   * [Documentation needed]
   *
   * @return [value]
   */
   public function actionReset()
   {
      $auth    = Yii::$app->authManager;
      $request = Yii::$app->request;
      
      $data = [];

      /**
       *  Quick fix for cookie timeout
       **/
      
      if( $this->_isUserIdentityEmpty )
      {
         return $this->render('testRole', [
            'data' => $data,
         ]);   
      }      
      
      $userId  = Yii::$app->user->identity->getId();
      $reset   = $request->get( 'reset', 'missing' );
   
/*      
      if( !empty( $userId ) && isset( $userId ) )
      {      
         $data = 
         [
            'getRoles' => [ 
               $auth->getRolesByUser($userId)
            ],
         ];
      }
 */
 
      $restoreRole = new TempAuthAssignment();
      
      $isRestored = $restoreRole->restorePermanentRoles();
   
      return $this->render('actionRole', [
         'data' => $data,
      ]);      
   }
}