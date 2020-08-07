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

class CodesController extends Controller
{
   const dropDownOptsKeys   = [ 'pageCount', 'type', 'is_active', 'is_hidden' ];

   private $_auth;
   private $_data;
   private $_dataProvider;
   private $_db;
   private $_dropDownOptsKeys;
   private $_request;
   private $_systemCodes;


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
      
      $this->_data               = [];
      $this->_dataProvider       = [];

      $this->_systemCodes        = new SystemCodes();
      

      
      $this->_data['filterForm']['type']              = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.type',        '');    
      $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.is_active',   -1);
      $this->_data['filterForm']['is_hidden']         = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.is_hidden',   -1);      
      $this->_data['filterForm']['paginationCount']   = $this->_request->get( 'pagination_count', 10 );

      
      /**
       *    Capturing the possible post() variables used in this controller
       **/
      $this->_data['id']   = $this->_request->post('id',       '' );
      
      if( strlen( $this->_data['id'] ) < 1 )
      {
         $this->_data['id']   = $this->_request->get('id', ''); 
      }
      
      if( strlen( $this->_data['id'] ) > 0 )
      {
         $this->_systemCodes = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->limit(1)->one();
            
//         $this->_tagsModel       = SystemCodes::findPermitTagsById( $this->_data['id'] );
//         $this->_codeChildModel  = SystemCodes::findUnassignedPermitTagOptions( $this->_data['id']);
      }   

/** 
      $this->_data['tagid']            = $this->_request->post('tagid',    '' );      
      $this->_data['addTag']           = $this->_request->post('addTag',   '' );
      $this->_data['dropTag']          = $this->_request->post('dropTag',  '' );     
 **/
  
      $this->_data['SystemCodes']['code']          = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.code',        '');      
      $this->_data['SystemCodes']['description']   = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.description', '');
      $this->_data['SystemCodes']['id']            = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.id',          '');
      $this->_data['SystemCodes']['insert']        = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.insert',      '');      
      $this->_data['SystemCodes']['is_active']     = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.is_active',   -1);
      $this->_data['SystemCodes']['is_hidden']     = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.is_hidden',   -1);
      $this->_data['SystemCodes']['type']          = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.type',        '');
      $this->_data['SystemCodes']['update']        = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.update',      '');
      
      /**
       *    if inserting a new record, set the filter to that new record's type as a UX feature
       **/  
      if( isset( $this->_data['SystemCodes']['type'] ) && !empty( $this->_data['SystemCodes']['type'] ) )
      {
         $this->_data['filterForm']['type'] = $this->_data['SystemCodes']['type'];
      }
  
      $this->_data['errors']  = [];   
      $this->_data['success'] = [];
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
    * Centralizing the query for building the User GridView
    *
    * @return SqlDataProvider
    */ 
   private function getCodesGridView()
   {
      $tableNm = SystemCodes::tableName();
      
      $params  = [];
      
//      $params[':table_name']  = Courses::tableName();
//      $params[':id']          = 1;     

      $sql  = "SELECT  id, type, code, description, is_active, is_hidden, created_at, updated_at " ;
      $sql .= "FROM " . $tableNm . " WHERE id > 0 ";

      $countSQL  = "SELECT COUNT(*) " ;
      $countSQL .= "FROM " . $tableNm . " WHERE id > 0 ";

      if(  $this->_data['filterForm']['type'] > 0 && strlen(  $this->_data['filterForm']['type'] ) > 0 )      
      {
         $andWhere = "AND type =:type ";
      
         $sql        .= $andWhere;
         $countSQL   .= $andWhere;
         
         $params[':type']   = $this->_data['filterForm']['type'];   
      }
      
      if(  $this->_data['filterForm']['is_active'] > -1 && strlen(  $this->_data['filterForm']['is_active'] ) > 0 )
      {
         $andWhere = "AND is_active =:is_active ";
      
         $sql        .= $andWhere;
         $countSQL   .= $andWhere;
         
         $params[':is_active']   = $this->_data['filterForm']['is_active']; 
      }
      
      if(  $this->_data['filterForm']['is_hidden'] > -1 && strlen(  $this->_data['filterForm']['is_hidden'] ) > 0 )
      {
         $andWhere = "AND is_hidden =:is_hidden ";
      
         $sql        .= $andWhere;
         $countSQL   .= $andWhere;   
      }
      
      $count = Yii::$app->db->createCommand(
         $countSQL,
         $params,
      )->queryScalar();      
      
      $CodesSDP = new SqlDataProvider ([
         'sql'          => $sql,
         'params'       => $params,
         'totalCount'   => $count,
         'sort' => [
            'defaultOrder' => [ 
               'id'           => SORT_ASC,
            ],
            'attributes' => [
               'id' => [
                  'default' => SORT_ASC,
                  'label' => 'ID',
               ],
               'type' => [
                  'default' => SORT_ASC,
                  'label' => 'Type',
               ],

               'code' => [
                  'default' => SORT_ASC,
                  'label' => 'Code',
               ],

               'description' => [
                  'default' => SORT_ASC,
                  'label' => 'Description',
               ],               
/**               
               'is_active' => [
                  'default' => SORT_ASC,
                  'label' => 'Status',
               ],

               'created_at',
               'updated_at',
 **/
            ],
         ],         
         'pagination' => [
            'pageSize' => $this->_data['filterForm']['paginationCount'],
         ],
      ]); 
      
      return $CodesSDP;
   }


