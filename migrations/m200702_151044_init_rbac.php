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
            'name' =>         '[Student]', 
            'description' =>  'Student selfServe',
         ],
         '2' => [ 
            'name' =>         '[Faculty]', 
            'description' =>  'Faculty selfServe',
         ],
         '3' => [ 
            'name' =>         '[Administrative]',   
            'description' =>  'Administration selfServe',
         ],
      ];
      
      $careerLevelAccess = [ 
         '1' => [ 
            'name' =>         '[UGAD]',   
            'description' =>  'Undergraduate Career Level',  
         ],
         '2' => [ 
            'name' =>         '[GRAD]',
            'description' =>  'Graduate Career Level',
         ],
      ];      
      
      $departmentAccess = [ 
         '1' => [ 
            'name' =>         '[ACCT]', 
            'description' =>  'Accounting Department', 
         ],
         '2' => [ 
            'name' =>         '[ECON]',  
            'description' =>  'Economics Department',  
         ],
         '3' => [ 
            'name' =>         '[FIN]',    
            'description' =>  'Finance Department',    
         ],
         '4' => [ 
            'name' =>         '[BIT]',        
            'description' =>  'BIT Department',        
         ],
         '5' => [ 
            'name' =>         '[MGMT]', 
            'description' =>  'Management Department', 
         ],
         '6' => [ 
            'name' =>         '[MCSM]',       
            'description' =>  'MCSM Department',       
         ],
      ];      
      
      $actionAccess = [ 
         '1' => [ 
            'id'           =>  '1',
            'name'         =>  '[Cre]', 
            'description'  =>  'Create Permission',
         ],
         '2' => [ 
            'id'           => '2',
            'name'         => '[Rea]', 
            'description'  => 'Read-Only Permission',
         ],
         '3' => [ 
            'id'           => '3',
            'name'         => '[Upd]', 
            'description'  => 'Update Permission',
         ],
         '4' => [ 
            'id'           => '4',         
            'name'         => '[sDel]', 
            'description'  => 'Soft-Delete (flag) Permission',
         ],
         '5' => [ 
            'id'           => '5',         
            'name'         => '[hDel]', 
            'description'  => 'Hard-Delete (row removal) Permission',
         ],
         '6' => [ 
            'id'           => '6',         
            'name'         => '[Bac]',
            'description'  => 'Remote Backup Permission',
         ],
         '7' => [ 
            'id'           => '7',         
            'name'         => '[Rol]',
            'description'  => 'Role Assignment Permission',
         ],         
      ];


      $roleCareerLevels = [ 
         $careerLevelAccess[1]['name'], 
         $careerLevelAccess[2]['name'], 
         '[Framework]' 
      ];
      
      $rolePermissions  = [ 
         $actionAccess[1]['name'],
         $actionAccess[2]['name'],
         $actionAccess[3]['name'],
         $actionAccess[4]['name'],
         $actionAccess[5]['name'],
         $actionAccess[6]['name'],
         $actionAccess[7]['name'],
      ];         
            
      $roleAccess = [
         '1' => [ 
            'name'         => 'Student-Undergraduate-1', 
            'description'  => $roleCareerLevels[0] . ' Student (' . 
               $actionAccess[2]['name'] . 
            ')',
            'system'       => [
               $systemsAccess[1]['name'],
            ],
         ],
         
         '2' => [ 
            'name'         => 'Student-Graduate-1', 
            'description'  => $roleCareerLevels[1] . ' Student (' . 
               $actionAccess[2]['name'] . 
            ')',
            'system'       => [
               $systemsAccess[1]['name'],
            ],
         ],
         
         '3' => [ 
            'name'         => 'Academic-Advisor-' . $roleCareerLevels[0] . '-2', 
            'description'  => $roleCareerLevels[0] . ' Academic Advisor (' . 
               $actionAccess[1]['name'] . $actionAccess[2]['name'] . $actionAccess[3]['name'] . 
            ')',
            'system'       => [
               $systemsAccess[1]['name'],
            ],
         ],         
                  
         '4' => [ 
            'name'         => 'Academic-Advisor-' . $roleCareerLevels[1] . '-2', 
            'description'  => $roleCareerLevels[1] . ' Academic Advisor (' . 
               $actionAccess[1]['name'] . $actionAccess[2]['name'] . $actionAccess[3]['name'] . 
            ')',
            'system'       => [
               $systemsAccess[1]['name'],
            ],
         ],
         
         '5' => [ 
            'name'         => 'Power-User-Academic-Advisor-' . $roleCareerLevels[0] . '-3', 
            'description'  => $roleCareerLevels[0] . ' Academic Advisor-Power User (' . 
               $actionAccess[1]['name'] . $actionAccess[2]['name'] . $actionAccess[3]['name'] . 
               $actionAccess[4]['name'] .  
            ')',
            'system'       => [
               $systemsAccess[1]['name'],
            ],
         ],
         
         '6' => [ 
            'name'         => 'Power-User-Academic-Advisor-' . $roleCareerLevels[1] . '-3', 
            'description'  => $roleCareerLevels[1] . ' Academic Advisor-Power User (' . 
               $actionAccess[1]['name'] . $actionAccess[2]['name'] . $actionAccess[3]['name'] . 
               $actionAccess[4]['name'] .  
            ')',
            'system'       => [
               $systemsAccess[1]['name'],
            ],
         ],         

         '9' => [ 
            'name'         => 'Framework-Admin-9', 
            'description'  => $roleCareerLevels[2] . ' Assistant Admin (' . 
               $actionAccess[1]['name'] . $actionAccess[2]['name'] . $actionAccess[3]['name'] . $actionAccess[4]['name'] .
               $actionAccess[6]['name'] . $actionAccess[7]['name'] .
            ')',
            'system'       => [
               $systemsAccess[1]['name'],
               $systemsAccess[2]['name'],
               $systemsAccess[3]['name'],
            ],
         ],
         
         '10' => [ 
            'name' =>   'Framework-Administrator-10', 
            'description'  => $roleCareerLevels[2] . ' Admin (' . 
               $actionAccess[1]['name'] . $actionAccess[2]['name'] . $actionAccess[3]['name'] . $actionAccess[4]['name'] .
               $actionAccess[5]['name'] . $actionAccess[6]['name'] . $actionAccess[7]['name'] .
            ')',
            'system'       => [
               '1' => $systemsAccess[1]['name'],
               '2' => $systemsAccess[2]['name'],
               '3' => $systemsAccess[3]['name'],
            ],         
         ],
      ];      

//      $systemsList      = [];
//      $careerLevelList  = [];
//      $departmentList   = [];    
//      $actionList       = [];  
      
      $rolesList        = [];

      /**
       *    Adding permissions to {auth_item}
       *******/

      $permissionsList  = [];
      
      foreach( $systemsAccess as $system )
      {

         $systemChk = [
            '1'  => strcmp( $system['name'], $systemsAccess[1]['name'] ),
            '2'  => strcmp( $system['name'], $systemsAccess[2]['name'] ),
            '3'  => strcmp( $system['name'], $systemsAccess[3]['name'] ),
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
