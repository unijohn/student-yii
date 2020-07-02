<?php

use yii\db\Migration;

/**
 * Class m200625_165659_tbl_PermitCodes
 */
class m200625_165659_tbl_PermitCodes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('tbl_PermitCodes', [
            'id'         => $this->primaryKey(),
            'code'       => $this->string(4)->notNull(),
            'msgShort'   => $this->string(64)->notNull(),
            'msgLong'    => $this->string(512)->notNull(),
            
            'isActive'   => $this->smallInteger()->notNull(),
            
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
        
         $columns = [ 'code', 'msgShort', 'msgLong', 'isActive', 'created_at'];
        
         $rows = [
            [  'A',   'Issued',      
               'Permit has been issued. You can register for this class and section.', 1, date("Y-m-d H:i:s") 
            ],
            [  'B',   'Duplicate',   
               'You are currently enrolled in this course or have received a permit for another section of this course.', 1, date("Y-m-d H:i:s") 
            ],
            [  'C',   'Denied: Prerequisite Requirement',    
               'Request denied. You have not completed the required prerequisites for this course.', 1, date("Y-m-d H:i:s") ],
            [  'D',   'Denied: Upper Division Limitation',   
               'Request denied. You have not been approved for upper division business courses.', 1, date("Y-m-d H:i:s") 
            ],
            [  'E',   'Denied: Maximum Number of Upper Division Courses',   
               'Request denied. You have reached the maximum number of upper division courses for which you have been approved.', 1, date("Y-m-d H:i:s") 
            ],
            [  'F',   'Pending: Transcript Required',
               'We do not have access to your transcript and cannot verify the necessary prerequisites. Please fax a copy of your transcript to: 901.678.0447.', 1, date("Y-m-d H:i:s")
            ],
            [  'G',   'Denied: Section Full',
               'Request denied because the section is full.  You may request permission into a full section by completing the Multipurpose form and obtaining all required approval signatures.', 1, date("Y-m-d H:i:s") 
            ],
            [  'H',   'Permit Not Needed',
               'A permit is not needed to register for this course.', 1, date("Y-m-d H:i:s") 
            ],
            [  'I',   'Denied: Limited to Honors',
               'You have requested a permit for an honors section for which you are not eligible.', 1, date("Y-m-d H:i:s") 
            ],
            [  'J',   'TBR-1',
               '( To Be Reviewed:  is it still needed? )', 1, date("Y-m-d H:i:s") 
            ],
            [  'K',   'TBR-2',
               'You should not need permits for any classes with the exception of MGMT 4710, which must be taken in your last semester before graduation.', 1, date("Y-m-d H:i:s") 
            ],
            [  'L',   'TBR-3',   
               '( To Be Reviewed:  is it still needed? )', 1, date("Y-m-d H:i:s") 
            ],
            [  'M',   'Course Not Offered',
               'Your request cannot be approved because this class is not being offered this semester.', 1, date("Y-m-d H:i:s") 
            ],
            [  'N',   'Past Registration Deadline',
               'Request denied. It is past the deadline to register for this semester.', 1, date("Y-m-d H:i:s") 
            ],
            [  'P',   '',   
               'Permit has been issued. You must register for this class.', 1, date("Y-m-d H:i:s") 
            ],
            [  'Q',   'Issued',
               'Permit has been issued for this course. You will be able to register for any open section of this course. You will also be able to change sections without requesting another permit.', 1, date("Y-m-d H:i:s") 
            ],
            [  'Z',   'Pending',
               'This request is pending review.', 1, date("Y-m-d H:i:s") 
            ],
         ];
                
        $this->batchInsert( 'tbl_PermitCodes', $columns, $rows );                

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //echo "m200625_165659_tbl_PermitCodes cannot be reverted.\n";

        $this->dropTable('tbl_PermitCodes');

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200625_165659_tbl_PermitCodes cannot be reverted.\n";

        return false;
    }
    */
}