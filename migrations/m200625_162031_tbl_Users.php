<?php

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m200625_162031_tbl_Users
 */
class m200625_162031_tbl_Users extends Migration
{
   protected function getUserTableName()
   {
      return "{{%tbl_Users}}";
   }


   protected function getTempRoleTableName()
   {
      return "{{%tbl_TempAssignmentTable}}";
   }   


   /**
   * @throws yii\base\InvalidConfigException
   * @return DbManager
   */
   protected function getAuthManager()
   {
      $authManager = Yii::$app->getAuthManager();
      if (!$authManager instanceof DbManager) 
      {
         throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
      }
      
      return $authManager;
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
        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY ([[item_name]], [[user_id]])',
            'FOREIGN KEY ([[item_name]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);
  **/


   /**
   * {@inheritdoc}
   */
   public function safeUp()
   {
      $authManager = $this->getAuthManager();

      $tableOptions = null;
      if ($this->isMySQL()) 
      {
         // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
         $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }        

      $time = time();
      
      $created_at = $time;
      
      $this->createTable($this->getTempRoleTableName(), [
         'id' => $this->primaryKey(),      
         'item_name' => $this->string(64)->notNull(),
         'temp_item_name' => $this->string(64)->notNull(),         
         'user_id' => $this->string(64)->notNull(),
         'created_at' => $this->integer()->notNull(),
         'deleted_at' => $this->integer(),                 
      ], $tableOptions);
      
      $this->createTable($this->getUserTableName(), [
         'id' => $this->primaryKey(),
         'uuid' => $this->string(16)->notNull(),
         'name' => $this->string(48)->notNull(),
         'auth_key' => $this->string(32)->notNull(),
         'access_token' => $this->string(32)->notNull(),
         
         'created_at' => $this->datetime()->notNull(),
         'updated_at' => $this->datetime(),
      ], $tableOptions);
      
      $columns = [ 'uuid', 'name', 'auth_key', 'access_token', 'created_at'];

      $rows = [
         [  
            'ugadstdt', 'Undergraduate Student',       
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'gradstdt', 'Graduate Student',
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'ugadadvr', 'Undergraduate Advisor',       
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'ugadadmn', 'Undergraduate Administrator', 
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'gradadvr', 'Graduate Advisor',            
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'gradadmn', 'Graduate Administrator',      
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'adminusr', 'Administrative User',         
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],      
      ];
      
      $this->batchInsert( $this->getUserTableName(), $columns, $rows );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_162031_tbl_user cannot be reverted.\n";

        $this->dropTable($this->getTempRoleTableName());
        $this->dropTable($this->getUserTableName());        

//        return false;
    }

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
