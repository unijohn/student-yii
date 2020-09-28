<?php

namespace app\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;

//use app\controllers\BaseController;

use app\models\BaseModel;
use app\models\Courses;
use app\models\CoursesCodesChild;
use app\models\FormFields;
use app\models\SystemCodes;

use app\modules\Consts;

class CoursesController extends BaseController
{
    private $_coursesModel;
    private $_coursesChildModel;
   
    private $_codesModel;

    private $_tagsModel;

    private $_tbl_SystemCodes;
    private $_tbl_CoursesCodesChild;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
      
        $this->_coursesModel          = new Courses();
        $this->_coursesChildModel     = new CoursesCodesChild();
      
        $this->_codesModel            = new SystemCodes();

        $this->_tbl_SystemCodes       = SystemCodes::tableName();
        $this->_tbl_CoursesCodesChild = CoursesCodesChild::tableName();
      
        /**
         *    Capturing the possible post() variables used in this controller
         *
         *    $this->_data['id'] ( post() ) is set in BaseController.  If it isn't set,
         *    we check to see if there is a get() version of it.
         **/
      
        if (strlen($this->_data['id']) < 1) {
            $this->_data['id']     = $this->_request->get('id', '');
        }
      
        if (strlen($this->_data['id']) > 0) {
            $this->_coursesModel = Courses::find()
            ->where(['id' => $this->_data['id'] ])
            ->limit(1)->one();
            
            $this->_tagsModel          = CoursesCodesChild::findTagsById($this->_data['id']);
            $this->_coursesChildModel  = SystemCodes::findUnassignedTagOptionsForCourses($this->_data['id'], true, false);
        }

        $this->_data['filterForm']['subject_area']      = ArrayHelper::getValue($this->_request->get(), 'Courses.subject_area', '');
        
        if ($this->_data['filterForm']['subject_area'] == 'ZZZZ') {
            $this->_data['filterForm']['subject_area'] = "";
        }
        
