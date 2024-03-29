<?php

namespace app\migrations;

use yii;

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

class BaseMigration extends Migration
{
    const SYS_FRAMEWORKID       = 1;
    const SYS_STUDENTID         = 2;
    const SYS_FACULTYID         = 3;
    const SYS_ADMINISTRATIONID  = 4;

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
