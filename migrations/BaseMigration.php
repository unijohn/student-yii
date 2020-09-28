<?php

namespace app\migrations;

use yii;

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

class BaseMigration extends Migration
{
    const STATUS_INACTIVE       = 0;
    const STATUS_ACTIVE         = 1;
   
    const STATUS_HIDDEN         = 0;
    const STATUS_VISIBLE        = 1;
    
    const STATUS_WORKDESK_DATA  = 0;
    const STATUS_BANNER_DATA    = 1;

    const SYS_FRAMEWORKID       = 1;
    const SYS_STUDENTID         = 2;
    const SYS_FACULTYID         = 3;
    const SYS_ADMINISTRATIONID  = 4;
   
    const CL_UGADID             = 1;
    const CL_GRADID             = 2;
    const CL_PHDID              = 3;
    const CL_CERTID             = 4;

    const DEPT_ACCT             = 1;
    const DEPT_ECON             = 2;
    const DEPT_FIN              = 3;
    const DEPT_BIT              = 4;
    const DEPT_MGMT             = 5;
    const DEPT_MCSM             = 6;

    const FEATURE_PERMIT        = 1;
    const FEATURE_GAAAP         = 2;
    const FEATURE_SYLLA         = 3;
    const FEATURE_COURSEASSIGN  = 4;

    const ACTION_ACCESS         = 1;
    const ACTION_CREATE         = 2;
    const ACTION_READ           = 3;
    const ACTION_UPDATE         = 4;
    const ACTION_sDELETE        = 5;
    const ACTION_hDELETE        = 6;
    const ACTION_BACKUP         = 7;
    const ACTION_ROLE           = 8;
    const ACTION_SYNCH          = 9;
    const ACTION_MANAGE         = 10;
   
    const ROLE_ADMIN            = 1;
    const ROLE_GENERIC          = 2;
    const ROLE_UGAD_STUDENT     = 2;
    const ROLE_GRAD_STUDENT     = 3;
    const ROLE_PHD_STUDENT      = 4;
    const ROLE_UGAD_ADVISOR     = 5;
    const ROLE_GRAD_ADVISOR     = 6;
    const ROLE_PHD_ADVISOR      = 7;
   
    const TYPE_PERMIT           = 1;
    const TYPE_DEPARTMENT       = 2;
    const TYPE_CAREERLEVEL      = 3;
    const TYPE_MASTERS          = 4;
    const TYPE_FACULTY_RANK     = 5;
    const TYPE_EMPLOYEE_CLASS   = 6;
    const TYPE_SCHOOL_DEPT      = 7;
    const TYPE_UNIVERSITY_DEPT  = 8;
   
    const CITIZEN_US_NO         = 0;
    const CITIZEN_US_YES        = 1;
   
    const CITIZEN_OTHER_NO      = 0;
    const CITIZEN_OTHER_YES     = 1;
   
    const VISA_NO               = 0;
    const VISA_F1               = 1;
    const VISA_F2               = 2;
    const VISA_F3               = 3;
    
    const TYPE_PROMPT_DEFAULT   = -1;

    const TYPE_DEPARTMENT_NOT_SET   = 0;
    const TYPE_DEPARTMENT_ACCT      = 1;
    const TYPE_DEPARTMENT_BITM      = 2;
    const TYPE_DEPARTMENT_ECON      = 3;
    const TYPE_DEPARTMENT_FIR       = 4;
    const TYPE_DEPARTMENT_MSCM      = 5;
    const TYPE_DEPARTMENT_MGMT      = 6;
    
    const TYPE_CAREERLEVEL_NOT_SET  = 0;
    const TYPE_CAREERLEVEL_UGAD     = 1;
    const TYPE_CAREERLEVEL_GRAD     = 2;
    const TYPE_CAREERLEVEL_PHD      = 3;
    const TYPE_CAREERLEVEL_CERT     = 4;
    
    const TYPE_MASTERS_NOT_SET      = 0;
    const TYPE_MASTERS_MA_ECON      = 1;
    const TYPE_MASTERS_MS_ACCT      = 2;
    const TYPE_MASTERS_MS_IS        = 3;
    const TYPE_MASTERS_MSBA_FIR     = 4;
    const TYPE_MASTERS_EMBA         = 5;
    const TYPE_MASTERS_PMBA         = 6;
    const TYPE_MASTERS_OMBA         = 7;

