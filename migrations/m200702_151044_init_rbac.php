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
            'description'  => 'Data Warehouse Sync Permissions',
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
      print_r( $permAuthList );
      die();
 **/
 
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
               // 2:  Student Self Serve, 1:  Access, 1:  Permits
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $featureAccess[1]['key'],

               // 2:  Student Self Serve, 1:  Access, 1:  UGAD               
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $careerLevelAccess[1]['key'],
            ],
         ],        
         '3' => [
            'id'              => '3',
            'name'            => 'Student-Graduate',
            'description'     => 'Graduate Student (1)',
            'allEverything'   => false,
            'permissions'     => [
               // 2:  Student Self Serve, 1: Access, 1:  Permits
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $featureAccess[1]['key'],

               // 2:  Student Self Serve, 1: Access, 1:  GRAD   
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $careerLevelAccess[2]['key'],
            ],
         ],
         '4' => [
            'id'              => '4',
            'name'            => 'Student-Doctorate',
            'description'     => 'Doctorate Student (1)',
            'allEverything'   => false,
            'permissions'     => [
               // 2:  Student Self Serve, 1: Access, 1:  Permits
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $featureAccess[1]['key'],

               // 2:  Student Self Serve, 1: Access, 1:  PHD   
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $careerLevelAccess[3]['key'],            
            ],
         ],
         '5' => [
            'id'              => '5',
            'name'            => 'Academic-Advisor-Undergraduate',
            'description'     => 'Undergraduate Advisor (2)',
            'allEverything'   => false,
            'permissions'     => [
               // 2:  Student Self Serve, 1: Access, 1:  Permits
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $featureAccess[1]['key'],

               // 2:  Student Self Serve, 1: Access, 1:  UGAD               
               $systemsAccess[2]['key'] . $actionAccess[1]['key'] . $careerLevelAccess[1]['key'],
               
               // 2:  Student Self Serve, 2: Create, 1:  UGAD               
               $systemsAccess[2]['key'] . $actionAccess[2]['key'] . $careerLevelAccess[1]['key'],
               
               // 2:  Student Self Serve, 4: Update, 1:  UGAD               
               $systemsAccess[2]['key'] . $actionAccess[4]['key'] . $careerLevelAccess[1]['key'],               
            ],
         ],            
      ];
      
        
      $roleAuthList  = [];    
      foreach( $roleAccess as $role )
      {
         $roleRole               = $auth->createRole( $role['name'] );         
         $roleRole->description  = $role['description'];
         
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
                  
                  $newAuthChild = [
                     'role'         => $roleRole,
                     'permission'   => $permAuth,
                  ];
                  
                  $roleAuthList[] = $newAuthChild;
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
