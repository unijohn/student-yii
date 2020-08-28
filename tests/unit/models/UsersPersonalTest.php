<?php

namespace tests\unit\models;

use app\models\UsersPersonal;

class UsersPersonalTest extends \Codeception\Test\Unit
{  
    public $tooShort    = "1";
    public $tooLong     = "Tooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo";
    public $justRight   = "123456789";
    
    public $goodMinInt  = 0;
    public $goodMaxInt  = 1;
    
    public $badMinInt   = -1;
    public $badMaxInt   = 10;

/**
    function __construct() {
        $this->tooShort = "1";
        
        $this->tooLong  = "Tooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo";
        $this->tooLong .= " Loooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooong";
    }
 **/

    public function testFindUserByUUID()
    {        
        expect_that($user = UsersPersonal::existsPersonal('adminusr'));

        $user = UsersPersonal::find()->Where([ 'uuid' => 'adminusr' ])->limit(1)->one();        
        expect($user->uNbr)->equals('U00000012');
        
        expect($user->userInformation->id)->equals(7);
    }
    
    public function testFirstNameValidation()
    {   
        $user = new UsersPersonal();
               
        $user->firstNm = $this->tooShort;
        $this->assertFalse($user->validate(['firstNm']));        

        $user->firstNm = $this->tooLong;
        $this->assertFalse($user->validate(['firstNm'])); 

        $user->firstNm = $this->justRight;
        $this->assertTrue($user->validate(['firstNm']));
    } 
    
    public function testLastNameValidation()
    {   
        $user = new UsersPersonal();
               
        $user->lastNm = $this->tooShort;
        $this->assertFalse($user->validate(['lastNm']));        

        $user->lastNm = $this->tooLong;
        $this->assertFalse($user->validate(['lastNm'])); 

        $user->lastNm = $this->justRight;
        $this->assertTrue($user->validate(['lastNm']));
    }    
    
    public function testUNbrValidation()
    {   
        $user = new UsersPersonal();
               
        $user->uNbr = $this->tooShort;
        $this->assertFalse($user->validate(['uNbr']));        

        $user->uNbr = $this->tooLong;
        $this->assertFalse($user->validate(['uNbr'])); 

        $user->uNbr = $this->justRight;
        $this->assertTrue($user->validate(['uNbr']));
    }    
    
    public function testVisaTypeValidation()
    {   
        $user = new UsersPersonal();

        $user->visa_type = $this->goodMinInt;
        $this->assertTrue($user->validate(['visa_type']));        
        
        $user->visa_type = $this->badMinInt;
        $this->assertFalse($user->validate(['visa_type']));    
        
        $user->visa_type = $this->goodMaxInt;
        $this->assertTrue($user->validate(['visa_type']));        
        
        $user->visa_type = $this->badMaxInt;
        $this->assertFalse($user->validate(['visa_type']));   
    }   

/*
   public function testFindUserByAccessToken()
   {
        codecept_debug( "[FCBE-WORKDESK]   Currently randomly generating access_token and auth_key" );
        codecept_debug( "[FCBE-WORKDESK]   Need to revise it in the future" );
        
        $user = User::findIdentity(7);
        
        expect_that($user = User::findIdentityByAccessToken($user->access_token));
        expect($user->uuid)->equals('adminusr');
        
        expect_not(User::findIdentityByAccessToken('non-existing'));        
   }


   public function testFindByUUID()
   {
      expect_that($user = User::findByUUID('adminusr'));
      expect_not(User::findByUUID('notadmin'));
   }


   **
   * @depends testFindByUUID
   *
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
   
   **/
}
