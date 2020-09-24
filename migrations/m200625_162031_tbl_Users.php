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
        $created_at = $this->_time;
      
        if ($this->_db->getTableSchema(self::getTblTempAuthAssignmentName(), true) === null) {
            $this->createTable(self::getTblTempAuthAssignmentName(), [
            'id'              => $this->primaryKey(),
            'item_name'       => $this->string(64)->notNull(),
            'temp_item_name'  => $this->string(64)->notNull(),
            'user_id'         => $this->string(64)->notNull(),
            'created_at'      => $this->integer()->notNull(),
            'deleted_at'      => $this->integer(),
         ], $this->_tableOptions);
         
            $this->createIndex('idx_TempAuthAssignment_user_id', self::getTblTempAuthAssignmentName(), 'user_id');
        }

        if ($this->_db->getTableSchema(self::getTblUserName(), true) === null) {
            $this->createTable(self::getTblUserName(), [
            'id'                    => $this->primaryKey(),
            'uuid'                  => $this->string(10)->notNull(),
            'is_active'             => $this->integer()->notNull(),
            'is_active_employee'    => $this->integer()->notNull(),
            'is_active_student'     => $this->integer()->notNull(),
            'is_test_account'       => $this->integer()->notNull(),
            'auth_key'              => $this->string(48)->notNull(),
            'access_token'          => $this->string(48)->notNull(),
            
            'created_at'            => $this->datetime()->notNull(),
            'updated_at'            => $this->datetime(),
         ], $this->_tableOptions);
        }
      
        $columns = [ 'uuid', 'is_active', 'is_active_employee', 'is_active_student', 'is_test_account', 'auth_key', 'access_token', 'created_at'];

        $rows = [
         [
            'ugadstdt',
            self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48),
            \Yii::$app->security->generateRandomString(32),
            $created_at,
         ],
         [
            'gradstdt',
            self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48),
            \Yii::$app->security->generateRandomString(32),
            $created_at,
         ],
         [
            'ugadadvr',
            self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48),
            \Yii::$app->security->generateRandomString(32),
            $created_at,
         ],
         [
            'ugadadmn',
            self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48),
            \Yii::$app->security->generateRandomString(32),
            $created_at,
         ],
         [
            'gradadvr',
            self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48),
            \Yii::$app->security->generateRandomString(32),
            $created_at,
         ],
         [
            'gradadmn',
            self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48),
            \Yii::$app->security->generateRandomString(32),
            $created_at,
         ],
         [
            'adminusr',
            self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE, self::STATUS_ACTIVE,
            \Yii::$app->security->generateRandomString(48),
            \Yii::$app->security->generateRandomString(32),
            $created_at,
         ],
      ];
      
        $this->batchInsert(self::getTblUserName(), $columns, $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_162031_tbl_user cannot be reverted.\n";

        $this->forceDropTable(self::getTblTempAuthAssignmentName());
        $this->forceDropTable(self::getTblUserName());

//        return false;
    }
}
