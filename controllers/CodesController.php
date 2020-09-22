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

use app\controllers\BaseController;

use app\models\FormFields;
use app\models\SystemCodes;
use app\models\SystemCodesChild;

class CodesController extends BaseController
{
    const dropDownOptsKeys  = [ 'pageCount' ];
   
    const dropDownOpts      =
    [
        'pageCount' =>
        [
            '10'    => '10',
            '25'    => '25',
            '50'    => '50',
            '100'   => '100',
        ],
    ];
   
    private $_systemCodes;
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
      
        $this->_codesModel            = new SystemCodes();
        $this->_codeChildModel        = new SystemCodesChild();
      
        $this->_tbl_SystemCodes       = SystemCodes::tableName();
        $this->_tbl_SystemCodesChild  = SystemCodesChild::tableName();
            
        /**
         *    Capturing the possible post() variables used in this controller
         *
         *    $this->_data['id'] ( post() ) is set in BaseController.  If it isn't set,
         *    we check to see if there is a get() version of it.
         **/
      
        if (strlen($this->_data['id']) < 1) {
            $this->_data['id']   = $this->_request->get('id', '');
        }
      
        if (strlen($this->_data['id']) > 0) {
            $this->_codesModel = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->limit(1)->one();
            
            $this->_tagsModel       = SystemCodes::findAllTagsById($this->_data['id']);
            $this->_codeChildModel  = $this->getCodeChildModel($this->_data['id'], $this->_codesModel->code);
        }

        $this->_data['filterForm']['type']              = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.type', '');
        $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.is_active', -1);
        $this->_data['filterForm']['is_visible']        = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.is_visible', -1);
        $this->_data['filterForm']['paginationCount']   = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.pagination_count', 10);
      
        $this->_data['tagid']            = $this->_request->post('tagid', '');
        $this->_data['addTag']           = $this->_request->post('addTag', '');
        $this->_data['dropTag']          = $this->_request->post('dropTag', '');
  
        $this->_data['SystemCodes']['code']          = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.code', '');
        $this->_data['SystemCodes']['code_str']      = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.code_str', '');        
        $this->_data['SystemCodes']['description']   = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.description', '');
        $this->_data['SystemCodes']['id']            = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.id', '');
        $this->_data['SystemCodes']['insert']        = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.insert', '');
        $this->_data['SystemCodes']['is_active']     = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.is_active', -1);
        $this->_data['SystemCodes']['is_visible']    = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.is_visible', -1);
        $this->_data['SystemCodes']['type']          = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.type', '');
        $this->_data['SystemCodes']['update']        = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.update', '');
      
        /**
         *    if inserting a new record, set the filter to that new record's type as a UX feature
         **/
        if (isset($this->_data['SystemCodes']['type']) && !empty($this->_data['SystemCodes']['type'])) {
            $this->_data['filterForm']['type'] = $this->_data['SystemCodes']['type'];
        }
      
