<?php

use yii\db\Migration;

/**
 * Class m200625_162742_tbl_MajorCode
 */
class m200625_162742_tbl_MajorCode extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_MajorCode', [
            'id' => $this->primaryKey(),
            'code' => $this->string(4)->notNull(),
            'name' => $this->string(48)->notNull(),
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
        $columns = [ 'code', 'name', 'created_at'];
        
        $rows = [
            [ 'MGMT', 'Management',          date("Y-m-d H:i:s") ],
            [ 'MKMT', 'Marketing',           date("Y-m-d H:i:s") ],
            [ 'ACCT', 'Accounting',          date("Y-m-d H:i:s") ],
            [ 'BIT',  'Bus. Info. Tech.',    date("Y-m-d H:i:s") ],
            [ 'INSY', 'Info. Sys.',          date("Y-m-d H:i:s") ],
            [ 'PSYC', 'Unknown PSYC',        date("Y-m-d H:i:s") ],
            [ 'SCMG', 'Supply Chain',        date("Y-m-d H:i:s") ],
            [ 'FIN',  'Finance, Ins., R.E.', date("Y-m-d H:i:s") ],
            [ 'BSEC', 'Unknown BSEC',        date("Y-m-d H:i:s") ],
            [ 'PNST', 'Unknown PNST',        date("Y-m-d H:i:s") ],
            [ 'HPRM', 'Unknown HPRM',        date("Y-m-d H:i:s") ],
            [ 'IMBA', 'Int. MBA',            date("Y-m-d H:i:s") ],
            [ 'ADV',  'Unknown ADV',         date("Y-m-d H:i:s") ],
            [ 'MIS',  'Manage. Info. Sys.',  date("Y-m-d H:i:s") ],
            [ 'YABS', 'Unknown YABS',        date("Y-m-d H:i:s") ],
            [ 'BINF', 'Unknown BINF',        date("Y-m-d H:i:s") ],
            [ 'ENGL', 'Unknown ENGL',        date("Y-m-d H:i:s") ],
            [ 'NURS', 'Unknown NURS',        date("Y-m-d H:i:s") ],
            [ 'COMP', 'Unknown COMP',        date("Y-m-d H:i:s") ],
         ];
                
        $this->batchInsert('tbl_MajorCode', $columns, $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_162742_tbl_MajorCode cannot be reverted.\n";

        $this->dropTable('tbl_MajorCode');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_162742_tbl_MajorCode cannot be reverted.\n";

        return false;
    }
    */
}