    const TYPE_FIELD_NOT_SET    = 0;
    const TYPE_FIELD_HTML_OPTS  = 1;
    const TYPE_FIELD_SELECT     = 2;
    const TYPE_FIELD_CHECKBOX   = 3;
    const TYPE_FIELD_RADIO      = 4;
    
    const TERM_NOT_SET          = 0;
    const TERM_SPRING           = 1;
    const TERM_MAYMESTER        = 2;
    const TERM_SUMMER           = 3;
    const TERM_SESSION_ONE      = 4;
    const TERM_SESSION_TWO      = 5;
    const TERM_FALL             = 6;
    
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
    
    const SKILL_STR_NOT_SET     = 0;
    const SKILL_STR_NONE        = 1;
    const SKILL_STR_BEGIN       = 2;
    const SKILL_STR_INTERMED    = 3;
    const SKILL_STR_EXPERT      = 4;
    
    const PREF_NOT_SET          = 0;
    const PREF_ONE              = 1;
    const PREF_TWO              = 2;
    const PREF_THREE            = 3;
    const PREF_FOUR             = 4;
    const PREF_FIVE             = 5;
    const PREF_SIX              = 6;
    const PREF_SEVEN            = 7;
    const PREF_EIGHT            = 8;
    
    const DOCUMENT_NOT_SET      = 0;
    const DOCUMENT_PERS_STMT    = 1;
    const DOCUMENT_ESSAY        = 2;
    const DOCUMENT_LTR_REQ      = 3;
    
    const TYPE_ITEM_NOT_SET         = 0;
    const TYPE_ITEM_FORM_FIELD      = 1;
    const TYPE_ITEM_ACTIVE          = 2;
    const TYPE_ITEM_VISIBLE         = 3;
    const TYPE_ITEM_BANNER_DATA     = 4;
    const TYPE_ITEM_US_CITIZEN      = 5;
    const TYPE_ITEM_VISA_TYPE       = 6;
    const TYPE_ITEM_CITIZEN_OTHER   = 7;
    const TYPE_ITEM_YEAR_FOUR       = 8;
    const TYPE_ITEM_TERM            = 9;
    const TYPE_ITEM_MONTH_TWO       = 10;
    const TYPE_ITEM_SKILL_STRENGTH  = 11;
    const TYPE_ITEM_PREFERENCE_RANK = 12;
    const TYPE_ITEM_DOCUMENT        = 13;
    const TYPE_YES_NO               = 14;    
    
    const TYPE_PERMIT_OPEN_REQ      = 0;
    const TYPE_PERMIT_ISSUED        = 1;
    const TYPE_PERMIT_DUPLICATE     = 2;
    
    const TYPE_FACULTY_RANK_NOT_SET = 0;
    const TYPE_FACULTY_RANK_01      = 1;
    const TYPE_FACULTY_RANK_02      = 2;
    const TYPE_FACULTY_RANK_03      = 3;
    const TYPE_FACULTY_RANK_09      = 4;
    const TYPE_FACULTY_RANK_UA      = 5;
    
    const TYPE_EMPLOYEE_CLASS_NOT_SET   = 0;
    const TYPE_EMPLOYEE_CLASS_AE        = 1;
    const TYPE_EMPLOYEE_CLASS_AD        = 2;
    const TYPE_EMPLOYEE_CLASS_F9        = 3;
    const TYPE_EMPLOYEE_CLASS_FA        = 4;
    const TYPE_EMPLOYEE_CLASS_CL        = 5;

