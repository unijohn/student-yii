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

class FieldsController extends BaseController
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
   
    private $_fieldsModel;

    private $_tbl_FormFields;


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
      
        $this->_fieldsModel             = new FormFields();
      
        $this->_tbl_FormFields          = FormFields::tableName();
            
        /**
         *    Capturing the possible post() variables used in this controller
         *
         *    $this->_data['id'] ( post() ) is set in BaseController.  If it isn't set,
         *    we check to see if there is a get() version of it.
         **/
      
        if (strlen($this->_data['id']) < 1) {
            $this->_data['id']   = $this->_request->get('id', '');
        }

//        $this->_data['filterForm']['type']              = ArrayHelper::getValue($this->_request->get(), 'FormFields.type', '');
        $this->_data['filterForm']['type']              = ArrayHelper::getValue($this->_request->get(), 'FormFields.type', '');
        $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'FormFields.is_active', -1);
        $this->_data['filterForm']['is_visible']        = ArrayHelper::getValue($this->_request->get(), 'FormFields.is_visible', -1);
        $this->_data['filterForm']['paginationCount']   = ArrayHelper::getValue($this->_request->get(), 'FormFields.pagination_count', 10);

        /**
                $this->_data['tagid']            = $this->_request->post('tagid', '');
                $this->_data['addTag']           = $this->_request->post('addTag', '');
                $this->_data['dropTag']          = $this->_request->post('dropTag', '');
         **/

        $this->_data['FormFields']['id']            = ArrayHelper::getValue($this->_request->post(), 'FormFields.id', '');
        $this->_data['FormFields']['form_field']    = ArrayHelper::getValue($this->_request->post(), 'FormFields.form_field', FormFields::TYPE_FIELD_NOT_SET);
        $this->_data['FormFields']['type']          = ArrayHelper::getValue($this->_request->post(), 'FormFields.type', FormFields::TYPE_FIELD_MIN);
        $this->_data['FormFields']['description']   = ArrayHelper::getValue($this->_request->post(), 'FormFields.description', '');
        
        $this->_data['FormFields']['value']         = ArrayHelper::getValue($this->_request->post(), 'FormFields.value', '');
        $this->_data['FormFields']['value_str']     = ArrayHelper::getValue($this->_request->post(), 'FormFields.value_str', 0);

        $this->_data['FormFields']['is_active']     = ArrayHelper::getValue($this->_request->post(), 'FormFields.is_active', FormFields::STATUS_ACTIVE);
        $this->_data['FormFields']['is_visible']    = ArrayHelper::getValue($this->_request->post(), 'FormFields.is_visible', FormFields::STATUS_VISIBLE);
        $this->_data['FormFields']['type']          = ArrayHelper::getValue($this->_request->post(), 'FormFields.type', '');
        
        $this->_data['FormFields']['insert']        = ArrayHelper::getValue($this->_request->post(), 'FormFields.insert', '');
        $this->_data['FormFields']['update']        = ArrayHelper::getValue($this->_request->post(), 'FormFields.update', '');
        
        /**
                if( isset() && !empty() ) {

                }
                if( isset() && !empty() ) {

                }
         **/

  