        //self::debug( $this->_data['SystemCodes']['type'] );
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
    private function getCodesGridView()
    {
        $tableNm = SystemCodes::tableName();
      
        $params  = [];

        $sql  = "SELECT  id, type, type_str, code, code_str, description, is_active, is_visible, order_by, created_at, updated_at " ;
        $sql .= "FROM " . $tableNm . " WHERE id > 0 ";

        $countSQL  = "SELECT COUNT(*) " ;
        $countSQL .= "FROM " . $tableNm . " WHERE id > 0 ";

        if ($this->_data['filterForm']['type'] > 0 && strlen($this->_data['filterForm']['type']) > 0) {
            $andWhere = "AND type =:type ";
      
            $sql        .= $andWhere;
            $countSQL   .= $andWhere;
         
            $params[':type']   = $this->_data['filterForm']['type'];
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
        }
      
        $count = Yii::$app->db->createCommand(
            $countSQL,
            $params
        )->queryScalar();
      
        $CodesSDP = new SqlDataProvider([
         'sql'          => $sql,
         'params'       => $params,
         'totalCount'   => $count,
         'sort' => [
            'defaultOrder' =>
            [
               'type_str'   => SORT_ASC,
               'order_by'   => SORT_ASC,
            ],
            'attributes' =>
            [
               'id' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'ID',
               ],
               'type_str' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Type',
               ],
               'code_str' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Code',
               ],
               'description' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Description',
               ],
               'order_by' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Ordering',
               ],               
            ],
         ],
         'pagination' =>
         [
            'pageSize' => $this->_data['filterForm']['paginationCount'],
         ],
      ]);
      
        return $CodesSDP;
    }


    /**
     *  Centralized render('fields-listing') call
     *
     *  returns void
     **/
    private function renderListing()
    {
        $this->_dataProvider = $this->getCodesGridView();

        return $this->render(
            'codes-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_codesModel,
            ]
        );
    }


    /**
     *  Centralized render('codes-view') call
     *
     *  returns void
     **/
    private function renderView()
    {
        return $this->render(
            'codes-view',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_codesModel,
                'tags'         => $this->_tagsModel,
                'allTags'      => $this->_codeChildModel,
            ]
        );
    }


    /**
     * Displays listing of all users in the system.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderListing();
    }
   

    /**
     * Displays selected Permit ( 1 record ).
     *
     * @return string
     */
    public function actionView()
    {
        $this->_codesModel = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->limit(1)->one();
    
        return $this->renderView();    
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public function actionDown()
    {
        $row = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();
            
        $row->scenario      = SystemCodes::SCENARIO_MOVE;
        $row->moveNext();
        
        $this->_data['filterForm']['type'] = $row['type'];
        
        return $this->renderListing();
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public function actionLast()
    {
        $row = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();
            
        $row->scenario      = SystemCodes::SCENARIO_MOVE;
        $row->moveLast();
        
        $this->_data['filterForm']['type'] = $row['type'];
        
        return $this->renderListing();
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public function actionUp()
    {
        $row = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();

        $row->scenario      = SystemCodes::SCENARIO_MOVE;
        $row->movePrev();
        
        $this->_data['filterForm']['type'] = $row['type'];
        
        return $this->renderListing();
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public function actionFirst()
    {
        $row = SystemCodes::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();

        $row->scenario      = SystemCodes::SCENARIO_MOVE;
        $row->moveFirst();
        
        $this->_data['filterForm']['type'] = $row['type'];
        
        return $this->renderListing();
    }


    /**
     * Adding new Course information
     *
     * @return (TBD)
     */
    public function actionAdd()
    {
        $this->_dataProvider = $this->getCodesGridView();

        $exitEarly = false;

        if (isset($this->_data['SystemCodes']['insert']) && !empty($this->_data['SystemCodes']['insert'])) {
            if ($this->_data['SystemCodes']['type'] < 1) {
                $this->_data['errors']['Add System Code'] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors']['type'] =
                [
                    'value' => "was not selected",
                ];
            
                $exitEarly = true;
            }

            if (empty($this->_data['SystemCodes']['code'])) {
                $this->_data['errors']['Add System Code'] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];

                $this->_data['errors']['code'] =
                [
                    'value' => "is blank",
                ];

                $exitEarly = true;
            }
      
            if (empty($this->_data['SystemCodes']['description'])) {
                $this->_data['errors']['Add System Code'] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors']['description'] =
                [
                    'value' => "is blank",
                ];
            
                $exitEarly = true;
            }
        }

        if ($exitEarly) {
            return $this->render(
                'codes-listing',
                [
                   'data'         => $this->_data,
                   'dataProvider' => $this->_dataProvider,
                   'model'        => $this->_codesModel,
                ]
            );
        }

        $idExists = SystemCodes::existsSystemCode($this->_systemCodes->type, $this->_systemCodes->code);

        $this->_systemCodes->type        = $this->_data['SystemCodes']['type'];
        $this->_systemCodes->code        = $this->_data['SystemCodes']['code'];
        $this->_systemCodes->description = $this->_data['SystemCodes']['description'];

        if ($idExists) {
            if (isset($this->_data['SystemCodes']['insert']) && !empty($this->_data['SystemCodes']['insert'])) {
                $this->_data['errors']['Add System Code'] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];

                $keyError          = $this->keyLookup('type', $this->_systemCodes->type);
                $keyError .= " ( " . $this->_systemCodes->code . " )";

                $this->_data['errors'][$keyError] =
                [
                    'value' => "already exists",
                ];

                /**
                 *    if inserting a new record, set the filter to that new record's type as a UX feature
                 **/
                $this->_data['filterForm']['type'] = $this->_systemCodes->type;
            }
         
            return $this->renderListing();
        }
      
        $updateModel               = new SystemCodes();
        $updateModel->scenario     = SystemCodes::SCENARIO_INSERT;

        $updateModel->type         = $this->_data['SystemCodes']['type'];
        $updateModel->code         = $this->_data['SystemCodes']['code'];
        $updateModel->description  = $this->_data['SystemCodes']['description'];
      
        $this->_data['SystemCodes']['insert'] = $updateModel->save();
         
//      $updateColumns = $updateModel->afterSave( false, $this->_data['addSystemCode']);

        if (!$this->_data['SystemCodes']['insert']) {
            $this->_data['errors']['Add System Code'] =
            [
                'value'     => "was unsuccessful",
                'htmlTag'   => 'h4',
                'class'     => 'alert alert-danger',
            ];
         
            $this->_data['errors']['system code'] =
            [
                'value'     => "was not saved",
            ];
        } else {
            $this->_data['success']['Add System Code'] =
            [
                'value'     => "was successful",
                'bValue'    => true,
                'htmlTag'   => 'h4',
                'class'     => 'alert alert-success',
            ];
         
            $keySuccess          = $this->keyLookup('type', $this->_systemCodes->type);
            $keySuccess .= " ( " . $this->_systemCodes->code . " )";
         
            $this->_data['success'][$keySuccess] =
            [
                'value'     => "was added",
                'bValue'    => true,
            ];
        }

        $this->_dataProvider = $this->getCodesGridView();

        return $this->render(
            'codes-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_codesModel,
            ]
        );
    }
   
   
    /**
     * Saving changes to System Codes and associated information
     *
     * @return (TBD)
     */
    public function actionSave()
    {
        $isError    = false;

        $msgAddTagHeader    = "Add Tag";
        $msgRemoveTagHeader = "Remove Tag";
        $msgHeader          = "Save System Code";        
 
        $tagRelationExists = SystemCodesChild::find()
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
            
                $isError = true;
            }

            if (!$isError) {
                $result = $this->addPermitTag($this->_data['id'], $this->_data['tagid']);
         
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
                } else {
                    $this->_data['errors'][$msgAddTagHeader] =
                    [
                        'value'     => "was unsuccessful",
                        'bValue'    => false,
                        'htmlTag'   => 'h4',
                        'class'     => 'alert alert-danger',
                   ];
               
                    $this->_data['errors'][$msgAddTagHeader] =
                    [
                        'value' => "was not successful; no tags were added. (Result: " . strval($result) . ") ",
                    ];
                }
            
                $exitEarly = true;
            }
        }

        if (strlen($this->_data['dropTag']) > 0) {
            $result = $this->removePermitTag($this->_data['id'], $this->_data['tagid']);
      
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
            }
         
            $exitEarly = true;
        }

        if (isset($this->_data['SystemCodes']['update']) && !empty($this->_data['SystemCodes']['update'])) {
            $this->_systemCodes              = new SystemCodes();
      
            $this->_systemCodes->id             = $this->_data['SystemCodes']['id'];
            $this->_systemCodes->type           = $this->_data['SystemCodes']['type'];
            $this->_systemCodes->code           = $this->_data['SystemCodes']['code'];
            $this->_systemCodes->code_str       = $this->_data['SystemCodes']['code_str'];            
            $this->_systemCodes->description    = $this->_data['SystemCodes']['description'];
   
            $exitEarly = false;
            
            if (!isset($this->_systemCodes->code_str) || empty($this->_systemCodes->code_str)) {
                $this->_data['errors'][$msgHeader] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];
   
                $this->_data['errors']['code_str'] =
                [
                    'value' => "is blank",
                ];
            
                $exitEarly = true;
            }            
         
            if (!isset($this->_systemCodes->description) || empty($this->_systemCodes->description)) {
                $this->_data['errors'][$msgHeader] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
   
                $this->_data['errors']['description'] =
                [
                    'value' => "is blank",
                ];
   
                $exitEarly = true;
            }
   
            if ($exitEarly) {
                $this->_tagsModel       = SystemCodes::findAllTagsById($this->_data['id']);
                $this->_codeChildModel  = $this->getCodeChildModel($this->_data['id'], $this->_codesModel->code);
         
                return $this->render(
                    'codes-view',
                    [
                        'data'         => $this->_data,
                        'dataProvider' => $this->_dataProvider,
                        'model'        => $this->_codesModel,
                        'tags'         => $this->_tagsModel,
                        'allTags'      => $this->_codeChildModel,
                    ]
                );
            }
      
            $updateModel                = SystemCodes::findOne($this->_systemCodes->id);
            $updateModel->scenario      = SystemCodes::SCENARIO_UPDATE;

