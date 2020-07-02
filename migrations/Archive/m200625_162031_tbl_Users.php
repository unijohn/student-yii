<?php

use yii\db\Migration;

/**
 * Class m200625_162031_tbl_Users
 */
class m200625_162031_tbl_Users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_Users', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(16)->notNull(),
            'name' => $this->string(48)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->notNull(),
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
         $columns = [ 'uuid', 'name', 'auth_key', 'access_token', 'created_at'];
        
         $rows = [
            [  
               'ugadstdt', 'Undergraduate Student',       
               \Yii::$app->security->generateRandomString(48), 
               \Yii::$app->security->generateRandomString(32), 
               date("Y-m-d H:i:s") 
            ],
            [ 
               'gradstdt', 'Graduate Student',
               \Yii::$app->security->generateRandomString(48), 
               \Yii::$app->security->generateRandomString(32), 
               date("Y-m-d H:i:s") 
            ],
            [ 
               'ugadadvr', 'Undergraduate Advisor',       
               \Yii::$app->security->generateRandomString(48), 
               \Yii::$app->security->generateRandomString(32), 
               date("Y-m-d H:i:s") 
            ],
            [ 
               'ugadadmn', 'Undergraduate Administrator', 
               \Yii::$app->security->generateRandomString(48), 
               \Yii::$app->security->generateRandomString(32), 
               date("Y-m-d H:i:s") 
            ],
            [ 
               'gradadvr', 'Graduate Advisor',            
               \Yii::$app->security->generateRandomString(48), 
               \Yii::$app->security->generateRandomString(32), 
               date("Y-m-d H:i:s") 
            ],
            [ 
               'gradadmn', 'Graduate Administrator',      
               \Yii::$app->security->generateRandomString(48), 
               \Yii::$app->security->generateRandomString(32), 
               date("Y-m-d H:i:s") 
            ],
            [ 
               'adminusr', 'Administrative User',         
               \Yii::$app->security->generateRandomString(48), 
               \Yii::$app->security->generateRandomString(32), 
               date("Y-m-d H:i:s") 
            ],      
         ];
                
        $this->batchInsert( 'tbl_Users', $columns, $rows );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_162031_tbl_user cannot be reverted.\n";

        $this->dropTable('tbl_Users');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_162031_tbl_user cannot be reverted.\n";

        return false;
    }
    */
}
