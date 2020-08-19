<?php

namespace app\controllers;

use yii;

use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;

use app\controllers\BaseController;

use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\SystemCodes;
use app\models\SystemCodesChild;
use app\models\User;
use app\models\UsersPersonal;

class UsersController extends BaseController
{
    const dropDownOptsKeys  = [ 'pageCount',  'is_active', 'us_citizen', 'citizen_other', 'visa_type', 'country_list' ];
   
    const dropDownOpts      =
    [
      'pageCount' =>
      [
         '10'  => '10',
         '25'  => '25',
         '50'  => '50',
         '100' => '100',
      ],
      'is_active' =>
      [
         '-1'  => 'Select Status',
         '0'   => 'Inactive',
         '1'   => 'Active',
      ],
      'us_citizen' =>
      [
         '-1'  => 'Select US Citizenship Status',
         '0'   => 'No',
         '1'   => 'Yes',
      ],
      'citizen_other' =>
      [
         '-1'  => 'Select Foreign Citizenship Status',
         '0'   => 'Not Applicable',
         '1'   => 'Yes',
      ],
      'visa_type' =>
      [
         '-1'  => 'Select Visa Status',
         '0'   => 'Not Applicable',
         '1'   => 'F-1',
         '2'   => 'F-2',
         '3'   => 'F-3',
      ],

      'country_list' =>
      [
        '-1'    => 'Select Country of Citizenship',
        '0'     => 'Not Applicable',
        'Africa' =>
        [
            "DZ" => "Algeria",
            "AO" => "Angola",
            "BJ" => "Benin",
            "BW" => "Botswana",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "CM" => "Cameroon",
            "CV" => "Cape Verde",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "KM" => "Comoros",
            "CG" => "Congo - Brazzaville",
            "CD" => "Congo - Kinshasa",
            "CI" => "Côte d’Ivoire",
            "DJ" => "Djibouti",
            "EG" => "Egypt",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "ET" => "Ethiopia",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GH" => "Ghana",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "KE" => "Kenya",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "ML" => "Mali",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "NA" => "Namibia",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "RW" => "Rwanda",
            "RE" => "Réunion",
            "SH" => "Saint Helena",
            "SN" => "Senegal",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "SD" => "Sudan",
            "SZ" => "Swaziland",
            "ST" => "São Tomé and Príncipe",
            "TZ" => "Tanzania",
            "TG" => "Togo",
            "TN" => "Tunisia",
            "UG" => "Uganda",
            "EH" => "Western Sahara",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
        ],
        'Americas' =>
        [
            "AI" => "Anguilla",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AW" => "Aruba",
            "BS" => "Bahamas",
            "BB" => "Barbados",
            "BZ" => "Belize",
            "BM" => "Bermuda",
            "BO" => "Bolivia",
            "BR" => "Brazil",
            "VG" => "British Virgin Islands",
            "CA" => "Canada",
            "KY" => "Cayman Islands",
            "CL" => "Chile",
            "CO" => "Colombia",
            "CR" => "Costa Rica",
            "CU" => "Cuba",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "SV" => "El Salvador",
            "FK" => "Falkland Islands",
            "GF" => "French Guiana",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GT" => "Guatemala",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HN" => "Honduras",
            "JM" => "Jamaica",
            "MQ" => "Martinique",
            "MX" => "Mexico",
            "MS" => "Montserrat",
            "AN" => "Netherlands Antilles",
            "NI" => "Nicaragua",
            "PA" => "Panama",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PR" => "Puerto Rico",
            "BL" => "Saint Barthélemy",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "SR" => "Suriname",
            "TT" => "Trinidad and Tobago",
            "TC" => "Turks and Caicos Islands",
            "VI" => "U.S. Virgin Islands",
            "US" => "United States",
            "UY" => "Uruguay",
            "VE" => "Venezuela",
        ],
        'Asia' =>
        [
            "AF" => "Afghanistan",
            "AM" => "Armenia",
            "AZ" => "Azerbaijan",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BT" => "Bhutan",
            "BN" => "Brunei",
            "KH" => "Cambodia",
            "CN" => "China",
            "CY" => "Cyprus",
            "GE" => "Georgia",
            "HK" => "Hong Kong SAR China",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IL" => "Israel",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Laos",
            "LB" => "Lebanon",
            "MO" => "Macau SAR China",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "MN" => "Mongolia",
            "MM" => "Myanmar [Burma]",
            "NP" => "Nepal",
            "NT" => "Neutral Zone",
            "KP" => "North Korea",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PS" => "Palestinian Territories",
            "YD" => "People's Democratic Republic of Yemen",
            "PH" => "Philippines",
            "QA" => "Qatar",
            "SA" => "Saudi Arabia",
            "SG" => "Singapore",
            "KR" => "South Korea",
            "LK" => "Sri Lanka",
            "SY" => "Syria",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "AE" => "United Arab Emirates",
            "UZ" => "Uzbekistan",
            "VN" => "Vietnam",
            "YE" => "Yemen",
        ],
        'Europe' =>
        [
            "AL" => "Albania",
            "AD" => "Andorra",
            "AT" => "Austria",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BA" => "Bosnia and Herzegovina",
            "BG" => "Bulgaria",
            "HR" => "Croatia",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DD" => "East Germany",
            "EE" => "Estonia",
            "FO" => "Faroe Islands",
            "FI" => "Finland",
            "FR" => "France",
            "DE" => "Germany",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GG" => "Guernsey",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IT" => "Italy",
            "JE" => "Jersey",
            "LV" => "Latvia",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MK" => "Macedonia",
            "MT" => "Malta",
            "FX" => "Metropolitan France",
            "MD" => "Moldova",
            "MC" => "Monaco",
            "ME" => "Montenegro",
            "NL" => "Netherlands",
            "NO" => "Norway",
            "PL" => "Poland",
            "PT" => "Portugal",
            "RO" => "Romania",
            "RU" => "Russia",
            "SM" => "San Marino",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "ES" => "Spain",
            "SJ" => "Svalbard and Jan Mayen",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "UA" => "Ukraine",
            "SU" => "Union of Soviet Socialist Republics",
            "GB" => "United Kingdom",
            "VA" => "Vatican City",
            "AX" => "Åland Islands",
        ],
        'Oceania' =>
        [
            "AS" => "American Samoa",
            "AQ" => "Antarctica",
            "AU" => "Australia",
            "BV" => "Bouvet Island",
            "IO" => "British Indian Ocean Territory",
            "CX" => "Christmas Island",
            "CC" => "Cocos [Keeling] Islands",
            "CK" => "Cook Islands",
            "FJ" => "Fiji",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GU" => "Guam",
            "HM" => "Heard Island and McDonald Islands",
            "KI" => "Kiribati",
            "MH" => "Marshall Islands",
            "FM" => "Micronesia",
            "NR" => "Nauru",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "PW" => "Palau",
            "PG" => "Papua New Guinea",
            "PN" => "Pitcairn Islands",
            "WS" => "Samoa",
            "SB" => "Solomon Islands",
            "GS" => "South Georgia and the South Sandwich Islands",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TV" => "Tuvalu",
            "UM" => "U.S. Minor Outlying Islands",
            "VU" => "Vanuatu",
            "WF" => "Wallis and Futuna",
        ],
    ],

   ];

