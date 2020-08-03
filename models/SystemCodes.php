<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use app\models\SystemCodesChild;


class SystemCodes extends ActiveRecord
{
   const TYPE_PERMIT       = 1;
   const TYPE_DEPARTMENT   = 2;
   const TYPE_CAREERLEVEL  = 3;
   const TYPE_MASTERS      = 4;
   
   const STATUS_INACTIVE   = 0;
   const STATUS_ACTIVE     = 1;


   public $id;
   public $type;
   public $code;
   public $description;
   public $is_active;
   public $created_at;
   public $updated_at;
   public $deleted_at;   


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
               ActiveRecord::EVENT_BEFORE_INSERT => ['created_at',],
               ActiveRecord::EVENT_BEFORE_DELETE => ['deleted_at',],
            ],
            // if you're using datetime instead of UNIX timestamp:
            'value' => time(),
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
   public function rules()
   {
      return [
//         [['name', 'type', ], 'required' ],
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
         ->where(['type' => SystemCodes::TYPE_PERMIT ])
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
         ->from(     $tbl_systemsCodes . ' sc' )
         ->innerJoin( $tbl_SystemCodesChild,       $tbl_SystemCodesChild . '.parent = sc.id' )
         ->innerJoin( $tbl_systemsCodes . ' sc2',  $tbl_SystemCodesChild . '.child = sc2.id' )
         ->where(['sc.type =:sc_type AND sc.is_active =:sc_is_active AND sc2.is_active =:sc2_is_active' ])
            ->addParams([ 
               ':sc_type'        => SystemCodes::TYPE_PERMIT, 
               ':sc_is_active'   => SystemCodes::STATUS_ACTIVE,
               ':sc2_is_active'  => SystemCodes::STATUS_ACTIVE, 
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
   public static function findPermitTagsById( $id = -1 )
   {
      if( $id < 0 || strval($id) === 0 )
      {
         return false;
      }
   
      $tbl_SystemsCodes       = SystemCodes::tableName();
      $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
      $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc2.id', 'sc2.type', 'sc2.code', 'sc2.description' ])
         ->from(     $tbl_SystemsCodes . ' sc' )
         ->innerJoin( $tbl_SystemCodesChild,       $tbl_SystemCodesChild . '.parent = sc.id' )
         ->innerJoin( $tbl_SystemsCodes . ' sc2',  $tbl_SystemCodesChild . '.child = sc2.id' )
         ->where(['sc.id' => $id ])
         ->andWhere([ 'sc.type'        => SystemCodes::TYPE_PERMIT ])
         ->andWhere([ 'sc.is_active'   => SystemCodes::STATUS_ACTIVE ])
         ->andWhere([ 'sc2.is_active'  => SystemCodes::STATUS_ACTIVE ])
         ->all();

      return $query_codes;
   }

/*
   public static function findbyUnassignedRoles( $assignedRoles = '' )
   {
      return AuthItem::find()
         ->where([ 'type' => AuthItem::TYPE_ROLE ]) 
         ->andWhere([ 'not in' , 'name', $assignedRoles ])
         ->all();         
   }   

   public static function findbyPermissions()
   {
      return AuthItem::find()
         ->where(['type' => AuthItem::TYPE_PERMISSION ])
         ->all();
   }
 */


    /**
     * TBD
     *
     * @returns model filtered by all entries that are not TYPE_PERMIT
     */
   public static function findPermitTagOptions( $id = -1 )
   {
      return SystemCodes::find()
         ->where([ '!=', 'type',  SystemCodes::TYPE_PERMIT ])
         ->all();
   }


    /**
     * TBD
     *
     * @param integer Row $id value for code entry
     * @returns model filtered by TYPE_PERMIT || false if $id is invalid
     */
   public static function findUnassignedPermitTagOptions( $id = -1 )
   {
      if( $id < 0 || strval($id) === 0 )
      {
         return false;
      }
   
      $tbl_SystemsCodes       = SystemCodes::tableName();
      $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
      $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc.is_active' ])
         ->from(     $tbl_SystemsCodes       . ' sc' )
         ->leftJoin( $tbl_SystemCodesChild   . ' scc', 'scc.child = sc.id' )
         ->where( 'sc.type !=:type AND ( scc.parent !=:id OR scc.parent IS NULL )' )
            ->addParams( [':type' => SystemCodes::TYPE_PERMIT, ':id' => $id], )
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
         ->where(['type' => SystemCodes::TYPE_DEPARTMENT ])
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
         ->where(['type' => SystemCodes::TYPE_CAREERLEVEL ])
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
         ->where(['type' => SystemCodes::TYPE_MASTERS ])
         ->all();
   }

   

/*
   public static function findbyUnassignedRoles( $assignedRoles = '' )
   {
      return AuthItem::find()
         ->where([ 'type' => AuthItem::TYPE_ROLE ]) 
         ->andWhere([ 'not in' , 'name', $assignedRoles ])
         ->all();         
   }   


   public static function findbyPermissions()
   {
      return AuthItem::find()
         ->where(['type' => AuthItem::TYPE_PERMISSION ])
         ->all();
   }
 */
   
   
/**
 *
 *    Relationships & Model section
 *
 **/   

   public function getCodeChildren()
   {
      return $this->hasMany(SystemCodesAssignment::className(), [ 'child' => 'id' ] );
   }
 

}