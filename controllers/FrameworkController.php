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


class FrameworkController extends Controller
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