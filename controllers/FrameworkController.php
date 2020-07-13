<?php

namespace app\controllers;

use yii;
use yii\filters\AccessControl;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\User;
use app\models\TempAuthAssignment;

class FrameworkController extends Controller
{
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
   public function actionTestrole()
   {
      $auth    = Yii::$app->authManager;
      $request = Yii::$app->request;
      
      $data = [];

      /**
       *  Quick fix for cookie timeout
       **/
      
      if( is_null( Yii::$app->user->identity ) )
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
            
            $currentRole->revokePermanentRoles( $userId );
         
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
      
      return $this->render('testRole', [
         'data' => $data,
      ]);      
   }

   /**
   * [Documentation needed]
   *
   * @return [value]
   */
   public function actionResetrole()
   {
      $auth    = Yii::$app->authManager;
      $request = Yii::$app->request;
      
      $data = [];

      /**
       *  Quick fix for cookie timeout
       **/
      
      if( is_null( Yii::$app->user->identity ) )
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

      
      if( !empty( $userId ) && isset( $userId ) )
      { 
         $isStored = $currentRole->storePermanentRoles( $userId, $request->get('role') );      
      
         if( $isStored )
         {
            $currentRoles = $auth->getRolesByUser($userId);
            
            $currentRole->revokePermanentRoles( $userId );
         
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
  **/      
      return $this->render('testRole', [
         'data' => $data,
      ]);      
   }      

}