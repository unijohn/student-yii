<?php

namespace app\models;

use Yii;
use yii\base\model;
//use yii\behaviors\TimestampBehavior;

use app\models\BaseModel;
use app\models\SystemCodes;

class SystemCodesChild extends BaseModel
{
    //   public $parent;
    //   public $child;


    public function init()
    {
        parent::init();
    }


    public static function tableName()
    {
        return '{{tbl_SystemCodesChild}}';
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

/**
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
     *
     *    Relationships & Model section
     *
     **/


    public function getAssignments()
    {
        return $this->hasMany(SystemCodes::className(), [ 'parent' => 'id' ]);
    }
}
