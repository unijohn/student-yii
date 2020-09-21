<?php

namespace tests\unit\models;

use app\models\SystemCodes;

class SystemCodesTest extends \Codeception\Test\Unit
{

/*
    public function testAddSystemCode()
    {
        $permitType    = SystemCodes::TYPE_PERMIT;
        $deptType      = SystemCodes::TYPE_DEPARTMENT;
        $careerType    = SystemCodes::TYPE_CAREERLEVEL;
        $mastersType   = SystemCodes::TYPE_MASTERS;

        $code = new SystemCodes();

        $code->type          = $permitType;
        $code->code          = "ZaZa";
        $code->description   = "Uniting-Testing";

        expect($saveResult = $code->save())->equals(true);

        // Type is below MIN
        $code->type          = -1;
        $code->code          = "ACCT";
        $code->description   = "Uniting-Testing";

        expect($saveResult = $code->save())->equals(false);

        // Type is above MAX
        $code->type          = 12;
        $code->code          = "EMBA";
        $code->description   = "Uniting-Testing";

        expect($saveResult = $code->save())->equals(false);
    }


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
