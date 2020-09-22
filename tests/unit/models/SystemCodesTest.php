<?php

namespace tests\unit\models;

use app\models\SystemCodes;

class SystemCodesTest extends \Codeception\Test\Unit
{

/*
    'id'                => $this->primaryKey(),
    'type'              => $this->integer()->notNull(),
    'type_str'          => $this->string(64)->notNull(),
    'code'              => $this->integer()->notNull(),
    'code_str'          => $this->string(64)->notNull(),
    'description'       => $this->string(64),
    
    'is_active'         => $this->integer()->notNull(),
    'is_visible'        => $this->integer()->notNull(),
    'is_banner_data'    => $this->integer()->notNull(),
    
    'order_by'          => $this->integer()->notNull(),
    
    'created_at'        => $this->integer()->notNull(),
    'updated_at'        => $this->integer(),
    'deleted_at'        => $this->integer(),
 */                    
 
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
