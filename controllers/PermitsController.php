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

use app\controllers\BaseController;

use app\models\SystemCodes;
use app\models\SystemCodesChild;

class PermitsController extends BaseController
{
    private $_codesModel;
    private $_codeChildModel;


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

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
    * @inheritdoc
    */
    public function actions()
    {
        $actions = parent::actions();
   
        return $actions;
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
