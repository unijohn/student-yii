<?php

namespace tests\unit\models;

use app\models\SystemCodes;

class SystemCodesTest extends \Codeception\Test\Unit
{
    public $justRight   = "Just Right Enough";
    public $tooLong     = "Tooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo";
 
    public function testAddSystemCode()
    {
        $systemCode             = new SystemCodes();
        
        $systemCode->scenario   = SystemCodes::SCENARIO_INSERT;
        
        // Everything correct
        $systemCode->type           = SystemCodes::TYPE_PERMIT;
        $systemCode->type_str       = $this->justRight;

        $systemCode->code           = 0;
        $systemCode->code_str       = $this->justRight;
        
        $systemCode->description    = $this->justRight;
        
        $systemCode->is_active      = SystemCodes::STATUS_ACTIVE;
        $systemCode->is_visible     = SystemCodes::STATUS_VISIBLE;
        $systemCode->is_banner_data = SystemCodes::STATUS_BANNER_DATA;
        
        expect($saveResult = $systemCode->save())->equals(true);
        
        // Type is below MIN
        $systemCode->type  = SystemCodes::TYPE_MIN - 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is above MAX
        $systemCode->type  = SystemCodes::TYPE_MAX + 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is just right
        $systemCode->type  = SystemCodes::TYPE_MASTERS;
        expect($saveResult = $systemCode->save())->equals(true);
       
        // description is too long
        $systemCode->description = $this->tooLong;
        expect($saveResult       = $systemCode->save())->equals(false);

        // description is just right
        $systemCode->description = $this->justRight;
        expect($saveResult       = $systemCode->save())->equals(true);
                
        // type_str is too long
        $systemCode->type_str   = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // type_str is just right
        $systemCode->type_str   = $this->justRight;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // code_str is too long
        $systemCode->code_str   = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // code_str is just right
        $systemCode->code_str   = $this->justRight;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_active is below MIN
        $systemCode->is_active  = SystemCodes::STATUS_VISIBLE_MIN - 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is above MAX
        $systemCode->is_active  = SystemCodes::STATUS_ACTIVE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_active  = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is just right
        $systemCode->is_active  = SystemCodes::STATUS_ACTIVE;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_visible is below MIN
        $systemCode->is_visible = SystemCodes::STATUS_VISIBLE_MIN + 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_visible is above MAX
        $systemCode->is_visible = SystemCodes::STATUS_VISIBLE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_visible = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_visible is just right
        $systemCode->is_visible = SystemCodes::STATUS_HIDDEN;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_banner_data is below MIN
        $systemCode->is_banner_data = SystemCodes::STATUS_BANNER_MIN + 100;
        expect($saveResult          = $systemCode->save())->equals(false);
        
        // is_banner_data is above MAX
        $systemCode->is_banner_data = SystemCodes::STATUS_BANNER_MAX + 100;
        expect($saveResult          = $systemCode->save())->equals(false);

        // is_banner_data is wrong kind of data
        $systemCode->is_banner_data = $this->tooLong;
        expect($saveResult          = $systemCode->save())->equals(false);

        // is_banner_data is just right
        $systemCode->is_banner_data = SystemCodes::STATUS_BANNER_DATA;
        expect($saveResult          = $systemCode->save())->equals(true);
    }
    
    
    public function testUpdateSystemCode()
    {
        $systemCode = SystemCodes::find()
            ->where(['id' => 6 ])
            ->limit(1)
            ->one();
        
        $systemCode->scenario   = SystemCodes::SCENARIO_UPDATE;
        
        // Everything correct
        $systemCode->type           = SystemCodes::TYPE_PERMIT;
        $systemCode->type_str       = $this->justRight;

        $systemCode->code           = 0;
        $systemCode->code_str       = $this->justRight;
        
        $systemCode->description    = $this->justRight;
        
        $systemCode->is_active      = SystemCodes::STATUS_ACTIVE;
        $systemCode->is_visible     = SystemCodes::STATUS_VISIBLE;
        
        expect($saveResult = $systemCode->save())->equals(true);
        
        // Type is below MIN
        $systemCode->type  = SystemCodes::TYPE_MIN - 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is above MAX
        $systemCode->type  = SystemCodes::TYPE_MAX + 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is just right
        $systemCode->type  = SystemCodes::TYPE_MASTERS;
        expect($saveResult = $systemCode->save())->equals(true);
       
        // description is too long
        $systemCode->description = $this->tooLong;
        expect($saveResult       = $systemCode->save())->equals(false);

        // description is just right
        $systemCode->description = $this->justRight;
        expect($saveResult       = $systemCode->save())->equals(true);
                
        // type_str is too long
        $systemCode->type_str   = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // type_str is just right
        $systemCode->type_str   = $this->justRight;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // code_str is too long
        $systemCode->code_str   = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // code_str is just right
        $systemCode->code_str   = $this->justRight;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_active is below MIN
        $systemCode->is_active  = SystemCodes::STATUS_VISIBLE_MIN - 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is above MAX
        $systemCode->is_active  = SystemCodes::STATUS_ACTIVE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_active  = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is just right
        $systemCode->is_active  = SystemCodes::STATUS_ACTIVE;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_visible is below MIN
        $systemCode->is_visible = SystemCodes::STATUS_VISIBLE_MIN + 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_visible is above MAX
        $systemCode->is_visible = SystemCodes::STATUS_VISIBLE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_visible = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_visible is just right
        $systemCode->is_visible = SystemCodes::STATUS_HIDDEN;
        expect($saveResult      = $systemCode->save())->equals(true);
    }
    
    
    public function testFindByMethods()
    {
        /*
         * public static function findbyType( $type = -1 )
         */
    
        // $type is right
        expect(SystemCodes::findbyType(SystemCodes::TYPE_MASTERS));

        // $type is wrong kind of data
        expect(SystemCodes::findbyType($this->tooLong))->equals(false);

        /*
         * public static function findbyTypeStr( $type_str = "" )
         */
        // $type is right
        expect(SystemCodes::findbyTypeStr("Masters"));

        // $type is wrong kind of data
        expect(SystemCodes::findbyTypeStr(10101010))->equals(false);
    
        // Calling the wrapper methods
        expect(SystemCodes::findbyPermit());
        expect(SystemCodes::findbyDepartment());
        expect(SystemCodes::findbyCareerLevel());
        expect(SystemCodes::findbyMasters());
        expect(SystemCodes::findbyFacultyRank());
        expect(SystemCodes::findbyEmployeeClass());
        expect(SystemCodes::findbySchoolDept());
        expect(SystemCodes::findbyUniversityDept());
        expect(SystemCodes::findPermitTagOptions());
    }
    
    
    public function testGetDistinctTypes()
    {
        // public static function getDistinctTypes($prompt = false)
        
        expect(SystemCodes::getDistinctTypes(true));
        expect(SystemCodes::getDistinctTypes(false));
    }
 
 
    public function testMoveSystemCodes()
    {
        $row = SystemCodes::find()
            ->where(['id' => 6 ])
            ->limit(1)
            ->one();
        
        // Starting position: id: 6
        // Departments, DEPT-NA, Dept Not Set
        //
        // Start position: 2
        // Min position: 1
        // Max position: 8

        expect($row->movePrev())->equals(true);
        expect($row->movePrev())->equals(false);
        
        expect($row->getIsLast())->equals(false);
        expect($row->getIsFirst())->equals(true);

        for ($i = 1; $i <= 7; $i++) {
            expect($row->moveNext())->equals(true);
        }
        
        expect($row->moveNext())->equals(false);

        // Too far; invalid positioning
        expect($row->moveToPosition(3000))->equals(false);
        
        // Too far; invalid positioning
        expect($row->moveToPosition(-1))->equals(false);
        
        // Valid positioning
        expect($row->moveToPosition(4))->equals(true);
    }
    
    
    public function testFindPermitTags()
    {
        $systemCode             = new SystemCodes();    
    
        // If permits are tagged, this test will fail
        $this->assertFalse( SystemCodes::findAllPermitTags(), "If permits are tagged, this test will fail");
        
        $row = SystemCodes::find()
            ->where([ 'id' => 6 ])
            ->limit(1)
            ->one();
        
        /*
         * public static function findPermitTagsById($id = -1)
         */
        // $id is wrong kind of data    
        $this->assertFalse( SystemCodes::findPermitTagsById("Masters"), "Should Fail:  'Masters' != [numeric] id");

        // $id is wrong value
        expect(SystemCodes::findPermitTagsById(-1))->equals(false);
        expect(SystemCodes::findPermitTagsById(10000000))->equals(false);        

        // $id is valid
        expect( SystemCodes::findPermitTagsById(4) );
        
        /*
         * public static function findAllTagsById($id = -1)
         */
        // $id is wrong kind of data    
        $this->assertFalse( SystemCodes::findAllTagsById("Masters"), "Should Fail:  'Masters' != [numeric] id");

        // $id is wrong value
        expect(SystemCodes::findAllTagsById(-1))->equals(false);
        expect(SystemCodes::findAllTagsById(10000000))->equals(false);        

        // $id is valid
        expect( SystemCodes::findAllTagsById(4) );        
    }
    
/*    
    public function testExistsSystemCode()
    {
        *
         *  public static function existsSystemCode($type = -1, $code = "")
         *
    
        // $type is right
        expect(SystemCodes::findbyType(SystemCodes::TYPE_MASTERS));

        // $type is wrong kind of data
        expect(SystemCodes::findbyType($this->tooLong))->equals(false);

        *
         * public static function findbyTypeStr( $type_str = "" )
         *
        // $type is right
        expect(SystemCodes::findbyTypeStr("Masters"));

        // $type is wrong kind of data
        expect(SystemCodes::findbyTypeStr(10101010))->equals(false);
    
        // Calling the wrapper methods
        expect(SystemCodes::findbyPermit());
        expect(SystemCodes::findbyDepartment());
        expect(SystemCodes::findbyCareerLevel());
        expect(SystemCodes::findbyMasters());
        expect(SystemCodes::findbyFacultyRank());
        expect(SystemCodes::findbyEmployeeClass());
        expect(SystemCodes::findbySchoolDept());
        expect(SystemCodes::findbyUniversityDept());
        expect(SystemCodes::findPermitTagOptions());
    } 
 */       

