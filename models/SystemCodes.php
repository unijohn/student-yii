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
   
   const STATUS_HIDDEN     = 0;
   const STATUS_VISIBLE    = 1;
   
   const SCENARIO_INSERT   = 'insert';
   const SCENARIO_UPDATE   = 'update';
   

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
               ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
               ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],           
               ActiveRecord::EVENT_BEFORE_DELETE => ['deleted_at'],
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
      $scenarios[self::SCENARIO_INSERT] = [];
      $scenarios[self::SCENARIO_UPDATE] = [ 'type', 'code', 'description', 'is_active', 'is_hidden' ];
   
      return $scenarios;
   }


   /**
   * @inheritdoc
   */
   public function rules()
   {
      return [
//         ['type', 'default', 'value'    => SystemCodes::STATUS_ACTIVE ],
//         ['type', 'integer', 'min'      => SystemCodes::STATUS_INACTIVE ],
         ['type', 'filter',  'filter'   => 'intval'],

//         ['is_active', 'default', 'value'    => SystemCodes::STATUS_ACTIVE ],
//         ['is_active', 'integer', 'min'      => SystemCodes::STATUS_INACTIVE ],
         ['is_active', 'filter',  'filter'   => 'intval'],

//         ['is_hidden', 'default', 'value'    => SystemCodes::STATUS_VISIBLE ],
//         ['is_hidden', 'integer', 'min'      => SystemCodes::STATUS_HIDDEN ],         
         ['is_hidden', 'filter',  'filter'   => 'intval'],
         
         [['is_active', 'is_hidden'], 'required', 'on' => self::SCENARIO_UPDATE ],
      
//         [['name', 'type', ], 'required' ],
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
         ->where( 'type !=:type AND id NOT IN ( SELECT child from ' . $tbl_SystemCodesChild .' WHERE parent = :id )' )
            ->addParams([ ':type' => SystemCodes::TYPE_PERMIT, ':id' => $id ])
         ->all();

/**
      $query_codes = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc.is_active' ])
         ->from(     $tbl_SystemsCodes       . ' sc' )
         ->leftJoin( $tbl_SystemCodesChild   . ' scc', 'scc.child = sc.id' )
         ->where( 'sc.type !=:type AND scc.child IS NULL ' )
            ->addParams([':type' => SystemCodes::TYPE_PERMIT ]);

//      $query_sub2    = SystemCodesChild::find()->select('child')->where([ 'child' => 1 ]);

      $query_codes2 = ( new \yii\db\Query() )
         ->select([  'sc.id', 'sc.type', 'sc.code', 'sc.description', 'sc.is_active' ])
         ->from(     $tbl_SystemCodesChild   . ' scc' )
         ->leftJoin( $tbl_SystemCodesChild   . ' scc2', 'scc.child = scc2.child' )
         ->innerJoin( $tbl_SystemsCodes      . ' sc ',  'sc.id = scc.child' )
         ->where( 'scc2.parent !=:id AND scc.child NOT IN ( SELECT child FROM ' . $tbl_SystemCodesChild . ' WHERE parent =:parent )'  )
            ->addParams([':id' => $id, ':parent' => $id ]);

      $query_codes->union( $query_codes2 );
      
      
//      print( "<pre>" );
      foreach( $query_codes->all() as $user_row )
      {
//         print_r( $user_row );
      }
//      die();
 **/
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

   
   public static function existsPermit($code)
   {        
      $query_permits = (new \yii\db\Query())
         ->select([ 'id', 'type', 'code', 'description', 'created_at', 'updated_at' ])
         ->from( SystemCodes::tableName() )
         ->where( 'code=:code AND type =:type ' )
            ->addParams([
               ':code' => $code, 
               ':type' => SystemCodes::TYPE_PERMIT, 
            ])
         ->limit(1);     
     
      foreach( $query_permits->each() as $permit_row )
      {
         return true;
      }
 
      return false;            
   }   
   
   
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