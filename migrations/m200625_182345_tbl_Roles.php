<?php

use yii\db\Migration;

/**
 * Class m200625_182345_tbl_Roles
 */
class m200625_182345_tbl_Roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_Roles', [
            'id'     => $this->primaryKey(),
            'role'   => $this->bigInteger()->notNull(),
            'name'   => $this->string(16)->notNull(), 
            'descr'  => $this->string(48)->notNull(),            
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
         $columns = [ 'role', 'name', 'descr', 'created_at'];
        
         $rows = [
            [ 1,   'User',          'Insert/Read Only',            date("Y-m-d H:i:s") ],
            [ 7,   'Approval User', 'Insert/Update',               date("Y-m-d H:i:s") ],
            [ 15,  'Super User',    'Insert/Update/Flag-Delete',   date("Y-m-d H:i:s") ],
            [ 31,  'Administrator', 'Insert/Update/Full-Delete',   date("Y-m-d H:i:s") ],
            
         ];
                
        $this->batchInsert( 'tbl_Roles', $columns, $rows );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_182345_tbl_Roles cannot be reverted.\n";

        $this->dropTable('tbl_Roles');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_182345_tbl_Roles cannot be reverted.\n";

        return false;
    }
    */
}
