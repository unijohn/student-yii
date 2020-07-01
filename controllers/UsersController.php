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
      return $this->render('index');
   }

   public function actionList()
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
         
   
/**      
      $dataProvider = new ActiveDataProvider([
         'query' => User::find(),
         'pagination' => [
            'pageSize' => 30,
         ],
      ]);
      
      $users = $dataProvider->getModels();   


      print( "<pre>" );
      print_r ( $provider );
      print( "</pre>" );
      
      die();
 **/

      return $this->render('list', ['dataProvider' => $dataProvider]);   

      //$this->view_title = 'Test List';
      
      return $this->render('list', ['dataProvider' => $dataProvider, ]);
   }   

}