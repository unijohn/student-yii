<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\db\ActiveRecord;


class BaseModel extends ActiveRecord
{  
   const STATUS_INACTIVE      = 0;
   const STATUS_ACTIVE        = 1;
   const STATUS_ACTIVE_MAX    = self::STATUS_ACTIVE;

   const STATUS_HIDDEN        = 0;
   const STATUS_VISIBLE       = 1;
   const STATUS_VISIBLE_MAX   = self::STATUS_VISIBLE;
   
   const SUBJECT_ACCT         = "ACCT";
   const SUBJECT_BA           = "BA";
   const SUBJECT_ECON         = "ECON";
   const SUBJECT_FIR          = "FIR";
   const SUBJECT_MGMT         = "MGMT";
   const SUBJECT_MIS          = "MIS";
   const SUBJECT_MKTG         = "MKTG";
   const SUBJECT_SCMS         = "SCMS";

   /** 
    * Permission types
    **/   
   const TYPE_ROLE            = 1;
   const TYPE_PERMISSION      = 2;   

   /** 
    * SystemCodes types
    **/   
   const TYPE_PERMIT          = 1;
   const TYPE_DEPARTMENT      = 2;
   const TYPE_CAREERLEVEL     = 3;
   const TYPE_MASTERS         = 4;

   const TYPE_MAX          = BaseModel::TYPE_MASTERS;      
   
   const SCENARIO_INSERT   = 'insert';
   const SCENARIO_UPDATE   = 'update';   


   public function init()
   {
      parent::init();
   }


   public static function debug( $msgObj, $willDie = true )
   {
      print( "<pre> ++ BaseModel ++" . PHP_EOL );
      var_dump( $msgObj );
      
      if( $willDie )
         die();
   }

}
