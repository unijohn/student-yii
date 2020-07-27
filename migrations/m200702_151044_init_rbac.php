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

      /**
       *    SystemID CONSTS
       **/ 
      $SYS_FRAMEWORKID        = 1;
      $SYS_STUDENTID          = 2;
      $SYS_FACULTYID          = 3;
      $SYS_ADMINISTRATIONID   = 4;


      $systemsAccess = [
         '1' => [
            'id'           => 1,
            'key'          => '[Framework]', 
            'name'         => '[Framework]', 
            'description'  => 'Framework selfServe',
         ],      
         '2' => [ 
            'id'           => 2,
            'key'          => '[Student]',
            'name'         => '[Student]', 
            'description'  => 'Student selfServe',
         ],
         '3' => [ 
            'id'           => 3,
            'name'         => '[Faculty]', 
            'key'          => '[Faculty]', 
            'description'  => 'Faculty selfServe',
         ],
         '4' => [ 
            'id'           => 4,
            'name'         => '[Administration]',
            'key'          => '[Administration]', 
            'description'  => 'Administration selfServe',
         ],
      ];


      /**
       *    CareerLevelID CONSTS
       **/ 
      $CL_UGADID  = 1;
      $CL_GRADID  = 2;
      $CL_PHDID   = 3;      

      
      $careerLevelAccess = [ 
         '1' => [ 
            'id'           => 1,
            'name'         => '[UGAD]',   
            'key'          => '[UGAD]',
            'description'  => 'Undergraduate Career Level',  
         ],
         '2' => [
            'id'           => 2,
            'name'         => '[GRAD]',
            'key'          => '[GRAD]',            
            'description'  => 'Graduate Career Level',
         ],
         '3' => [ 
            'id'           => 3,
            'name'         => '[PHD]',
            'key'          => '[PHD]',            
            'description'  => 'Doctorate Career Level',
         ],         
      ];      


      $departmentAccess = [ 
         '1' => [ 
            'id'              => 1,
            'key'             => '[ACCT]',
            'name'            => '[ACCT]', 
            'description'     => 'Accounting Department', 
         ],
         '2' => [ 
            'id'              => 2,
            'key'             => '[ECON]',            
            'name'            => '[ECON]',  
            'description'     => 'Economics Department',  
         ],
         '3' => [ 
            'id'              => 3,
            'key'             => '[FIN]',            
            'name'            => '[FIN]',    
            'description'     => 'Finance Department',    
         ],
         '4' => [ 
            'id'              => 4,
            'key'             => '[BIT]',            
            'name'            => '[BIT]',        
            'description'     => 'BIT Department',        
         ],
         '5' => [ 
            'id'              => 5,
            'key'             => '[MGMT]',            
            'name'            => '[MGMT]', 
            'description'     => 'Management Department', 
         ],
         '6' => [ 
            'id'              => 1,
            'key'             => '[MCSM]',    
            'name'            => '[MCSM]',       
            'description'     => 'MCSM Department',       
         ],
      ];


      /**
       *    FeatureID CONSTS
       **/ 
      $FEAT_PERMIT   = 1;
      $FEAT_GAAAP    = 2;
      $FEAT_SYLLA    = 3;    
      
      $featureAccess = [
         '1' => [ 
            'id'              => 1,
            'key'             => '[Permit]',            
            'name'            => '[Permit]', 
            'description'     => 'Permit Feature',
         ],
         '2' => [ 
            'id'              => 2,
            'key'             => '[GAApp]',            
            'name'            => '[GAApp]', 
            'description'     => 'Graduate Assistant Applications',       
         ],
         '3' => [ 
            'id'              => 3,
            'key'             => '[Sylla]',            
            'name'            => '[Sylla]', 
            'description'     => 'Course Syllabi',
         ],
      ]; 


      /**
       *    ActionID CONSTS
       **/ 
      $ACT_ACCESS    = 1;
      $ACT_CREATE    = 2;
      $ACT_READ      = 3;
      $ACT_UPDATE    = 4;
      $ACT_sDELETE   = 5;
      $ACT_hDELETE   = 6;
      $ACT_BACKUP    = 7;
      $ACT_ROLE      = 8;
      $ACT_SYNCH     = 9;
      $ACT_MANAGE    = 10;
   
      
      $actionAccess = [ 
         '1' => [ 
            'id'           => '1',
            'key'          => '[Access]',
            'name'         => '[Access]', 
            'description'  => '(System) Access Permission',
         ],
         '2' => [ 
            'id'           => '2',
            'key'          => '[Create]',            
            'name'         => '[Create]', 
            'description'  => 'Create Permission',
         ],
         '3' => [ 
            'id'           => '3',
            'key'          => '[Read]',            
            'name'         => '[Read]', 
            'description'  => 'Read-Only Permission',
         ],
         '4' => [ 
            'id'           => '4',
            'key'          => '[Update]',            
            'name'         => '[Update]', 
            'description'  => 'Update Permission',
         ],
         '5' => [ 
            'id'           => '5',
            'key'          => '[sDelete]',              
            'name'         => '[sDelete]', 
            'description'  => 'Soft-Delete (flag) Permission',
         ],
         '6' => [ 
            'id'           => '6',
            'key'          => '[hDelete]',            
            'name'         => '[hDelete]', 
            'description'  => 'Hard-Delete (row removal) Permission',
         ],
         '7' => [ 
            'id'           => '7',
            'key'          => '[Backup]',            
            'name'         => '[Backup]',
            'description'  => 'Remote Backup Permission',
         ],
         '8' => [ 
            'id'           => '8',
            'key'          => '[Role]',              
            'name'         => '[Role]',
            'description'  => 'Role Assignment Permission',
         ],
         '9' => [ 
            'id'           => '9',
            'key'          => '[Synch]',            
            'name'         => '[Synch]',
            'description'  => 'Data Warehouse Sync Permission',
         ],
         '10' => [ 
            'id'           => '10',
            'key'          => '[Manage]',            
            'name'         => '[Manage]',
            'description'  => 'System-Feature Management Permission',
         ],     
      ];

     
      $permissionsList = [];
      
      /**
       *  Basic System Access Flag Creation

             
      foreach( $systemsAccess as $system )
      {
         $newPermission = [
                  'system'          => [
                     'name'         => $system['name'],
                     'description'  => $system['description'],
                  ],
                  'action'          => [
                     'name'         => $actionAccess[1]['name'],
                     'description'  => $actionAccess[1]['description'],
                  ],
                  'career'          => [],
                  'department'      => [],
                  'feature'         => [],
         ];         
         
         $system['name'] .$actionAccess[1]['name'];
         $permissionsList[] = $newPermission;      
      }
       **/

      
      foreach( $systemsAccess as $system )
      {
         foreach( $actionAccess as $action )
         {
            foreach( $careerLevelAccess as $career )
            {
               $newPermission = [
                  'system'          => [
                     'name'         => $system['name'],
                     'description'  => $system['description'],
                  ],
                  'action'          => [
                     'name'         => $action['name'],
                     'description'  => $action['description'],
                  ],
                  'career'          => [
                     'name'         => $career['name'],
                     'description'  => $career['description'],
                  ],
                  'department'      => [],
                  'feature'         => [],                  
               ];
               $permissionsList[] = $newPermission;      
            }
            
            foreach( $departmentAccess as $department )
            {
               $newPermission = [
                  'system'          => [
                     'name'         => $system['name'],
                     'description'  => $system['description'],
                  ],
                  'action'          => [
                     'name'         => $action['name'],
                     'description'  => $action['description'],
                  ],
                  'department'          => [
                     'name'         => $department['name'],
                     'description'  => $department['description'],
                  ],
                  'career'          => [],
                  'feature'         => [],                  
               ];               
               $permissionsList[] = $newPermission;      
            }
            
            foreach( $featureAccess as $feature )
            {
               $newPermission = [
                  'system'          => [
                     'name'         => $system['name'],
                     'description'  => $system['description'],
                  ],
                  'action'          => [
                     'name'         => $action['name'],
                     'description'  => $action['description'],
                  ],
                  'feature'         => [
                     'name'         => $feature['name'],
                     'description'  => $feature['description'],
                  ],
                  'career'          => [],
                  'department'      => [],                       
               ];
               $permissionsList[] = $newPermission;      
            }
         }
      }      

