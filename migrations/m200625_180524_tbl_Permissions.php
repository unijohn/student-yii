<?php

use yii\db\Migration;

/**
 * Class m200625_180524_tbl_Permissions
 */
class m200625_180524_tbl_Permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_Permissions', [
            'id' => $this->primaryKey(),
            'bit' => $this->bigInteger()->notNull(),
            'name' => $this->string(48)->notNull(),
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
         $columns = [ 'bit', 'name', 'created_at'];
        
         $rows = [
            [ 1,  'Only',        date("Y-m-d H:i:s") ],
            [ 2,  'Insert',      date("Y-m-d H:i:s") ],
            [ 4,  'Update',      date("Y-m-d H:i:s") ],
            [ 8,  'Flag-Delete', date("Y-m-d H:i:s") ],
            [ 16, 'Full-Delete', date("Y-m-d H:i:s") ],
         ];
                
        $this->batchInsert( 'tbl_Permissions', $columns, $rows );            
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_180524_tbl_Roles cannot be reverted.\n";

        $this->dropTable('tbl_Permissions');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_180524_tbl_Roles cannot be reverted.\n";

        return false;
    }
    */
}
