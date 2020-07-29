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
   private $_auth;
   private $_data;
   private $_dataProvider;
   private $_request;
   private $_codesModel;
   private $_codeChildModel;


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

      $this->_codesModel      = new SystemCodes();
      $this->_codeChildModel  = new SystemCodesChild();
      
      /**
       *    Capturing the possible post() variables used in this controller
       **/      
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
}