   /**
    * Displays listing of all users in the system.
    *
    * @return string
    */
   public function actionIndex()
   {
      $this->_dataProvider = $this->getCodesGridView();

      return $this->render('codes-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_systemCodes,
      ]);      
   }
   

   /**
    * Displays selected Permit ( 1 record ).
    *
    * @return string
    */
   public function actionView()
   {  
      return $this->render('codes-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_systemCodes,
//            'tags'         => $this->_tagsModel,
//            'allTags'      => $this->_codeChildModel,
      ]);      
   }


   /**
    * Adding new Course information
    *
    * @return (TBD)
    */
   public function actionAdd()
   {
      $this->_dataProvider = $this->getCodesGridView();    
      
      $this->_systemCodes->type        = $this->_data['SystemCodes']['type'];
      $this->_systemCodes->code        = $this->_data['SystemCodes']['code']; 
      $this->_systemCodes->description = $this->_data['SystemCodes']['description']; 

      $exitEarly = false;

      if( isset( $this->_data['SystemCodes']['insert'] ) && !empty( $this->_data['SystemCodes']['insert'] ) )
      {
         if( !isset( $this->_systemCodes->code ) || empty( $this->_systemCodes->code ) )
         {
            $this->_data['errors']['Add System Code'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];

            $this->_data['errors']['code'] = [
               'value' => "is blank",      
            ];

            $exitEarly = true;
         }
      
         if( !isset( $this->_systemCodes->description ) || empty( $this->_systemCodes->description ) )
         {

            $this->_data['errors']['Add System Code'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
            
            $this->_data['errors']['description'] = [
               'value' => "is blank",      
            ];      
            
            $exitEarly = true;
         }
      }        

      if( $exitEarly )
      {
         return $this->render('codes-listing', [
               'data'         => $this->_data, 
               'dataProvider' => $this->_dataProvider,
               'model'        => $this->_systemCodes,
         ]); 
      }

      $idExists = SystemCodes::existsSystemCode( $this->_systemCodes->type, $this->_systemCodes->code  );         
      
      if( $idExists )
      {
         if( isset( $this->_data['SystemCodes']['insert'] ) && !empty( $this->_data['SystemCodes']['insert'] ) )
         {
            $this->_data['errors']['Add System Code'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];

            $keyError          = $this->keyLookup( 'type', $this->_systemCodes->type );
            $keyError['type'] .= " ( " . $this->_systemCodes->code . " )";

            $this->_data['errors'][$keyError['type']] = [
               'value' => "already exists",      
            ];
            
            $this->_data['filterForm']['type'] = $this->_systemCodes->type;
         }
         
         return $this->render('codes-listing', [
               'data'         => $this->_data, 
               'dataProvider' => $this->_dataProvider,
               'model'        => $this->_systemCodes,
         ]);          
      }
      
      $updateModel            = new SystemCodes();
      
      $updateModel->scenario  = SystemCodes::SCENARIO_INSERT;      

      $updateModel->type         = $this->_data['SystemCodes']['type'];
      $updateModel->code         = $this->_data['SystemCodes']['code'];
      $updateModel->description  = $this->_data['SystemCodes']['description'];
//      $updateModel->is_active    = SystemCodes::STATUS_ACTIVE;  
//      $updateModel->is_hidden    = SystemCodes::STATUS_VISIBLE;      

      $this->_data['SystemCodes']['insert'] = $updateModel->save();   
         
//      $updateColumns = $updateModel->afterSave( false, $this->_data['addSystemCode']);

      if( !$this->_data['SystemCodes']['insert'] )
      {
         $this->_data['errors']['Add System Code'] = [
            'value'     => "was unsuccessful",
            'htmlTag'   => 'h4',
            'class'     => 'alert alert-danger',
         ];
         
         $this->_data['errors']['system code'] = [
            'value'     => "was not saved",
         ];               
      }
      else
      {
         $this->_data['success']['Add System Code'] = [
            'value'     => "was successful",
            'bValue'    => true,
            'htmlTag'   => 'h4',
            'class'     => 'alert alert-success',
         ];
         
         $keySuccess          = $this->keyLookup( 'type', $this->_systemCodes->type );            
         $keySuccess['type'] .= " ( " . $this->_systemCodes->code . " )";         
         
         $this->_data['success'][$keySuccess['type']] = [
            'value'     => "was added",
            'bValue'    => true,
         ];  
      }

      $this->_dataProvider = $this->getCodesGridView();

      return $this->render('codes-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_systemCodes,
      ]); 
   }
   
   
   /**
    * Saving changes to System Codes and associated information
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
 
/**
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
 **/      