/**
      print_r( $permissionsList );
      die();
 **/

      /**
       *    Adding permissions to {auth_item}
       *******/

      $permAuthList  = [];

      foreach( $permissionsList as $permission )
      {
      
         $newKey           = $permission['system']['name'] . $permission['action']['name'];
         $newDescription   = $permission['system']['description'] . "-" . $permission['action']['description'];
         
         if( isset( $permission['career']['name'] ) && !empty( $permission['career']['name'] ) )
         {
            $newKey           .= $permission['career']['name'];
            $newDescription   .= "-" . $permission['career']['description'];
         }

         if( isset( $permission['department']['name'] ) && !empty( $permission['department']['name'] ) )
         {
            $newKey           .= $permission['department']['name'];
            $newDescription   .= "-" . $permission['department']['description'];
         }

         if( isset( $permission['feature']['name'] ) && !empty( $permission['feature']['name'] ) )
         {
            $newKey           .= $permission['feature']['name'];
            $newDescription   .= "-" . $permission['feature']['description'];
         } 

         $newPerm = $auth->createPermission( $newKey  );
         $newPerm->description = $newDescription;
      
         $auth->add($newPerm);        
         
         $newAuthItem = [
            'key'             => $newKey,
            'description'     => $newDescription,
            'permission'      => $newPerm,
         ];  
         
         $permAuthList[$newKey] = $newAuthItem;
      }    


      /**
       *    ActionID CONSTS
       **/ 
      $ROLE_ADMIN          = 1;
      $ROLE_UGAD_STUDENT   = 2;
      $ROLE_GRAD_STUDENT   = 3;
      $ROLE_PHD_STUDENT    = 4;
      $ROLE_UGAD_ADVISOR   = 5;
      $ROLE_GRAD_ADVISOR   = 6;
      $ROLE_PHD_ADVISOR    = 7;
      
 
      $roleAccess = [
         '1' => [
            'id'              => '1',
            'name'            => 'Framework-Administrator',
            'description'     => 'Framework Administrator (10)',
            'allEverything'   => true,
         ],
         '2' => [
            'id'              => '2',
            'name'            => 'Student-Undergraduate',
            'description'     => 'Undergraduate Student (1)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $featureAccess[$FEAT_PERMIT]['key'],

         //    2:  Student Self Serve                . 1: Access                         . 1:  UGAD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $careerLevelAccess[$CL_UGADID]['key'],
            ],
         ],        
         '3' => [
            'id'              => '3',
            'name'            => 'Student-Graduate',
            'description'     => 'Graduate Student (1)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $featureAccess[$FEAT_PERMIT]['key'],

         //    2:  Student Self Serve                . 1: Access                         . 2:  GRAD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $careerLevelAccess[$CL_GRADID]['key'],
            ],
         ],
         '4' => [
            'id'              => '4',
            'name'            => 'Student-Doctorate',
            'description'     => 'Doctorate Student (1)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $featureAccess[$FEAT_PERMIT]['key'],

         //    2:  Student Self Serve                . 1: Access                         . 3:  PHD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $careerLevelAccess[$CL_PHDID]['key'],            
            ],
         ],
         '5' => [
            'id'              => '5',
            'name'            => 'Academic-Advisor-Undergraduate',
            'description'     => 'Undergraduate Advisor (2)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $featureAccess[$FEAT_PERMIT]['key'],

         //    2:  Student Self Serve                . 1: Access                         . 1:  UGAD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $careerLevelAccess[$CL_UGADID]['key'],
                      
         //    2:  Student Self Serve                . 2: Create                         . 1:  UGAD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_CREATE]['key'] . $careerLevelAccess[$CL_UGADID]['key'],
               
         //    2:  Student Self Serve                . 4: Update                         . 1:  UGAD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_UPDATE]['key'] . $careerLevelAccess[$CL_UGADID]['key'],
            ],
         ],
         '6' => [
            'id'              => '6',
            'name'            => 'Academic-Advisor-Graduate',
            'description'     => 'Graduate Advisor (2)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $featureAccess[$FEAT_PERMIT]['key'],
       
         //    2:  Student Self Serve                . 1:  Access                        . 2:  GRAD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $careerLevelAccess[$CL_GRADID]['key'],
               
         //    2:  Student Self Serve                . 2: Create                         . 2:  GRAD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_CREATE]['key'] . $careerLevelAccess[$CL_GRADID]['key'],
               
         //    2:  Student Self Serve                . 4: Update                         . 2:  GRAD               
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_UPDATE]['key'] . $careerLevelAccess[$CL_GRADID]['key'],               
            ],
         ],         
         '7' => [
            'id'              => '7',
            'name'            => 'Academic-Advisor-PhD',
            'description'     => 'PhD Advisor (2)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $featureAccess[$FEAT_PERMIT]['key'],
       
         //    2:  Student Self Serve                . 1:  Access                        . 3:  PHD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_ACCESS]['key'] . $careerLevelAccess[$CL_PHDID]['key'],
               
         //    2:  Student Self Serve                . 2: Create                         . 3:  PHD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_CREATE]['key'] . $careerLevelAccess[$CL_PHDID]['key'],
               
         //    2:  Student Self Serve                . 4: Update                         . 3:  PHD
               $systemsAccess[$SYS_STUDENTID]['key'] . $actionAccess[$ACT_UPDATE]['key'] . $careerLevelAccess[$CL_PHDID]['key'],               
            ],
         ], 
      ];
      
        
      $roleAuthList  = [];    
      foreach( $roleAccess as $role )
      {
         $roleRole               = $auth->createRole( $role['name'] );         
         $roleRole->description  = $role['description'];

         $newRoleChild = [
            'role'      => $roleRole,
         ];
         
         $roleAuthList[] = $newRoleChild;
         
         $auth->add($roleRole);

         /**
          *    All permissions for all systems, features, careers, departments for this role
          **/
         if( isset($role['allEverything']) && !empty($role['allEverything'] ) )
         {
            if( $role['allEverything'])
            {
               foreach( $permAuthList as $permAuth )
               {
                  $auth->addChild( $roleRole, $permAuth['permission'] );
               }
            }
         }
         else
         {
            foreach( $role['permissions'] as $permItem )
            {
               $auth->addChild( $roleRole, $permAuthList[$permItem]['permission'] );
            }
         }
      }

      $frameworkRole = $auth->getRole('Framework-Administrator');

      $auth->assign( $auth->getRole('Framework-Administrator'), 7 );
      
      $auth->assign( $auth->getRole('Student-Undergraduate'),           1 );
      $auth->assign( $auth->getRole('Student-Graduate'),                2 );
      $auth->assign( $auth->getRole('Academic-Advisor-Undergraduate'),  3 );
      $auth->assign( $auth->getRole('Academic-Advisor-Graduate'),       5 ); 
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
