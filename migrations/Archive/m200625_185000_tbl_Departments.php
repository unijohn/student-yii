<?php

use yii\db\Migration;

/**
 * Class m200625_185000_tbl_Departments
 */
class m200625_185000_tbl_Departments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_Departments', [
            'id'     => $this->primaryKey(),
            'code' => $this->string(4)->notNull(),
            'name' => $this->string(48)->notNull(),         
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
         $columns = [ 'code', 'name', 'created_at'];
        
         $rows = [
            [ 'ACCT',   'Accounting',           date("Y-m-d H:i:s") ],
            [ 'MKTG',   'Marketing',            date("Y-m-d H:i:s") ],
            [ 'MGMT',   'Management',           date("Y-m-d H:i:s") ],
            [ 'FIR',    'Finance',              date("Y-m-d H:i:s") ],
            [ 'BITM',   'Business Info. Tech.', date("Y-m-d H:i:s") ],
            [ 'ECON',   'Economics',            date("Y-m-d H:i:s") ],
                        
         ];
                
        $this->batchInsert( 'tbl_Departments', $columns, $rows );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_195946_tbl_Departments cannot be reverted.\n";

        $this->dropTable('tbl_Departments');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_195946_tbl_Departments cannot be reverted.\n";

        return false;
    }
    */
}
