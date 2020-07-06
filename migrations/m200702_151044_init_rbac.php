<?php

use yii\db\Migration;

/**
 * Class m200702_151044_init_rbac
 */
class m200702_151044_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function safeUp()
   {    
      $auth = Yii::$app->authManager;

      /**
       *    createPermissions:  systems level
       **/        

      $systemsAccess = [
         '1' => [
            'id'           => 1,
            'name'         => '[Framework]', 
            'description'  => 'Framework selfServe',
         ],      
         '2' => [ 
            'id'           => 2,
            'name'         => '[Student]', 
            'description'  => 'Student selfServe',
         ],
         '3' => [ 
            'id'           => 3,
            'name'         => '[Faculty]', 
            'description'  => 'Faculty selfServe',
         ],
         '4' => [ 
            'id'           => 4,
            'name'         => '[Administration]',   
            'description'  => 'Administration selfServe',
         ],
      ];
      
      
      $careerLevelAccess = [ 
         '1' => [ 
            'id'           => 1,
            'name'         => '[UGAD]',   
            'description'  => 'Undergraduate Career Level',  
         ],
         '2' => [
            'id'           => 2,
            'name'         => '[GRAD]',
            'description'  => 'Graduate Career Level',
         ],
         '3' => [ 
            'id'           => 3,
            'name'         => '[PHD]',
            'description'  => 'Doctorate Career Level',
         ],         
      ];      
      
      
      $departmentAccess = [ 
         '1' => [ 
            'id'              => 1,
            'name'            => '[ACCT]', 
            'description'     => 'Accounting Department', 
         ],
         '2' => [ 
            'id'              => 2,
            'name'            => '[ECON]',  
            'description'     => 'Economics Department',  
         ],
         '3' => [ 
            'id'              => 3,
            'name'            => '[FIN]',    
            'description'     => 'Finance Department',    
         ],
         '4' => [ 
            'id'              => 4,
            'name'            => '[BIT]',        
            'description'     => 'BIT Department',        
         ],
         '5' => [ 
            'id'              => 5,
            'name'            => '[MGMT]', 
            'description'     => 'Management Department', 
         ],
         '6' => [ 
            'id'              => 1,
            'name'            => '[MCSM]',       
            'description'     => 'MCSM Department',       
         ],
      ];
      
      
      $featureAccess = [
         '1' => [ 
            'id'              => 1,
            'name'            => '[Permit]', 
            'description'     => 'Permit Feature',
         ],
         '2' => [ 
            'id'              => 2,
            'name'            => '[GAApp]', 
            'description'     => 'Graduate Assistant Applications',       
         ],
         '3' => [ 
            'id'              => 3,
            'name'            => '[Sylla]', 
            'description'     => 'Course Syllabi',
         ],         
      ]; 
      
      
      $actionAccess = [ 
         '1' => [ 
            'id'           =>  '1',
            'name'         =>  '[Access]', 
            'description'  =>  '(System) Access Permission',
         ],
         '2' => [ 
            'id'           =>  '2',
            'name'         =>  '[Create]', 
            'description'  =>  'Create Permission',
         ],
         '3' => [ 
            'id'           => '3',
            'name'         => '[Read]', 
            'description'  => 'Read-Only Permission',
         ],
         '4' => [ 
            'id'           => '4',
            'name'         => '[Update]', 
            'description'  => 'Update Permission',
         ],
         '5' => [ 
            'id'           => '5',         
            'name'         => '[sDelete]', 
            'description'  => 'Soft-Delete (flag) Permission',
         ],
         '6' => [ 
            'id'           => '6',         
            'name'         => '[hDelete]', 
            'description'  => 'Hard-Delete (row removal) Permission',
         ],
         '7' => [ 
            'id'           => '7',         
            'name'         => '[Backup]',
            'description'  => 'Remote Backup Permission',
         ],
         '8' => [ 
            'id'           => '8',         
            'name'         => '[Role]',
            'description'  => 'Role Assignment Permission',
         ],
         '9' => [ 
            'id'           => '9',
            'name'         => '[Synch]',
            'description'  => 'Data Warehouse Sync Permissions',
         ],         
      ];

     
      $permissionsList = [];
      
      /**
       *  Basic System Access Flag Creation
       **/
             
      foreach( $systemsAccess as $system )
      {
         $newPermission = $system['name'] . $actionAccess[1]['name'];
         $permissionsList[] = $newPermission;
      }


      foreach( $careerLevelAccess as $career )
      {
         $newPermission = $career['name'] . $actionAccess[1]['name'];
         $permissionsList[] = $newPermission;      
      }


      foreach( $departmentAccess as $department )
      {
         $newPermission = $department['name'] . $actionAccess[1]['name'];
         $permissionsList[] = $newPermission;      
      }


      print_r( $permissionsList );
      die();


      $roleAccess = [
         '1' => [
            'id'           => '1',
            'name'         => 'Student-Undergraduate-1',
            'permissions'  => [
               $actionAccess[1],
               $actionAccess[2],
            ],
            'system'       => [
               $systemAccess[2],          // Student   
            ],
            'career'       => [
               $careerLevelAccess[1],     // UGAD
            ],
            'department'   => [], 
         ],
         '2' => [
            'id'           => '2',
            'name'         => 'Student-Graduate-1',
            'permissions'  => [
               $actionAccess[1],
               $actionAccess[2],
            ],
            'system'       => [
               $systemAccess[2],          // Student   
            ],
            'career'       => [
               $careerLevelAccess[2],     // GRAD
            ],
            'department'   => [], 
         ],
         '3' => [
            'id'           => '3',
            'name'         => 'Student-Doctorate-3',
            'permissions'  => [
               $actionAccess[1],
               $actionAccess[2],
            ],
            'system'       => [
               $systemAccess[2],          // Student   
            ],
            'career'       => [
               $careerLevelAccess[2],     // PHD
            ],
            'department'   => [], 
         ],               
      ];


      $rolesList        = [];
      $permissionsList  = [];

      /**
       *    Adding permissions to {auth_item}
       *******/
      
      foreach( $systemsAccess as $system )
      {

         $systemChk = [
            '1'  => strcmp( $system['name'], $systemsAccess[1]['name'] ),  // Framework
            '2'  => strcmp( $system['name'], $systemsAccess[2]['name'] ),  // Student
            '3'  => strcmp( $system['name'], $systemsAccess[3]['name'] ),  // Faculty
            '4'  => strcmp( $system['name'], $systemsAccess[3]['name'] ),  // Administration
         ];      
      
         $sysName = $system['name'];
         $sysDesc = $system['description'];  

         // If processing Student Self-Serve system requirements
         if( $systemChk[1] === 0 )
         {
            foreach( $careerLevelAccess as $career )
            {
               $careerName  = $career['name'];         
               $careerDesc  = $career['description'];  
            
               foreach( $actionAccess as $action )
               {
                  $actionName = $action['name'];
                  $actionDesc = $action['description'];
                  
                  $newPermName = $sysName . $careerName . $actionName;
                  $newPermDesc = $sysDesc . '-' . $careerDesc . '-' . $actionDesc;
               
                  $newPerm = $auth->createPermission( $newPermName );
                  $newPerm->description = $newPermDesc;
                  
                  $auth->add($newPerm);      
                  
                  $newPermission = [
                     'permission'   => $newPerm,
                     'systemKey'    => $sysName,
                     'careerKey'    => $careerName,
                     'actionKey'    => $actionName,
                  ];
                  
                  $permissionsList[] = $newPermission;
               }         
            }
         }
      }    
      
      /**
       *    Adding roles to {auth_item}
       *******/      

      foreach( $roleAccess as $role )
      {
         $roleRole               = $auth->createRole( $role['name'] );         
         $roleRole->description  = $role['description'];
         
         $auth->add($roleRole);
         
         $rolesList[] = $roleRole;
         
         $roleChk   = [];

         $roleChk[] = strpos( $role['description'], $roleCareerLevels[0] );
         $roleChk[] = strpos( $role['description'], $roleCareerLevels[1] );
         $roleChk[] = strpos( $role['description'], $roleCareerLevels[2] );

         $systemChk = [];         
         foreach( $role['system'] as $roleSys )
         {
            foreach( $systemsAccess as $sysAccess )
            {
               $systemChk[] = strcmp( $roleSys, $sysAccess['name'] );
            }
         }  

         // [UG] Role
         if( $roleChk[0] !== false )
         {
//            print( $role['description'] . ']]  ' . $roleChk[0] . ' !== false' . PHP_EOL );
            foreach( $permissionsList as $permItem )
            {
               if
               ( 
                  strpos( $role['description'], $permItem['actionKey'] ) !== false &&
                  strpos( $role['description'], $permItem['careerKey'] ) !== false
               )
               {
                  $auth->addChild( $roleRole, $permItem['permission'] );
               }
            }
         }
         
         // [GR] Role
         if( $roleChk[1] !== false )
         {
            foreach( $permissionsList as $permItem )
            {
               if
               ( 
                  strpos( $role['description'], $permItem['actionKey'] ) !== false &&
                  strpos( $role['description'], $permItem['careerKey'] ) !== false
               )
               {
                  $auth->addChild( $roleRole, $permItem['permission'] );
               }
            }
         }         
         
         // [Framework] Role
         if( $roleChk[2] !== false )
         {
            foreach( $permissionsList as $permItem )
            {
               if( strpos( $role['description'], $permItem['actionKey'] ) !== false )
               {
                  $auth->addChild( $roleRole, $permItem['permission'] );
               }
            }
         }
      }        
      
//print_r( $rolesList );
//die();    

      $auth->assign( $rolesList[7], 7 );


   }
      
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m200702_151044_init_rbac cannot be reverted.\n";

      $auth = Yii::$app->authManager;
      $auth->removeAll();

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200702_151044_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
