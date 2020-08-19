<?php

namespace app\controllers\permits;

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
use app\controllers\CodesController;

use app\models\SystemCodes;
use app\models\SystemCodesChild;

class ManageAdminController extends BaseController
{
    const dropDownOptsKeys  = [ 'tags_permits' ];
   
    const dropDownOpts      =
    [
        'tags_permits' =>
        [
            '1'  => 'Select Permit Tag',
        ],
    ];


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
            $this->_data['id']     = $this->_request->get('id', '');
        }
      
        if (strlen($this->_data['id']) > 0) {
            $this->_codesModel = SystemCodes::find()
                ->where(['id' => $this->_data['id'] ])
                ->limit(1)->one();
            
            $this->_tagsModel       = SystemCodes::findPermitTagsById($this->_data['id']);
            $this->_codeChildModel  = SystemCodes::findUnassignedPermitTagOptions($this->_data['id']);
        }
      
        $this->_data['filterForm']['code']              = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.code', '');
        $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.is_active', -1);
        $this->_data['filterForm']['is_hidden']         = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.is_hidden', -1);
        $this->_data['filterForm']['is_tagged']         = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.is_tagged', -1);
        $this->_data['filterForm']['pagination_count']  = ArrayHelper::getValue($this->_request->get(), 'SystemCodes.pagination_count', 10);
       
        $this->_data['tagid']            = $this->_request->post('tagid', '');
        $this->_data['addTag']           = $this->_request->post('addTag', '');
        $this->_data['dropTag']          = $this->_request->post('dropTag', '');
      
        $this->_data['addPermit']        = ArrayHelper::getValue($this->_request->post(), 'Permit.addPermit', '');
        $this->_data['savePermit']       = ArrayHelper::getValue($this->_request->post(), 'Permit.savePermit', '');
      
        $this->_data['SystemCodes']['id']            = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.id', '');
        $this->_data['SystemCodes']['code']          = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.code', '');
        $this->_data['SystemCodes']['description']   = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.description', '');
        $this->_data['SystemCodes']['is_active']     = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.is_active', -1);
        $this->_data['SystemCodes']['is_hidden']     = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.is_hidden', -1);
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
     * Centralizing the query for building the Permit GridView
     *
     * @return SqlDataProvider
     */
    private function getPermitGridView()
    {
        $params[':type']  = 1;

        /**
              $count = $this->_db->createCommand(
                 "SELECT COUNT(*) FROM " . $this->_tbl_SystemCodes . " WHERE type =:type ",
                 [':type' => $params[':type']])->queryScalar();
         **/
 
        $sql  = "SELECT  sc.id, sc.code, sc.description, sc.is_active, sc.is_hidden, sc.created_at, sc.updated_at " ;
        $sql .= "FROM " . $this->_tbl_SystemCodes . " AS sc ";

        $sql_count = "SELECT COUNT(*) FROM " . $this->_tbl_SystemCodes . " AS sc ";

        if ($this->_data['filterForm']['is_tagged'] > -1 && strlen($this->_data['filterForm']['is_tagged']) > 0) {
            $sql       .= "INNER JOIN " . $this->_tbl_SystemCodesChild . " AS scc ON scc.parent = sc.id ";
            $sql_count .= "INNER JOIN " . $this->_tbl_SystemCodesChild . " AS scc ON scc.parent = sc.id ";
        }
      
        $sql        .= "WHERE type =:type ";
        $sql_count  .= "WHERE type =:type ";
      
        if ($this->_data['filterForm']['is_active'] > -1 && strlen($this->_data['filterForm']['is_active']) > 0) {
            $sql       .= "AND is_active =:is_active ";
            $sql_count .= "AND is_active =:is_active ";

            $params[':is_active']   = $this->_data['filterForm']['is_active'];
        }
      
        if ($this->_data['filterForm']['is_hidden'] > -1 && strlen($this->_data['filterForm']['is_hidden']) > 0) {
            $sql        .= "AND is_hidden =:is_hidden ";
            $sql_count  .= "AND is_hidden =:is_hidden ";

            $params[':is_hidden']   = $this->_data['filterForm']['is_hidden'];
        }
      
        if ($this->_data['filterForm']['code'] > -1 && strlen($this->_data['filterForm']['code']) > 0) {
            $sql        .= "AND code =:code ";
            $sql_count  .= "AND code =:code ";

            $params[':code']   = $this->_data['filterForm']['code'];
        }
      
        if ($this->_data['filterForm']['is_tagged'] > -1 && strlen($this->_data['filterForm']['is_tagged']) > 0) {
            $sql        .= "AND scc.child =:is_tagged ";
            $sql_count  .= "AND scc.child =:is_tagged ";

            $params[':is_tagged']   = $this->_data['filterForm']['is_tagged'];
        }
      
        $count = $this->_db->createCommand($sql_count, $params)->queryScalar();
      
      
        $PermitSDP = new SqlDataProvider(
            [
                'sql'          => $sql,
                'params'       => $params,
                'totalCount'   => $count,
                'sort' =>
                [
                    'attributes' =>
                    [
                        'code' =>
                        [
                          'default' => SORT_ASC,
                          'label' => 'Code',
                        ],
         
                        'description' =>
                        [
                          'default' => SORT_ASC,
                          'label' => 'description',
                        ],
                        'created_at',
                        'updated_at',
                    ],
                ],
                'pagination' =>
                [
                    'pageSize' => $this->_data['filterForm']['pagination_count'],
                ],
            ]
        );
      
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

        return $this->render(
            'permits-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_codesModel,
            ]
        );
    }


    /**
     * Displays selected Permit ( 1 record ).
     *
     * @return string
     */
    public function actionView()
    {
        return $this->render(
            'permit-view',
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
     * Adding new Permit information
     *
     * @return (TBD)
     */
    public function actionAdd()
    {
        $this->_dataProvider = $this->getPermitGridView();
      
        $this->_codesModel->code = ArrayHelper::getValue($this->_request->post(), 'SystemCodes.code', '');
      
        $idExists = SystemCodes::existsPermit($this->_codesModel->code);
      
        if ($idExists) {
            if (isset($this->_data['addPermit']) && !empty($this->_data['addPermit'])) {
                $this->_data['errors']['Add Permit'] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];
            }
            $this->_data['errors']['code'] =
            [
                'value' => "already exists",
            ];
        } else {
            $this->_codesModel->type         = SystemCodes::TYPE_PERMIT;
            $this->_codesModel->description  = $this->_codesModel->code;
            $this->_codesModel->is_active    = SystemCodes::STATUS_ACTIVE;
            $this->_codesModel->is_hidden    = SystemCodes::STATUS_VISIBLE;
        }
      
        if (!$idExists) {
            if (isset($this->_data['addPermit']) && !empty($this->_data['addPermit'])) {
                if (isset($this->_codesModel->code) && !empty($this->_codesModel->code)) {
                    $this->_data['savePermit'] = $this->_codesModel->save();
                } else {
                    $this->_data['errors']['Add Permit'] =
                    [
                        'value'     => "was unsuccessful",
                        'bValue'    => false,
                        'htmlTag'   => 'h4',
                        'class'     => 'alert alert-danger',
                    ];
                    
                    $this->_data['errors']['code'] =
                    [
                        'value'     => "was blank",
                    ];
                }
            }
        }

        if (isset($this->_data['savePermit']) && !empty($this->_data['savePermit'])) {
            $this->_data['success']['Add Permit'] =
            [
                'value'     => "was successful",
                'bValue'    => true,
                'htmlTag'   => 'h4',
                'class'     => 'alert alert-success',
            ];
            
            $this->_data['success'][$this->_codesModel->code] =
            [
                'value'     => "was added",
                'bValue'    => true,
            ];
        }

        return $this->render(
            'permits-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_codesModel,
            ]
        );
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

        if (strlen($this->_data['addTag']) > 0) {
            if (!is_null($tagRelationExists)) {
                $this->_data['errors']['Add Tag'] =
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
            
                    $this->_data['success']['Add Tag'] =
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
                    $this->_data['errors']['Add Tag'] =
                    [
                        'value'     => "was unsuccessful",
                        'bValue'    => false,
                        'htmlTag'   => 'h4',
                        'class'     => 'alert alert-danger',
                    ];
               
                    $this->_data['errors']['Add Permit Tag'] =
                    [
                        'value' => "was not successful; no tags were added. (Result: " . strval($result) . ") ",
                    ];
                }
            }
        }

        if (strlen($this->_data['dropTag']) > 0) {
            $result = $this->removePermitTag($this->_data['id'], $this->_data['tagid']);
      
            if ($result > 0) {
                $this->_data['success']['Remove Tag'] =
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
                $this->_data['errors']['Remove Tag'] =
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
        }
      
        if (isset($this->_data['savePermit']) && !empty($this->_data['savePermit'])) {
            $updateModel      = SystemCodes::findOne($this->_data['SystemCodes']['id']);

            $updateModel->code         = $this->_data['SystemCodes']['code'];
            $updateModel->description  = $this->_data['SystemCodes']['description'];

            //$updateColumns = $updateModel->getDirtyAttributes();

            $updateModel->is_active    = $this->_data['SystemCodes']['is_active'];
            $updateModel->is_hidden    = $this->_data['SystemCodes']['is_hidden'];

            $this->_data['savePermit'] = $updateModel->save();
            $updateColumns = $updateModel->afterSave(false, $this->_data['savePermit']);
      
            if ($this->_data['savePermit'] && is_array($updateColumns)) {
                if (count($updateColumns) > 0) {
                    $this->_data['success']['Save Permit'] =
                    [
                        'value'     => "was successful",
                        'bValue'    => true,
                        'htmlTag'   => 'h4',
                        'class'     => 'alert alert-success',
                    ];
               
                    foreach ($updateColumns as $key => $val) {
                        $keyIndex = ucwords(strtolower(str_replace("_", " ", $key)));
               
                        if ($key !== "updated_at" && $key !== "deleted_at") {
//                            $lookupNew = "TBD";
//                            $lookupOld = "TBI";
                            $lookupNew = $this->keyLookup($key, $val);
                            $lookupOld = $this->keyLookup($key, $this->_data['SystemCodes'][$key]);
                  
                            $this->_data['success'][$keyIndex] =
                            [
                                'value'     => "was updated ",
                                'bValue'    => true,
                            ];
                     
                            if (strpos($lookupNew, "Unknown") !== 0) {
                                $this->_data['success'][$keyIndex] =
                                [
                                    'value'  => "was updated ( " . $lookupNew . " -> " . $lookupOld . " )",
                                ];
                            }
                        }
                    }
                }
            }
        }

        $this->_codesModel      = $this->_codesModel->findOne($this->_data['id']);
        $this->_tagsModel       = SystemCodes::findPermitTagsById($this->_data['id']);
//        $this->_tagsModel       = SystemCodes::findAllTagsById($this->_data['id']);
      
        $this->_codeChildModel  = SystemCodes::findUnassignedPermitTagOptions($this->_data['id']);

        return $this->render(
            'permit-view',
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
     * TBD
     *
     * @return (TBD)
     */
    private function keyLookup($key, $value)
    {
        $codeType   = self::getDropDownOpts('tags_permits');
        $isActive   = CodesController::getDropDownOpts('is_active');
        $isHidden   = CodesController::getDropDownOpts('is_hidden');
      
        if ($key === "type") {
            if (isset($codeType[$value]) && !empty($codeType[$value])) {
                return $codeType[$value];
            } else {
                return "Unknown value : " . $key . " :: " . $value;
            }
        } elseif ($key === "is_active") {
            if (isset($isActive[$value]) && !empty($isActive[$value])) {
                return $isActive[$value];
            } else {
                return "Unknown value : " . $key . " :: " . $value;
            }
        } elseif ($key === "is_hidden") {
            if (isset($isHidden[$value]) && !empty($isHidden[$value])) {
                return $isHidden[$value];
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
    public static function getDropDownOpts($key = "", $prompt = false)
    {
        $dropDownOpts     = self::dropDownOpts;
   
        if (!isset($key) || empty($key)) {
            return $dropDownOpts;
        } elseif (!in_array($key, self::dropDownOptsKeys)) {
            return $dropDownOpts;
        }
      
        if ($key === "tags_permits") {
            $tagsModel  = SystemCodes::findPermitTagOptions();
         
            foreach ($tagsModel as $tag_row) {
                $dropDownOpts[$key][$tag_row->id] = $tag_row->code . ": " . $tag_row->description;
            }
        }
      
        if (!$prompt) {
            if (isset($dropDownOpts[$key])) {
                unset($dropDownOpts[$key][-1]);
            }
        }

        return $dropDownOpts[$key];
    }
}
