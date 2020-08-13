<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\behaviors\TimestampBehavior;

use app\models\BaseModel;
use app\models\SystemCodesChild;


class SystemCodes extends BaseModel
{
   private $_changedAttributes;


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
     * @returns array[] attributes updated after save
     */
   public function afterSave($insert, $changedAttributes) 
   {
      parent::afterSave($insert, $changedAttributes);
   
      if(!$insert) 
      {
         if( is_null( $this->_changedAttributes ) || empty( $this->_changedAttributes ) )
            $this->_changedAttributes = $changedAttributes;
            
         return $this->_changedAttributes;
      }
      
      return [];
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
         ->from(     $tbl_systemsCodes . ' sc' )
         ->innerJoin( $tbl_SystemCodesChild,       $tbl_SystemCodesChild . '.parent = sc.id' )
         ->innerJoin( $tbl_systemsCodes . ' sc2',  $tbl_SystemCodesChild . '.child = sc2.id' )
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
   public static function findPermitTagsById( $id = -1 )
   {
      if( $id < 0 || strval($id) === 0 )
      {
         return false;
      }
   
      $tbl_SystemsCodes       = self::tableName();
      $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   
      $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc2.id', 'sc2.type', 'sc2.code', 'sc2.description' ])
         ->from(     $tbl_SystemsCodes . ' sc' )
         ->innerJoin( $tbl_SystemCodesChild,       $tbl_SystemCodesChild . '.parent = sc.id' )
         ->innerJoin( $tbl_SystemsCodes . ' sc2',  $tbl_SystemCodesChild . '.child = sc2.id' )
         ->where(['sc.id' => $id ])
         ->andWhere([ 'sc.type'        => self::TYPE_PERMIT ])
         ->andWhere([ 'sc.is_active'   => self::STATUS_ACTIVE ])
         ->andWhere([ 'sc2.is_active'  => self::STATUS_ACTIVE ])
         ->all();

      return $query_codes;
   }


    /**
     * TBD
     *
     * @returns model filtered by all entries that are not TYPE_PERMIT
     */
   public static function findPermitTagOptions( $id = -1 )
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
   public static function findUnassignedPermitTagOptions( $id = -1 )
   {
      if( $id < 0 || strval($id) === 0 )
      {
         return false;
      }
   
      $tbl_SystemsCodes       = self::tableName();
      $tbl_SystemCodesChild   = SystemCodesChild::tableName();
   

      $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc.is_active' ])
         ->from(     $tbl_SystemsCodes       . ' sc' )
         ->where( 'type !=:type AND id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )' )
            ->addParams([ ':type' => self::TYPE_PERMIT, ':id' => $id ])
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
   public static function existsSystemCode( $type = -1, $code = "" )
   {        
      $query_codes = (new \yii\db\Query())
         ->select([ 'id', 'type', 'code', 'description', 'created_at', 'updated_at' ])
         ->from( self::tableName() )
         ->where( 'code=:code AND type =:type ' )
            ->addParams([
               ':code' => $code, 
               ':type' => $type, 
            ])
         ->limit(1);     

      foreach( $query_codes->each() as $code_row )
      {
         return new static( $code_row );
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
      return self::existsSystemCode( self::TYPE_PERMIT, $code );  
   }   
   
   
/**
 *
 *    Relationships & Model section
 *
 **/   

   public function getCodeChildren()
   {
      return $this->hasMany(SystemCodesChild::className(), [ 'child' => 'id' ] );
   }
}