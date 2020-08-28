<?php

namespace tests\unit\models;

use app\models\Courses;

class CoursesTest extends \Codeception\Test\Unit
{
    public function testAddCourse()
    {
        $course = new Courses();
      
        $course->id = "TESTME2010001";
        $course->subject_area = "TESTME";
        $course->course_number = "2010";
        $course->section_number = "001";
      
        expect_that($saveResult = $course->save());
      
        expect_that($course = Courses::existsCourse($course->id));
        expect_not($course = Courses::existsCourse("0012010TESTME"));
    }

    public function testExistsCourse()
    {
        $idFind     = "ACCT2010001";
        $idNotFind  = "PHYS2095001";
   
        expect_that($course = Courses::existsCourse($idFind));
        expect($course->subject_area)->equals('ACCT');
      
        expect_not($course = Courses::existsCourse($idNotFind));
    }
   
    public function testCountOfAllSubjectAreas()
    {
        $report = Courses::getAllSubjectAreas();
   
        expect(count($report))->equals(8);
    }
}
