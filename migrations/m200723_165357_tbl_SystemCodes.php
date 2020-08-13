<?php

use yii\db\Migration;

/**
 * Class m200723_165357_tbl_PermitCodes
 */
class m200723_165357_tbl_SystemCodes extends Migration
{
   protected function getTableName()
   {
      return "{{%tbl_SystemCodes}}";
   }
   
   
   protected function getCodesChildTableName()
   {
      return "{{%tbl_SystemCodesChild}}";
   }   


/**
 *    To Do List (for my scattered mine)
 *    . Feature Management Logic
 *    . SystemsCodeChild Many-to-Many method(s)
 *    . Add/Remove Tags for System Codes
 *    . Permit Codes Gridview
 *    . Permit Codes Gridview - Search
 *    . Site-wide Role / Permission Logic with [Manage] permission
 **/
 

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
      if ($this->isMSSQL()) 
      {
         return '';
      }
      
      if ($this->isOracle()) 
      {
         return ' ' . $delete;
      }
      
      return implode(' ', ['', $delete, $update]);
   }


   /**
   * {@inheritdoc}
   */
   public function safeUp()
   {
      $TYPE_PERMIT      = 1;
      $TYPE_DEPARTMENT  = 2;
      $TYPE_CAREERLEVEL = 3;
      $TYPE_MASTERS     = 4;

      $STATUS_INACTIVE  = 0;
      $STATUS_ACTIVE    = 1;
      
      $STATUS_HIDDEN    = 0;
      $STATUS_VISIBLE   = 1;  

      $tableOptions     = null;

      if ($this->isMySQL()) 
      {
         // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
         $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }          

      $time       = time();
      $created_at = $time;
      $updated_at = $time;      

      $this->createTable($this->getTableName(), [
         'id'              => $this->primaryKey(),      
         'type'            => $this->integer()->notNull(),
         'code'            => $this->string(8)->notNull(),
         'description'     => $this->string(64),         
         'is_active'       => $this->integer()->notNull(),
         'is_hidden'       => $this->integer()->notNull(),         
         'created_at'      => $this->integer()->notNull(),
         'updated_at'      => $this->integer()->notNull(),         
         'deleted_at'      => $this->integer(),
      ], $tableOptions);

      $this->createTable($this->getCodesChildTableName(), [
         'parent'          => $this->integer()->notNull(),
         'child'           => $this->integer()->notNull(),
         'created_at'      => $this->integer()->notNull(),
         'PRIMARY KEY ([[parent]], [[child]])',
         'FOREIGN KEY ([[parent]]) REFERENCES ' . $this->getTableName() . ' ([[id]])' .
         $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
         'FOREIGN KEY ([[child]]) REFERENCES ' . $this->getTableName()  . ' ([[id]])' .
         $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
      ], $tableOptions);
      
      $this->createIndex('idx_SystemCodes_type', $this->getTableName(), 'type');
      $this->createIndex('idx_SystemCodes_code', $this->getTableName(), 'code');      

      $codeColumns      = [ 'type', 'code', 'description', 'is_active', 'is_hidden', 'created_at', 'updated_at' ];

      $permitRows = [
         [  
            $TYPE_PERMIT, 'A', 'ISSUED', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'B', 'PRIOR_ISSUED', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'C', 'DENIED_PREREQ', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'D', 'DENIED_UPPER', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],       
         [  
            $TYPE_PERMIT, 'E', 'DENIED_MAX_UPPER', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'F', 'TRANSCRIPT_REQ', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'G', 'DENIED_FULL', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'H', 'DENIED_NOT_NEEDED', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'I', 'DENIED_HONORS_REQ', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'J', '', $STATUS_INACTIVE, $STATUS_HIDDEN,
            $created_at, $updated_at,
         ], 
         [  
            $TYPE_PERMIT, 'K', 'CODE_CHANGED', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'L', '', $STATUS_INACTIVE, $STATUS_HIDDEN,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'M', 'DENIED_NOT_OFFERED', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'N', 'DENIED_DEADLINE', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'P', 'REQUEST_PENDING', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'Q', 'ISSUED_ANY_SECTION', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'Z', 'PENDING', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
      ];
 
      
      $departmentRows = [
         [  
            $TYPE_DEPARTMENT, 'ACCT', 'Accounting', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_DEPARTMENT, 'BITM', 'Bit_Info_Tech', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_DEPARTMENT, 'ECON', 'Economics', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_DEPARTMENT, 'FIR', 'Finance', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_DEPARTMENT, 'MCSM', 'Mktg_Supply_Chain', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_DEPARTMENT, 'MGMT', 'Management', $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
      ];


      $careerLevelRows = [
         [  
            $TYPE_CAREERLEVEL, 'UGAD', 'Undergraduate',  $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_CAREERLEVEL, 'GRAD', 'Graduate',       $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_CAREERLEVEL, 'PHD',  'Doctorate',      $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
      ];

      
      $mastersRows = [
         [  
            $TYPE_MASTERS, 'MAECON',   'MA_ECON',     $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_MASTERS, 'MSACCT',   'MS_ACCT',     $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_MASTERS, 'MSIS',     'MS_IS',       $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_MASTERS, 'MSBAFIR',  'MSBA_FIR',    $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_MASTERS, 'EMBA',     'EXEC_MBA',    $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_MASTERS, 'PMBA',     'PROF_MBA',    $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_MASTERS, 'OMBA',     'ONLINE_MBA',  $STATUS_ACTIVE, $STATUS_VISIBLE,
            $created_at, $updated_at,
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

      $permitChildRows = [      
         [ 1, 24, $created_at], [ 1, 25, $created_at], [ 1, 26, $created_at],
         [17, 24, $created_at], [17, 25, $created_at], [17, 26, $created_at],
      ];
      
      $this->batchInsert( $this->getTableName(), $codeColumns, $permitRows      );
      $this->batchInsert( $this->getTableName(), $codeColumns, $departmentRows  );
      $this->batchInsert( $this->getTableName(), $codeColumns, $careerLevelRows );
      $this->batchInsert( $this->getTableName(), $codeColumns, $mastersRows     );
      
      $this->batchInsert( $this->getCodesChildTableName(), $codeChildColumns, $permitChildRows     );      
   }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200723_165357_tbl_PermitCodes cannot be reverted.\n";

      if (Yii::$app->db->getTableSchema($this->getTableName(), true) !== null) 
      {
         $this->dropTable($this->getTableName());
      }

      if (Yii::$app->db->getTableSchema($this->getCodesChildTableName(), true) !== null) 
      {
         $this->dropTable($this->getCodesChildTableName());
      }  

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
