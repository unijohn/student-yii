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
   private $_db;
   private $_request;
   private $_codesModel;
   private $_codeChildModel;
   private $_tagsModel;

   private $_tbl_SystemCodes;
   private $_tbl_SystemCodesChild;

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
      $this->_db        = Yii::$app->db;
      $this->_request   = Yii::$app->request;  
      
      $this->_data             = [];
      $this->_dataProvider     = [];

      $this->_codesModel            = new SystemCodes();
      $this->_codeChildModel        = new SystemCodesChild();
      
      $this->_tbl_SystemCodes       = SystemCodes::tableName();
      $this->_tbl_SystemCodesChild  = SystemCodesChild::tableName();
      
      /**
       *    Capturing the possible post() variables used in this controller
       **/
      $this->_data['id']               = $this->_request->post('id',       '' );
      
      if( strlen( $this->_data['id'] ) < 1 )
      {
         $this->_data['id']     = $this->_request->get('id', ''); 
      }
      
      if( strlen( $this->_data['id'] ) > 0 )
      {
         $this->_codesModel = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->limit(1)->one();
            
         $this->_tagsModel       = SystemCodes::findPermitTagsById( $this->_data['id'] );
         $this->_codeChildModel  = SystemCodes::findUnassignedPermitTagOptions( $this->_data['id']);
      }
       
      $this->_data['tagid']            = $this->_request->post('tagid',    '' );      
      $this->_data['addTag']           = $this->_request->post('addTag',   '' );
      $this->_data['dropTag']          = $this->_request->post('dropTag',  '' );       
         
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
      
      $count = $this->_db->createCommand(
         "SELECT COUNT(*) FROM " . $this->_tbl_SystemCodes . " WHERE type =:type ",
         [':type' => $params[':type']])->queryScalar();
           
      $sql  = "SELECT  id, code, description, is_active, created_at, updated_at " ;
      $sql .= "FROM " . $this->_tbl_SystemCodes . " WHERE type =:type ";
      
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
      return $this->render('permit-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_codesModel,
            'tags'         => $this->_tagsModel,
            'allTags'      => $this->_codeChildModel,
      ]);      
   }
   
   
   /**
    * Saving changes to Permit and Tag information
    *
    * @return (TBD)
    */
   public function actionSave()
   {  
      $isError = false;

/**
print( "<pre>");
print_r( $this->_request->post() );
die();
 **/
 
      $tagRelationExists = SystemCodesChild::find()
         ->where([ 'parent' => $this->_data['id'] ])
         ->andWhere([ 'child' => $this->_data['tagid'] ])
         ->limit(1)
         ->one(); 
         
      $tagChild = SystemCodes::find()
         ->where([ 'id' => $this->_data['tagid'] ])
         ->limit(1)
         ->one();

      if( strlen( $this->_data['addTag'] ) > 0 )
      {
         if( !is_null( $tagRelationExists ) )
         {        
            $this->_data['errors']['Add Tag'] = [
               'value'     => "was unsuccessful",
               'bValue'    => false,
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
            
            $this->_data['errors'][$tagChild['description']] = [
               'value' => "was not added; relationship already exists.",
            ];
            
            $isError = true;
         }

         if( !$isError )
         {
            if( $this->addTag( $this->_data['tagid'], $this->_data['id'] ) )
            { 
               $tag = SystemCodes::find()
                  ->where([ 'id' => $this->_data['tagid'] ])
                  ->limit(1)
                  ->one();
            
               $this->_data['success']['Add Tag'] = [
                  'value'        => "was successful",
                  'bValue'       => true,
                  'htmlTag'      => 'h4',
                  'class'        => 'alert alert-success', 
               ];
               
               $this->_data['success'][$tagChild['description']] = [
                  'value' => "was added",
               ];
            }
            else
            {
               $this->_data['errors']['Add Tag'] = [
                  'value'     => "was unsuccessful",
                  'bValue'    => false,
                  'htmlTag'   => 'h4',
                  'class'     => 'alert alert-danger',
               ];
               
               $this->_data['errors']['Add Permit Tag'] = [
                  'value' => "was not successful; no tags were added.",
               ];
            }
         }    
      }

      if( strlen( $this->_data['dropTag'] ) > 0 )
      {
         if( $this->removeTag( $this->_data['tagid'], $this->_data['id'] ) )
         {
            $this->_data['success']['Remove Tag'] = [
               'value'        => "was successful",
               'bValue'       => true,
               'htmlTag'      => 'h4',
               'class'        => 'alert alert-success', 
            ];
            
            $this->_data['success'][$tagChild['description']] = [
               'value' => "was removed",
            ];
         }
         else
         {
            $this->_data['errors']['Remove Tag'] = [
               'value'     => "was unsuccessful",
               'bValue'    => false,
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
            
            $this->_data['errors'][$tagChild['description']] = [
               'value' => "was not successful; no tags were removed.",
            ];
         }  
      }

      $this->_tagsModel       = SystemCodes::findPermitTagsById( $this->_data['id'] );

      return $this->render('permit-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_codesModel,
            'tags'         => $this->_tagsModel,
            'allTags'      => $this->_codeChildModel,
      ]);  
   }   
   

   /**
    * Adds tag assigned to Permit
    *
    * @return bool if rows deleted are > 0
    */
    public function addTag($tagId, $permitId)
    {
/**
   Need to add error catching later or handle it in action before getting this far
  
        if ($this->isEmptyUserId($userId)) {
            return false;
        }
        
        unset($this->_checkAccessAssignments[(string) $userId]);
 **/

        return $this->_db->createCommand()
            ->insert($this->_tbl_SystemCodesChild, ['parent' => (integer) $permitId, 'child' => (integer) $tagId])
            ->execute() > 0;
    }


   /**
    * Removes tag assigned to Permit
    *
    * @return bool if rows deleted are > 0
    */
    public function removeTag($tagId, $permitId)
    {
/**
   Need to add error catching later or handle it in action before getting this far
  
        if ($this->isEmptyUserId($userId)) {
            return false;
        }
        
        unset($this->_checkAccessAssignments[(string) $userId]);
 **/

        return $this->_db->createCommand()
            ->delete($this->_tbl_SystemCodesChild, ['parent' => (integer) $permitId, 'child' => (integer) $tagId])
            ->execute() > 0;
    }

}