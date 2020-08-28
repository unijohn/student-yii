<?php

namespace app\models;

use Yii;
use yii\base\model;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    const STATUS_INACTIVE      = 0;
    const STATUS_ACTIVE        = 1;
    const STATUS_ACTIVE_MIN    = self::STATUS_INACTIVE;
    const STATUS_ACTIVE_MAX    = self::STATUS_ACTIVE;

    const STATUS_HIDDEN        = 0;
    const STATUS_VISIBLE       = 1;
    const STATUS_VISIBLE_MIN   = self::STATUS_HIDDEN;
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
    const CITIZEN_US_MIN       = self::CITIZEN_US_NO;
    const CITIZEN_US_MAX       = self::CITIZEN_US_YES;
   
    const CITIZEN_OTHER_NO     = 0;
    const CITIZEN_OTHER_MIN    = 0;
    const CITIZEN_OTHER_MAX    = 4;
   
    const VISA_NO              = 0;
    const VISA_F1              = 1;
    const VISA_F2              = 2;
    const VISA_F3              = 3;
    const VISA_MIN             = self::VISA_NO;
    const VISA_MAX             = self::VISA_F3;

    const TYPE_FIELD_NOT_SET   = 0;
    const TYPE_FIELD_SELECT    = 1;
    const TYPE_FIELD_CHECKBOX  = 2;
    const TYPE_FIELD_RADIO     = 3;
    const TYPE_FIELD_MIN       = self::TYPE_FIELD_NOT_SET;
    const TYPE_FIELD_MAX       = self::TYPE_FIELD_RADIO;

    const TERM_NOT_SET          = 0;
    const TERM_SPRING           = 1;
    const TERM_MAYMESTER        = 2;
    const TERM_SUMMER           = 3;
    const TERM_SESSION_ONE      = 4;
    const TERM_SESSION_TWO      = 5;
    const TERM_FALL             = 6;
    const TERM_MIN              = self::TERM_NOT_SET;
    const TERM_MAX              = self::TERM_FALL;
    
    const MONTH_TWO_NOT_SET     = 0;
    const MONTH_TWO_JAN         = 1;
    const MONTH_TWO_FEB         = 2;
    const MONTH_TWO_MAR         = 3;
    const MONTH_TWO_APR         = 4;
    const MONTH_TWO_MAY         = 5;
    const MONTH_TWO_JUN         = 6;
    const MONTH_TWO_JUL         = 7;
    const MONTH_TWO_AUG         = 8;
    const MONTH_TWO_SEPT        = 9;
    const MONTH_TWO_OCT         = 10;
    const MONTH_TWO_NOV         = 11;
    const MONTH_TWO_DEC         = 12;
    const MONTH_TWO_MIN         = self::MONTH_TWO_NOT_SET;
    const MONTH_TWO_MAX         = self::MONTH_TWO_DEC;
    
    const SKILL_STR_NOT_SET     = 0;
    const SKILL_STR_NONE        = 1;
    const SKILL_STR_BEGIN       = 2;
    const SKILL_STR_INTERMED    = 3;
    const SKILL_STR_EXPERT      = 4;
    const SKILL_STR_MIN         = self::SKILL_STR_NOT_SET;
    const SKILL_STR_MAX         = self::SKILL_STR_EXPERT;
    
    const PREF_NOT_SET          = 0;
    const PREF_ONE              = 1;
    const PREF_TWO              = 2;
    const PREF_THREE            = 3;
    const PREF_FOUR             = 4;
    const PREF_FIVE             = 5;
    const PREF_SIX              = 6;
    const PREF_SEVEN            = 7;
    const PREF_EIGHT            = 8;
    const PREF_MIN              = self::PREF_NOT_SET;
    const PREF_MAX              = self::PREF_EIGHT;
    
    const DOCUMENT_NOT_SET      = 0;
    const DOCUMENT_PERS_STMT    = 1;
    const DOCUMENT_ESSAY        = 2;
    const DOCUMENT_LTR_REQ      = 3;
    const DOCUMENT_MIN          = self::DOCUMENT_NOT_SET;
    const DOCUMENT_MAX          = self::DOCUMENT_LTR_REQ;
    
    const TYPE_ITEM_NOT_SET         = 0;
    const TYPE_ITEM_FORM_FIELD      = 1;
    const TYPE_ITEM_ACTIVE          = 2;
    const TYPE_ITEM_VISIBLE         = 3;
    const TYPE_ITEM_US_CITIZEN      = 4;
    const TYPE_ITEM_VISA_TYPE       = 5;
    const TYPE_ITEM_CITIZEN_OTHER   = 6;
    const TYPE_ITEM_YEAR_FOUR       = 7;
    const TYPE_ITEM_TERM            = 8;
    const TYPE_ITEM_MONTH_TWO       = 9;
    const TYPE_ITEM_SKILL_STRENGTH  = 10;
    const TYPE_ITEM_PREFERENCE_RANK = 11;
    const TYPE_ITEM_DOCUMENT        = 12;
    const TYPE_ITEM_MIN             = self::TYPE_ITEM_FORM_FIELD;
    const TYPE_ITEM_MAX             = self::TYPE_ITEM_DOCUMENT;

    const SCENARIO_INSERT   = 'insert';
    const SCENARIO_UPDATE   = 'update';
    const SCENARIO_DELETE   = 'delete';
    const SCENARIO_MOVE     = 'move';


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
