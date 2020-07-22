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
use yii\web\View;


use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\User;
use app\models\UserSearch;
use app\models\TempAuthAssignment;


class RolesController extends Controller
{
   private $_auth;
   private $_authItemModel;
   private $_data;
   private $_dataProvider;
   private $_newRole;
   private $_request;
   private $_reset;
   private $_roleModel;
   private $_user;
   private $_userId;
   private $_userModel;
   private $_view;
   

   public function init()
   {
      parent::init();
      
      /**
       *  Quick fix for cookie timeout
       **/      
      
      $this->_user      = Yii::$app->user;      
      
      if( is_null( $this->_user->identity ) )
      {
         /* /site/index works but trying to learn named routes syntax */
         return $this->redirect(['/site/index']);
      }
      
      $this->_auth      = Yii::$app->authManager;
      $this->_request   = Yii::$app->request;  
      $this->_view      = Yii::$app->view;
      
      $this->_data             = [];

      $this->_userModel        = new User();
      $this->_roleModel        = new AuthAssignment();
      $this->_authItemModel    = new AuthItem();

      /**
       *    Capturing the possible get() variables used in this controller
       **/    

      $this->_newRole   = $this->_request->get( 'role', '' );
      $this->_reset     = $this->_request->get( 'reset', 'missing' );      
      $this->_userId    = $this->_user->identity->getId(); 
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
      
      if( !empty( $this->_userId ) && isset( $this->_userId ) &&
          !empty( $this->_newRole ) && isset( $this->_newRole ) )
      { 
         $isStored = $currentRole->storePermanentRoles( $this->_userId, $this->_newRole );      
      
         if( $isStored )
         {
            $currentRoles = $this->_auth->getRolesByUser( $this->_userId );
            
            $currentRole->revokeRoles( $this->_userId );
         
            foreach( $currentRoles as $key => $roles )
            {
               $data['getRole'][$key] = [ 
                  'type'         => $roles->type,
                  'description'  => $roles->description,
               ];
            }

            if( $currentRole->assignTemporaryRole( $this->_newRole ) )
            {            
               $data['newRole'][$this->_newRole] = [
                  'type'            => 1,
                  'description'     => $this->_newRole,
               ];
               
               $this->_data['success']['Switch Role'] = [
                  'value'        => "was successful",
                  'bValue'       => true,
                  'htmlTag'      => 'h4',
                  'class'        => 'alert alert-success',
                  'type'         => 1,
                  'description'  => $this->_newRole,      
               ];
               
               $this->_data['success'][$this->_newRole] = [
                  'value'     => "is now the role for this account.",
                  'bValue'    => true,
               ];                
               
            }
            else 
            {
               $this->_data['errors']['Switch Role'] = [
                  'value'     => "was unsuccessful",
                  'htmlTag'   => 'h4',
                  'class'     => 'alert alert-danger',
               ];
      
               $this->_data['errors']['Temp Role'] = [
                  'value' => "assignment failed",      
               ];                        
            }
         }
         else
         {  
            $this->_data['errors']['Switch Role'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
   
            $this->_data['errors']['Temp Role'] = [
               'value' => "is already assigned; restore role before assuming a new role",      
            ];            
         }          
      }
      else
      {
         $this->_data['errors']['Switch Role'] = [
            'value'     => "was unsuccessful",
            'htmlTag'   => 'h4',
            'class'     => 'alert alert-danger',
         ];

         $this->_data['errors']['userId-newRole'] = [
            'value' => "are missing",      
         ];
      }

      $this->_view->params['data'] = $this->_data;
      
      return $this->render('/site/index', [
         'data' => $this->_data,
      ]);      
   }
   

   /**
   * [Documentation needed]
   *
   * @return [value]
   */
   public function actionReset()
   {
      $restoreRole = new TempAuthAssignment();
      
      $isRestored = $restoreRole->restorePermanentRoles();
      
      if( $isRestored )
      {
         $this->_data['success']['Restore Roles'] = [
            'value'        => "was successful",
            'bValue'       => true,
            'htmlTag'      => 'h4',
            'class'        => 'alert alert-success', 
         ];
         
         $this->_data['success']['Restore Permanent Roles'] = [
            'value' => "was successful",
         ];   
      }
      else
      {
         $this->_data['errors']['Restore Roles'] = [
            'value'     => "was unsuccessful",
            'bValue'    => false,
            'htmlTag'   => 'h4',
            'class'     => 'alert alert-danger',
         ];

         if( !$restoreRole->existsTemporaryEntries() )
            $this->_data['errors']['Temp Role'] = [
               'value' => "is not assigned; nothing to reset.",
            ];
      }  

      $this->_view->params['data'] = $this->_data;
   
      return $this->render('/site/index', [
         'data' => $this->_data,
      ]);      
   }
}