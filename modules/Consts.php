<?php

namespace app\modules;

use Yii;
use yii\base\Module;

class Consts extends Module
{
    /****
     *  Scenarios
     ********/
    const SCENARIO_INSERT   = 'insert';
    const SCENARIO_UPDATE   = 'update';
    const SCENARIO_DELETE   = 'delete';
    const SCENARIO_MOVE     = 'move';

    /****
     *  FormFields Related
     ********/

    const TYPE_PROMPT_DEFAULT       = -1;

    /**
     * Centralizing FormField.type_str const values here
     **/
    const IS_ACTIVE_TYPE_STR        = 'Is-Active';
    const IS_VISIBLE_TYPE_STR       = 'Is-Visible';
    const IS_BANNER_DATA_TYPE_STR   = 'Is-Banner-Data';
    const IS_YES_NO_TYPE_STR        = 'Is-Yes-No';

    /**
     * Centralizing FormField.type const values here
     **/
    const TYPE_ITEM_NOT_SET         = 0;
    const TYPE_ITEM_FORM_FIELD      = 1;
    const TYPE_ITEM_ACTIVE          = 2;
    const TYPE_ITEM_VISIBLE         = 3;
    const TYPE_ITEM_SOURCE          = 4;
    const TYPE_ITEM_YES_NO          = 5;
    const TYPE_ITEM_US_CITIZEN      = 6;
    const TYPE_ITEM_VISA_TYPE       = 7;
    const TYPE_ITEM_CITIZEN_OTHER   = 8;
    const TYPE_ITEM_YEAR_FOUR       = 9;
    const TYPE_ITEM_TERM            = 10;
    const TYPE_ITEM_MONTH_TWO       = 11;
    const TYPE_ITEM_SKILL_STRENGTH  = 12;
    const TYPE_ITEM_PREFERENCE_RANK = 13;
    const TYPE_ITEM_DOCUMENT        = 14;

    const TYPE_ITEM_MIN             = self::TYPE_ITEM_FORM_FIELD;
    const TYPE_ITEM_MAX             = self::TYPE_ITEM_DOCUMENT;
    
    // TYPE_ITEM_FORM_FIELD     = 1
    const TYPE_FIELD_NOT_SET    = 0;
    const TYPE_FIELD_HTML_OPTS  = 1;
    const TYPE_FIELD_SELECT     = 2;
    const TYPE_FIELD_CHECKBOX   = 3;
    const TYPE_FIELD_RADIO      = 4;
    const TYPE_FIELD_MIN        = self::TYPE_FIELD_NOT_SET;
    const TYPE_FIELD_MAX        = self::TYPE_FIELD_RADIO;
     
    // TYPE_ITEM_ACTIVE                 = 2
    const TYPE_ITEM_STATUS_INACTIVE     = 0;
    const TYPE_ITEM_STATUS_ACTIVE       = 1;
    const TYPE_ITEM_STATUS_ACTIVE_MIN   = self::TYPE_ITEM_STATUS_INACTIVE;
    const TYPE_ITEM_STATUS_ACTIVE_MAX   = self::TYPE_ITEM_STATUS_ACTIVE;

    // TYPE_ITEM_VISIBLE                = 3
    const TYPE_ITEM_STATUS_HIDDEN       = 0;
    const TYPE_ITEM_STATUS_VISIBLE      = 1;
    const TYPE_ITEM_STATUS_VISIBLE_MIN  = self::TYPE_ITEM_STATUS_HIDDEN;
    const TYPE_ITEM_STATUS_VISIBLE_MAX  = self::TYPE_ITEM_STATUS_VISIBLE;
    
    // TYPE_ITEM_SOURCE                     = 4
    const TYPE_ITEM_SOURCE_UNKNOWN          = 0;
    const TYPE_ITEM_SOURCE_WORKDESK_DATA    = 1;
    const TYPE_ITEM_SOURCE_BANNER_DATA      = 2;
    const TYPE_ITEM_SOURCE_MIN              = self::TYPE_ITEM_SOURCE_UNKNOWN;
    const TYPE_ITEM_SOURCE_MAX              = self::TYPE_ITEM_SOURCE_BANNER_DATA;
    
    // TYPE_ITEM_YES_NO             = 5
    const TYPE_ITEM_YES_NO_NO       = 0;
    const TYPE_ITEM_YES_NO_YES      = 1;
    const TYPE_ITEM_YES_NO_MIN      = self::TYPE_YES_NO_NO;
    const TYPE_ITEM_YES_NO_MAX      = self::TYPE_YES_NO_YES;
    
    /**
     *  Currently used in UsersPersonal Only
     **/
    // TYPE_ITEM_US_CITIZEN             = 6
    const TYPE_ITEM_CITIZEN_US_NO       = 0;
    const TYPE_ITEM_CITIZEN_US_YES      = 1;
    const TYPE_ITEM_CITIZEN_US_MIN      = self::CITIZEN_US_NO;
    const TYPE_ITEM_CITIZEN_US_MAX      = self::CITIZEN_US_YES;

