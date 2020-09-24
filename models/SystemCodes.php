<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\position\PositionBehavior;  // https://github.com/yii2tech/ar-position

use app\models\BaseModel;
use app\models\CoursesCodesChild;
use app\models\SystemCodesChild;

class SystemCodes extends BaseModel
{
    public $_changedAttributes;


    public function init()
    {
        parent::init();
    }


    public static function tableName()
    {
        return '{{tbl_SystemCodes}}';
    }

   
    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return
        [
            'id'                => Yii::t('app', 'ID'),
        
            'type'              => Yii::t('app', 'Code Type'),
            'type_str'          => Yii::t('app', 'Code Type (Str)'),
            'code'              => Yii::t('app', 'Code (#)'),
            'code_str'          => Yii::t('app', 'Code (Str)'),
            'description'       => Yii::t('app', 'Description'),
            
            'is_active'         => Yii::t('app', 'Is Active'),
            'is_visible'        => Yii::t('app', 'Is Visible'),
            'is_banner_data'    => Yii::t('app', 'Source Data'),
            
            'order_by'          => Yii::t('app', 'Ordering'),
            
            'created_at'        => Yii::t('app', 'Created'),
            'updated_at'        => Yii::t('app', 'Updated'),
            'deleted_at'        => Yii::t('app', 'Deleted'),
        ];
    }


    // explicitly list every field, best used when you want to make sure the changes
    // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
    public function fields()
    {

/**
      return [
         // field name is the same as the attribute name
         'id'     => 'id',
      ];
 **/
    }


    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
         'timeStampBehavior' => [
            'class' => TimestampBehavior::className(),
            'attributes' =>
            [
               self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
               self::EVENT_BEFORE_UPDATE => ['updated_at'],
               self::EVENT_BEFORE_DELETE => ['deleted_at'],
            ],
            // if you're using datetime instead of UNIX timestamp:
            'value' => time(),
         ],
         
        'positionBehavior' => [
            'class' => PositionBehavior::className(),
            'positionAttribute' => 'order_by',
            'groupAttributes' => [
                'type' // multiple lists varying by 'categoryId'
            ],
        ],

