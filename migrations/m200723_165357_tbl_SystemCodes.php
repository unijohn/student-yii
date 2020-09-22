<?php

namespace app\migrations;

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
                self::TYPE_PERMIT, 'Permits', self::TYPE_PROMPT_DEFAULT,    'PERMIT-PROMPT',    'Select Permit Response',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'Permits', self::TYPE_PERMIT_OPEN_REQ,   'PERMIT-OPEN',      'Open Permit Request',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'Permits', self::TYPE_PERMIT_ISSUED,     'PERMIT-ISSUED',    'Closed: Issued Permit',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'Permits', self::TYPE_PERMIT_DUPLICATE, 'PERMIT-DUP-REQ',    'Closed: Duplicate Request',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                4,
                $created_at,
             ],
        ];
  
      
        $departmentRows =
        [
             [
                self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_PROMPT_DEFAULT,    'DEPT-PROMPT',    'Select Department',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_NOT_SET,  'DEPT-NA',  'Dept Not Set',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_ACCT,     'ACCT',     'Accounting',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_BITM,     'BITM',     'Bit_Info_Tech',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                4,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_ECON,     'ECON',     'Economics',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                5,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_FIR,      'FIR',      'Finance',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                6,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'Departments',   self::TYPE_DEPARTMENT_MSCM,     'MCSM',     'Mktg_Supply_Chain',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                7,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'Departments', self::TYPE_DEPARTMENT_MGMT,       'MGMT',     'Management',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                8,
                $created_at,
             ],
        ];


        $careerLevelRows =
        [
             [
                self::TYPE_CAREERLEVEL, 'Career-Levels',   self::TYPE_PROMPT_DEFAULT,       'CL-PROMPT',    'Select Department',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_CAREERLEVEL, 'Career-Levels',    self::TYPE_CAREERLEVEL_NOT_SET, 'CL-NA',        'Career Level Not Set',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_CAREERLEVEL, 'Career-Levels',    self::TYPE_CAREERLEVEL_UGAD,    'UGAD',         'Undergraduate',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_CAREERLEVEL, 'Career-Levels',    self::TYPE_CAREERLEVEL_GRAD,    'GRAD',         'Graduate',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                4,
                $created_at,
             ],
             [
                self::TYPE_CAREERLEVEL, 'Career-Levels',    self::TYPE_CAREERLEVEL_PHD,     'PHD',          'Doctorate',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                5,
                $created_at,
             ],
             [
                self::TYPE_CAREERLEVEL, 'Career-Levels',    self::TYPE_CAREERLEVEL_CERT,    'CERT',         'Certificate',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                6,
                $created_at,
             ],
        ];


        $mastersRows =
        [
             [
                self::TYPE_MASTERS, 'Masters',   self::TYPE_PROMPT_DEFAULT, 'MSTR-PROMPT',    'Select Masters',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_NOT_SET,  'MSTR-NA',  'Masters Not Set',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_MA_ECON,  'MAECON',   'MA_ECON',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_MS_ACCT,  'MSACCT',   'MS_ACCT',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                4,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_MS_IS,    'MSIS',     'MS_IS',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                5,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_MSBA_FIR, 'MSBAFIR',  'MSBA_FIR',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                6,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_EMBA, 'EMBA',         'EXEC_MBA',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                7,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_PMBA, 'PMBA',         'PROF_MBA',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                8,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'Masters', self::TYPE_MASTERS_OMBA, 'OMBA',         'ONLINE_MBA',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                9,
                $created_at,
             ],
        ];


        $facultyRankRows =
        [
             [
                self::TYPE_FACULTY_RANK, 'Faculty-Rank', self::TYPE_PROMPT_DEFAULT,         'FACRANK-PROMPT',   'Select Faculty Rank',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_FACULTY_RANK, 'Faculty-Rank', self::TYPE_FACULTY_RANK_NOT_SET,   'FACRANK-NA',       'Faculty Rank Not Set',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_FACULTY_RANK, 'Faculty-Rank', self::TYPE_FACULTY_RANK_01,        '01',               'Professor [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_FACULTY_RANK, 'Faculty-Rank', self::TYPE_FACULTY_RANK_02,        '02',               'Associate Professor [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                self::TYPE_FACULTY_RANK, 'Faculty-Rank', self::TYPE_FACULTY_RANK_03,        '03',               'Assistant Professor [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                5,
                $created_at,
             ],
             [
                self::TYPE_FACULTY_RANK, 'Faculty-Rank', self::TYPE_FACULTY_RANK_NOT_SET,   'UA',               'Unavailable [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                6,
                $created_at,
             ],
             [
                self::TYPE_FACULTY_RANK, 'Faculty-Rank', self::TYPE_FACULTY_RANK_09,        '09',               'Non-standard academic ranking [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                7,
                $created_at,
             ],
        ];


        $employeeClassRows =
        [
             [
                self::TYPE_EMPLOYEE_CLASS, 'Employee-Class', self::TYPE_PROMPT_DEFAULT,         'EMPCLASS-PROMPT',  'Select Employee Class',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_EMPLOYEE_CLASS, 'Employee-Class', self::TYPE_EMPLOYEE_CLASS_NOT_SET, 'EMPCLASS-NA',      'Employee Class Not Set',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_EMPLOYEE_CLASS, 'Employee-Class', self::TYPE_EMPLOYEE_CLASS_AE,      'AE',   'Administrative Executive [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_EMPLOYEE_CLASS, 'Employee-Class', self::TYPE_EMPLOYEE_CLASS_AD,      'AD',   'Administrative Professional [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                self::TYPE_EMPLOYEE_CLASS, 'Employee-Class', self::TYPE_EMPLOYEE_CLASS_F9,      'F9',   '9/10 Month Faculty [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                5,
                $created_at,
             ],
             [
                self::TYPE_EMPLOYEE_CLASS, 'Employee-Class', self::TYPE_EMPLOYEE_CLASS_FA,      'FA',   'Faculty 12 Month [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                6,
                $created_at,
             ],
             [
                self::TYPE_EMPLOYEE_CLASS, 'Employee-Class', self::TYPE_EMPLOYEE_CLASS_CL,      'CL',   'Clerical / Support Staff [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                7,
                $created_at,
             ],
        ];


        $schoolDeptLevelRows =
        [
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_PROMPT_DEFAULT,                'SCHDEPT-PROMPT',   'Select School Department',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School',  self::TYPE_SCHOOL_DEPT_NOT_SET,          'SCHDEPT-NA',       'School Dept Not Set',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_PROVOST,           'DEPT-PROVOST',     'Provost Office [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_FCBE_ACAD_PROG,    'DEPT-FCBEPROG',   'FCBE Academic Program [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_COL_FCBE,          'DEPT-COLFCBE',     'College of Business Economics [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                5,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_CIO_ITS,           'DEPT-CIOITS',      'CIO Information Technology Services [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                6,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_FCBE_ACAD_ADMIN,   'DEPT-FCBEADM',     'FCBE Academic Administration [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                7,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_MSCM,              'DEPT-FCBEMSCM',    'Marketing Supply Management [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                8,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_ECON,              'DEPT-FCBEECON',    'Economics [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                9,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_FIR,               'DEPT-FCBEFIR',     'Finance Insurance Real Estate [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                10,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_BITM,              'DEPT-FCBEBITM',    'Business Information and Technology [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                11,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_MGMT,              'DEPT-FCBEMGMT',    'Management [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                12,
                $created_at,
             ],
             [
                self::TYPE_SCHOOL_DEPT, 'Departments-School', self::TYPE_SCHOOL_DEPT_ACCT,              'DEPT-FCBEACCT',    'School of Accountancy [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                13,
                $created_at,
             ],
        ];


        $universityDeptLevelRows =
        [
             [
                self::TYPE_UNIVERSITY_DEPT, 'Departments-University', self::TYPE_PROMPT_DEFAULT,                'UNIDEPT-PROMPT',   'Select University Department',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                1,
                $created_at,
             ],
             [
                self::TYPE_UNIVERSITY_DEPT, 'Departments-University', self::TYPE_UNIVERSITY_DEPT_NOT_SET,       'UNIDEPT-NA',       'University Dept Not Set',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_WORKDESK_DATA,
                2,
                $created_at,
             ],
             [
                self::TYPE_UNIVERSITY_DEPT, 'Departments-University', self::TYPE_UNIVERSITY_DEPT_ACAD_AFFAIR,   'UDEPT-ACADAFF',    'Academic Affairs [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                3,
                $created_at,
             ],
             [
                self::TYPE_UNIVERSITY_DEPT, 'Departments-University', self::TYPE_UNIVERSITY_DEPT_ITS,           'UDEPT-ITS',        'Information Technology Services [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                4,
                $created_at,
             ],
             [
                self::TYPE_UNIVERSITY_DEPT, 'Departments-University', self::TYPE_UNIVERSITY_DEPT_COL_FCBE,      'UDEPT-COLFCBE',    'College of Business Economics [Banner]',
                self::STATUS_ACTIVE, self::STATUS_VISIBLE, self::STATUS_BANNER_DATA,
                5,
                $created_at,
             ],
        ];


        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $permitRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $departmentRows);
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