    /**
     *  Currently used in UsersPersonal Only
     **/
    // TYPE_ITEM_VISA_TYPE      = 7;
    const TYPE_ITEM_VISA_NO     = 0;
    const TYPE_ITEM_VISA_F1     = 1;
    const TYPE_ITEM_VISA_F2     = 2;
    const TYPE_ITEM_VISA_F3     = 3;
    const TYPE_ITEM_VISA_MIN    = self::VISA_NO;
    const TYPE_ITEM_VISA_MAX    = self::VISA_F3;

    // TYPE_ITEM_CITIZEN_OTHER          = 8
    // Citizen-Other is not listed here.  Long static list of all countries.
    // Currently used in UsersPersonal Only
    
    const TYPE_ITEM_CITIZEN_OTHER_NA    = 0;
    
    // TYPE_ITEM_YEAR_FOUR      = 9
    // Calendar-Year-Four is not listed here.  Long static list of years from 1930 - 2030

    // TYPE_ITEM_TERM                   = 10
    const TYPE_ITEM_TERM_NOT_SET        = 0;
    const TYPE_ITEM_TERM_SPRING         = 1;
    const TYPE_ITEM_TERM_MAYMESTER      = 2;
    const TYPE_ITEM_TERM_SUMMER         = 3;
    const TYPE_ITEM_TERM_SESSION_ONE    = 4;
    const TYPE_ITEM_TERM_SESSION_TWO    = 5;
    const TYPE_ITEM_TERM_FALL           = 6;
    const TYPE_ITEM_TERM_MIN            = self::TERM_NOT_SET;
    const TYPE_ITEM_TERM_MAX            = self::TERM_FALL;
    
    // TYPE_ITEM_MONTH_TWO              = 11
    const TYPE_ITEM_MONTH_TWO_NOT_SET   = 0;
    const TYPE_ITEM_MONTH_TWO_JAN       = 1;
    const TYPE_ITEM_MONTH_TWO_FEB       = 2;
    const TYPE_ITEM_MONTH_TWO_MAR       = 3;
    const TYPE_ITEM_MONTH_TWO_APR       = 4;
    const TYPE_ITEM_MONTH_TWO_MAY       = 5;
    const TYPE_ITEM_MONTH_TWO_JUN       = 6;
    const TYPE_ITEM_MONTH_TWO_JUL       = 7;
    const TYPE_ITEM_MONTH_TWO_AUG       = 8;
    const TYPE_ITEM_MONTH_TWO_SEPT      = 9;
    const TYPE_ITEM_MONTH_TWO_OCT       = 10;
    const TYPE_ITEM_MONTH_TWO_NOV       = 11;
    const TYPE_ITEM_MONTH_TWO_DEC       = 12;
    const TYPE_ITEM_MONTH_TWO_MIN       = self::MONTH_TWO_NOT_SET;
    const TYPE_ITEM_MONTH_TWO_MAX       = self::MONTH_TWO_DEC;
    
    // TYPE_ITEM_SKILL_STRENGTH         = 12
    const TYPE_ITEM_SKILL_STR_NOT_SET   = 0;
    const TYPE_ITEM_SKILL_STR_NONE      = 1;
    const TYPE_ITEM_SKILL_STR_BEGIN     = 2;
    const TYPE_ITEM_SKILL_STR_INTERMED  = 3;
    const TYPE_ITEM_SKILL_STR_EXPERT    = 4;
    const TYPE_ITEM_SKILL_STR_MIN       = self::SKILL_STR_NOT_SET;
    const TYPE_ITEM_SKILL_STR_MAX       = self::SKILL_STR_EXPERT;
    
    // TYPE_ITEM_PREFERENCE_RANK    = 13
    const TYPE_ITEM_PREF_NOT_SET    = 0;
    const TYPE_ITEM_PREF_ONE        = 1;
    const TYPE_ITEM_PREF_TWO        = 2;
    const TYPE_ITEM_PREF_THREE      = 3;
    const TYPE_ITEM_PREF_FOUR       = 4;
    const TYPE_ITEM_PREF_FIVE       = 5;
    const TYPE_ITEM_PREF_SIX        = 6;
    const TYPE_ITEM_PREF_SEVEN      = 7;
    const TYPE_ITEM_PREF_EIGHT      = 8;
    const TYPE_ITEM_PREF_MIN        = self::PREF_NOT_SET;
    const TYPE_ITEM_PREF_MAX        = self::PREF_EIGHT;
    
