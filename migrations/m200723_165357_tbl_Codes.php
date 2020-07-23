<?php

use yii\db\Migration;

/**
 * Class m200723_165357_tbl_PermitCodes
 */
class m200723_165357_tbl_Codes extends Migration
{
   protected function getTableName()
   {
      return "{{%tbl_Codes}}";
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
   * {@inheritdoc}
   */
   public function safeUp()
   {
      $TYPE_PERMIT      = 1;  
      
      $STATUS_INACTIVE  = 0;
      $STATUS_ACTIVE    = 1;    
   
      $tableOptions = null;
      if ($this->isMySQL()) 
      {
         // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
         $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }          

      $time = time();
      $created_at = $time;
      $updated_at = $time;      

      $this->createTable($this->getTableName(), [
         'id'              => $this->primaryKey(),      
         'type'            => $this->integer()->notNull(),
         'code'            => $this->string(8)->notNull(),
         'description'     => $this->string(64),         
         'is_active'       => $this->integer()->notNull(),
         'created_at'      => $this->integer()->notNull(),
         'updated_at'      => $this->integer()->notNull(),         
         'deleted_at'      => $this->integer(),                 
      ], $tableOptions);

      $columns = [ 'type', 'code', 'description', 'is_active', 'created_at', 'updated_at' ];

      $permitRows = [
         [  
            $TYPE_PERMIT, 'A', 'ISSUED', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'B', 'PRIOR_ISSUED', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'C', 'DENIED_PREREQ', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'D', 'DENIED_UPPER', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],       
         [  
            $TYPE_PERMIT, 'E', 'DENIED_MAX_UPPER', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'F', 'TRANSCRIPT_REQ', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'G', 'DENIED_FULL', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'H', 'DENIED_NOT_NEEDED', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'I', 'DENIED_HONORS_REQ', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'J', '', $STATUS_INACTIVE,
            $created_at, $updated_at,
         ], 
         [  
            $TYPE_PERMIT, 'K', 'CODE_CHANGED', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'L', '', $STATUS_INACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'M', 'DENIED_NOT_OFFERED', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'N', 'DENIED_DEADLINE', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'P', 'REQUEST_PENDING', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'Q', 'ISSUED_ANY_SECTION', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
         [  
            $TYPE_PERMIT, 'Z', 'PENDING', $STATUS_ACTIVE,
            $created_at, $updated_at,
         ],
      ];
      
      $this->batchInsert( $this->getTableName(), $columns, $permitRows );            
   }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200723_165357_tbl_PermitCodes cannot be reverted.\n";

        $this->dropTable($this->getTableName());

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
