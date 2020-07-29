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

use app\models\SystemCodes;
use app\models\SystemCodesChild;


class PermitsController extends Controller
{
{
   private $_auth;
   private $_data;
   private $_dataProvider;
   private $_request;
   private $_permitModel;
   private $_tagsModel;

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

      $this->_permitModel     = new SystemCodes();
      $this->_tagsModel       = new AuthAssignment();

/**
      $this->_data['filterForm']['uuid']              = ArrayHelper::getValue($this->_request->get(), 'User.uuid',      '');
      $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'User.is_active', -1);
      $this->_data['filterForm']['paginationCount']   = $this->_request->get( 'pagination_count', 10 );
 **/
      
      /**
       *    Capturing the possible post() variables used in this controller
       **/      

/**
      $this->_data['post']['uuid']           = $this->_request->post('uuid',     '' );

      if( strlen( $this->_data['post']['uuid'] ) < 1 )
      {
         $this->_data['post']['uuid']        = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '' ); 
      }

      $this->_data['post']['addRole']        = $this->_request->post('addRole',        '' );
      $this->_data['post']['dropRole']       = $this->_request->post('dropRole',       '' );
      $this->_data['post']['authitem']       = $this->_request->post('authitem',       '' );
      $this->_data['post']['authassignment'] = $this->_request->post('authassignment', '' );
 **/
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}