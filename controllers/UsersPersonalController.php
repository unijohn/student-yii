<?php

namespace app\controllers;

use yii;

use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Response;

use app\controllers\BaseController;

use app\models\BaseModel;
use app\models\FormFields;
use app\models\SystemCodes;
use app\models\SystemCodesChild;
use app\models\User;
use app\models\UsersPersonal;

class UsersPersonalController extends BaseController
{
    private $_userModel;
    private $_userPersonalModel;
   
    private $_tbl_SystemCodes;
    private $_tbl_SystemCodesChild;
   
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->_userModel               = new User();
        $this->_userPersonalModel       = new UsersPersonal();
      
        $this->_tbl_SystemCodes         = SystemCodes::tableName();
        $this->_tbl_SystemCodesChild    = SystemCodesChild::tableName();
           
        /**
         *    Capturing the possible post() variables used in this controller
         **/
        if (!isset($this->_data['uuid']) || empty($this->_data['uuid'])) {
            $this->_data['uuid']   = $this->_request->get('uuid', '');
        }
      
        if (!isset($this->_data['uuid']) || empty($this->_data['uuid'])) {
            $this->_data['uuid']   = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.uuid', '');
        }
        
        if (isset($this->_data['uuid']) && !empty($this->_data['uuid'])) {
            $this->_userPersonalModel = UsersPersonal::findOne($this->_data['uuid']);
        }
        
        $this->_data['UserPersonal']['uNbr']                = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.uNbr', '');
        $this->_data['UserPersonal']['firstNm']             = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.firstNm', '');
        $this->_data['UserPersonal']['middleNm']            = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.middleNm', '');
        $this->_data['UserPersonal']['lastNm']              = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.lastNm', '');
        $this->_data['UserPersonal']['us_citizen']          = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.us_citizen', '');
        $this->_data['UserPersonal']['citizen_other']       = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.citizen_other', BaseModel::CITIZEN_OTHER_NO);
        $this->_data['UserPersonal']['visa_type']           = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.visa_type', BaseModel::VISA_NO);
        $this->_data['UserPersonal']['saveUserPersonal']    = ArrayHelper::getValue($this->_request->post(), 'UsersPersonal.saveUserPersonal', '');

        if( empty( $this->_data['UserPersonal']['citizen_other'] ) ) {
            $citizenOther = FormFields::findFieldByProperties( 
                BaseModel::TYPE_ITEM_CITIZEN_OTHER, '',
                BaseModel::CITIZEN_OTHER_NO 
            );
            
            $this->_data['UserPersonal']['citizen_other'] = $citizenOther['value'];
        }

