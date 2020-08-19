<?php

use yii\db\Migration;

/**
 * Class m200625_182101_tbl_Systems
 */
class m200625_182101_tbl_Systems extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_Systems', [
            'id' => $this->primaryKey(),
            'code' => $this->string(4)->notNull(),
            'name' => $this->string(24)->notNull(),
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
        $columns = [ 'code', 'name', 'created_at'];
        
        $rows = [
            [ 'PRMT',  'Permits System',  date("Y-m-d H:i:s") ],
         ];
                
        $this->batchInsert('tbl_Systems', $columns, $rows);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_182101_tbl_Systems cannot be reverted.\n";

        $this->dropTable('tbl_Systems');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_182101_tbl_Systems cannot be reverted.\n";

        return false;
    }
    */
}