/** 
      $this->_data['SystemCodes']['code']          = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.code',        '');      
      $this->_data['SystemCodes']['description']   = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.description', '');
      $this->_data['SystemCodes']['id']            = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.id',          '');
      $this->_data['SystemCodes']['insert']        = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.insert',      '');      
      $this->_data['SystemCodes']['is_active']     = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.is_active',   -1);
      $this->_data['SystemCodes']['is_hidden']     = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.is_hidden',   -1);
      $this->_data['SystemCodes']['type']          = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.type',        '');
      $this->_data['SystemCodes']['update']        = ArrayHelper::getValue($this->_request->post(),   'SystemCodes.update',      '');
 **/

      if( isset( $this->_data['SystemCodes']['update'] ) && !empty( $this->_data['SystemCodes']['update']  ) )
      {
         $this->_systemCodes->id          = $this->_data['SystemCodes']['id'];
         $this->_systemCodes->type        = $this->_data['SystemCodes']['type'];
         $this->_systemCodes->code        = $this->_data['SystemCodes']['code'];
         $this->_systemCodes->description = $this->_data['SystemCodes']['description'];
   
         $exitEarly = false;

         if( !isset( $this->_systemCodes->type ) || empty( $this->_systemCodes->type ) )
         {
            $this->_data['errors']['Save System Code'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];

            /**
               Unsure what kind of error will be caught here; TBD
             **/
             
            $this->_data['errors']['type'] = [
               'value' => "is invalid",      
            ];      
            
            $exitEarly = true;
         }
         
         if( !isset( $this->_systemCodes->code ) || empty( $this->_systemCodes->code ) )
         {
            $this->_data['errors']['Save System Code'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
   
            $this->_data['errors']['code'] = [
               'value' => "is blank",      
            ];      
            
            $exitEarly = true;
         }      
         
         if( !isset( $this->_systemCodes->description ) || empty( $this->_systemCodes->description ) )
         {
            $this->_data['errors']['Save System Code'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
   
            $this->_data['errors']['description'] = [
               'value' => "is blank",      
            ];      
   
            $exitEarly = true;
         }        
   
         if( $exitEarly )
         {  
            return $this->render('codes-view', [
                  'data'         => $this->_data, 
                  'dataProvider' => $this->_dataProvider,
                  'model'        => $this->_systemCodes,
      //            'tags'         => $this->_tagsModel,
      //            'allTags'      => $this->_codeChildModel,
            ]);  
         }   
      
         $updateModel      = SystemCodes::findOne( $this->_systemCodes->id );
         
         $updateModel->scenario = SystemCodes::SCENARIO_UPDATE;
 
         $updateModel->code         = $this->_data['SystemCodes']['code'];
         $updateModel->description  = $this->_data['SystemCodes']['description'];         

         //$updateColumns = $updateModel->getDirtyAttributes();     

         $updateModel->type         = $this->_data['SystemCodes']['type'];
         $updateModel->is_active    = $this->_data['SystemCodes']['is_active'];
         $updateModel->is_hidden    = $this->_data['SystemCodes']['is_hidden'];

         $this->_data['SystemCodes']['update'] = $updateModel->save();   
         
         $updateColumns = $updateModel->afterSave( false, $this->_data['SystemCodes']['update']);

         if( $this->_data['SystemCodes']['update'] && is_array( $updateColumns ) )
         {
            
            if( count( $updateColumns ) > 0 )
            {
               $this->_data['success']['Save System Code'] = [
                  'value'     => "was successful",
                  'bValue'    => true,
                  'htmlTag'   => 'h4',
                  'class'     => 'alert alert-success',
               ];
               
               foreach( $updateColumns as $key => $val )
               {     
                  $keyIndex = ucfirst( strtolower(str_replace( "_", " ", $key )) );
               
                  if( $key !== "updated_at" && $key !== "deleted_at" )
                  {
         
                     $lookupNew = $this->keyLookup( $key, $val );
                     $lookupOld = $this->keyLookup( $key, $this->_data['SystemCodes'][$key] );                     
                  
                     $this->_data['success'][$keyIndex] = [
                        'value'     => "was updated",
                        'bValue'    => true,
                     ];
                     
                     if( strpos( $lookupNew[$key], "Unknown key" ) !== 0 )
                     {
                        $this->_data['success'][$keyIndex] = [
                           'value'  => "was updated ( " . $lookupNew[$key] . " -> " . $lookupOld[$key] . " )",
                        ];
                     }
                  }
               }
            }
         }  
      }    

      $this->_systemCodes      = $this->_systemCodes->findOne( $this->_data['id']  );
      
//      $this->_tagsModel       = SystemCodes::findPermitTagsById( $this->_data['id'] );
//      $this->_codeChildModel  = SystemCodes::findUnassignedPermitTagOptions( $this->_data['id']);


      return $this->render('codes-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_systemCodes,
//            'tags'         => $this->_tagsModel,
//            'allTags'      => $this->_codeChildModel,
      ]);  
   }   
   
   /**
    * TBD
    *
    * @return (TBD)
    */
   private function keyLookup( $key, $value )
   {
   
      $codeType['1']     = "Permit";
      $codeType['2']     = "Department";
      $codeType['3']     = "CareerLevel";
      $codeType['4']     = "Masters";         
      
      $isActive['-1']   = 'Select Status';
      $isActive['1']    = 'Active';
      $isActive['0']    = 'Inactive';
      
      $isHidden['1']    = 'Visible';
      $isHidden['0']    = 'Hidden';    
      
      $valLookup        = [];      
      
      if( $key === "type" )
      {
         if( intval($value) === 1 )
         {
            $valLookup[$key] = "Permit";
         }
         else if( intval($value) === 2 )
         {
            $valLookup[$key] = "Department";
         }
         else if( intval($value) === 3 )
         {
            $valLookup[$key] = "CareerLevel";
         }
         else if( intval($value) === 4 )
         {
            $valLookup[$key] = "Masters";
         }
         else
         {
            $valLookup[$key] = "Undocumented value : " . $value;
         }                                    
      }
      else if( $key === "is_active" )
      {
         $valLookup[$key] = $value ? "Active" : "Inactive";      
      }
      else if( $key === "is_hidden" )
      {
         $valLookup[$key] = $value ? "Visible" : "Hidden";      
      }
      else
      {
         $valLookup[$key] = "Unknown key : " . $key;        
      }
   
      return $valLookup;
   }
   
   /**
    * TBD
    *
    * @return (TBD)
    */
   public static function getDropDownOpts( $key = "", $prompt = false)
   {
      $dropDownOpts     = [];   
   
      if( !isset( $key ) || empty( $key ) )
      {
         return $dropDownOpts;
      }
      else if( !in_array( $key, self::dropDownOptsKeys ) )
      {
         return $dropDownOpts;
      }      
      
      $dropDownOpts['pageCount'] = [
         '10'  => '10',
         '25'  => '25',
         '50'  => '50',
         '100' => '100',
      ];
      
      $dropDownOpts['type'] = [
         '-1'  => 'Select Type',
         '1'   => 'Permit',
         '2'   => 'Department',
         '3'   => 'CareerLevel',
         '4'   => 'Masters',
      ];
      
      $dropDownOpts['is_active'] = [
         '-1'  => 'Select Status',
         '0'   => 'Inactive',
         '1'   => 'Active',

      ];    
      
      $dropDownOpts['is_hidden'] = [
         '-1'  => 'Select Status',
         '0'   => 'Hidden',
         '1'   => 'Visible',

      ];
      
      if( !$prompt )
      {
         if( isset( $dropDownOpts[$key] ) )
         {
            unset( $dropDownOpts[$key][-1] );
         }
      }

      return $dropDownOpts[$key];
   }      
}