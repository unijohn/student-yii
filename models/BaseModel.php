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

    const TYPE_MAX             = self::TYPE_MASTERS;
   
    const DEPT_ACCT            = 1;
    const DEPT_ECON            = 2;
    const DEPT_FIN             = 3;
    const DEPT_BIT             = 4;
    const DEPT_MGMT            = 5;
    const DEPT_MCSM            = 6;
   
    const DEPT_MAX             = self::DEPT_MCSM;
   
    const CL_UGADID            = 1;
    const CL_GRADID            = 2;
    const CL_PHDID             = 3;
   
    const CL_MAX               = self::CL_PHDID;
   
    /**
     * UsersPersonal types
     **/
    
    const CITIZEN_US_NO        = 0;
    const CITIZEN_US_YES       = 1;
   
    const CITIZEN_US_MAX       = self::CITIZEN_US_YES;
   
    const CITIZEN_OTHER_NO     = 0;
//    const CITIZEN_OTHER_YES    = 1;
   
    const CITIZEN_OTHER_MIN    = 1;
    const CITIZEN_OTHER_MAX    = 4;
   
    const VISA_NO              = 0;
    const VISA_F1              = 1;
    const VISA_F2              = 2;
    const VISA_F3              = 3;
   
    const VISA_MAX             = self::VISA_F3;
   
    const SCENARIO_INSERT   = 'insert';
    const SCENARIO_UPDATE   = 'update';


    public $_changedAttributes;

    public function init()
    {
        parent::init();
    }


    public static function debug($msgObj, $willDie = true)
    {
        print("<pre> ++ BaseModel ++" . PHP_EOL);
        var_dump($msgObj);
      
        if ($willDie) {
            die();
        }
    }


    /**
     * TBD
     *
     * @returns array[] attributes updated after save
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
   
        if (!$insert) {
            if (is_null($this->_changedAttributes) || empty($this->_changedAttributes)) {
                $this->_changedAttributes = $changedAttributes;
            }
            
            return $this->_changedAttributes;
        }
      
        return [];
    }
}
