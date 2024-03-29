<?php

namespace app\migrations;

use app\modules\Consts;

/**
 * Class m200723_165357_tbl_PermitCodes
 */
class m200723_165357_tbl_SystemCodes extends BaseMigration
{

/**
 *    To Do List (for my scattered mine)
 *    . Feature Management Logic
 *    x SystemsCodeChild Many-to-Many method(s)
 *    x Add/Remove Tags for System Codes
 *    x Permit Codes Gridview
 *    x Permit Codes Gridview - Search
 *    . Site-wide Role / Permission Logic with [Manage] permission
 **/


    /**
    * {@inheritdoc}
    */
    public function safeUp()
    {
        $created_at = $this->_time;
        $updated_at = $this->_time;

        if ($this->_db->getTableSchema(self::getTblSystemCodesName(), true) === null) {
            $this->createTable(
                self::getTblSystemCodesName(),
                [
                    'id'                => $this->primaryKey(),
                    'type'              => $this->integer()->notNull(),
                    'type_str'          => $this->string(64)->notNull(),
                    'code'              => $this->integer()->notNull(),
                    'code_str'          => $this->string(64),
                    'description'       => $this->string(64)->notNull(),

                    'is_active'         => $this->integer()->notNull(),
                    'is_visible'        => $this->integer()->notNull(),
                    'is_banner_data'    => $this->integer()->notNull(),

                    'order_by'          => $this->integer()->notNull(),

                    'created_at'        => $this->integer()->notNull(),
                    'updated_at'        => $this->integer(),
                    'deleted_at'        => $this->integer(),
                ],
                $this->_tableOptions
            );
         
            $this->createIndex('idx_SystemCodes_type', self::getTblSystemCodesName(), 'type');
            $this->createIndex('idx_SystemCodes_code', self::getTblSystemCodesName(), 'code');
        }

        if ($this->_db->getTableSchema(self::getTblSystemCodesChildName(), true) === null) {
            $this->createTable(
                self::getTblSystemCodesChildName(),
                [
                    'parent'          => $this->integer()->notNull(),
                    'child'           => $this->integer()->notNull(),
                    'created_at'      => $this->integer()->notNull(),
                    'PRIMARY KEY ([[parent]], [[child]])',
                    'FOREIGN KEY ([[parent]]) REFERENCES ' . self::getTblSystemCodesName() . ' ([[id]])' .
                    $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
                    'FOREIGN KEY ([[child]]) REFERENCES ' . self::getTblSystemCodesName()  . ' ([[id]])' .
                    $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
                ],
                $this->_tableOptions
            );
        }

        $codeColumns    = [ 'type', 'type_str', 'code', 'code_str', 'description', 'is_active', 'is_visible', 'is_banner_data', 'order_by', 'created_at' ];

        $permitRows =
        [
             [
                Consts::CODE_ITEM_PERMITS, 'Permits', Consts::TYPE_PROMPT_DEFAULT,    'PERMIT-PROMPT',    'Select Permit Response',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_PERMITS, 'Permits', Consts::CODE_ITEM_PERMIT_OPEN_REQ,   'PERMIT-OPEN',      'Open Permit Request',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_PERMITS, 'Permits', Consts::CODE_ITEM_PERMIT_ISSUED,     'PERMIT-ISSUED',    'Closed: Issued Permit',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                3,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_PERMITS, 'Permits', Consts::CODE_ITEM_PERMIT_DUPLICATE, 'PERMIT-DUP-REQ',    'Closed: Duplicate Request',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                4,
                $created_at,
             ],
        ];
  
        /*
                $departmentRows =
                [
                     [
                        self::TYPE_DEPARTMENT, 'Departments',   Consts::TYPE_PROMPT_DEFAULT,    'DEPT-PROMPT',    'Select Department',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        1,
                        $created_at,
                     ],
                     [
                        self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_NOT_SET,  'DEPT-NA',  'Dept Not Set',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        2,
                        $created_at,
                     ],
                     [
                        self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_ACCT,     'ACCT',     'Accounting',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        3,
                        $created_at,
                     ],
                     [
                        self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_BITM,     'BITM',     'Bit_Info_Tech',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        4,
                        $created_at,
                     ],
                     [
                        self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_ECON,     'ECON',     'Economics',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        5,
                        $created_at,
                     ],
                     [
                        self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_FIR,      'FIR',      'Finance',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        6,
                        $created_at,
                     ],
                     [
                        self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_MSCM,     'MCSM',     'Mktg_Supply_Chain',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        7,
                        $created_at,
                     ],
                     [
                        self::TYPE_DEPARTMENT, 'Departments', self::TYPE_DEPARTMENT_MGMT,       'MGMT',     'Management',
                        Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                        8,
                        $created_at,
                     ],
                ];
         */

        $careerLevelRows =
        [
             [
                Consts::CODE_ITEM_CAREERLEVELS, 'Career-Levels',    Consts::TYPE_PROMPT_DEFAULT,            'CL-PROMPT',    'Select Department',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE,      Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_CAREERLEVELS, 'Career-Levels',    Consts::CODE_ITEM_CAREERLEVEL_NOT_SET,  'CL-NA',        'Career Level Not Set',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE,      Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_CAREERLEVELS, 'Career-Levels',    Consts::CODE_ITEM_CAREERLEVEL_UGAD,     'UGAD',         'Undergraduate',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE,      Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                3,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_CAREERLEVELS, 'Career-Levels',    Consts::CODE_ITEM_CAREERLEVEL_GRAD,     'GRAD',         'Graduate',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE,      Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                4,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_CAREERLEVELS, 'Career-Levels',    Consts::CODE_ITEM_CAREERLEVEL_PHD,       'PHD',         'Doctorate',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE,      Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                5,
                $created_at,
             ],
        ];


        $mastersRows =
        [
             [
                Consts::CODE_ITEM_MASTERS, 'Masters',   Consts::TYPE_PROMPT_DEFAULT,        'MSTR-PROMPT',  'Select Masters',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters',   Consts::CODE_ITEM_MASTERS_NOT_SET,  'MSTR-NA',      'Masters Not Set',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters',   Consts::CODE_ITEM_MASTERS_MA_ECON,  'MAECON',       'MA_ECON',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                3,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters',   Consts::CODE_ITEM_MASTERS_MS_ACCT,  'MSACCT',       'MS_ACCT',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                4,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters',   Consts::CODE_ITEM_MASTERS_MS_IS,    'MSIS',         'MS_IS',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                5,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters',   Consts::CODE_ITEM_MASTERS_MSBA_FIR, 'MSBAFIR',      'MSBA_FIR',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                6,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters',   Consts::CODE_ITEM_MASTERS_EMBA,     'EMBA',         'EXEC_MBA',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                7,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters', Consts::CODE_ITEM_MASTERS_PMBA,       'PMBA',         'PROF_MBA',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                8,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_MASTERS, 'Masters', Consts::CODE_ITEM_MASTERS_OMBA,       'OMBA',         'ONLINE_MBA',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                9,
                $created_at,
             ],
        ];


        $facultyRankRows =
        [
             [
                Consts::CODE_ITEM_FACULTYRANK, 'Faculty-Rank', Consts::TYPE_PROMPT_DEFAULT,             'FACRANK-PROMPT',   'Select Faculty Rank',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_FACULTYRANK, 'Faculty-Rank', Consts::CODE_ITEM_FACULTY_RANK_NOT_SET, 'FACRANK-NA',       'Faculty Rank Not Set',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_FACULTYRANK, 'Faculty-Rank', Consts::CODE_ITEM_FACULTY_RANK_01,      '01',               'Professor [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_FACULTYRANK, 'Faculty-Rank', Consts::CODE_ITEM_FACULTY_RANK_02,      '02',               'Associate Professor [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_FACULTYRANK, 'Faculty-Rank', Consts::CODE_ITEM_FACULTY_RANK_03,      '03',               'Assistant Professor [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                5,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_FACULTYRANK, 'Faculty-Rank', Consts::CODE_ITEM_FACULTY_RANK_NOT_SET, 'UA',               'Unavailable [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                6,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_FACULTYRANK, 'Faculty-Rank', Consts::CODE_ITEM_FACULTY_RANK_09,      '09',               'Non-standard academic ranking [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                7,
                $created_at,
             ],
        ];


        $employeeClassRows =
        [
             [
                Consts::CODE_ITEM_EMPLOYEECLASS, 'Employee-Class', Consts::TYPE_PROMPT_DEFAULT,             'EMPCLASS-PROMPT',  'Select Employee Class',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_EMPLOYEECLASS, 'Employee-Class', Consts::CODE_ITEM_EMPLOYEE_CLASS_NOT_SET, 'EMPCLASS-NA',     'Employee Class Not Set',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_EMPLOYEECLASS, 'Employee-Class', Consts::CODE_ITEM_EMPLOYEE_CLASS_AE,      'AE',   'Administrative Executive [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_EMPLOYEECLASS, 'Employee-Class', Consts::CODE_ITEM_EMPLOYEE_CLASS_AD,      'AD',   'Administrative Professional [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_EMPLOYEECLASS, 'Employee-Class', Consts::CODE_ITEM_EMPLOYEE_CLASS_F9,      'F9',   '9/10 Month Faculty [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                5,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_EMPLOYEECLASS, 'Employee-Class', Consts::CODE_ITEM_EMPLOYEE_CLASS_FA,      'FA',   'Faculty 12 Month [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                6,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_EMPLOYEECLASS, 'Employee-Class', Consts::CODE_ITEM_EMPLOYEE_CLASS_CL,      'CL',   'Clerical / Support Staff [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                7,
                $created_at,
             ],
        ];


        $schoolDeptLevelRows =
        [
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::TYPE_PROMPT_DEFAULT,                   'SCHDEPT-PROMPT',   'Select School Department',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School',  Consts::CODE_ITEM_DEPT_SCHOOL_NOT_SET,        'SCHDEPT-NA',       'School Dept Not Set',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_PROVOST,         'DEPT-PROVOST',     'Provost Office [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_FCBE_ACAD_PROG,  'DEPT-FCBEPROG',   'FCBE Academic Program [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_COL_FCBE,        'DEPT-COLFCBE',     'College of Business Economics [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                5,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_CIO_ITS,         'DEPT-CIOITS',      'CIO Information Technology Services [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                6,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_FCBE_ACAD_ADMIN, 'DEPT-FCBEADM',     'FCBE Academic Administration [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                7,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_MSCM,            'DEPT-FCBEMSCM',    'Marketing Supply Management [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                8,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_ECON,            'DEPT-FCBEECON',    'Economics [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                9,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_FIR,             'DEPT-FCBEFIR',     'Finance Insurance Real Estate [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                10,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_BITM,            'DEPT-FCBEBITM',    'Business Information and Technology [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                11,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_MGMT,            'DEPT-FCBEMGMT',    'Management [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                12,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_SCHOOL, 'Departments-School', Consts::CODE_ITEM_DEPT_SCHOOL_ACCT,            'DEPT-FCBEACCT',    'School of Accountancy [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                13,
                $created_at,
             ],
        ];


        $universityDeptLevelRows =
        [
             [
                Consts::CODE_ITEM_DEPT_UNIVERSITY, 'Departments-University', Consts::TYPE_PROMPT_DEFAULT,                   'UNIDEPT-PROMPT',   'Select University Department',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_UNIVERSITY, 'Departments-University', Consts::CODE_ITEM_DEPT_UNIVERSITY_NOT_SET,     'UNIDEPT-NA',       'University Dept Not Set',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_UNIVERSITY, 'Departments-University', Consts::CODE_ITEM_DEPT_UNIVERSITY_ACAD_AFFAIR, 'UDEPT-ACADAFF',    'Academic Affairs [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_UNIVERSITY, 'Departments-University', Consts::CODE_ITEM_DEPT_UNIVERSITY_ITS,         'UDEPT-ITS',        'Information Technology Services [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                Consts::CODE_ITEM_DEPT_UNIVERSITY, 'Departments-University', Consts::CODE_ITEM_DEPT_UNIVERSITY_COL_FCBE,    'UDEPT-COLFCBE',    'College of Business Economics [Banner]',
                Consts::TYPE_ITEM_STATUS_ACTIVE, Consts::TYPE_ITEM_STATUS_VISIBLE, Consts::TYPE_ITEM_SOURCE_BANNER_DATA,
                5,
                $created_at,
             ],
        ];


        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $permitRows);
//        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $departmentRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $careerLevelRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $mastersRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $facultyRankRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $employeeClassRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $schoolDeptLevelRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $universityDeptLevelRows);

        /**
         *    Sample Assignments
         *
         *    1: 1, A, ISSUED
         *    ..24: 3, UGAD, Undergraduate, $created_at
         *    ..25: 3, GRAD, Graduate,      $created_at
         *    ..26: 3, PHD,  Doctorate,     $created_at
         *
         *    17: 1, Z, PENDING
         *    ..24: 3, UGAD, Undergraduate, $created_at
         *    ..25: 3, GRAD, Graduate,      $created_at
         *    ..26: 3, PHD,  Doctorate,     $created_at
         **/
//        $codeChildColumns = [ 'parent', 'child', 'created_at' ];

//        $permitChildRows =
//        [
//            [ 1, 24, $created_at], [ 1, 25, $created_at], [ 1, 26, $created_at],
//            [17, 24, $created_at], [17, 25, $created_at], [17, 26, $created_at],
//        ];
      
//        $this->batchInsert(self::getTblSystemCodesChildName(), $codeChildColumns, $permitChildRows);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200723_165357_tbl_PermitCodes cannot be reverted.\n";

        $this->forceDropTable(self::getTblSystemCodesName());
        $this->forceDropTable(self::getTblSystemCodesChildName());

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200723_165357_tbl_PermitCodes cannot be reverted.\n";

        return false;
    }
    */
}