/**
         *    if inserting a new record, set the filter to that new record's type as a UX feature

        if (isset($this->_data['SystemCodes']['type']) && !empty($this->_data['SystemCodes']['type'])) {
            $this->_data['filterForm']['type'] = $this->_data['SystemCodes']['type'];
        }
 **/
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
     * Centralizing the query for building the FormFields GridView
     *
     * @return SqlDataProvider
     */
    private function getFieldsGridView()
    {
        $params  = [];

        $sql  = "SELECT id, form_field, type, type_str, description, value, value_str, is_active, is_visible, order_by, created_at, updated_at " ;
        $sql .= "FROM " . $this->_tbl_FormFields . " WHERE id > 0 ";

        $countSQL  = "SELECT COUNT(*) " ;
        $countSQL .= "FROM " . $this->_tbl_FormFields . " WHERE id > 0 ";

        if ($this->_data['filterForm']['type'] > -1 && strlen($this->_data['filterForm']['type']) > 0) {
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
            
            $params[':is_visible']   = $this->_data['filterForm']['is_visible'];
        }
      
        $count = Yii::$app->db->createCommand(
            $countSQL,
            $params
        )->queryScalar();
      
        $FieldsSDP = new SqlDataProvider([
         'sql'          => $sql,
         'params'       => $params,
         'totalCount'   => $count,
         'sort' => [
            'defaultOrder' =>
            [
               'type'       => SORT_ASC,
               'order_by'   => SORT_ASC,
            ],
            'attributes' =>
            [
               'id' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'ID',
               ],
               'form_field' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Form Field',
               ],
               'type_str' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Grouping',
               ],
               'type' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Grouping',
               ],
               'order_by' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Ordering',
               ],
               'description' =>
               [
                  'default' => SORT_ASC,
                  'label'   => 'Description',
               ],
            ],
         ],
         'pagination' =>
         [
            'pageSize' => $this->_data['filterForm']['paginationCount'],
         ],
      ]);
      
        return $FieldsSDP;
    }


    /**
     *  Centralized render('fields-listing') call
     *
     *  returns void
     **/
    private function renderListing()
    {
        /**
                $results = FormFields::find()
                ->where(['grouping' => 5  ])
                ->all();

                $count = 1;

                print( "<pre>" );
                print( "        \$fieldRows = " . PHP_EOL );
                print( "        [ " . PHP_EOL );
                print( "            [ " . PHP_EOL );
                print( "                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'calendar_year_four', 'Select Year', '', -1, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $count, \$created_at,  " . PHP_EOL );
                print( "            ], " . PHP_EOL );

                for( $i = 2030; $i >= 1930; $i-- ) {

                    $count++;

                    if( $i >= 2021 ){
                        $isActive  = "self::STATUS_INACTIVE";
                        $isVisible = "self::STATUS_HIDDEN";
                    }
                    else {
                        $isActive  = "self::STATUS_ACTIVE";
                        $isVisible = "self::STATUS_VISIBLE";
                    }

                    print( "            [" . PHP_EOL );
                    print( "                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'calendar_year_four', '$i', '$i', $i, $isActive, $isVisible, $count, \$created_at," . PHP_EOL );
                    print( "            ]," . PHP_EOL );

        //            $count++;
                }

                print( "        ];" . PHP_EOL );

                die();
        **/
    
        $this->_dataProvider = $this->getFieldsGridView();

        //self::debug( $this->_data );

        return $this->render(
            'fields-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_fieldsModel,
            ]
        );
    }
    

    /**
     *  Centralized render('fields-view') call
     *
     *  returns void
     **/
    private function renderView()
    {
        return $this->render(
            'fields-view',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_fieldsModel,
            ]
        );
    }


    /**
     * Displays listing of all form fields in the system.
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
        $this->_fieldsModel = FormFields::find()
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
        $row = FormFields::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();
            
        $row->scenario      = FormFields::SCENARIO_MOVE;
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
        $row = FormFields::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();
            
        $row->scenario      = FormFields::SCENARIO_MOVE;
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
        $row = FormFields::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();

        $row->scenario      = FormFields::SCENARIO_MOVE;
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
        $row = FormFields::find()
            ->where(['id' => $this->_data['id'] ])
            ->one();

        $row->scenario      = FormFields::SCENARIO_MOVE;
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
//        $this->_dataProvider = $this->getCodesGridView();

        $exitEarly = false;
        $msgHeader = "Add Form Field";

        if (isset($this->_data['FormFields']['insert']) && !empty($this->_data['FormFields']['insert'])) {
            if ($this->_data['FormFields']['form_field'] < 1) {
                $this->_data['errors'][$msgHeader] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors']['form_field'] =
                [
                    'value' => "was not selected",
                ];

                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }

            if (empty($this->_data['FormFields']['type'])) {
                $this->_data['errors'][$msgHeader] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];

                $this->_data['errors']['type'] =
                [
                    'value' => "is blank",
                ];

                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }
      
            if (empty($this->_data['FormFields']['description'])) {
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

                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }
        }

        if ($exitEarly) {
            return $this->renderListing();
        }

        /**
                $this->_data['FormFields']['id']            = ArrayHelper::getValue($this->_request->post(), 'FormFields.id',           '');
                $this->_data['FormFields']['form_field']    = ArrayHelper::getValue($this->_request->post(), 'FormFields.form_field',   FormFields::TYPE_FIELD_MIN);
                $this->_data['FormFields']['grouping']      = ArrayHelper::getValue($this->_request->post(), 'FormFields.grouping',     FormFields::TYPE_ITEM_MAX);
                $this->_data['FormFields']['description']   = ArrayHelper::getValue($this->_request->post(), 'FormFields.description',  '');

                $this->_data['FormFields']['value']         = ArrayHelper::getValue($this->_request->post(), 'FormFields.value',           '');
                $this->_data['FormFields']['value_int']     = ArrayHelper::getValue($this->_request->post(), 'FormFields.value_int',       0);

                $this->_data['FormFields']['is_active']     = ArrayHelper::getValue($this->_request->post(), 'FormFields.is_active',    FormFields::STATUS_ACTIVE);
                $this->_data['FormFields']['is_hidden']     = ArrayHelper::getValue($this->_request->post(), 'FormFields.is_visible',   FormFields::STATUS_VISIBLE);
                $this->_data['FormFields']['type']          = ArrayHelper::getValue($this->_request->post(), 'FormFields.type', '');
         **/
         
        $idExists = FormFields::existsFieldByProperties(
            $this->_data['FormFields']['form_field'],
            $this->_data['FormFields']['type'],
            '',
            $this->_data['FormFields']['description'],
            $this->_data['FormFields']['value'],
            $this->_data['FormFields']['value_str']
        );

        $this->_fieldsModel->form_field     = $this->_data['FormFields']['form_field'];
        $this->_fieldsModel->type           = $this->_data['FormFields']['type'];
        $this->_fieldsModel->description    = $this->_data['FormFields']['description'];
        $this->_fieldsModel->value          = $this->_data['FormFields']['value'];
        $this->_fieldsModel->value_str      = $this->_data['FormFields']['value_str'];

        if ($idExists) {
            if (isset($this->_data['FormFields']['insert']) && !empty($this->_data['FormFields']['insert'])) {
                $this->_data['errors']['useSession'] = true;
                
                $this->_data['errors'][$msgHeader] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];

                //$keyIndex = ucfirst(strtolower(str_replace("_", " ", $key)));

                $keyError  = "( " . $this->keyLookup('form_field', $this->_fieldsModel->form_field) . " ) ";
                $keyError .= $this->keyLookup('type_str', $this->_fieldsModel->grouping) . ": ";
                $keyError .= $this->_fieldsModel->description;

                $this->_data['errors'][$keyError] =
                [
                    'value' => "already exists",
                ];

                /**
                 *    if inserting a new record, set the filter to that new record's type as a UX feature
                 **/
                $this->_data['filterForm']['form_field']    = $this->_fieldsModel->form_field;
                $this->_data['filterForm']['type']      = $this->_fieldsModel->grouping;
            }
            
            $this->_data['errors']['useSession'] = true;
            return $this->renderListing();
        }
      
        $updateModel               = new FormFields();
        $updateModel->scenario     = FormFields::SCENARIO_INSERT;

        $updateModel->form_field    = $this->_data['FormFields']['form_field'];
        $updateModel->type          = $this->_data['FormFields']['type'];
        $updateModel->type_str      = $this->keyLookup('type_str', $this->_data['FormFields']['type']);
        $updateModel->description   = $this->_data['FormFields']['description'];
        $updateModel->value         = $this->_data['FormFields']['value'];
        $updateModel->value_str     = $this->_data['FormFields']['value_str'];

        $this->_data['FormFields']['insert'] = $updateModel->save();
         
