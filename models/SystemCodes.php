<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;

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
        return [
//         'id' => Yii::t('app', 'ID'),
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
                'grouping' // multiple lists varying by 'categoryId'
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
        $scenarios[self::SCENARIO_INSERT] = [ 'type', 'code', 'description', 'is_active', 'is_hidden' ];
        $scenarios[self::SCENARIO_UPDATE] = [ 'type', 'code', 'description', 'is_active', 'is_hidden' ];
   
        return $scenarios;
    }


    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
         ['type', 'default', 'value'    => self::TYPE_PERMIT ],
         ['type', 'integer', 'min'      => self::TYPE_PERMIT ],
         ['type', 'integer', 'max'      => self::TYPE_MAX    ],
         ['type', 'filter',  'filter'   => 'intval'],

         ['is_active', 'default', 'value'    => self::STATUS_ACTIVE   ],
         ['is_active', 'integer', 'min'      => self::STATUS_INACTIVE ],
         ['is_active', 'filter',  'filter'   => 'intval'],

         ['is_hidden', 'default', 'value'    => self::STATUS_VISIBLE ],
         ['is_hidden', 'integer', 'min'      => self::STATUS_HIDDEN  ],
         ['is_hidden', 'filter',  'filter'   => 'intval'],

         [
            [
               'type', 'code', 'description', 'is_active', 'is_hidden'
            ],
            'required', 'on' => self::SCENARIO_UPDATE
         ],
      ];
    }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_PERMIT
     */
    public static function findbyPermit()
    {
        return SystemCodes::find()
         ->where(['type' => self::TYPE_PERMIT ])
         ->all();
    }
      

    /**
     * TBD
     *
     * @returns model filtered by TYPE_PERMIT
     */
    public static function findAllPermitTags()
    {
        $tbl_systemsCodes       = $this->tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.type', 'sc.code', 'sc.description', 'sc2.type', 'sc2.code', 'sc2.description' ])
         ->from($tbl_systemsCodes . ' sc')
         ->innerJoin($tbl_SystemCodesChild, $tbl_SystemCodesChild . '.parent = sc.id')
         ->innerJoin($tbl_systemsCodes . ' sc2', $tbl_SystemCodesChild . '.child = sc2.id')
         ->where(['sc.type =:sc_type AND sc.is_active =:sc_is_active AND sc2.is_active =:sc2_is_active' ])
            ->addParams([
               ':sc_type'        => self::TYPE_PERMIT,
               ':sc_is_active'   => self::STATUS_ACTIVE,
               ':sc2_is_active'  => self::STATUS_ACTIVE,
            ])
         ->all();

        return $query_codes;
    }
   
   
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_PERMIT || false if $id is invalid
     */
    public static function findPermitTagsById($id = -1)
    {
        if ($id < 0 || strval($id) === 0) {
            return false;
        }
   
        $tbl_SystemsCodes       = self::tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc2.id', 'sc2.type', 'sc2.code', 'sc2.description', 'sc2.is_active', 'sc2.is_hidden' ])
         ->from($tbl_SystemsCodes . ' sc')
         ->innerJoin($tbl_SystemCodesChild, $tbl_SystemCodesChild . '.parent = sc.id')
         ->innerJoin($tbl_SystemsCodes . ' sc2', $tbl_SystemCodesChild . '.child = sc2.id')
         ->where(['sc.id' => $id ])
         ->andWhere([ 'sc.type'        => self::TYPE_PERMIT ])
//         ->andWhere([ 'sc.is_active'   => self::STATUS_ACTIVE ])
//         ->andWhere([ 'sc2.is_active'  => self::STATUS_ACTIVE ])
         ->all();

        return $query_codes;
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
        if ($id < 0 || strval($id) === 0) {
            return false;
        }
   
        $tbl_SystemsCodes       = self::tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc2.id', 'sc2.type', 'sc2.code', 'sc2.description', 'sc2.is_active', 'sc2.is_hidden' ])
         ->from($tbl_SystemsCodes . ' sc')
         ->innerJoin($tbl_SystemCodesChild, $tbl_SystemCodesChild . '.parent = sc.id')
         ->innerJoin($tbl_SystemsCodes . ' sc2', $tbl_SystemCodesChild . '.child = sc2.id')
         ->where(['sc.id' => $id ])
         //->andWhere([ 'sc.is_active'   => self::STATUS_ACTIVE ])
         //->andWhere([ 'sc2.is_active'  => self::STATUS_ACTIVE ])
         ->all();

        return $query_codes;
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
     * @returns model filtered by TYPE_PERMIT || false if $id is invalid
     */
    public static function findUnassignedPermitTagOptions($id = -1)
    {
        if ($id < 0 || strval($id) === 0) {
            return false;
        }
      
        // $id, SelectType, OmitType [self::TYPE_PERMIT]
        return self::findUnassignedTagOptions($id, -1, self::TYPE_PERMIT);
    }
   
   
    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_PERMIT || false if $id is invalid
     */
    public static function findUnassignedDepartmentTagOptions($id = -1)
    {
        if ($id < 0 || strval($id) === 0) {
            return false;
        }
      
        // $id, SelectType, OmitType [self::TYPE_PERMIT]
        return self::findUnassignedTagOptions($id, -1, self::TYPE_DEPARTMENT);
    }


    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model || false if $id is invalid
     */
    public static function findUnassignedTagOptions($id = -1, $selectType = -1, $omitType = -1, $isActive = self::STATUS_ACTIVE)
    {
        if ($id < 0 || !is_numeric($id)) {
            return false;
        }
   
        $tbl_SystemsCodes       = self::tableName();
        $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
        $tag = SystemCodes::find()
         ->where([ 'id' => $id ])
         ->limit(1)
         ->one();

        $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc.is_active' ])
         ->from($tbl_SystemsCodes       . ' sc');
            
       
        if ($selectType > 0 && is_numeric($selectType)) {
            $query_codes = $query_codes->where('sc.type =:type AND sc.is_active =:is_active AND sc.id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )')
            ->addParams([
               ':type'        => $selectType,
               ':is_active'   => $isActive,
               ':id'          => $id
            ])
         ->all();
        } elseif ($omitType > 0 && is_numeric($omitType)) {
            $query_codes = $query_codes->where('sc.type !=:type AND sc.is_active =:is_active AND sc.id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )')
            ->addParams([
               ':type'        => $omitType,
               ':is_active'   => $isActive,
               ':id'          => $id
            ])
         ->all();
        } else {
            $query_codes = $query_codes->where('sc.is_active =:is_active AND sc.id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )')
            ->addParams([
               ':is_active'   => $isActive,
               ':id'          => $id
            ])
         ->all();
        }

        return $query_codes;
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
            ->addParams([ ':id' => $id, 'is_active' => self::STATUS_ACTIVE, 'type' => self::TYPE_PERMIT ])
         ->all();

        return $query_codes;
    }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_DEPARTMENT
     */
    public static function findbyDepartment()
    {
        return SystemCodes::find()
         ->where(['type' => self::TYPE_DEPARTMENT ])
         ->all();
    }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_CAREERLEVEL
     */
    public static function findbyCareerLevel()
    {
        return SystemCodes::find()
         ->where(['type' => self::TYPE_CAREERLEVEL ])
         ->all();
    }


    /**
     * TBD
     *
     * @returns model filtered by TYPE_MASTERS
     */
    public static function findbyMasters()
    {
        return SystemCodes::find()
         ->where(['type' => self::TYPE_MASTERS ])
         ->all();
    }


    /**
     * Determines if this system code already exists in the system
     *
     * @return (TBD)
     */
    public static function existsSystemCode($type = -1, $code = "")
    {
        $query_codes = (new \yii\db\Query())
         ->select([ 'id', 'type', 'code', 'description', 'created_at', 'updated_at' ])
         ->from(self::tableName())
         ->where('code=:code AND type =:type ')
            ->addParams([
               ':code' => $code,
               ':type' => $type,
            ])
         ->limit(1);

        foreach ($query_codes->each() as $code_row) {
            return new static($code_row);
        }
 
        return null;
    }


    /**
     * Determines if this permit already exists in the system
     *
     * @return (TBD)
     */
    public static function existsPermit($code)
    {
        return self::existsSystemCode(self::TYPE_PERMIT, $code);
    }
   
    /**
     * Determines if this department already exists in the system
     *
     * @return (TBD)
     */
    public static function existsDepartment($code)
    {
        return self::existsSystemCode(self::TYPE_DEPARTMENT, $code);
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