    /*
        public function testExistsSystemCode()
        {
            $permitType    = SystemCodes::TYPE_PERMIT;
            $deptType      = SystemCodes::TYPE_DEPARTMENT;
            $careerType    = SystemCodes::TYPE_CAREERLEVEL;
            $mastersType   = SystemCodes::TYPE_MASTERS;

            expect_that($code = SystemCodes::existsSystemCode($permitType, "A"));
            expect($code->description)->equals('ISSUED');

            expect_that($code = SystemCodes::existsSystemCode($mastersType, "PMBA"));
            expect($code->description)->equals('PROF_MBA');

            expect_not($code = SystemCodes::existsSystemCode($deptType, "UGAD"));
            expect_not($code = SystemCodes::existsSystemCode($careerType, "ACCT"));
        }

        public function testExistsPermit()
        {
            expect_that($code = SystemCodes::existsPermit("A"));
            expect($code->description)->equals('ISSUED');

            expect_not($code = SystemCodes::existsPermit("UGAD"));
            expect_not($code = SystemCodes::existsPermit("Nothing-Here"));
        }

        public function testFindPermitTagsById()
        {
            $idFind     = 1;
            $idNotFind  = 19;

            expect_that($code = SystemCodes::findPermitTagsById($idFind));
            expect_not($code = SystemCodes::existsPermit($idNotFind));
        }
     */
}