    const TYPE_SCHOOL_DEPT_NOT_SET          = 0;
    const TYPE_SCHOOL_DEPT_PROVOST          = 1;
    const TYPE_SCHOOL_DEPT_FCBE_ACAD_PROG   = 2;
    const TYPE_SCHOOL_DEPT_COL_FCBE         = 3;
    const TYPE_SCHOOL_DEPT_CIO_ITS          = 4;
    const TYPE_SCHOOL_DEPT_FCBE_ACAD_ADMIN  = 5;
    const TYPE_SCHOOL_DEPT_MSCM             = 6;
    const TYPE_SCHOOL_DEPT_ECON             = 7;
    const TYPE_SCHOOL_DEPT_FIR              = 8;
    const TYPE_SCHOOL_DEPT_BITM             = 9;
    const TYPE_SCHOOL_DEPT_MGMT             = 10;
    const TYPE_SCHOOL_DEPT_ACCT             = 11;
    
    const TYPE_UNIVERSITY_DEPT_NOT_SET      = 0;
    const TYPE_UNIVERSITY_DEPT_ACAD_AFFAIR  = 1;
    const TYPE_UNIVERSITY_DEPT_ITS          = 2;
    const TYPE_UNIVERSITY_DEPT_COL_FCBE     = 3;
    
    const TYPE_YES_NO_NOT_SET               = 0;
    const TYPE_YES_NO_YES                   = 1;    
    const TYPE_YES_NO_NO                    = 2;        

    const tbl_YiiNames  = [
      'auth_assignment',
      'auth_item',
      'auth_item_child',
      'auth_rule',
      'migration',
      'sqlite_sequence',
   ];
   
    const tbl_WorkDeskNames = [
      '{{tbl_Courses}}',
      '{{tbl_CoursesCodesChild}}',
      '{{tbl_SystemCodes}}',
      '{{tbl_SystemCodesChild}}',
      '{{tbl_TempAuthAssignment}}',
      '{{tbl_Users}}',
      '{{tbl_UsersPersonal}}',
      '{{tbl_FormFields}}',
   ];

    public $_auth;
    public $_db;
    public $_tableOptions;
    public $_time;


    public function init()
    {
        parent::init();
      
        $this->_auth         = $this->getAuthManager();
        $this->_db           = Yii::$app->db;
      
        $this->_tableOptions = null;
        $this->_time         = time();
      
        if ($this->isMySQL()) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->_tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }
   

    public static function getWorkDeskTableName($index = -1)
    {
        return self::tbl_WorkDeskNames[$index];
    }


    public static function getTblCoursesName()
    {
        return self::getWorkDeskTableName(0);
    }
   
   
    public static function getTblCoursesCodesChildName()
    {
        return self::getWorkDeskTableName(1);
    }
   
    public static function getTblSystemCodesName()
    {
        return self::getWorkDeskTableName(2);
    }


    public static function getTblSystemCodesChildName()
    {
        return self::getWorkDeskTableName(3);
    }


    public static function getTblTempAuthAssignmentName()
    {
        return self::getWorkDeskTableName(4);
    }


    public static function getTblUserName()
    {
        return self::getWorkDeskTableName(5);
    }


    public static function getTblUserPersonalName()
    {
        return self::getWorkDeskTableName(6);
    }
    
    
    public static function getTblFormFieldsName()
    {
        return self::getWorkDeskTableName(7);
    }


    /**
    * @throws yii\base\InvalidConfigException
    * @return DbManager
    */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
      
        return $authManager;
    }


    /**
    * @return bool
    */
    protected function forceDropTable($tableNm = '')
    {
        $wasDropped = false;
   
        if ($this->_db->getTableSchema($tableNm, true) !== null) {
            $this->dropTable($tableNm);
            $wasDropped = true;
        }
      
        return $wasDropped;
    }


    /**
    * @return bool
    */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }


    /**
    * @return bool
    */
    protected function isOracle()
    {
        return $this->db->driverName === 'oci';
    }


    /**
    * @return bool
    */
    protected function isMySQL()
    {
        return $this->db->driverName === 'mysql';
    }


    /**
    * @return bool
    */
    protected function isSQLite()
    {
        return strncmp($this->db->getDriverName(), 'sqlite', 6) === 0;
    }


    /**
    * @return string
    */
    protected function buildFkClause($delete = '', $update = '')
    {
        if ($this->isMSSQL()) {
            return '';
        }
   
        if ($this->isOracle()) {
            return ' ' . $delete;
        }
   
        return implode(' ', ['', $delete, $update]);
    }
}
