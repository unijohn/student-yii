<?php

namespace app\controllers;

use yii;

//use yii\data\ActiveDataProvider;
//use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;

//use app\models\AuthAssignment;
//use app\models\AuthItem;
//use app\models\SystemCodes;
//use app\models\SystemCodesChild;
//use app\models\User;


class BaseController extends Controller
{

   /**
    * Quick note:  to extend these values into controllers further down the line,
    *              make them `public`.  `private` will restrict them to the 
    *              BaseController only.
    **/
   public $_auth;
   public $_data;
   public $_dataProvider;
   public $_request;
   public $_view;
   public $_user;
   
   
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
      $this->_view      = Yii::$app->view;
      $this->_user      = Yii::$app->user;            
      
      $this->_data             = [];
      $this->_dataProvider     = [];
      
      /**
       *    Capturing the possible post() variables used across all controllers
       **/
      $this->_data['id']   = $this->_request->post( 'id', '' );
      
      $this->_data['errors']  = [];   
      $this->_data['success'] = [];
   }   


    /**
     * {@inheritdoc}
     */
 
    public function behaviors()
    {   
        return [
/**        
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
 **/
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
}