    private $_authItemModel;

    private $_roleModel;
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

        $this->_userModel        = new User();
        $this->_roleModel        = new AuthAssignment();
        $this->_authItemModel    = new AuthItem();
      
        $this->_tbl_SystemCodes       = SystemCodes::tableName();
        $this->_tbl_SystemCodesChild  = SystemCodesChild::tableName();
           
        /**
         *    Capturing the possible post() variables used in this controller
         **/
        if (!isset($this->_data['uuid']) || empty($this->_data['uuid'])) {
            $this->_data['uuid']   = $this->_request->get('uuid', '');
        }
      
        if (!isset($this->_data['uuid']) || empty($this->_data['uuid'])) {
            $this->_data['uuid']   = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '');
        }
        
        if (isset($this->_data['uuid']) && !empty($this->_data['uuid'])) {
            $this->_userPersonalModel = UsersPersonal::findOne($this->_data['uuid']);
        }
        
//        self::debug( $this->_data['uuid'], false );
//        self::debug( $this->_userPersonalModel );
      
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
     * Centralizing the query for building the User GridView
     *
     * @return SqlDataProvider
     */
    private function getUserGridView()
    {
        $params[':id'] = 1;
      
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(*) FROM tbl_Users WHERE id >=:id ',
            [':id' => $params[':id']]
        )->queryScalar();
            
        $sql  = "SELECT  id, uuid, is_active, created_at, updated_at " ;
        $sql .= "FROM tbl_Users WHERE id >=:id ";

        if (strlen($this->_data['filterForm']['uuid']) > 0) {
            $sql .= "AND uuid LIKE :uuid ";
            $params[':uuid'] = '%' . $this->_data['filterForm']['uuid'] . '%';
        }
      
        if ($this->_data['filterForm']['is_active'] > -1 && strlen($this->_data['filterForm']['is_active']) > 0) {
            $sql .= "AND is_active =:is_active ";
            $params[':is_active']   = $this->_data['filterForm']['is_active'];
        }
      
        $UserSDP = new SqlDataProvider([
         'sql'          => $sql,
         'params'       => $params,
         'totalCount'   => $count,
         'sort' => [
            'attributes' =>
            [
               'uuid' =>
               [
                  'default' => SORT_ASC,
                  'label' => 'UUID',
               ],
/**
               'name' => [
                  'default' => SORT_ASC,
                  'label' => 'Name',
               ],

               'is_active' => [
                  'default' => SORT_ASC,
                  'label' => 'Status',
               ],
 **/
               'created_at',
               'updated_at',
            ],
         ],
         'pagination' =>
         [
            'pageSize' => $this->_data['filterForm']['paginationCount'],
         ]
      ]);
      
        return $UserSDP;
    }

    /**
     * Displays listing of all users in the system.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->_dataProvider = $this->getUserGridView();

        return $this->render(
            'users-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_userModel
            ]
        );
    }
   

    /**
     * Displays selected UUID ( 1 record ).
     *
     * @return string
     */
    public function actionView()
    {
        $this->_data['uuid']     = $this->_request->get('uuid', '');

        $this->_userModel = User::find()
            ->where(['uuid' => $this->_data['uuid'] ])
            ->limit(1)->one();

        $this->_roleModel  = AuthAssignment::find();
      
        $assignedRoles = [];
        foreach ($this->_userModel->roles as $role) {
            $assignedRoles[] = $role->item_name;
        }
      
        $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);
        

        return $this->render(
            'user-view',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_userModel,
                'roles'        => $this->_roleModel,
                'allRoles'     => $this->_authItemModel,
                'userPersonal' => $this->_userPersonalModel,
            ]
        );
    }


    /**
     * Adding new User and Role information
     *
     * @return (TBD)
     */
    public function actionAdd()
    {
        $this->_dataProvider = $this->getUserGridView();
   
        // Testing GH Workflow
   
        $this->_userModel->uuid          = ArrayHelper::getValue($this->_request->post(), 'User.uuid', '');
      
        $uuidExists = User::existsUUID($this->_userModel->uuid);
      
        if ($uuidExists) {
            if (isset($this->_data['addUser']) && !empty($this->_data['addUser'])) {
                $this->_data['errors']['Add User'] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];

                $this->_data['errors']['uuid'] =
                [
                    'value' => "already exists",
                ];
            }
        } else {
//         $this->_userModel->name       = $this->_userModel->uuid;
            $this->_userModel->is_active  = 1;
            $this->_userModel->created_at = time();
            
            $this->_userModel->generateAuthKey();
            $this->_userModel->generateAccessToken();
        }
      
        if (!$uuidExists) {
            if (isset($this->_data['addUser']) && !empty($this->_data['addUser'])) {
                if (isset($this->_userModel->uuid) && !empty($this->_userModel->uuid)) {
                    $this->_data['saveUser'] = $this->_userModel->save();
                } else {
                    $this->_data['errors']['Add User'] =
                    [
                        'value'     => "was unsuccessful",
                        'htmlTag'   => 'h4',
                        'class'     => 'alert alert-danger',
                    ];
               
                    $this->_data['errors']['uuid'] =
                    [
                        'value'     => "is null",
                    ];
                }
            }
        }

        if ($this->_data['saveUser']) {
            $this->_data['success']['Add User'] =
            [
                'value'     => "was successful",
                'bValue'    => true,
                'htmlTag'   => 'h4',
                'class'     => 'alert alert-success',
            ];
         
            $this->_data['success'][$this->_userModel->uuid] =
            [
                'value'     => "was added",
                'bValue'    => true,
            ];
        }

        return $this->render(
            'users-listing',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_userModel,
            ]
        );
    }
   
   
    /**
     * Saving changes to User and Role information
     *
     * @return (TBD)
     */
    public function actionSave()
    {
        $exitEarly = false;

        $this->_userModel = User::find()
         ->where(['uuid' => $this->_data['uuid'] ])
         ->limit(1)->one();

        $roleTag = "";
      
        if (isset($this->_data['authitem']['name']) && !empty($this->_data['authitem']['name'])) {
            $roleTag = $this->_data['authitem']['name'];
        } elseif (isset($this->_data['authassignment']['item_name']) && !empty($this->_data['authassignment']['item_name'])) {
            $roleTag = $this->_data['authassignment']['item_name'];
        }

        if (strlen($this->_data['addRole']) > 0) {
            if ($this->_auth->assign($this->_auth->getRole($roleTag), $this->_userModel->id)) {
                $this->_data['success']['Add Role'] =
                [
                   'value'        => "was successful",
                   'bValue'       => true,
                   'htmlTag'      => 'h4',
                   'class'        => 'alert alert-success',
                ];
            
                $this->_data['success'][$roleTag] =
                [
                    'value' => "was added",
                ];
            } else {
                $this->_data['errors']['Add Role'] =
                [
                   'value'     => "was unsuccessful",
                   'bValue'    => false,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors'][$roleTag] =
                [
                    'value' => "was not added.",
                ];
            }
         
            $exitEarly = true;
        }

        if (strlen($this->_data['dropRole']) > 0) {
            if ($this->_auth->revoke($this->_auth->getRole($roleTag), $this->_userModel->id)) {
                $this->_data['success']['Remove Role'] =
                [
                   'value'        => "was successful",
                   'bValue'       => true,
                   'htmlTag'      => 'h4',
                   'class'        => 'alert alert-success',
                ];
            
                $this->_data['success'][$roleTag] =
                [
                    'value' => "was removed",
                ];
            } else {
                $this->_data['errors']['Remove Role'] =
                [
                   'value'     => "was unsuccessful",
                   'bValue'    => false,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];
            
                $this->_data['errors'][$roleTag] =
                [
                    'value' => "was not removed.",
                ];
            }
         
            $exitEarly = true;
        }

        /**
         * Tag only update; exiting early
         **/

        if ($exitEarly) {
            $roleModel  = AuthAssignment::find();
         
            $assignedRoles = [];
            foreach ($this->_userModel->roles as $role) {
                $assignedRoles[] = $role->item_name;
            }
         
            $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);
      
            return $this->render(
                'user-view',
                [
                    'data'         => $this->_data,
                    'dataProvider' => $this->_dataProvider,
                    'model'        => $this->_userModel,
                    'roles'        => $this->_roleModel,
                    'allRoles'     => $this->_authItemModel,
                ]
            );
        }
      
        /**
         * User model update
         **/
        $exitEarly = false;
        $uuidExists = User::existsUUID($this->_data['uuid']);
      
        if (!$uuidExists) {
            if (isset($this->_data['saveUser']) && !empty($this->_data['saveUser'])) {
                $this->_data['errors']['Save User'] =
                [
                   'value'     => "was unsuccessful",
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-danger',
                ];

                $this->_data['errors']['uuid'] =
                [
                    'value' => " ( " . $this->_data['uuid'] . " ) does not exist",
                ];
            }
         
            $roleModel  = AuthAssignment::find();
         
            $assignedRoles = [];
            foreach ($this->_userModel->roles as $role) {
                $assignedRoles[] = $role->item_name;
            }
         
            $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);
      
            return $this->render(
                'user-view',
                [
                    'data'         => $this->_data,
                    'dataProvider' => $this->_dataProvider,
                    'model'        => $this->_userModel,
                    'roles'        => $this->_roleModel,
                    'allRoles'     => $this->_authItemModel,
                ]
            );
        }

        $updateModel            = $this->_userModel;
      
        $updateModel->scenario  = User::SCENARIO_UPDATE;

        $updateModel->is_active     = $this->_data['User']['is_active'];
        $updateModel->access_token  = $this->_data['User']['access_token'];

        $this->_data['User']['Update']   = $updateModel->save();
      
        $updateColumns = $updateModel->afterSave(false, $this->_data['User']['Update']);
      
        if ($this->_data['User']['Update'] && is_array($updateColumns)) {
            if (count($updateColumns) > 0) {
                $this->_data['success']['Save User'] =
                [
                   'value'     => "was successful",
                   'bValue'    => true,
                   'htmlTag'   => 'h4',
                   'class'     => 'alert alert-success',
                ];
            
                foreach ($updateColumns as $key => $val) {
                    $keyIndex = ucwords(strtolower(str_replace("_", " ", $key)));
            
                    if ($key !== "updated_at" && $key !== "deleted_at") {
                        $lookupNew = $this->keyLookup($key, $val);
                        $lookupOld = $this->keyLookup($key, $this->_data['User'][$key]);
               
                        $this->_data['success'][$keyIndex] =
                        [
                            'value'     => "was updated",
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

        $roleModel  = AuthAssignment::find();
      
        $assignedRoles = [];
        foreach ($this->_userModel->roles as $role) {
            $assignedRoles[] = $role->item_name;
        }
      
        $this->_authItemModel   = AuthItem::findbyUnassignedRoles($assignedRoles);

        return $this->render(
            'user-view',
            [
                'data'         => $this->_data,
                'dataProvider' => $this->_dataProvider,
                'model'        => $this->_userModel,
                'roles'        => $this->_roleModel,
                'allRoles'     => $this->_authItemModel,
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
        $isActive   = self::getDropDownOpts('is_active');
      
        if ($key === "is_active") {
            if (isset($isActive[$value]) && !empty($isActive[$value])) {
                return $isActive[$value];
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
      
        if (!$prompt) {
            if (isset($dropDownOpts[$key])) {
                unset($dropDownOpts[$key][-1]);
            }
        }

        return $dropDownOpts[$key];
    }
}