        /**
                $this->_data['filterForm']['uuid']              = ArrayHelper::getValue($this->_request->get(), 'User.uuid', '');
                $this->_data['filterForm']['is_active']         = ArrayHelper::getValue($this->_request->get(), 'User.is_active', -1);
                $this->_data['filterForm']['paginationCount']   = ArrayHelper::getValue($this->_request->get(), 'User.pagination_count', 10);

                $this->_data['post']['addRole']        = $this->_request->post('addRole', '');
                $this->_data['post']['dropRole']       = $this->_request->post('dropRole', '');
                $this->_data['post']['authitem']       = $this->_request->post('authitem', '');
                $this->_data['post']['authassignment'] = $this->_request->post('authassignment', '');

                $this->_data['User']['is_active']      = ArrayHelper::getValue($this->_request->post(), 'User.is_active', -1);
                $this->_data['User']['access_token']   = ArrayHelper::getValue($this->_request->post(), 'User.access_token', -1);
                $this->_data['User']['saveUser']       = ArrayHelper::getValue($this->_request->post(), 'User.saveUser', -1);

                $this->_data['addRole']          = $this->_request->post('addRole', '');
                $this->_data['dropRole']         = $this->_request->post('dropRole', '');
                $this->_data['authitem']         = $this->_request->post('authitem', '');
                $this->_data['authassignment']   = $this->_request->post('authassignment', '');

                $this->_data['addUser']          = ArrayHelper::getValue($this->_request->post(), 'User.addUser', '');
                $this->_data['lookupUser']       = ArrayHelper::getValue($this->_request->post(), 'User.lookupUser', '');
                $this->_data['saveUser']         = false;
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
     * (TBD)
     *
     * @return (TBD)
     */
    public function actionAdd()
    {
        return false;
    }
   
   
    /**
     * Saving changes to UserPersonal
     *
     * @return (TBD)
     */
    public function actionSave()
    {
        $exitEarly = false;

        $this->_userModel = User::find()
         ->where(['uuid' => $this->_data['uuid'] ])
         ->limit(1)->one();

        if (strlen($this->_data['UserPersonal']['saveUserPersonal']) > 0) {
            if (!UsersPersonal::existsPersonal($this->_data['uuid'])) {
                $this->_data['errors']['useSession'] = true;
            
                $this->_data['errors']['Save Personal Information'] =
                [
                    'value'         => "was unsuccessful",
                    'bValue'        => false,
                    'htmlTag'       => 'h4',
                    'class'         => 'alert alert-danger',                
                ];
                
                $this->_data['errors'][$this->_data['uuid']] =
                [
                    'value' => "does not exist in the system."
                ];
                
                $exitEarly = false;
            } else {
                $updateModel            = $this->_userPersonalModel;
                $updateModel->scenario  = User::SCENARIO_UPDATE;
                
                $updateModel->uNbr          = $this->_data['UserPersonal']['uNbr'];
                $updateModel->firstNm       = $this->_data['UserPersonal']['firstNm'];
                $updateModel->middleNm      = $this->_data['UserPersonal']['middleNm'];
                $updateModel->lastNm        = $this->_data['UserPersonal']['lastNm'];
                $updateModel->us_citizen    = $this->_data['UserPersonal']['us_citizen'];
                
                if ($updateModel->us_citizen == BaseModel::CITIZEN_US_YES) {
                    $citizenOther = FormFields::findFieldByProperties( 
                        BaseModel::TYPE_ITEM_CITIZEN_OTHER, '',
                        BaseModel::CITIZEN_OTHER_NO 
                    );
                
                    $updateModel->citizen_other = $citizenOther['value'];
                    $updateModel->visa_type     = BaseModel::VISA_NO;
                } else {

                    $updateModel->citizen_other = $this->_data['UserPersonal']['citizen_other'];
                    $updateModel->visa_type     = $this->_data['UserPersonal']['visa_type'];
                }

                $this->_data['UserPersonal']['saveResult']   = $updateModel->save();

/**
                if( !$this->_data['UserPersonal']['saveResult'] ) {
                    self::debug( $this->_userPersonalModel->getErrors(), false );
                    self::debug( $this->_data['UserPersonal'] );
                }
 **/
      
                $updateColumns = $updateModel->afterSave(false, $this->_data['UserPersonal']['saveUserPersonal']);
            }

            if ($this->_data['UserPersonal']['saveResult'] && is_array($updateColumns)) {
                if (count($updateColumns) > 0) {
                    foreach ($updateColumns as $key => $val) {
                        $keyIndex = ucwords(strtolower(str_replace("_", " ", $key)));
                
                        if ($key !== "updated_at" && $key !== "deleted_at") {
                            if ($val == $this->_data['UserPersonal'][$key]) {
                                // For some reason, afterSave() is stating that the value for this key has updated
                                continue;
                            } else {
                                // Avoid setting this success header multiple times
                                if (!isset($this->_data['success']['Save Personal Information'])) {
                                    $this->_data['success']['useSession'] = true;                                
                                
                                    $this->_data['success']['Save Personal Information'] =
                                    [
                                       'value'      => "was successful",
                                       'bValue'     => true,
                                       'htmlTag'    => 'h4',
                                       'class'      => 'alert alert-success',
                                    ];
                                }
                            }
                            
                            $lookupNew = $this->keyLookup($key, $val);
                            $lookupOld = $this->keyLookup($key, $this->_data['UserPersonal'][$key]);                            
                            
                            $labels = $this->_userPersonalModel->attributeLabels();
                            
//                            self::debug( $labels );
                   
                            $this->_data['success'][$labels[$key]] =
                            [
                                'value'     => "was updated",
                                'bValue'    => true,
                            ];

                            if (strpos($lookupNew, "Unknown") !== 0) {
                                $this->_data['success'][$labels[$key]] =
                                [
                                    'value'  => "was updated ( " . $lookupNew . " -> " . $lookupOld . " )",
                                ];
                            }
                        }
                    }
                }
            }
        }
 
        return $this->redirect(['users/view', 'uuid' => $this->_data['uuid'] ]);
    }
   
    /**
     * TBD
     *
     * @return (TBD)
     */
    private function keyLookup($key, $value)
    {
        $usCitizen      = UsersController::getDropDownOpts('us_citizen');
        $citizenOther   = UsersController::getDropDownOpts('citizen_other');
        $visaType       = UsersController::getDropDownOpts('visa_type');
//        $countryList    = UsersController::getDropDownOpts('country_list');

//        self::debug("KeyLookUp == START : " . $key . " => " . $value, false);
      
        if ($key === "us_citizen") {
            if (isset($usCitizen[$value]) && !empty($usCitizen[$value])) {
                return $usCitizen[$value];
            } else {
                return "Unknown value : " . $key . " :: " . $value;
            }
            /**
                    } elseif ($key === "citizen_other") {
                        foreach( $citizenOther as $continent ){
                            //self::debug( $continent, false );

                            foreach( $continent as $cKey => $country ){
            //                    self::debug( $value . " >> " . $cKey . " => " . $country, false );

                                if ( strcmp ($value, $cKey) === 0 ) {
            //                        self::debug( "YES:: " . $cKey . " => " . $country, true );
                                    return $country;
                                }
                            }
                        }

                        return "Unknown value : " . $key . " == " . $value;
                    } elseif ($key === "visa_type") {
            **/
        } elseif ($key === "citizen_other") {
            if (isset($citizenOther[$value]) && !empty($citizenOther[$value])) {
                return $citizenOther[$value];
            } else {
                return "Unknown value : " . $key . " :: " . $value;
            }
        } elseif ($key === "visa_type") {
            if (isset($visaType[$value]) && !empty($visaType[$value])) {
                return $visaType[$value];
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
        $dropDownOpts     = UsersController::dropDownOpts;
   
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
}