        $this->_data['filterForm']['course_number']     = ArrayHelper::getValue($this->_request->get(), 'Courses.course_number', '');
        $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'Courses.is_active', -1);
        $this->_data['filterForm']['is_visible']        = ArrayHelper::getValue($this->_request->get(), 'Courses.is_visible', -1);
        $this->_data['filterForm']['pagination_count']  = ArrayHelper::getValue($this->_request->get(), 'Courses.pagination_count', 25);
 
        $this->_data['tagid']            = $this->_request->post('tagid', '');
        $this->_data['addTag']           = $this->_request->post('addTag', '');
        $this->_data['dropTag']          = $this->_request->post('dropTag', '');
 
        $this->_data['addCourse']        = ArrayHelper::getValue($this->_request->post(), 'Course.addCourse', '');
        $this->_data['saveCourse']       = ArrayHelper::getValue($this->_request->post(), 'Course.saveCourse', '');
      
        $this->_data['Courses']['id']             = ArrayHelper::getValue($this->_request->post(), 'Courses.id', '');
        $this->_data['Courses']['subject_area']   = ArrayHelper::getValue($this->_request->post(), 'Courses.subject_area', '');
        $this->_data['Courses']['course_number']  = ArrayHelper::getValue($this->_request->post(), 'Courses.course_number', '');
        $this->_data['Courses']['section_number'] = ArrayHelper::getValue($this->_request->post(), 'Courses.section_number', '');
        $this->_data['Courses']['is_active']      = ArrayHelper::getValue($this->_request->post(), 'Courses.is_active', -1);
        $this->_data['Courses']['is_visible']     = ArrayHelper::getValue($this->_request->post(), 'Courses.is_visible', -1);
      
        /**
         *    if inserting a new record, set the filter to that new record's type as a UX feature
         **/
        if (isset($this->_data['Courses']['subject_area']) && !empty($this->_data['Courses']['subject_area'])) {
            $this->_data['filterForm']['subject_area'] = $this->_data['Courses']['subject_area'];
        }
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
    * @inheritdoc
    */
    public function actions()
    {
        $actions = parent::actions();
   
        return $actions;
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

        $sql  = "SELECT  id, subject_area, course_number, section_number, is_active, is_visible, created_at, updated_at " ;
        $sql .= "FROM " . $tableNm . " WHERE length(id) > 0 ";

        $countSQL  = "SELECT COUNT(*) " ;
        $countSQL .= "FROM " . $tableNm . " WHERE length(id) > 0 ";

        if (strlen($this->_data['filterForm']['subject_area']) > 0) {
            $andWhere = "AND subject_area LIKE :subject_area ";
      
            $sql        .= $andWhere;
            $countSQL   .= $andWhere;
         
            $params[':subject_area'] = '%' . $this->_data['filterForm']['subject_area'] . '%';
        }
      
        if (strlen($this->_data['filterForm']['course_number']) > 0) {
            $andWhere = "AND course_number LIKE :course_number ";
      
            $sql        .= $andWhere;
            $countSQL   .= $andWhere;
         
            $params[':course_number'] = '%' . $this->_data['filterForm']['course_number'] . '%';
        }
      
        if ($this->_data['filterForm']['is_active'] > -1 && strlen($this->_data['filterForm']['is_active']) > 0) {
            $andWhere = "AND is_active =:is_active ";
      
            $sql        .= $andWhere;
            $countSQL   .= $andWhere;
         
            $params[':is_active']   = $this->_data['filterForm']['is_active'];
        }
      
        if ($this->_data['filterForm']['is_visible'] > -1 && strlen($this->_data['filterForm']['is_visible']) > 0) {
            $andWhere = "AND is_visible =:is_visible ";
      
            $sql        .= $andWhere;
            $countSQL   .= $andWhere;
            
            $params[':is_visible']   = $this->_data['filterForm']['is_visible'];
        }
      
        //self::debug( $this->_data['filterForm']['subject_area'] . " :: " . strlen($this->_data['filterForm']['subject_area']), false );
        //self::debug( $params );
      
        $count = Yii::$app->db->createCommand(
            $countSQL,
            $params
        )->queryScalar();
      
        $CoursesSDP = new SqlDataProvider([
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
            'pageSize' => $this->_data['filterForm']['pagination_count'],
         ],
      ]);
      
        return $CoursesSDP;
    }


    /**
     *  Centralized render('courses-listing') call
     *
     *  returns void
     **/
    private function renderListing()
    {
        $this->_dataProvider = $this->getCoursesGridView();

        return $this->render('courses-listing', [
            'data'            => $this->_data,
            'dataProvider'    => $this->_dataProvider,
            'model'           => $this->_coursesModel,
            'modelSubjects'  => Courses::getAllSubjectAreas()
      ]);
    }
    

    /**
     * Displays listing of all courses in the system.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderListing();
    }


    /**
     *  Centralized render('course-view') call
     *
     *  returns void
     **/
    private function renderView()
    {
        if (strlen($this->_data['id']) === 0 ||  $this->_data['id'] === "") {
            return $this->redirect(['courses/index' ]);
        }

        return $this->render('course-view', [
            'data'         => $this->_data,
            'dataProvider' => $this->_dataProvider,
            'model'        => $this->_coursesModel,
            'tags'         => $this->_tagsModel,
            'allTags'      => $this->_coursesChildModel,
        ]);
    }
   

    /**
     * Displays selected Course ( 1 record ).
     *
     * @return string
     */
    public function actionView()
    {
        return $this->renderView();
    }


    /**
     * Adding new Course information
     *
     * @return (TBD)
     */
    public function actionAdd()
    {
        $this->_dataProvider = $this->getCoursesGridView();
      
        $this->_coursesModel->subject_area     = ArrayHelper::getValue($this->_request->post(), 'Courses.subject_area', '');
        $this->_coursesModel->course_number    = ArrayHelper::getValue($this->_request->post(), 'Courses.course_number', '');
        $this->_coursesModel->section_number   = ArrayHelper::getValue($this->_request->post(), 'Courses.section_number', '');

        $exitEarly = false;

        if (!isset($this->_coursesModel->subject_area) || empty($this->_coursesModel->subject_area)) {
            if (isset($this->_data['addCourse']) && !empty($this->_data['addCourse'])) {
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
      
        if (!isset($this->_coursesModel->course_number) || empty($this->_coursesModel->course_number)) {
            if (isset($this->_data['addCourse']) && !empty($this->_data['addCourse'])) {
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
      
        if (!isset($this->_coursesModel->section_number) || empty($this->_coursesModel->section_number)) {
            if (isset($this->_data['addCourse']) && !empty($this->_data['addCourse'])) {
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

        if ($exitEarly) {
            return $this->renderListing();
        }

        $idChecking = $this->_coursesModel->subject_area . $this->_coursesModel->course_number . $this->_coursesModel->section_number;
        $idExists = Courses::existsCourse($idChecking);
      
        if ($idExists) {
            if (isset($this->_data['addCourse']) && !empty($this->_data['addCourse'])) {
                $this->_data['errors']['Add Course'] = [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];
            }
            $this->_data['errors']['course'] = [
            'value' => "already exists",
         ];
        } else {
            $this->_coursesModel->id         = $idChecking;
            $this->_coursesModel->is_active  = Consts::TYPE_ITEM_STATUS_ACTIVE;
            $this->_coursesModel->is_visible = Consts::TYPE_ITEM_STATUS_VISIBLE;
        }
      
        if (!$idExists) {
            if (isset($this->_data['addCourse']) && !empty($this->_data['addCourse'])) {
                if (isset($this->_coursesModel->id) && !empty($this->_coursesModel->id)) {
                    $this->_data['saveCourse'] = $this->_coursesModel->save();
                } else {
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

        if (isset($this->_data['saveCourse']) && !empty($this->_data['saveCourse'])) {
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

        return $this->renderListing();
    }
   
   
    /**
     * Saving changes to Course and Tag information
     *
     * @return (TBD)
     */
    public function actionSave()
    {
        $exitEarly    = false;

        $msgAddTagHeader    = "Add Course Tag";
        $msgRemoveTagHeader = "Remove Course Tag";
        $msgHeader          = "Save Course";
        
 
        $tagRelationExists = CoursesCodesChild::find()
         ->where([ 'parent' => $this->_data['id'] ])
         ->andWhere([ 'child' => $this->_data['tagid'] ])
         ->limit(1)
         ->one();
         
        $tagChild = SystemCodes::find()
         ->where([ 'id' => $this->_data['tagid'] ])
         ->limit(1)
         ->one();

        if (strlen($this->_data['addTag']) > 0) {
            if (!is_null($tagRelationExists)) {
                $this->_data['errors'][$msgAddTagHeader] =
                [
                   'value'     => "was unsuccessful",
                   'bValue'    => false,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors'][$tagChild['description']] =
                [
                    'value' => "was not added; relationship already exists.",
                ];
                
                $this->_data['errors']['useSession'] = true;
            
                $exitEarly = true;
            }

            if (!$exitEarly) {
                $result = $this->addCourseTag($this->_data['id'], $this->_data['tagid']);
         
                if ($result > 0) {
                    $tag = SystemCodes::find()
                  ->where([ 'id' => $this->_data['tagid'] ])
                  ->limit(1)
                  ->one();
            
                    $this->_data['success'][$msgAddTagHeader] =
                    [
                        'value'        => "was successful",
                        'bValue'       => true,
                        'htmlTag'      => 'h4',
                        'class'        => 'alert alert-success',
                    ];
               
                    $this->_data['success'][$tagChild['description']] =
                    [
                        'value' => "was added",
                    ];
                    
                    $this->_data['success']['useSession'] = true;
                } else {
                    $this->_data['errors'][$msgAddTagHeader] =
                    [
                      'value'     => "was unsuccessful",
                      'bValue'    => false,
                      'htmlTag'   => 'h4',
                      'class'     => 'alert alert-danger',
                   ];
               
                    $this->_data['errors'][$msgAddTagHeader] = [
                        'value' => "was not successful; no tags were added. (Result: " . strval($result) . ") ",
                    ];
                    
                    $this->_data['errors']['useSession'] = true;
                }
            
                $exitEarly = true;
            }
        }

        if (strlen($this->_data['dropTag']) > 0) {
            $result = $this->removeCourseTag($this->_data['id'], $this->_data['tagid']);
      
            if ($result > 0) {
                $this->_data['success'][$msgRemoveTagHeader] =
                [
                   'value'        => "was successful",
                   'bValue'       => true,
                   'htmlTag'      => 'h4',
                   'class'        => 'alert alert-success',
                ];
            
                $this->_data['success'][$tagChild['description']] =
                [
                   'value' => "was removed",
                ];

                $this->_data['success']['useSession'] = true;
            } else {
                $this->_data['errors'][$msgRemoveTagHeader] =
                [
                   'value'     => "was unsuccessful",
                   'bValue'    => false,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors'][$tagChild['description']] =
                [
                   'value' => "was not successful; no tags were removed. (Result: " . strval($result) . ") ",
                ];
                
                $this->_data['errors']['useSession'] = true;
            }
            
            $exitEarly = true;
        }

        if (isset($this->_data['saveCourse']) && !empty($this->_data['saveCourse'])) {
            $this->_coursesModel->id               = ArrayHelper::getValue($this->_request->post(), 'Courses.id', '');
            $this->_coursesModel->subject_area     = ArrayHelper::getValue($this->_request->post(), 'Courses.subject_area', '');
            $this->_coursesModel->course_number    = ArrayHelper::getValue($this->_request->post(), 'Courses.course_number', '');
            $this->_coursesModel->section_number   = ArrayHelper::getValue($this->_request->post(), 'Courses.section_number', '');
   
            $exitEarly = false;

            if (!isset($this->_coursesModel->subject_area) || empty($this->_coursesModel->subject_area)) {
                $this->_data['errors'][$msgHeader] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];
   
                $this->_data['errors']['subject'] =
                [
                    'value' => "is blank",
                ];

                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }

            if (!isset($this->_coursesModel->course_number) || empty($this->_coursesModel->course_number)) {
                $this->_data['errors'][$msgHeader] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];
   
                $this->_data['errors']['course'] =
                [
                    'value' => "is blank",
                ];

                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }
         
            if (!isset($this->_coursesModel->section_number) || empty($this->_coursesModel->section_number)) {
                $this->_data['errors'][$msgHeader] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];
   
                $this->_data['errors']['section'] =
                [
                    'value' => "is blank",
                ];
   
                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }
        }


        /**
         *  No reason to update model if the work is done for now
         **/
       
        if ($exitEarly) {
            return $this->redirect(['courses/view', 'id' => $this->_data['id'] ]);
        }
         
        $updateModel      = Courses::findOne($this->_coursesModel->id);

        $updateModel->subject_area    = $this->_data['Courses']['subject_area'];
        $updateModel->course_number   = $this->_data['Courses']['course_number'];
        $updateModel->section_number  = $this->_data['Courses']['section_number'];

        $updateColumns = $updateModel->getDirtyAttributes();

        $updateModel->is_active    = $this->_data['Courses']['is_active'];
        $updateModel->is_visible   = $this->_data['Courses']['is_visible'];

        if (!$updateModel->validate()) {
            $this->_data['errors'][$msgHeader] =
            [
               'value'     => "was unsuccessful",
               'htmlTag'   => 'h4',
               'class'     => 'alert alert-danger',
            ];

            $this->_data['errors']['description'] =
            [
                'value' => $updateModel->errors,
            ];

            $this->_data['errors']['useSession'] = true;
            
            self::debug($updateModel->errors);
        }

        $this->_data['saveCourse'] = $updateModel->save();
        
        $updateColumns = $updateModel->afterSave(false, $this->_data['saveCourse']);
        
        //self::debug( $updateColumns );
      
        if (isset($this->_data['saveCourse']) && !empty($this->_data['saveCourse'])) {
            if (count($updateColumns) > 0) {
                foreach ($updateColumns as $key => $val) {
                    $keyIndex = ucwords(strtolower(str_replace("_", " ", $key)));
            
                    if ($key !== "updated_at" && $key !== "deleted_at") {
                        if ($val == $this->_data['Courses'][$key]) {
                            // For some reason, afterSave() is stating that the value for this key has updated
                            // e.g. is_active, is_visible :: Basically any "-1" == -1 situation
                            continue;
                        } else {
                            // Avoid setting this success header multiple times
                            if (!isset($this->_data['success'][$msgHeader])) {
                                $this->_data['success']['useSession'] = true;
                            
                                $this->_data['success'][$msgHeader] =
                                [
                                   'value'      => "was successful",
                                   'bValue'     => true,
                                   'htmlTag'    => 'h4',
                                   'class'      => 'alert alert-success',
                                ];
                            }
                        }
                        
                        $lookupNew = $this->keyLookup($key, $val);
                        $lookupOld = $this->keyLookup($key, $this->_data['Courses'][$key]);
                        
//                            self::debug( $lookupNew . " vs. " . $lookupOld, true );
                        
                        $labels = $this->_coursesModel->attributeLabels();
                        
//                            self::debug( $labels );
               
                        $this->_data['success'][$labels[$key]] =
                        [
                            'value'     => "was updated ( <strong>" . $val . "</strong> -> <strong>" . $this->_data['Courses'][$key] . "</strong> )",
                            'bValue'    => true,
                        ];

                        if (strpos($lookupNew, "Unknown") !== 0) {
                            $this->_data['success'][$labels[$key]] =
                            [
                                'value'  => "was updated ( <strong>" . $lookupNew . "</strong> -> <strong>" . $lookupOld . "</strong> )",
                            ];
                        }
                    }
                }
                
//                    self::debug( $this->_data['success'] );
            }
        }

        // Using 'useSession' and redirecting users back to view so reloads/refresh does not bring up 'Reload Post' screen
        // on web browsers
        return $this->redirect(['courses/view', 'id' => $this->_data['id'] ]);
    }
    
    
    /**
     * TBD
     *
     * @return (TBD)
     */
    private function keyLookup($key, $value)
    {
        $isActive       = FormFields::getSelectOptions(-1, Consts::IS_ACTIVE_TYPE_STR, true);
        $isVisible      = FormFields::getSelectOptions(-1, Consts::IS_VISIBLE_TYPE_STR, true);

        if ($key == 'is_active'  && array_key_exists($value, $isActive)) {
            return $isActive[ $value ];
        } elseif ($key == 'is_visible' && array_key_exists($value, $isVisible)) {
            return $isVisible[ strval($value)];
        }
        return "Unknown key : " . $key . " :: " . $value;
    }
}