    // TYPE_ITEM_DOCUMENT               = 14
    const TYPE_ITEM_DOCUMENT_NOT_SET    = 0;
    const TYPE_ITEM_DOCUMENT_PERS_STMT  = 1;
    const TYPE_ITEM_DOCUMENT_ESSAY      = 2;
    const TYPE_ITEM_DOCUMENT_LTR_REQ    = 3;
    const TYPE_ITEM_DOCUMENT_MIN        = self::DOCUMENT_NOT_SET;
    const TYPE_ITEM_DOCUMENT_MAX        = self::DOCUMENT_LTR_REQ;
    
    
    /****
     *  SystemCodes Related
     ********/
    const CODE_ITEM_NOT_SET         = 0;
    const CODE_ITEM_PERMITS         = 1;
    const CODE_ITEM_CAREERLEVELS    = 2;
    const CODE_ITEM_MASTERS         = 3;
    const CODE_ITEM_FACULTYRANK     = 4;
    const CODE_ITEM_EMPLOYEECLASS   = 5;
    const CODE_ITEM_DEPT_SCHOOL     = 6;
    const CODE_ITEM_DEPT_UNIVERSITY = 7;

    const CODE_ITEM_MIN             = self::CODE_ITEM_NOT_SET;
    const CODE_ITEM_MAX             = self::CODE_ITEM_DEPT_UNIVERSITY;
    
    // CODE_ITEM_PERMITS                = 1
    const CODE_ITEM_PERMIT_NOT_SET      = 0;
    const CODE_ITEM_PERMIT_OPEN_REQ     = 1;
    const CODE_ITEM_PERMIT_ISSUED       = 2;
    const CODE_ITEM_PERMIT_DUPLICATE    = 3;
    
    // CODE_ITEM_CAREERLEVELS           = 2
    const CODE_ITEM_CAREERLEVEL_NOT_SET = 0;
    const CODE_ITEM_CAREERLEVEL_UGAD    = 1;
    const CODE_ITEM_CAREERLEVEL_GRAD    = 2;
    const CODE_ITEM_CAREERLEVEL_PHD     = 3;
    
    // CODE_ITEM_MASTERS                = 3
    const CODE_ITEM_MASTERS_NOT_SET     = 0;
    const CODE_ITEM_MASTERS_MA_ECON     = 1;
    const CODE_ITEM_MASTERS_MS_ACCT     = 2;
    const CODE_ITEM_MASTERS_MS_IS       = 3;
    const CODE_ITEM_MASTERS_MSBA_FIR    = 4;
    const CODE_ITEM_MASTERS_EMBA        = 5;
    const CODE_ITEM_MASTERS_PMBA        = 6;
    const CODE_ITEM_MASTERS_OMBA        = 7;
    
    // CODE_ITEM_FACULTYRANK                = 4
    const CODE_ITEM_FACULTY_RANK_NOT_SET    = 0;
    const CODE_ITEM_FACULTY_RANK_01         = 1;
    const CODE_ITEM_FACULTY_RANK_02         = 2;
    const CODE_ITEM_FACULTY_RANK_03         = 3;
    const CODE_ITEM_FACULTY_RANK_09         = 4;
    const CODE_ITEM_FACULTY_RANK_UA         = 5;
    
    // CODE_ITEM_EMPLOYEECLASS              = 5
    const CODE_ITEM_EMPLOYEE_CLASS_NOT_SET  = 0;
    const CODE_ITEM_EMPLOYEE_CLASS_AE       = 1;
    const CODE_ITEM_EMPLOYEE_CLASS_AD       = 2;
    const CODE_ITEM_EMPLOYEE_CLASS_F9       = 3;
    const CODE_ITEM_EMPLOYEE_CLASS_FA       = 4;
    const CODE_ITEM_EMPLOYEE_CLASS_CL       = 5;
    
    // CODE_ITEM_DEPT_SCHOOL                    = 6
    const CODE_ITEM_DEPT_SCHOOL_NOT_SET         = 0;
    const CODE_ITEM_DEPT_SCHOOL_PROVOST         = 1;
    const CODE_ITEM_DEPT_SCHOOL_FCBE_ACAD_PROG  = 2;
    const CODE_ITEM_DEPT_SCHOOL_COL_FCBE        = 3;
    const CODE_ITEM_DEPT_SCHOOL_CIO_ITS         = 4;
    const CODE_ITEM_DEPT_SCHOOL_FCBE_ACAD_ADMIN = 5;
    const CODE_ITEM_DEPT_SCHOOL_MSCM            = 6;
    const CODE_ITEM_DEPT_SCHOOL_ECON            = 7;
    const CODE_ITEM_DEPT_SCHOOL_FIR             = 8;
    const CODE_ITEM_DEPT_SCHOOL_BITM            = 9;
    const CODE_ITEM_DEPT_SCHOOL_MGMT            = 10;
    const CODE_ITEM_DEPT_SCHOOL_ACCT            = 11;
    
    // CODE_ITEM_DEPT_UNIVERSITY                = 7
    const CODE_ITEM_DEPT_UNIVERSITY_NOT_SET     = 0;
    const CODE_ITEM_DEPT_UNIVERSITY_ACAD_AFFAIR = 1;
    const CODE_ITEM_DEPT_UNIVERSITY_ITS         = 2;
    const CODE_ITEM_DEPT_UNIVERSITY_COL_FCBE    = 3;
}