/**
         'softDeleteBehavior' => [
            'class' => SoftDeleteBehavior::className(),
            'softDeleteAttributeValues' =>
            [
               'isDeleted' => true
            ],

            // mutate native `delete()` method
            'replaceRegularDelete' => false
         ],
 **/
 
      ];
    }


    /**
    * @inheritdoc
    */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_INSERT] = [ 'type', 'type_str', 'code', 'code_str', 'description', 'value', 'value_str', 'is_active', 'is_visible', 'is_banner_data', ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'type', 'type_str', 'code', 'code_str', 'description', 'value', 'value_str', 'is_active', 'is_visible', ];
        $scenarios[self::SCENARIO_MOVE]   = [ 'order_by', ];
   
        return $scenarios;
    }


    /**
    * @inheritdoc
    */
    public function rules()
    {
        return
        [
            [
                'is_active',  'number', 'min' => self::STATUS_ACTIVE_MIN,  'max' => self::STATUS_ACTIVE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'is_visible', 'number', 'min' => self::STATUS_VISIBLE_MIN, 'max' => self::STATUS_VISIBLE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'is_banner_data', 'number', 'min' => self::STATUS_BANNER_MIN, 'max' => self::STATUS_BANNER_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'type', 'number', 'min' => self::TYPE_MIN, 'max' => self::TYPE_MAX,
                'tooBig' => 'Select a valid option', 'tooSmall' => 'Select a valid option',
            ],
            [
                'order_by',   'number',
            ],

            [
                'is_active', 'default', 'value' => self::STATUS_ACTIVE
            ],
            [
                'is_visible', 'default', 'value' => self::STATUS_VISIBLE
            ],
            [
                'is_banner_data', 'default', 'value' => self::STATUS_BANNER_MIN
            ],

            [
                'type_str',     'string', 'max' => 64
            ],
            [
                'description',  'string', 'max' => 64
            ],
            [
                'code_str',     'string', 'max' => 64
            ],
            
            [
                [
                    'type', 'type_str', 'code', 'code_str', 'description', 'is_active', 'is_visible',
                ],
                'required', 'on' => self::SCENARIO_UPDATE
            ],
            [
                [
                    'order_by',
                ],
                'required', 'on' => self::SCENARIO_MOVE
            ],
        ];
    }


    /**
     * TBD
     *
     * @returns model filtered by $type
     */
    public static function findbyType($type = -1)
    {
        if ($type < 0 || intval($type) === 0 || gettype($type) != 'integer') {
            return false;
        }
        
        return SystemCodes::find()
         ->where(['type' => $type ])
         ->all();
    }
    
    
    /**
     * TBD
     *
     * @returns model filtered by $type_str
     */
    public static function findbyTypeStr($type_str = "")
    {
        if ($type_str == "" || strlen($type_str) == 0 || gettype($type_str) != 'string') {
            return false;
        }
    
        return SystemCodes::find()
         ->where(['type_str' => $type_str ])
         ->all();
    }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_PERMIT
     */
    public static function findbyPermit()
    {
        return SystemCodes::findbyType(self::TYPE_PERMIT);
    }
    
    
    /**
     * TBD
     *
     * @returns model filtered by TYPE_DEPARTMENT
     */
    public static function findbyDepartment()
    {
        return SystemCodes::findbyType(self::TYPE_DEPARTMENT);
    }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_CAREERLEVEL
     */
    public static function findbyCareerLevel()
    {
        return SystemCodes::findbyType(self::TYPE_CAREERLEVEL);
    }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_MASTERS
     */
    public static function findbyMasters()
    {
        return SystemCodes::findbyType(self::TYPE_MASTERS);
    }
    

    /**
      * TBD
      *
      * @returns model filtered by TYPE_FACULTY_RANK
      */
    public static function findbyFacultyRank()
    {
        return SystemCodes::findbyType(self::TYPE_FACULTY_RANK);
    }
    
    
    /**
      * TBD
      *
      * @returns model filtered by TYPE_EMPLOYEE_CLASS
      */
    public static function findbyEmployeeClass()
    {
        return SystemCodes::findbyType(self::TYPE_EMPLOYEE_CLASS);
    }


    /**
      * TBD
      *
      * @returns model filtered by TYPE_SCHOOL_DEPT
      */
    public static function findbySchoolDept()
    {
        return SystemCodes::findbyType(self::TYPE_SCHOOL_DEPT);
    }
    
    
    /**
      * TBD
      *
      * @returns model filtered by TYPE_UNIVERSITY_DEPT
      */
    public static function findbyUniversityDept()
    {
        return SystemCodes::findbyType(self::TYPE_UNIVERSITY_DEPT);
    }
        

    /**
     * TBD
     *
     * @return (TBD)
     */
    public static function getDistinctTypes($prompt = false)
    {
        $tbl_systemCodes = SystemCodes::tableName();
   
        $query_fields = ( new \yii\db\Query() )
            ->select([  'sc.type', 'sc.type_str' ])
            ->distinct()
            ->from($tbl_systemCodes . ' sc')
            ->orderBy('sc.type')
            ->all();

        $dropDown = [];

        if ($prompt) {
            $dropDown[0] = "Select Type";
        }

        foreach ($query_fields as $row) {
            $dropDown[$row['type']] = $row['type_str'];
        }
        
        return $dropDown;
    }
      

    /**
     * TBD
     *
     * @returns model filtered by TYPE_PERMIT
     */
    public static function findAllPermitTags()
    {
        $tbl_systemsCodes       = self::tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.type', 'sc.code', 'sc.description', 'sc2.type', 'sc2.code', 'sc2.description' ])
         ->from($tbl_systemsCodes . ' sc')
         ->innerJoin($tbl_SystemCodesChild, $tbl_SystemCodesChild . '.parent = sc.id')
         ->innerJoin($tbl_systemsCodes . ' sc2', $tbl_SystemCodesChild . '.child = sc2.id')
         ->where(['=', 'sc.type', self::TYPE_PERMIT ])
         ->andWhere([ '=', 'sc.is_active', self::STATUS_ACTIVE ])
         ->andWhere([  '=', 'sc2.is_active',self::STATUS_ACTIVE ]);
         

        if ($query_codes->count() == 0) {
            return false;
        }

        return $query_codes->all();
    }
   
   
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_PERMIT || false if $id is invalid
     */
    public static function findPermitTagsById($id = -1)
    {
        if ($id < 0 || strval($id) === 0 || gettype($id) != 'integer') {
            return false;
        }
   
        $tbl_SystemsCodes       = self::tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc2.id', 'sc2.type', 'sc2.code', 'sc2.description', 'sc2.is_active', 'sc2.is_visible' ])
         ->from($tbl_SystemsCodes . ' sc')
         ->innerJoin($tbl_SystemCodesChild, $tbl_SystemCodesChild . '.parent = sc.id')
         ->innerJoin($tbl_SystemsCodes . ' sc2', $tbl_SystemCodesChild . '.child = sc2.id')
         ->where(['sc.id' => $id ])
         ->andWhere([ 'sc.type'        => self::TYPE_PERMIT ]);
//         ->andWhere([ 'sc.is_active'   => self::STATUS_ACTIVE ])
//         ->andWhere([ 'sc2.is_active'  => self::STATUS_ACTIVE ])

        if ($query_codes->count() == 0) {
            return false;
        }

        return $query_codes->all();
    }


    /**
     * TBD
     *
     * Note:   If sc2 is Inactive, it will disappear from its code assignments
     *         FIR.MSBAFIR == Inactive:  Tag will not appear to be removed on FIR code.
     *
     * Suggestion:   Add a "Show Hidden and/or Inactive Tags" on 'parent' code
     *               FIR.show_all_tags == MSBAFIR which is set to Hidden & Inactive
     *
     * @param integer Row $id value for code entry
     * @returns model || false if $id is invalid
     */
    public static function findAllTagsById($id = -1)
    {
        if ($id < 0 || strval($id) === 0 || !is_numeric($id)) {
     
        /*
            self::debug( "id < 0: " . ( $id < 0 ? 'true' : 'false'), false );
            self::debug( "strval($id) === 0: " . ( strval($id) === 0 ? 'true' : 'false'), false );
            self::debug( "is_numeric($id) : " . ( is_numeric($id) ? 'true' : 'false'), false );
         */
        
            return false;
        }
   
        $tbl_SystemsCodes       = self::tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc2.id', 'sc2.type', 'sc2.code', 'sc2.code_str', 'sc2.description', 'sc2.is_active', 'sc2.is_visible' ])
         ->from($tbl_SystemsCodes . ' sc')
         ->innerJoin($tbl_SystemCodesChild, $tbl_SystemCodesChild . '.parent = sc.id')
         ->innerJoin($tbl_SystemsCodes . ' sc2', $tbl_SystemCodesChild . '.child = sc2.id')
         ->where(['sc.id' => $id ]);
        //->andWhere([ 'sc.is_active'   => self::STATUS_ACTIVE ])
        //->andWhere([ 'sc2.is_active'  => self::STATUS_ACTIVE ])

        if ($query_codes->count() == 0) {
            return false;
        }

        return $query_codes->all();
    }


    /**
     * TBD
     *
     * @returns model filtered by all entries that are not TYPE_PERMIT
     */
    public static function findPermitTagOptions()
    {
        return SystemCodes::find()
         ->where([ '!=', 'type',  self::TYPE_PERMIT ])
         ->all();
    }


    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model || false if $id is invalid
     */
    public static function findUnassignedTagOptions($id = -1, $selectType = -1, $omitType = -1, $isActive = self::STATUS_ACTIVE, $getSql = false)
    {
        if ($id < 0 || strval($id) === 0 || !is_numeric($id)) {
     
        /*
            self::debug( "id < 0: " . ( $id < 0 ? 'true' : 'false'), false );
            self::debug( "strval($id) === 0: " . ( strval($id) === 0 ? 'true' : 'false'), false );
            self::debug( "is_numeric($id) : " . ( is_numeric($id) ? 'true' : 'false'), false );
         */
        
            return false;
        }

        $tbl_SystemsCodes       = self::tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $tag = SystemCodes::find()
         ->where([ 'id' => $id ])
         ->limit(1)
         ->one();

        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.code_str', 'sc.description', 'sc.is_active', 'sc.is_visible', 'sc.is_banner_data' ])
         ->from($tbl_SystemsCodes       . ' sc');
                   
        if ($selectType > 0 && is_numeric($selectType)) {
            $query_codes = $query_codes->where('sc.type =:type AND sc.is_active =:is_active AND sc.id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )')
            ->addParams([
               ':type'        => $selectType,
               ':is_active'   => $isActive,
               ':id'          => $id
            ]);
        } elseif ($omitType > 0 && is_numeric($omitType)) {
            $query_codes = $query_codes->where('sc.type !=:type AND sc.is_active =:is_active AND sc.id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )')
            ->addParams([
               ':type'        => $omitType,
               ':is_active'   => $isActive,
               ':id'          => $id
            ]);
        } else {
            $query_codes = $query_codes->where('sc.is_active =:is_active AND sc.id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )')
            ->addParams([
               ':is_active'   => $isActive,
               ':id'          => $id
            ]);
        }
        
        // No prompt options
        $query_codes = $query_codes->andWhere([ '!=', 'sc.code', -1 ]);
        
        if ($getSql) {
            self::debug("SystemCodes (518-ish)", false);
            self::debug($query_codes->createCommand()->getRawSql());
        } elseif ($query_codes->count() == 0) {
            return false;
        }

        return $query_codes->all();
    }


    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_PERMIT || false if $id is invalid
     */
    public static function findUnassignedPermitTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_PERMIT, self::STATUS_ACTIVE, false);
    }
   
   
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_DEPARTMENT || false if $id is invalid
     */
    public static function findUnassignedDepartmentTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_DEPARTMENT);
    }


    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_CAREERLEVEL || false if $id is invalid
     */
    public static function findUnassignedCareerLevelTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_CAREERLEVEL);
    }
    
    
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_MASTERS || false if $id is invalid
     */
    public static function findUnassignedMasterTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_MASTERS);
    }
    
    
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_FACULTY_RANK || false if $id is invalid
     */
    public static function findUnassignedFacultyRankTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_FACULTY_RANK);
    }
    
    
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_EMPLOYEE_CLASS || false if $id is invalid
     */
    public static function findUnassignedEmployeeClassTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_EMPLOYEE_CLASS);
    }
    
    
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_SCHOOL_DEPT || false if $id is invalid
     */
    public static function findUnassignedSchoolDepartmentTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_SCHOOL_DEPT);
    }
    
    
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_UNIVERSITY_DEPT || false if $id is invalid
     */
    public static function findUnassignedUniversityDepartmentTagOptions($id = -1)
    {
        return self::findUnassignedTagOptions($id, -1, self::TYPE_UNIVERSITY_DEPT);
    }
     

    /**
     * TBD
     *
     * @param integer Row $id value for course entry
     * @returns model || false if $id is invalid
     */
    public static function findUnassignedTagOptionsForCourses($id = "")
    {
        if (empty($id) || !is_string($id)) {
            return false;
        }
   
        $tbl_SystemCodes        = self::tableName();
        $tbl_CoursesCodesChild  = CoursesCodesChild::tableName();
   

        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc.is_active' ])
         ->from($tbl_SystemCodes       . ' sc')
         ->where('id NOT IN ( SELECT child from ' . $tbl_CoursesCodesChild .' WHERE parent = :id ) AND sc.is_active =:is_active AND sc.type !=:type')
            ->addParams([ ':id' => $id, 'is_active' => self::STATUS_ACTIVE, 'type' => self::TYPE_PERMIT ]);

        return $query_codes->all();
    }


    /**
     * Determines if this system code already exists in the system
     *
     * @return (TBD)
     */
    public static function existsSystemCode($type = -1, $code_str = "", $getSql = false)
    {
        if ($type < 0 || strval($type) === 0 || gettype($type) != 'integer') {
            return false;
        } elseif ($code_str === "" || strval($code_str) === 0 || gettype($code_str) != 'string') {
            return false;
        }
        
        //self::debug( "683: : " . $code_str . " :: " . $type);
    
        $query_codes = (new \yii\db\Query())
         ->select([ 'id', 'type', 'code', 'code_str', 'description', 'created_at', 'updated_at' ])
         ->from(self::tableName())
         ->where('code_str=:code_str AND type =:type ')
            ->addParams([
               ':code_str' => $code_str,
               ':type' => $type,
            ]);
         
        if ($getSql) {
            self::debug("SystemCodes (695-ish)", false);
            self::debug($query_codes->createCommand()->getRawSql());
        }

        return ($query_codes->count() ? true : false);
    }


    /**
     * Determines if this permit already exists in the system
     *
     * @return (TBD)
     */
    public static function existsPermit($code_str)
    {
//        self::debug( self::TYPE_PERMIT . " :: " . $code_str );
        return self::existsSystemCode(self::TYPE_PERMIT, $code_str);
    }


    /**
     * Determines if this department already exists in the system
     *
     * @return (TBD)
     */
    public static function existsDepartment($code_str)
    {
        return self::existsSystemCode(self::TYPE_DEPARTMENT, $code_str);
    }


    /**
     * Determines if this careel level already exists in the system
     *
     * @return (TBD)
     */
    public static function existsCareelLevel($code_str)
    {
        return self::existsSystemCode(self::TYPE_CAREERLEVEL, $code_str);
    }
    
    
    /**
     * Determines if this masters already exists in the system
     *
     * @return (TBD)
     */
    public static function existsMasters($code_str)
    {
        return self::existsSystemCode(self::TYPE_MASTERS, $code_str);
    }
    
    
    /**
     * Determines if this faculty rank already exists in the system
     *
     * @return (TBD)
     */
    public static function existsFacultyRank($code_str)
    {
        return self::existsSystemCode(self::TYPE_FACULTY_RANK, $code_str);
    }
    
    
    /**
     * Determines if this employee class already exists in the system
     *
     * @return (TBD)
     */
    public static function existsEmployeeClass($code_str)
    {
        return self::existsSystemCode(self::TYPE_EMPLOYEE_CLASS, $code_str);
    }
   
   
    /**
     * Determines if this school department already exists in the system
     *
     * @return (TBD)
     */
    public static function existsSchoolDepartment($code_str)
    {
        return self::existsSystemCode(self::TYPE_SCHOOL_DEPT, $code_str);
    }
    
    
    /**
     * Determines if this school department already exists in the system
     *
     * @return (TBD)
     */
    public static function existsUniversityDepartment($code_str)
    {
        return self::existsSystemCode(self::TYPE_UNIVERSITY_DEPT, $code_str);
    }

   
    /**
     *
     *    Relationships & Model section
     *
     **/

    public function getCodeChildren()
    {
        return $this->hasMany(SystemCodesChild::className(), [ 'child' => 'id' ]);
    }
}