//      $updateColumns = $updateModel->afterSave( false, $this->_data['addSystemCode']);

        if (!$this->_data['FormFields']['insert']) {
            $this->_data['errors'][$msgHeader] =
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
            $this->_data['success'][$msgHeader] =
            [
                'value'     => "was successful",
                'bValue'    => true,
                'htmlTag'   => 'h4',
                'class'     => 'alert alert-success',
            ];
         
            $keySuccess  = "( " . $this->keyLookup('form_field', $this->_fieldsModel->form_field) . " ) ";
            $keySuccess .= $this->keyLookup('type_str', $this->_fieldsModel->type) . ": ";
            $keySuccess .= $this->_fieldsModel->description;
         
            $this->_data['success'][$keySuccess] =
            [
                'value'     => "was added",
                'bValue'    => true,
            ];
            
            $this->_data['success']['useSession'] = true;
        }


        /**
         * Setting the Grouping filter to newly insert record to easily verify that the record is in the system
         **/
        $this->_data['filterForm']['type'] = $updateModel->type;

        $this->_dataProvider = $this->getFieldsGridView();
        return $this->renderListing();
    }
   
   
    /**
     * Saving changes to System Codes and associated information
     *
     * @return (TBD)
     */
    public function actionSave()
    {
        $isError    = false;
        $msgHeader  = "Save Form Field";

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

                        $exitEarly = true;
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

                    $exitEarly = true;
                }
         **/

        if (isset($this->_data['FormFields']['update']) && !empty($this->_data['FormFields']['update'])) {
        
//            self::debug( "742" , false );
//            self::debug( $this->_data['FormFields']['update'], false );
        
            $this->_fieldsModel                 = new FormFields();

            $this->_fieldsModel->id             = $this->_data['FormFields']['id'];

            $this->_fieldsModel->form_field     = $this->_data['FormFields']['form_field'];
            $this->_fieldsModel->type           = $this->_data['FormFields']['type'];
            $this->_fieldsModel->type_str       = $this->keyLookup('type_str', $this->_data['FormFields']['type']);
            $this->_fieldsModel->description    = $this->_data['FormFields']['description'];
            $this->_fieldsModel->value          = $this->_data['FormFields']['value'];
            $this->_fieldsModel->value_str      = $this->_data['FormFields']['value_str'];
            
            $this->_fieldsModel->is_active      = $this->_data['FormFields']['is_active'];
            $this->_fieldsModel->is_visible     = $this->_data['FormFields']['is_visible'];
   
            $exitEarly = false;

            if (!isset($this->_fieldsModel->form_field) || empty($this->_fieldsModel->form_field)) {
                $this->_data['errors'][$msgHeader] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];

                /**
                   Unsure what kind of error will be caught here; TBD
                 **/
             
                $this->_data['errors']['form_field'] =
                [
                    'value' => "is invalid",
                ];

                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }
         
            if (!isset($this->_fieldsModel->type) || empty($this->_fieldsModel->type)) {
                $this->_data['errors'][$msgHeader] =
                [
                    'value'     => "was unsuccessful",
                    'htmlTag'   => 'h4',
                    'class'     => 'alert alert-danger',
                ];
   
                $this->_data['errors']['type'] =
                [
                    'value' => "is invalid",
                ];
            
                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }
         
            if (!isset($this->_fieldsModel->description) || empty($this->_fieldsModel->description)) {
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
   
                $this->_data['errors']['useSession'] = true;
                $exitEarly = true;
            }
   
            if ($exitEarly) {
                return $this->renderView();
            }

            $updateModel                    = FormFields::findOne($this->_fieldsModel->id);
            $updateModel->scenario          = FormFields::SCENARIO_UPDATE;
 
            $updateModel->form_field        = $this->_data['FormFields']['form_field'];
            $updateModel->type              = $this->_data['FormFields']['type'];
            $updateModel->type_str          = $this->keyLookup('type_str', $this->_data['FormFields']['type']);
            $updateModel->description       = $this->_data['FormFields']['description'];
            $updateModel->value             = $this->_data['FormFields']['value'];
            $updateModel->value_str          = $this->_data['FormFields']['value_str'];
            
            $updateModel->is_active         = $this->_data['FormFields']['is_active'];
            $updateModel->is_visible        = $this->_data['FormFields']['is_visible'];

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

            $this->_data['FormFields']['update'] = $updateModel->save();
         
            $updateColumns = $updateModel->afterSave(false, $this->_data['FormFields']['update']);

            if ($this->_data['FormFields']['update'] && is_array($updateColumns)) {
                if (count($updateColumns) > 0) {
                    foreach ($updateColumns as $key => $val) {
                        $keyIndex = ucwords(strtolower(str_replace("_", " ", $key)));
                
                        if ($key !== "updated_at" && $key !== "deleted_at") {
                            if ($val == $this->_data['FormFields'][$key]) {
                                // For some reason, afterSave() is stating that the value for this key has updated
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
                            $lookupOld = $this->keyLookup($key, $this->_data['FormFields'][$key]);
                            
//                            self::debug( $lookupNew . " vs. " . $lookupOld, true );
                            
                            $labels = $this->_fieldsModel->attributeLabels();
                            
//                            self::debug( $labels );
                   
                            $this->_data['success'][$labels[$key]] =
                            [
                                'value'     => "was updated ( <strong>" . $val . "</strong> -> <strong>" . $this->_data['FormFields'][$key] . "</strong> )",
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
                }
            }
        }

        return $this->redirect(['fields/view', 'id' => $this->_data['id'] ]);
    }

   
    /**
     * TBD
     *
     * @return (TBD)
     */
    private function keyLookup($key, $value)
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
        } elseif (!in_array($key, self::dropDownOptsKeys)) {
            return $dropDownOpts;
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
