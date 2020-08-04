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
      
      
/**      
      $this->_data['post']['addRole']        = $this->_request->post('addRole',        '' );
      $this->_data['post']['dropRole']       = $this->_request->post('dropRole',       '' );
      $this->_data['post']['authitem']       = $this->_request->post('authitem',       '' );
      $this->_data['post']['authassignment'] = $this->_request->post('authassignment', '' );        
      
      $this->_data['uuid']           = $this->_request->post('uuid',     '' );
      $this->_data['addRole']        = $this->_request->post('addRole',  '' );
      $this->_data['dropRole']       = $this->_request->post('dropRole', '' );
      $this->_data['authitem']       = $this->_request->post('authitem', '' );
      $this->_data['authassignment'] = $this->_request->post('authassignment', '' );    
      
      $this->_data['addUser']          = ArrayHelper::getValue($this->_request->post(), 'User.addUser',     '' );
      $this->_data['lookupUser']       = ArrayHelper::getValue($this->_request->post(), 'User.lookupUser',  '' );
      $this->_data['saveUser']         = false;
 **/     
 
      $this->_data['addCourse']        = ArrayHelper::getValue($this->_request->post(), 'Course.addCourse',    '' );
      $this->_data['saveCourse']       = ArrayHelper::getValue($this->_request->post(), 'Course.saveCourse',   '' );
  
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
         $params,
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

      return $this->render('courses-listing', [
            'data'         => $this->_data, 
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_coursesModel,
      ]); 
   }
   
   
   /**
    * Saving changes to User and Role information
    *
    * @return (TBD)
    */
   public function actionSave()
   {       
//      $this->_auth->assign( $auth->getRole('Academic-Advisor-Graduate'),       5 ); 
//      print_r( $this->_request->post() );

      $this->_userModel = User::find()
         ->where(['uuid' => $this->_data['uuid'] ])
         ->limit(1)->one();

//      print( $this->_userModel->id . PHP_EOL );

      if( strlen( $this->_data['addRole'] ) > 0 )
      {
         if( $this->_auth->assign( $this->_auth->getRole($this->_data['authitem']['name']), $this->_userModel->id ) )
         {
            $this->_data['success']['Add Role'] = [
               'value'        => "was successful",
               'bValue'       => true,
               'htmlTag'      => 'h4',
               'class'        => 'alert alert-success', 
            ];
            
            $this->_data['success']['Add Role To User'] = [
               'value' => "was successful",
            ];
         }
         else
         {
            $this->_data['errors']['Add Role'] = [
               'value'     => "was unsuccessful",
               'bValue'    => false,
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
            
            $this->_data['errors']['Remove Role From User'] = [
               'value' => "was not successful; no roles were added.",
            ];
         }           
      }

      if( strlen( $this->_data['dropRole'] ) > 0 )
      {
         if( $this->_auth->revoke( $this->_auth->getRole($this->_data['authassignment']['item_name']), $this->_userModel->id ) )
         {
            $this->_data['success']['Remove Role'] = [
               'value'        => "was successful",
               'bValue'       => true,
               'htmlTag'      => 'h4',
               'class'        => 'alert alert-success', 
            ];
            
            $this->_data['success']['Remove Role From User'] = [
               'value' => "was successful",
            ];
         }
         else
         {
            $this->_data['errors']['Remove Role'] = [
               'value'     => "was unsuccessful",
               'bValue'    => false,
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
            
            $this->_data['errors']['Remove Role From User'] = [
               'value' => "was not successful; no roles were removed.",
            ];
         }  
      }

      $roleModel  = AuthAssignment::find();
      
      $assignedRoles = [];
      foreach( $this->_userModel->roles as $role )
      {
         $assignedRoles[] = $role->item_name;
      }
      
      $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);      

      return $this->render('user-view', [
         'data'         => $this->_data, 
         'dataProvider' => $this->_dataProvider,
         'model'        => $this->_userModel,
         'roles'        => $this->_roleModel,
         'allRoles'     => $this->_authItemModel,
      ]);
   }
}