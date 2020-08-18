<?php

namespace app\migrations;


/**
 * Class m200625_162031_tbl_Users
 *
 * NOTE: Run this command to initate the AuthManager tables
 *   yii migrate --migrationPath=@yii/rbac/migrations/
 */
class m200625_162031_tbl_Users extends BaseMigration
{

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
      
      if ($this->_db->getTableSchema(self::getTblTempAuthAssignmentName(), true) === null) 
      {
         $this->createTable( self::getTblTempAuthAssignmentName(), [
            'id'              => $this->primaryKey(),      
            'item_name'       => $this->string(64)->notNull(),
            'temp_item_name'  => $this->string(64)->notNull(),         
            'user_id'         => $this->string(64)->notNull(),
            'created_at'      => $this->integer()->notNull(),
            'deleted_at'      => $this->integer(),                 
         ], $tableOptions);
         
         $this->createIndex('idx_TempAuthAssignment_user_id', self::getTblTempAuthAssignmentName(), 'user_id');
      }         

      if ($this->_db->getTableSchema(self::getTblUserName(), true) === null) 
      {
         $this->createTable(self::getTblUserName(), [
            'id'           => $this->primaryKey(),
            'uuid'         => $this->string(16)->notNull(),
//            'name'         => $this->string(48)->notNull(),  // Moving this information into its own model
            'is_active'    => $this->integer()->notNull(),
            'auth_key'     => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->notNull(),
            
            'created_at'   => $this->datetime()->notNull(),
            'updated_at'   => $this->datetime(),
         ], $tableOptions);
      }
      
      $columns = [ 'uuid', 'is_active', 'auth_key', 'access_token', 'created_at'];

      $rows = [
         [  
            'ugadstdt',
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'gradstdt',
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'ugadadvr',
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'ugadadmn',
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'gradadvr',
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'gradadmn', 
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'adminusr', 
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],
         [ 
            'gridview_01', 
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],    
         [ 
            'gridview_02', 
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],    
         [ 
            'gridview_03', 
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ], 
         [ 
            'gridview_04', 
            self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48), 
            \Yii::$app->security->generateRandomString(32), 
            $created_at,
         ],                                           
      ];
      
      $this->batchInsert( self::getTblUserName(), $columns, $rows );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_162031_tbl_user cannot be reverted.\n";

        $this->forceDropTable( self::getTblTempAuthAssignmentName()  );
        $this->forceDropTable( self::getTblUserName()                );

//        return false;
    }
}
