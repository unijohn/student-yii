<?php

use yii\db\Migration;

/**
 * Class m200625_162733_tbl_CareerLevel
 */
class m200625_162733_tbl_CareerLevel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_CareerLevel', [
            'id' => $this->primaryKey(),
            'code' => $this->string(4)->notNull(),
            'name' => $this->string(24)->notNull(),
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
        $columns = [ 'code', 'name', 'created_at'];
        
        $rows = [
            [ 'UG', 'Undergraduate', date("Y-m-d H:i:s") ],
            [ 'GR', 'Graduate', date("Y-m-d H:i:s") ],
            [ 'LW', 'Unknown LW', date("Y-m-d H:i:s") ],
            [ 'CE', 'Unknown CE', date("Y-m-d H:i:s") ],
         ];
         
        
        $this->batchInsert('tbl_CareerLevel', $columns, $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_162733_tbl_CareerLevel cannot be reverted.\n";

        $this->dropTable('tbl_CareerLevel');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_162733_tbl_CareerLevel cannot be reverted.\n";

        return false;
    }
    */
}