/*           
            self::debug( "Old Value: " . $updateModel->code . " : " . gettype( $updateModel->code ), false );
            self::debug( "New Value: " . $this->_data['SystemCodes']['code'] . " : " . gettype( $this->_data['SystemCodes']['code'] ), false );                 
            
            if( $updateModel->code == $this->_data['SystemCodes']['code'] )
                self::debug( "Same value", false );
            else
                self::debug( "different values", false );
 */
            
            if( $this->_data['SystemCodes']['code'] != intval($updateModel->code) ) {
                $updateModel->code          = $this->_data['SystemCodes']['code'];
                
//                self::debug( "Updated ->code", false );
            }
            $updateModel->code_str      = $this->_data['SystemCodes']['code_str'];
            $updateModel->description   = $this->_data['SystemCodes']['description'];

//            $updateColumnsTest = $updateModel->getDirtyAttributes();

            $updateModel->type          = $this->_data['SystemCodes']['type'];
            $updateModel->is_active     = $this->_data['SystemCodes']['is_active'];
            $updateModel->is_visible    = $this->_data['SystemCodes']['is_visible'];

            $this->_data['SystemCodes']['update'] = $updateModel->save();
         
            $updateColumns = $updateModel->afterSave(false, $this->_data['SystemCodes']['update']);

            if ($this->_data['SystemCodes']['update'] && is_array($updateColumns)) {
                if (count($updateColumns) > 0) {
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
               
                    foreach ($updateColumns as $key => $val) {
                        $keyIndex = ucwords(strtolower(str_replace("_", " ", $key)));

                        if ($key !== "updated_at" && $key !== "deleted_at") {                       
                        
                            if ($val == $this->_data['SystemCodes'][$key]) {
                                // For some reason, afterSave() is stating that the value for this key has updated                              
                                continue;
                            }
                            
                            $lookupNew = $this->keyLookup($key, $val);
                            $lookupOld = $this->keyLookup($key, $this->_data['SystemCodes'][$key]);   
                            
//                            self::debug( $lookupNew . " vs. " . $lookupOld, false );
                            
                            $labels = $this->_codesModel->attributeLabels();
                            
//                            self::debug( $labels );
                   
                            $this->_data['success'][$labels[$key]] =
                            [
                                'value'     => "was updated ( <strong>" . $val . "</strong> -> <strong>" . $this->_data['SystemCodes'][$key] . "</strong> )",
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
        }

        return $this->redirect(['codes/view', 'id' => $this->_data['id'] ]);
    }
   
    /**
     * TBD
     *
     * @return (TBD)
     */
    private function keyLookup($key, $value)
    {
        $codeType   = self::getDropDownOpts('type');
        
        $isActive   = FormFields::getSelectOptions(-1, CodesController::IS_ACTIVE_TYPE_STR , true);
        $isVisible  = FormFields::getSelectOptions(-1, CodesController::IS_VISIBLE_TYPE_STR, true);
        $isBanner   = FormFields::getSelectOptions(-1, CodesController::IS_BANNER_DATA_TYPE_STR, true);        
      
        if ($key == 'is_active'  && array_key_exists($value, $isActive)) {
            return $isActive[$value ];
        } elseif ($key == 'is_visible' && array_key_exists($value, $isVisible)) {       
            return $isVisible[$value];
        } elseif ($key == 'is_banner_data' && array_key_exists($value, $isBanner)) {
            return $isBanner[$value];
        } elseif ($key === "type") {
            if (isset($codeType[$value]) && !empty($codeType[$value])) {
                return $codeType[$value];
            } else {
                return "Unknown value : " . $key . " :: " . $value;
            }
        }
   
        return "Unknown key : " . $key . " :: " . $value;
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    private function FormFieldskeyLookup($key, $value)
    {
        $formField      = FormFields::getFormFieldOptions(-1, 'Form-Field', false);
        $typeField      = FormFields::getDistinctGroupings();
        $isActive       = FormFields::getSelectOptions(-1, 'Is-Active', true);
        $isVisible      = FormFields::getSelectOptions(-1, 'Is-Visible', true);

        if ($key == 'form_field'  && array_key_exists($value, $formField)) {
            return $formField[ $value ];
        } elseif ($key == 'type_str'  && array_key_exists($value, $typeField)) {
            return $typeField[ $value ];
        } elseif ($key == 'is_active'  && array_key_exists($value, $isActive)) {
            return $isActive[ $value ];
        } elseif ($key == 'is_visible' && array_key_exists($value, $isVisible)) {
            return $isVisible[ strval($value)];
        }
        
        return "Unknown key : " . $key . " :: " . $value;
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getDropDownOpts($key = "", $prompt = false)
    {
        $dropDownOpts     = self::dropDownOpts;
   
        if (!isset($key) || empty($key)) {
            return $dropDownOpts;
        } elseif ($key == CodesController::IS_ACTIVE_TYPE_STR) {
            return FormFields::getSelectOptions(-1, CodesController::IS_ACTIVE_TYPE_STR, $prompt);
        } elseif ($key == CodesController::IS_VISIBLE_TYPE_STR) {
            return FormFields::getSelectOptions(-1, CodesController::IS_VISIBLE_TYPE_STR, $prompt);
        } elseif ($key == CodesController::IS_BANNER_DATA_TYPE_STR) {
            return FormFields::getSelectOptions(-1, CodesController::IS_BANNER_DATA_TYPE_STR, $prompt);
        } elseif ($key == 'type') {
            return SystemCodes::getDistinctTypes($prompt);
        }
      
        if (!$prompt) {
            if (isset($dropDownOpts[$key])) {
                unset($dropDownOpts[$key][-1]);
            }
        }
        
        return $dropDownOpts[$key];
    }


    /**
     * TBD
     *
     * @return (TBD)
     */
    private function getCodeChildModel($id = -1, $code = "")
    {
        if (SystemCodes::existsPermit($code)) {
            return SystemCodes::findUnassignedPermitTagOptions($id);
        } elseif (SystemCodes::existsDepartment($code)) {
            return SystemCodes::findUnassignedDepartmentTagOptions($id);
        } else {
            return SystemCodes::findUnassignedTagOptions($id);
        }
    }
}
