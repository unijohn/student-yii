<?php

namespace app\controllers\permits;

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


class ManageAdminController extends Controller
{
   private $_auth;
   private $_data;
   private $_dataProvider;
   private $_request;
   private $_codesModel;
   private $_codeChildModel;
   private $_tagsModel;

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
    * Centralizing the query for building the Permit GridView
    *
    * @return SqlDataProvider
    */ 
   private function getPermitGridView()
   {
      $params[':type']  = 1; 
      
      $count = Yii::$app->db->createCommand(
         'SELECT COUNT(*) FROM tbl_SystemCodes WHERE type =:type ',
         [':type' => $params[':type']])->queryScalar();
      
/**
      $sql  =  "SELECT  id, uuid, name, is_active, ";
      $sql .=  "        datetime(created_at, 'unixepoch') as created_at, datetime(updated_at, 'unixepoch') as updated_at " ;
      $sql .= "FROM tbl_Users WHERE id >=:id ";
 **/
       
      $sql  = "SELECT  id, code, description, is_active, created_at, updated_at " ;
      $sql .= "FROM tbl_SystemCodes WHERE type =:type ";

/**
      if( strlen ($this->_data['filterForm']['uuid'] ) > 0 )
      {
         $sql .= "AND uuid LIKE :uuid ";
         $params[':uuid'] = '%' . $this->_data['filterForm']['uuid'] . '%';      
      }
      
      if(  $this->_data['filterForm']['is_active'] > -1 && strlen(  $this->_data['filterForm']['is_active'] ) > 0 )
      {
         $sql .= "AND is_active =:is_active ";
         $params[':is_active']   = $this->_data['filterForm']['is_active'];         
      }
 **/
      
      $PermitSDP = new SqlDataProvider ([
         'sql'          => $sql,
         'params'       => $params,
         'totalCount'   => $count,
         'sort' => [
            'attributes' => [
               'code' => [
                  'default' => SORT_ASC,
                  'label' => 'Code',
               ],
 
               'description' => [
                  'default' => SORT_ASC,
                  'label' => 'description',
               ],
/**         
               'is_active' => [
                  'default' => SORT_ASC,
                  'label' => 'Status',
               ],
 **/               
               'created_at',
               'updated_at',                              
            ],
         ],         
         'pagination' => [
            'pageSize' => 10,
         ],
/**                  
         'pagination' => [
            'pageSize' => $this->_data['filterForm']['paginationCount'],
         ],
 **/
      ]); 
      
      return $PermitSDP;
   }


   /**
   * Displays homepage.
   *
   * @return string
   */
   public function actionIndex()
   {
      $this->_dataProvider = $this->getPermitGridView();

      return $this->render('permits-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_codesModel,
      ]); 
   }


   /**
    * Displays selected Permit ( 1 record ).
    *
    * @return string
    */
   public function actionView()
   {  
      $this->_data['id']     = $this->_request->get('id', '');

      $this->_codesModel = SystemCodes::find()
         ->where(['id' => $this->_data['id'] ])
         ->limit(1)->one();

      $this->_tagsModel       = SystemCodes::findPermitTagsById( $this->_data['id'] );
      $this->_codeChildModel  = SystemCodes::findPermitTagOptions();

      return $this->render('permit-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_codesModel,
            'tags'         => $this->_tagsModel,
            'allTags'      => $this->_codeChildModel,
      ]);      
   }
}