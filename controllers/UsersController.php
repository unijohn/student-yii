<?php

namespace app\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\data\SQLDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

use app\models\User;

class UsersController extends Controller
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
      $count = Yii::$app->db->createCommand(
         'SELECT COUNT(*) FROM tbl_Users WHERE id >=:id ',
         [':id' => 1])->queryScalar();
      
      $dataProvider = new SqlDataProvider ([
         'sql' => 'SELECT * FROM tbl_Users WHERE id >=:id',
         'params' => [':id' => 1],
         'totalCount' => $count,
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
               'created_at',
               'updated_at',                              
            ],
         ],         
         'pagination' => [
            'pageSize' => 30,
         ],
      ]);               

      return $this->render('index', ['dataProvider' => $dataProvider]);   
   }

   public function actionList()
   {
   }   

}