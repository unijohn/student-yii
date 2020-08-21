<?php

namespace app\migrations;

/**
 * Class M200818200112TblUsersPersonal
 */
class m200818_200112_tbl_UsersPersonal extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $created_at = $this->_time;
   
        if ($this->_db->getTableSchema(self::getTblUserPersonalName(), true) === null) {
            $this->createTable(
                self::getTblUserPersonalName(),
                [
               'uuid'            => $this->string(16)->notNull(),
               'uNbr'            => $this->string(10)->notNull(),  // e.g. U12345678
               'firstNm'         => $this->string(64)->notNull(),
               'middleNm'        => $this->string(64),
               'lastNm'          => $this->string(64)->notNull(),
               'salutation'      => $this->string(16),
               'us_citizen'      => $this->integer()->notNull(),
               'citizen_other'   => $this->string(4),
               'visa_type'       => $this->integer()->notNull(),
               
               'created_at'   => $this->datetime()->notNull(),
               'updated_at'   => $this->datetime(),
               'deleted_at'   => $this->datetime(),
               'PRIMARY KEY ( [[uuid]] )',
            ],
                $this->_tableOptions
            );
         
            $this->createIndex('idx_UsersPersonal_uuid', self::getTblUserPersonalName(), 'uuid');
            $this->createIndex('idx_UsersPersonal_us_citizen', self::getTblUserPersonalName(), 'us_citizen');
        }

        $columns =
        [
            'uuid', 'uNbr', 'firstNm', 'middleNm', 'lastNm', 'salutation', 'us_citizen',
            'citizen_other', 'visa_type', 'created_at'
        ];
      
        $coursePersonal = [
         [
            'ugadstdt', 'U12345678', 'Ugad', 'I.', 'Student', 'Mr.', self::CITIZEN_US_YES,
            self::CITIZEN_OTHER_NO, self::VISA_NO, $created_at,
         ],
         [
            'gradstdt', 'U12345679', 'Grad', 'I.', 'Student', 'Mrs.', self::CITIZEN_US_YES,
            self::CITIZEN_OTHER_NO, self::VISA_NO, $created_at,
         ],
         [
            'ugadadvr', 'U00123456', 'Ugad', '', 'Advisor', 'Mrs.', self::CITIZEN_US_YES,
            self::CITIZEN_OTHER_NO, self::VISA_NO, $created_at,
         ],
         [
            'gradadvr', 'U00123457', 'Grad', '', 'Advisor', 'Mrs.', self::CITIZEN_US_YES,
            self::CITIZEN_OTHER_NO, self::VISA_NO, $created_at,
         ],
         [
            'ugadadmn', 'U00001234', 'Ugad', 'S.', 'Administrator', 'Mrs.', self::CITIZEN_US_YES,
            self::CITIZEN_OTHER_NO, self::VISA_NO, $created_at,
         ],
         [
            'gradadmn', 'U00001235', 'Grad', 'S.', 'Administrator', 'Mr.', self::CITIZEN_US_YES,
            self::CITIZEN_OTHER_NO, self::VISA_NO, $created_at,
         ],
         [
            'adminusr', 'U00000012', 'Admin', 'S.', 'User', 'Mr.', self::CITIZEN_US_YES,
            self::CITIZEN_OTHER_NO, self::VISA_NO, $created_at,
         ],
         [
            'gridview_01', 'U12000001', 'Grid01', '', 'View', 'Mr.', self::CITIZEN_US_NO,
            self::CITIZEN_OTHER_YES, self::VISA_F1, $created_at,
         ],
         [
            'gridview_02', 'U12000002', 'Grid02', '', 'View', 'Mr.', self::CITIZEN_US_NO,
            self::CITIZEN_OTHER_YES, self::VISA_F2, $created_at,
         ],
         [
            'gridview_03', 'U12000003', 'Grid03', '', 'View', 'Mr.', self::CITIZEN_US_NO,
            self::CITIZEN_OTHER_YES, self::VISA_F3, $created_at,
         ],
         [
            'gridview_04', 'U12000004', 'Grid04', '', 'View', 'Mr.', self::CITIZEN_US_NO,
            self::CITIZEN_OTHER_YES, self::VISA_F1, $created_at,
         ],
      ];
      
        $this->batchInsert(self::getTblUserPersonalName(), $columns, $coursePersonal);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "M200818200112TblUsersPersonal cannot be reverted.\n";

        $this->forceDropTable(self::getTblUserPersonalName());

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M200818200112TblUsersPersonal cannot be reverted.\n";

        return false;
    }
    */
}
