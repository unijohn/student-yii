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
                    'id'              => $this->primaryKey(),
                    'type'            => $this->integer()->notNull(),
                    'code'            => $this->string(8)->notNull(),
                    'description'     => $this->string(64),
                    'is_active'       => $this->integer()->notNull(),
                    'is_hidden'       => $this->integer()->notNull(),
                    'created_at'      => $this->integer()->notNull(),
                    'updated_at'      => $this->integer()->notNull(),
                    'deleted_at'      => $this->integer(),
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

        $codeColumns    = [ 'type', 'code', 'description', 'is_active', 'is_hidden', 'created_at' ];

        $permitRows =
        [
             [
                self::TYPE_PERMIT, 'A', 'ISSUED', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'B', 'PRIOR_ISSUED', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'C', 'DENIED_PREREQ', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'D', 'DENIED_UPPER', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'E', 'DENIED_MAX_UPPER', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'F', 'TRANSCRIPT_REQ', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'G', 'DENIED_FULL', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'H', 'DENIED_NOT_NEEDED', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'I', 'DENIED_HONORS_REQ', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'J', '', self::STATUS_INACTIVE, self::STATUS_HIDDEN,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'K', 'CODE_CHANGED', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'L', '', self::STATUS_INACTIVE, self::STATUS_HIDDEN,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'M', 'DENIED_NOT_OFFERED', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'N', 'DENIED_DEADLINE', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'P', 'REQUEST_PENDING', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'Q', 'ISSUED_ANY_SECTION', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_PERMIT, 'Z', 'PENDING', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
        ];
 
      
        $departmentRows =
        [
             [
                self::TYPE_DEPARTMENT, 'ACCT', 'Accounting', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'BITM', 'Bit_Info_Tech', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'ECON', 'Economics', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'FIR', 'Finance', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'MCSM', 'Mktg_Supply_Chain', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_DEPARTMENT, 'MGMT', 'Management', self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
      ];


        $careerLevelRows =
        [
             [
                self::TYPE_CAREERLEVEL, 'UGAD', 'Undergraduate',  self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_CAREERLEVEL, 'GRAD', 'Graduate',       self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_CAREERLEVEL, 'PHD',  'Doctorate',      self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
      ];

      
        $mastersRows =
        [
             [
                self::TYPE_MASTERS, 'MAECON',   'MA_ECON',     self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'MSACCT',   'MS_ACCT',     self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'MSIS',     'MS_IS',       self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'MSBAFIR',  'MSBA_FIR',    self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'EMBA',     'EXEC_MBA',    self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'PMBA',     'PROF_MBA',    self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
             [
                self::TYPE_MASTERS, 'OMBA',     'ONLINE_MBA',  self::STATUS_ACTIVE, self::STATUS_VISIBLE,
                $created_at,
             ],
      ];
      
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
        $codeChildColumns = [ 'parent', 'child', 'created_at' ];

        $permitChildRows =
        [
            [ 1, 24, $created_at], [ 1, 25, $created_at], [ 1, 26, $created_at],
            [17, 24, $created_at], [17, 25, $created_at], [17, 26, $created_at],
        ];
      
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $permitRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $departmentRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $careerLevelRows);
        $this->batchInsert(self::getTblSystemCodesName(), $codeColumns, $mastersRows);
      
        $this->batchInsert(self::getTblSystemCodesChildName(), $codeChildColumns, $permitChildRows);
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
