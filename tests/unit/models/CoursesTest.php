<?php

namespace tests\unit\models;

use app\models\Courses;

class CoursesTest extends \Codeception\Test\Unit
{
   public function testExistsCourse()
   {
      $idFind = "ACCT2010001";
      $idNotFind = "PHYS2095001";
   
      expect_that($course = Courses::existsCourse($idFind));
      expect($course->subject_area)->equals('ACCT');
      
      expect_not($course = Courses::existsCourse($idNotFind));      
   }
}
