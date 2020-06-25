<?php

use yii\db\Migration;

/**
 * Class m200625_162752_tbl_MinorCode
 */
class m200625_162752_tbl_MinorCode extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_MinorCode', [
            'id' => $this->primaryKey(),
            'code' => $this->string(4)->notNull(),
            'name' => $this->string(48)->notNull(),
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
         $columns = [ 'code', 'name', 'created_at'];
        
         $rows = [
            [ 'SMMK', 'Unknown SMMK',     date("Y-m-d H:i:s") ],
            [ 'INBS', 'Unknown INBS',     date("Y-m-d H:i:s") ],
            [ 'ACCT', 'Accounting',       date("Y-m-d H:i:s") ],
            [ 'RLES', 'Unknown RLES',     date("Y-m-d H:i:s") ],            
            [ 'BIT',  'Bus. Info. Tech.', date("Y-m-d H:i:s") ],
            [ 'BSFN', 'Unknown BSFN',     date("Y-m-d H:i:s") ],
            [ 'ENGL', 'Unknown ENGL',     date("Y-m-d H:i:s") ],
            [ 'GERM', 'Unknown GERM',     date("Y-m-d H:i:s") ],
            [ 'MKMT', 'Marketing Mgmt.',  date("Y-m-d H:i:s") ],
            [ 'MGMT', 'Management',       date("Y-m-d H:i:s") ],
            [ 'FIN',  'Unknown HPRM',     date("Y-m-d H:i:s") ],
            [ 'ENTR', 'Unknown ENTR',     date("Y-m-d H:i:s") ],
            [ 'LTLA', 'Unknown ADV',      date("Y-m-d H:i:s") ],
            [ 'CHEM', 'Unknown CHEM',     date("Y-m-d H:i:s") ],
            [ 'MKTG', 'Marketing',        date("Y-m-d H:i:s") ],
            [ 'NPMT', 'Unknown NPMT',     date("Y-m-d H:i:s") ],            
            [ 'JAPN', 'Unknown JAPN',     date("Y-m-d H:i:s") ],
            [ 'EMGT', 'Unknown EMGT',     date("Y-m-d H:i:s") ],
            [ 'SCMG', 'Unknown SCMG',     date("Y-m-d H:i:s") ],
            [ 'BSEC', 'Unknown BSEC',     date("Y-m-d H:i:s") ],
            [ 'FREN', 'Unknown FREN',     date("Y-m-d H:i:s") ],
            [ 'AERO', 'Unknown AERO',     date("Y-m-d H:i:s") ],
         ];
                
        $this->batchInsert( 'tbl_MinorCode', $columns, $rows );        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200625_162752_tbl_MinorCode cannot be reverted.\n";

        $this->dropTable('tbl_MinorCode');

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_162752_tbl_MinorCode cannot be reverted.\n";

        return false;
    }
    */
}
