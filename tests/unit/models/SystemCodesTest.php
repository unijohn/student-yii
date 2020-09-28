<?php

namespace tests\unit\models;

use app\models\SystemCodes;

use app\modules\Consts;

class SystemCodesTest extends \Codeception\Test\Unit
{
    public $justRight   = "Just Right Enough";
    public $tooLong     = "Tooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo";
 
    public function testAddSystemCode()
    {
        $systemCode             = new SystemCodes();
        
        $systemCode->scenario   = Consts::SCENARIO_INSERT;
        
        // Everything correct
        $systemCode->type           = Consts::CODE_ITEM_PERMITS;
        $systemCode->type_str       = $this->justRight;

        $systemCode->code           = 0;
        $systemCode->code_str       = $this->justRight;
        
        $systemCode->description    = $this->justRight;
        
        $systemCode->is_active      = Consts::TYPE_ITEM_STATUS_ACTIVE;
        $systemCode->is_visible     = Consts::TYPE_ITEM_STATUS_VISIBLE;
        $systemCode->is_banner_data = Consts::TYPE_ITEM_SOURCE_BANNER_DATA;
        
        expect($saveResult = $systemCode->save())->equals(true);
        
        // Type is below MIN
        $systemCode->type  = Consts::TYPE_ITEM_MIN - 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is above MAX
        $systemCode->type  = Consts::TYPE_ITEM_MAX + 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is just right
        $systemCode->type  = Consts::CODE_ITEM_MASTERS;
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
        $systemCode->is_active  = Consts::TYPE_ITEM_STATUS_VISIBLE_MIN - 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is above MAX
        $systemCode->is_active  = Consts::TYPE_ITEM_STATUS_ACTIVE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_active  = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is just right
        $systemCode->is_active  = Consts::TYPE_ITEM_STATUS_ACTIVE;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_visible is below MIN
        $systemCode->is_visible = Consts::TYPE_ITEM_STATUS_VISIBLE_MIN + 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_visible is above MAX
        $systemCode->is_visible = Consts::TYPE_ITEM_STATUS_VISIBLE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_visible = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_visible is just right
        $systemCode->is_visible = Consts::TYPE_ITEM_STATUS_HIDDEN;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_banner_data is below MIN
        $systemCode->is_banner_data = Consts::TYPE_ITEM_SOURCE_MIN - 1;
        expect($saveResult          = $systemCode->save())->equals(false);
        
        // is_banner_data is above MAX
        $systemCode->is_banner_data = Consts::TYPE_ITEM_SOURCE_MAX + 1;
        expect($saveResult          = $systemCode->save())->equals(false);

        // is_banner_data is wrong kind of data
        $systemCode->is_banner_data = $this->tooLong;
        expect($saveResult          = $systemCode->save())->equals(false);

        // is_banner_data is just right
        $systemCode->is_banner_data = Consts::TYPE_ITEM_SOURCE_BANNER_DATA;
        expect($saveResult          = $systemCode->save())->equals(true);
    }
    
    
    public function testUpdateSystemCode()
    {
        $systemCode = SystemCodes::find()
            ->where(['id' => 6 ])
            ->limit(1)
            ->one();
        
        $systemCode->scenario   = Consts::SCENARIO_UPDATE;
        
        // Everything correct
        $systemCode->type           = Consts::CODE_ITEM_PERMITS;
        $systemCode->type_str       = $this->justRight;

        $systemCode->code           = 0;
        $systemCode->code_str       = $this->justRight;
        
        $systemCode->description    = $this->justRight;
        
        $systemCode->is_active      = Consts::TYPE_ITEM_STATUS_ACTIVE;
        $systemCode->is_visible     = Consts::TYPE_ITEM_STATUS_VISIBLE;

        if (!$systemCode->validate()) {
            SystemCodes::debug($systemCode->errors, true);
        }
        
        expect($saveResult = $systemCode->save())->equals(true);
        
        // Type is below MIN
        $systemCode->type  = Consts::TYPE_ITEM_MIN - 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is above MAX
        $systemCode->type  = Consts::TYPE_ITEM_MAX + 100;
        expect($saveResult = $systemCode->save())->equals(false);

        // Type is just right
        $systemCode->type  = Consts::CODE_ITEM_MASTERS;
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
        $systemCode->is_active  = Consts::TYPE_ITEM_STATUS_VISIBLE_MIN - 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is above MAX
        $systemCode->is_active  = Consts::TYPE_ITEM_STATUS_ACTIVE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_active  = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_active is just right
        $systemCode->is_active  = Consts::TYPE_ITEM_STATUS_ACTIVE;
        expect($saveResult      = $systemCode->save())->equals(true);
        
        // is_visible is below MIN
        $systemCode->is_visible = Consts::TYPE_ITEM_STATUS_VISIBLE_MIN + 100;
        expect($saveResult      = $systemCode->save())->equals(false);
        
        // is_visible is above MAX
        $systemCode->is_visible = Consts::TYPE_ITEM_STATUS_VISIBLE_MAX + 100;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_active is wrong kind of data
        $systemCode->is_visible = $this->tooLong;
        expect($saveResult      = $systemCode->save())->equals(false);

        // is_visible is just right
        $systemCode->is_visible = Consts::TYPE_ITEM_STATUS_HIDDEN;
        expect($saveResult      = $systemCode->save())->equals(true);
    }
    
    
    public function testFindByMethods()
    {
        /*
         * public static function findbyType( $type = -1 )
         */
    
        // $type is right
        expect(SystemCodes::findbyType(Consts::CODE_ITEM_MASTERS));

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
            ->where(['id' => 7 ])
            ->limit(1)
            ->one();
        
        // Starting position: id: y
        // Career-Levels, UGAD, Undergraduate
        //
        // Start position: 3
        // Min position: 1
        // Max position: 5

        expect($row->movePrev())->equals(true);
        expect($row->movePrev())->equals(true);
        expect($row->movePrev())->equals(false);
        
        expect($row->getIsLast())->equals(false);
        expect($row->getIsFirst())->equals(true);

        for ($i = 1; $i <= 4; $i++) {
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
    
    
    public function testFindTags()
    {
        $systemCode             = new SystemCodes();
    
        // If permits are tagged, this test will fail
        $this->assertFalse(SystemCodes::findAllPermitTags(), "If permits are tagged, this test will fail");

        expect(SystemCodes::findPermitTagOptions());

        $row = SystemCodes::find()
            ->where([ 'id' => 6 ])
            ->limit(1)
            ->one();
        
        /*
         * public static function findPermitTagsById($id = -1)
         */
        // $id is wrong kind of data
        $this->assertFalse(SystemCodes::findPermitTagsById("Masters"), "Should Fail:  'Masters' != [numeric] id");

        // $id is wrong value
        expect(SystemCodes::findPermitTagsById(-1))->equals(false);
        expect(SystemCodes::findPermitTagsById(10000000))->equals(false);

        // $id is valid
        expect(SystemCodes::findPermitTagsById(4));
        
        /*
         * public static function findAllTagsById($id = -1)
         */
        // $id is wrong kind of data
        $this->assertFalse(SystemCodes::findAllTagsById("Masters"), "Should Fail:  'Masters' != [numeric] id");

        // $id is wrong value
        expect(SystemCodes::findAllTagsById(-1))->equals(false);
        expect(SystemCodes::findAllTagsById(10000000))->equals(false);

        // $id is valid
        expect(SystemCodes::findAllTagsById(4));
        
        /*
         * public static function findUnassignedTagOptions($id = -1, $selectType = -1, $omitType = -1, $isActive = self::STATUS_ACTIVE)
         */
        // $id is wrong kind of data
        $this->assertFalse(SystemCodes::findUnassignedTagOptions("Masters", "Booyah", "DONT WORK", "FAILME"), "Should Fail:  All int parameters being passed strings");

        // $id, $selectType, $omitType is wrong value
        expect(SystemCodes::findUnassignedTagOptions(-1, -1, -1, Consts::TYPE_ITEM_STATUS_ACTIVE))->equals(false);
        
        // $id is wrong value
        expect(SystemCodes::findUnassignedTagOptions(-1, 1000000, 1000000, Consts::TYPE_ITEM_STATUS_ACTIVE))->equals(false);
        
        // $isActive is wrong value
        expect(SystemCodes::findUnassignedTagOptions(-1, 1000000, 1000000, -1000))->equals(false);

        // $selectType, $omitType is wrong value :: Should work
        expect(SystemCodes::findUnassignedTagOptions(1000000, -1, -1, Consts::TYPE_ITEM_STATUS_ACTIVE));
        
        // $selectType is wrong value :: Should work
        expect(SystemCodes::findUnassignedTagOptions(1000000, 1000000, -1, Consts::TYPE_ITEM_STATUS_ACTIVE));
        
        // $omitType is wrong value ::should work
        expect(SystemCodes::findUnassignedTagOptions(1000000, -1, 1000000, Consts::TYPE_ITEM_STATUS_ACTIVE));

        // vv- To be revisited during next refactoring -vv
        // $id, $selectType, $omitType, $isActive are valid
        //expect(SystemCodes::findUnassignedPermitTagOptions(4, -1, SystemCodes::TYPE_DEPARTMENT, Consts::TYPE_ITEM_STATUS_ACTIVE));
        
        // $id, $selectType, $omitType, $isActive are valid
        //expect(SystemCodes::findUnassignedPermitTagOptions(4, SystemCodes::TYPE_DEPARTMENT, -1, Consts::TYPE_ITEM_STATUS_ACTIVE));
        

        // Wrapper methods :: No $id given
        expect(SystemCodes::findUnassignedPermitTagOptions())->equals(false);
        //expect(SystemCodes::findUnassignedDepartmentTagOptions())->equals(false);
        expect(SystemCodes::findUnassignedCareerLevelTagOptions())->equals(false);
        expect(SystemCodes::findUnassignedMasterTagOptions())->equals(false);
        expect(SystemCodes::findUnassignedFacultyRankTagOptions())->equals(false);
        expect(SystemCodes::findUnassignedEmployeeClassTagOptions())->equals(false);
        expect(SystemCodes::findUnassignedSchoolDepartmentTagOptions())->equals(false);
        expect(SystemCodes::findUnassignedUniversityDepartmentTagOptions())->equals(false);
        
        // Wrapper methods :: $id given; array() returned
        expect(SystemCodes::findUnassignedPermitTagOptions(2));
        //expect(SystemCodes::findUnassignedDepartmentTagOptions(2));
        expect(SystemCodes::findUnassignedCareerLevelTagOptions(2));
        expect(SystemCodes::findUnassignedMasterTagOptions(2));
        expect(SystemCodes::findUnassignedFacultyRankTagOptions(2));
        expect(SystemCodes::findUnassignedEmployeeClassTagOptions(2));
        expect(SystemCodes::findUnassignedSchoolDepartmentTagOptions(2));
        expect(SystemCodes::findUnassignedUniversityDepartmentTagOptions(2));
    }
    

    public function testExistsSystemCode()
    {
        /*
         *  public static function existsSystemCode($type = -1, $code_str = "")
         */
        // $type, $code_str are wrong kind of data
        $this->assertFalse(SystemCodes::existsSystemCode("Masters", dechex(1000)), "Should Fail:  'Masters' != [numeric] type && dechex(1000) != [string] code_str");

        // $code_str are wrong kind of data
        $this->assertFalse(SystemCodes::existsSystemCode(2, dechex(10000)), "Should Fail:  dechex(1000) != [string] code_str");
        
        // $type are wrong kind of data
        $this->assertFalse(SystemCodes::existsSystemCode("FAIL", 'PERMIT-OPEN'), "Should Fail:  'FAIL' != [numeric] type");
        
        // $type, $code are valid
        expect(SystemCodes::existsSystemCode(2, 2));
        
        // Wrapper methods :: invalid values given
        
        // $code_str is wrong
        expect(SystemCodes::existsPermit('Open Permit Request'))->equals(false);
//        expect(SystemCodes::existsDepartment('Economics'))->equals(false);    // Replaced with School & University Department values
        expect(SystemCodes::existsCareelLevel('Undergraduate'))->equals(false);
        expect(SystemCodes::existsMasters('MA_ECON'))->equals(false);
        expect(SystemCodes::existsFacultyRank('Professor [Banner]'))->equals(false);
        expect(SystemCodes::existsEmployeeClass('Administrative Executive [Banner]'))->equals(false);
        expect(SystemCodes::existsSchoolDepartment('Economics [Banner]'))->equals(false);
        expect(SystemCodes::existsUniversityDepartment('Academic Affairs [Banner]'))->equals(false);
        
        // $code_str is vald
        expect(SystemCodes::existsPermit('PERMIT-OPEN'))->equals(true);
//        expect(SystemCodes::existsDepartment('ECON'))->equals(true);          // Replaced with School & University Department values
        expect(SystemCodes::existsCareelLevel('UGAD'))->equals(true);
        expect(SystemCodes::existsMasters('MAECON'))->equals(true);
        expect(SystemCodes::existsFacultyRank('01'))->equals(true);
        expect(SystemCodes::existsEmployeeClass('AE'))->equals(true);
        expect(SystemCodes::existsSchoolDepartment('DEPT-CIOITS'))->equals(true);
        expect(SystemCodes::existsUniversityDepartment('UDEPT-ITS'))->equals(true);
    }
    
    
    public function testUnassignedTagOptionsForCourses()
    {
        /*
         *  public static function findUnassignedTagOptionsForCourses($id = "")
         */
        // $id is empty
        $this->assertFalse(SystemCodes::findUnassignedTagOptionsForCourses(), "Should Fail:  id cannot be blank");

        // $id is not string
        $this->assertFalse(SystemCodes::findUnassignedTagOptionsForCourses(1000000), "Should Fail:  id cannot be numeric");

        // $id is wrong value :: still works because $id is a selection of omission
        expect(SystemCodes::findUnassignedTagOptionsForCourses("FAIL"));
        
        // $id is valid
        expect(SystemCodes::findUnassignedTagOptionsForCourses("ACCT2010002"));
    }
    
    


    /*
        public function testExistsSystemCode()
        {
            $permitType    = Consts::CODE_ITEM_PERMITS;
            $deptType      = SystemCodes::TYPE_DEPARTMENT;
            $careerType    = SystemCodes::TYPE_CAREERLEVEL;
            $mastersType   = Consts::CODE_ITEM_MASTERS;

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
