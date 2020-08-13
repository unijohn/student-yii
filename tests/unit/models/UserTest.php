<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
   public function testFindUserById()
   {
      /**
       *  If this unit test fails, did you rebuild tlb_Users?
       **/
   
      expect_that($user = User::findIdentity(7));
      expect($user->uuid)->equals('adminusr');
      
      expect_not(User::findIdentity(13));
   }


   public function testFindUserByAccessToken()
   {
      codecept_debug( "[FCBE-WORKDESK]   Currently randomly generating access_token and auth_key" );
      codecept_debug( "[FCBE-WORKDESK]   Need to revise it in the future" );

      expect_that($user = User::findIdentityByAccessToken('RIQFHOWd5GBOknxtm1U2wmquI0qBpOvp'));
      expect($user->uuid)->equals('adminusr');
      
      expect_not(User::findIdentityByAccessToken('non-existing'));        
   }


   public function testFindByUUID()
   {
      expect_that($user = User::findByUUID('adminusr'));
      expect_not(User::findByUUID('notadmin'));
   }


   /**
   * @depends testFindByUUID
   */
   public function testValidateUser($user)
   {
      expect_that( $user = User::findByUUID('adminusr') );
      expect_that($user->validatePassword('admin'));   
      
      expect( $user->validateAuthKey($user->auth_key, 'tO4HR9nMCCpQGaoz6iRnuFXXVoS-5FfNmMIiRuu3DxOaqMpa') );
      expect_not( $user->validateAuthKey('nonono', 'test102key') );
      
//              $this->assertTrue(  $user->validateAuthKey($user->auth_key, 'tO4HR9nMCCpQGaoz6iRnuFXXVoS-5FfNmMIiRuu3DxOaqMpa') );
//              $this->assertFalse( $user->validateAuthKey('nonono', 'test102key' ) );
   }


   public function testIsFrameworkAdministrator()
   {
      $id = 7;
      
      expect_that($user = User::findIdentity($id));
      expect($user->uuid)->equals('adminusr');

      expect($user->isFrameworkAdministrator( $id ) )->equals(false);
      expect_not($user->isFrameworkAdministrator( 6 ) );
   }


   public function testIsAssignedTemporaryRole()
   {
      $id = 7;
      
      expect_that($user = User::findIdentity($id));
      expect($user->uuid)->equals('adminusr');

      expect($user->isAssignedTemporaryRole( $id ) )->equals(false);
      expect_not($user->isFrameworkAdministrator( 6 ) );
   }
}
