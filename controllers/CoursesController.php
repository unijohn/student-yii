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

use app\models\Courses;
//use app\models\UserSearch;


class CoursesController extends Controller
{
   private $_auth;
   private $_data;
   private $_dataProvider;
   private $_db;
   private $_request;
   private $_coursesModel;
   

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

      $this->_coursesModel     = new Courses();
      
  
      $this->_data['filterForm']['subject_area']      = ArrayHelper::getValue($this->_request->get(), 'Courses.subject_area',    '');
      $this->_data['filterForm']['course_number']     = ArrayHelper::getValue($this->_request->get(), 'Courses.course_number',   '');      
      $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'Courses.is_active',       -1);
      $this->_data['filterForm']['is_hidden']         = ArrayHelper::getValue($this->_request->get(), 'Courses.is_hidden',       -1);      
      $this->_data['filterForm']['paginationCount']   = $this->_request->get( 'pagination_count', 25 );

      
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
         $this->_coursesModel = Courses::find()
            ->where(['id' => $this->_data['id'] ])
            ->limit(1)->one();
            
//         $this->_tagsModel       = SystemCodes::findPermitTagsById( $this->_data['id'] );
//         $this->_codeChildModel  = SystemCodes::findUnassignedPermitTagOptions( $this->_data['id']);
      }   
 
      $this->_data['tagid']            = $this->_request->post('tagid',    '' );      
      $this->_data['addTag']           = $this->_request->post('addTag',   '' );
      $this->_data['dropTag']          = $this->_request->post('dropTag',  '' );     
 
      $this->_data['addCourse']        = ArrayHelper::getValue($this->_request->post(), 'Course.addCourse',    '' );
      $this->_data['saveCourse']       = ArrayHelper::getValue($this->_request->post(), 'Course.saveCourse',   '' );
      
      $this->_data['Courses']['id']             = ArrayHelper::getValue($this->_request->post(),   'Courses.id',              '');
      $this->_data['Courses']['subject_area']   = ArrayHelper::getValue($this->_request->post(),   'Courses.subject_area',    '');
      $this->_data['Courses']['course_number']  = ArrayHelper::getValue($this->_request->post(),   'Courses.course_number',   '');
      $this->_data['Courses']['section_number'] = ArrayHelper::getValue($this->_request->post(),   'Courses.section_number',  '');      
      $this->_data['Courses']['is_active']      = ArrayHelper::getValue($this->_request->post(),   'Courses.is_active',       -1);
      $this->_data['Courses']['is_hidden']      = ArrayHelper::getValue($this->_request->post(),   'Courses.is_hidden',       -1);      
  
      $this->_data['errors']           = [];   
      $this->_data['success']          = [];
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
   private function getCoursesGridView()
   {
      $tableNm = Courses::tableName();
      
      $params  = [];
      
//      $params[':table_name']  = Courses::tableName();
//      $params[':id']          = 1;     

      $sql  = "SELECT  id, subject_area, course_number, section_number, is_active, is_hidden, created_at, updated_at " ;
      $sql .= "FROM " . $tableNm . " WHERE length(id) > 0 ";

      $countSQL  = "SELECT COUNT(*) " ;
      $countSQL .= "FROM " . $tableNm . " WHERE length(id) > 0 ";

      if( strlen ($this->_data['filterForm']['subject_area'] ) > 0 )
      {
         $andWhere = "AND subject_area LIKE :subject_area ";
      
         $sql        .= $andWhere;
         $countSQL   .= $andWhere;
         
         $params[':subject_area'] = '%' . $this->_data['filterForm']['subject_area'] . '%';      
      }
      
      if( strlen ($this->_data['filterForm']['course_number'] ) > 0 )
      {
         $andWhere = "AND course_number LIKE :course_number ";
      
         $sql        .= $andWhere;
         $countSQL   .= $andWhere;
         
         $params[':course_number'] = '%' . $this->_data['filterForm']['course_number'] . '%';      
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
         $params
      )->queryScalar();      
      
      $CoursesSDP = new SqlDataProvider ([
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
               'subject_area' => [
                  'default' => SORT_ASC,
                  'label' => 'Subject',
               ],

               'course_number' => [
                  'default' => SORT_ASC,
                  'label' => 'Course',
               ],

               'section_number' => [
                  'default' => SORT_ASC,
                  'label' => 'Section',
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
      
      return $CoursesSDP;
   }


   /**
    * Displays listing of all users in the system.
    *
    * @return string
    */
   public function actionIndex()
   {
      $this->_dataProvider = $this->getCoursesGridView();

      return $this->render('courses-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_coursesModel,
      ]);      
   }
   

   /**
    * Displays selected Permit ( 1 record ).
    *
    * @return string
    */
   public function actionView()
   {  
      return $this->render('course-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_coursesModel,
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
      $this->_dataProvider = $this->getCoursesGridView();
      
      $this->_coursesModel->subject_area     = ArrayHelper::getValue($this->_request->post(), 'Courses.subject_area',   '' );
      $this->_coursesModel->course_number    = ArrayHelper::getValue($this->_request->post(), 'Courses.course_number',  '' ); 
      $this->_coursesModel->section_number   = ArrayHelper::getValue($this->_request->post(), 'Courses.section_number', '' );       

      $exitEarly = false;

      if( !isset( $this->_coursesModel->subject_area ) || empty( $this->_coursesModel->subject_area ) )
      {
         if( isset( $this->_data['addCourse'] ) && !empty( $this->_data['addCourse'] ) )
         {
            $this->_data['errors']['Add Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
         }

         $this->_data['errors']['subject'] = [
            'value' => "is blank",      
         ];      
         
         $exitEarly = true;
      }
      
      if( !isset( $this->_coursesModel->course_number ) || empty( $this->_coursesModel->course_number ) )
      {
         if( isset( $this->_data['addCourse'] ) && !empty( $this->_data['addCourse'] ) )
         {
            $this->_data['errors']['Add Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
         }

         $this->_data['errors']['course'] = [
            'value' => "is blank",      
         ];      
         
         $exitEarly = true;
      }      
      
      if( !isset( $this->_coursesModel->section_number ) || empty( $this->_coursesModel->section_number ) )
      {
         if( isset( $this->_data['addCourse'] ) && !empty( $this->_data['addCourse'] ) )
         {
            $this->_data['errors']['Add Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
         }

         $this->_data['errors']['section'] = [
            'value' => "is blank",      
         ];      

         $exitEarly = true;
      }        

      if( $exitEarly )
      {
         return $this->render('courses-listing', [
               'data'         => $this->_data, 
               'dataProvider' => $this->_dataProvider,
               'model'        => $this->_coursesModel,
         ]); 
      }

      $idChecking = $this->_coursesModel->subject_area . $this->_coursesModel->course_number . $this->_coursesModel->section_number;   
      $idExists = Courses::existsCourse( $idChecking );         
      
      if( $idExists )
      {
         if( isset( $this->_data['addCourse'] ) && !empty( $this->_data['addCourse'] ) )
         {
            $this->_data['errors']['Add Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];

         }
         $this->_data['errors']['course'] = [
            'value' => "already exists",      
         ];
      }
      else
      {
         $this->_coursesModel->id         = $idChecking;
         $this->_coursesModel->is_active  = Courses::STATUS_ACTIVE;      
         $this->_coursesModel->is_hidden  = Courses::STATUS_VISIBLE;      
      } 
      
      if( !$idExists )
      {          
         if( isset($this->_data['addCourse'] ) && !empty( $this->_data['addCourse'] ) )
         {        
            if( isset( $this->_coursesModel->id   ) && !empty( $this->_coursesModel->id ) )
            {
               $this->_data['saveCourse'] = $this->_coursesModel->save();   
            }
            else
            {
               $this->_data['errors']['Add Course'] = [
                  'value'     => "was unsuccessful",
                  'htmlTag'   => 'h4',
                  'class'     => 'alert alert-danger',
               ];
               
               $this->_data['errors']['id'] = [
                  'value'     => "is null",
               ];               
            }
         }
      }

      if( isset($this->_data['saveCourse'] ) && !empty( $this->_data['saveCourse'] ) )
      {
         $this->_data['success']['Add Course'] = [
            'value'     => "was successful",
            'bValue'    => true,
            'htmlTag'   => 'h4',
            'class'     => 'alert alert-success',
         ];
         
         $this->_data['success'][$this->_coursesModel->id] = [
            'value'     => "was added",
            'bValue'    => true,
         ];         
      }
      
      $this->_dataProvider = $this->getCoursesGridView();      

      return $this->render('courses-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_coursesModel,
      ]); 
   }
   
   
   /**
    * Saving changes to Course and Tag information
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
      
      if( isset($this->_data['saveCourse'] ) && !empty( $this->_data['saveCourse'] ) )
      {
         $this->_coursesModel->id               = ArrayHelper::getValue($this->_request->post(), 'Courses.id',   '' );
         $this->_coursesModel->subject_area     = ArrayHelper::getValue($this->_request->post(), 'Courses.subject_area',   '' );
         $this->_coursesModel->course_number    = ArrayHelper::getValue($this->_request->post(), 'Courses.course_number',  '' ); 
         $this->_coursesModel->section_number   = ArrayHelper::getValue($this->_request->post(), 'Courses.section_number', '' );       
   
         $exitEarly = false;

         if( !isset( $this->_coursesModel->subject_area ) || empty( $this->_coursesModel->subject_area ) )
         {
            $this->_data['errors']['Save Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
   
            $this->_data['errors']['subject'] = [
               'value' => "is blank",      
            ];      
            
            $exitEarly = true;
         }
         
         if( !isset( $this->_coursesModel->course_number ) || empty( $this->_coursesModel->course_number ) )
         {
            $this->_data['errors']['Save Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
   
            $this->_data['errors']['course'] = [
               'value' => "is blank",      
            ];      
            
            $exitEarly = true;
         }      
         
         if( !isset( $this->_coursesModel->section_number ) || empty( $this->_coursesModel->section_number ) )
         {
            $this->_data['errors']['Save Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
   
            $this->_data['errors']['section'] = [
               'value' => "is blank",      
            ];      
   
            $exitEarly = true;
         }        
   
         if( $exitEarly )
         {  
            return $this->render('course-view', [
                  'data'         => $this->_data, 
                  'dataProvider' => $this->_dataProvider,
                  'model'        => $this->_coursesModel,
      //            'tags'         => $this->_tagsModel,
      //            'allTags'      => $this->_codeChildModel,
            ]);  
         }      
      
         $updateModel      = Courses::findOne( $this->_coursesModel->id );
 
         $updateModel->subject_area    = $this->_data['Courses']['subject_area'];
         $updateModel->course_number   = $this->_data['Courses']['course_number'];
         $updateModel->section_number  = $this->_data['Courses']['section_number'];         

         $updateColumns = $updateModel->getDirtyAttributes();

         $updateModel->is_active    = $this->_data['Courses']['is_active'];
         $updateModel->is_hidden    = $this->_data['Courses']['is_hidden'];

         $this->_data['savePermit'] = $updateModel->save();   
         
         if( isset($this->_data['savePermit'] ) && !empty( $this->_data['savePermit'] ) )
         {
            if( count( $updateColumns ) > 0 )
            {
               $this->_data['success']['Save Permit'] = [
                  'value'     => "was successful",
                  'bValue'    => true,
                  'htmlTag'   => 'h4',
                  'class'     => 'alert alert-success',
               ];
               
               foreach( $updateColumns as $key => $val )
               {     
                  $keyIndex = ucfirst( strtolower(str_replace( "_", " ", $key )) );
               
                  $this->_data['success'][$keyIndex] = [
                     'value'     => "was updated ",
                     'bValue'    => true,
                  ];                     
               }
            }
         }  
      }    

      $this->_coursesModel      = $this->_coursesModel->findOne( $this->_data['id']  );
      
//      $this->_tagsModel       = SystemCodes::findPermitTagsById( $this->_data['id'] );
//      $this->_codeChildModel  = SystemCodes::findUnassignedPermitTagOptions( $this->_data['id']);


      return $this->render('course-view', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_coursesModel,
//            'tags'         => $this->_tagsModel,
//            'allTags'      => $this->_codeChildModel,
      ]);  
   }   
}