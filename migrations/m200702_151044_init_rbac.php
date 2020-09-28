<?php

namespace app\migrations;

use app\modules\Consts;

/**
 * Class m200702_151044_init_rbac
 */
class m200702_151044_init_rbac extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         *    createPermissions:  systems level
         **/

        $systemsAccess =
        [
            self::SYS_FRAMEWORKID =>
            [
                'id'           => self::SYS_FRAMEWORKID,
                'key'          => '[Framework]',
                'name'         => '[Framework]',
                'description'  => 'Framework selfServe',
            ],
            self::SYS_STUDENTID =>
            [
                'id'           => self::SYS_STUDENTID,
                'key'          => '[Student]',
                'name'         => '[Student]',
                'description'  => 'Student selfServe',
            ],
            self::SYS_FACULTYID =>
            [
                'id'           => self::SYS_FACULTYID,
                'name'         => '[Faculty]',
                'key'          => '[Faculty]',
                'description'  => 'Faculty selfServe',
            ],
            self::SYS_ADMINISTRATIONID =>
            [
                'id'           => self::SYS_ADMINISTRATIONID,
                'name'         => '[Administration]',
                'key'          => '[Administration]',
                'description'  => 'Administration selfServe',
            ],
        ];
      
        $careerLevelAccess =
        [
            Consts::CODE_ITEM_CAREERLEVEL_UGAD =>
            [
                'id'           => Consts::CODE_ITEM_CAREERLEVEL_UGAD,
                'name'         => '[UGAD]',
                'key'          => '[UGAD]',
                'description'  => 'Undergraduate Career Level',
            ],
            Consts::CODE_ITEM_CAREERLEVEL_GRAD =>
            [
                'id'           => Consts::CODE_ITEM_CAREERLEVEL_GRAD,
                'name'         => '[GRAD]',
                'key'          => '[GRAD]',
                'description'  => 'Graduate Career Level',
            ],
            Consts::CODE_ITEM_CAREERLEVEL_PHD =>
            [
                'id'           => Consts::CODE_ITEM_CAREERLEVEL_PHD,
                'name'         => '[PHD]',
                'key'          => '[PHD]',
                'description'  => 'Doctorate Career Level',
            ],
        ];

        $departmentAccess =
        [
            Consts::CODE_ITEM_DEPT_SCHOOL_ACCT =>
            [
                'id'              => Consts::CODE_ITEM_DEPT_SCHOOL_ACCT,
                'key'             => '[ACCT]',
                'name'            => '[ACCT]',
                'description'     => 'Accounting Department',
            ],
            Consts::CODE_ITEM_DEPT_SCHOOL_ECON =>
            [
                'id'              => Consts::CODE_ITEM_DEPT_SCHOOL_ECON,
                'key'             => '[ECON]',
                'name'            => '[ECON]',
                'description'     => 'Economics Department',
            ],
            Consts::CODE_ITEM_DEPT_SCHOOL_FIR =>
            [
                'id'              => Consts::CODE_ITEM_DEPT_SCHOOL_FIR,
                'key'             => '[FIN]',
                'name'            => '[FIN]',
                'description'     => 'Finance Department',
            ],
            Consts::CODE_ITEM_DEPT_SCHOOL_BITM =>
            [
                'id'              => Consts::CODE_ITEM_DEPT_SCHOOL_BITM,
                'key'             => '[BIT]',
                'name'            => '[BIT]',
                'description'     => 'BIT Department',
            ],
            Consts::CODE_ITEM_DEPT_SCHOOL_MGMT =>
            [
                'id'              => Consts::CODE_ITEM_DEPT_SCHOOL_MGMT,
                'key'             => '[MGMT]',
                'name'            => '[MGMT]',
                'description'     => 'Management Department',
            ],
            Consts::CODE_ITEM_DEPT_SCHOOL_MSCM =>
            [
                'id'              => Consts::CODE_ITEM_DEPT_SCHOOL_MSCM,
                'key'             => '[MCSM]',
                'name'            => '[MCSM]',
                'description'     => 'MCSM Department',
            ],
        ];
      
        $featureAccess =
        [
            self::FEATURE_PERMIT =>
            [
                'id'              => self::FEATURE_PERMIT,
                'key'             => '[Permit]',
                'name'            => '[Permit]',
                'description'     => 'Permit Feature',
            ],
            self::FEATURE_GAAAP =>
            [
                'id'              => self::FEATURE_GAAAP,
                'key'             => '[GAApp]',
                'name'            => '[GAApp]',
                'description'     => 'Graduate Assistant Applications',
            ],
            self::FEATURE_SYLLA =>
            [
                'id'              => self::FEATURE_SYLLA,
                'key'             => '[Sylla]',
                'name'            => '[Sylla]',
                'description'     => 'Course Syllabi',
            ],
            self::FEATURE_COURSEASSIGN =>
            [
                'id'              => self::FEATURE_COURSEASSIGN,
                'key'             => '[RAssign]',
                'name'            => '[RAssign]',
                'description'     => 'Course Assignment',
            ],
        ];

        $actionAccess =
        [
            self::ACTION_ACCESS =>
            [
                'id'           => self::ACTION_ACCESS,
                'key'          => '[Access]',
                'name'         => '[Access]',
                'description'  => '(System) Access Permission',
            ],
            self::ACTION_CREATE =>
            [
                'id'           => self::ACTION_CREATE,
                'key'          => '[Create]',
                'name'         => '[Create]',
                'description'  => 'Create Permission',
            ],
            self::ACTION_READ =>
            [
                'id'           => self::ACTION_READ,
                'key'          => '[Read]',
                'name'         => '[Read]',
                'description'  => 'Read-Only Permission',
            ],
            self::ACTION_UPDATE =>
            [
                'id'           => self::ACTION_UPDATE,
                'key'          => '[Update]',
                'name'         => '[Update]',
                'description'  => 'Update Permission',
            ],
            self::ACTION_sDELETE =>
            [
                'id'           => self::ACTION_sDELETE,
                'key'          => '[sDelete]',
                'name'         => '[sDelete]',
                'description'  => 'Soft-Delete (flag) Permission',
            ],
            self::ACTION_hDELETE =>
            [
                'id'           => self::ACTION_hDELETE,
                'key'          => '[hDelete]',
                'name'         => '[hDelete]',
                'description'  => 'Hard-Delete (row removal) Permission',
            ],
            self::ACTION_BACKUP =>
            [
                'id'           => self::ACTION_BACKUP,
                'key'          => '[Backup]',
                'name'         => '[Backup]',
                'description'  => 'Remote Backup Permission',
            ],
            self::ACTION_ROLE =>
            [
                'id'           => self::ACTION_ROLE,
                'key'          => '[Role]',
                'name'         => '[Role]',
                'description'  => 'Role Assignment Permission',
            ],
            self::ACTION_SYNCH =>
            [
                'id'           => self::ACTION_SYNCH,
                'key'          => '[Synch]',
                'name'         => '[Synch]',
                'description'  => 'Data Warehouse Sync Permission',
            ],
            self::ACTION_MANAGE =>
            [
                'id'           => self::ACTION_MANAGE,
                'key'          => '[Manage]',
                'name'         => '[Manage]',
                'description'  => 'System-Feature Management Permission',
            ],
        ];

     
        $permissionsList = [];
        
        foreach ($systemsAccess as $system) {
            foreach ($actionAccess as $action) {
                foreach ($careerLevelAccess as $career) {
                    $newPermission =
                    [
                        'system'          =>
                        [
                            'name'         => $system['name'],
                            'description'  => $system['description'],
                        ],
                        'action'          =>
                        [
                            'name'         => $action['name'],
                            'description'  => $action['description'],
                        ],
                        'career'          =>
                        [
                            'name'         => $career['name'],
                            'description'  => $career['description'],
                        ],
                        'department'      => [],
                        'feature'         => [],
                    ];
                    $permissionsList[] = $newPermission;
                }
                    
                foreach ($departmentAccess as $department) {
                    $newPermission =
                    [
                        'system'       =>
                        [
                            'name'         => $system['name'],
                            'description'  => $system['description'],
                        ],
                        'action'       =>
                        [
                            'name'         => $action['name'],
                            'description'  => $action['description'],
                        ],
                        'department'   =>
                        [
                            'name'         => $department['name'],
                            'description'  => $department['description'],
                        ],
                        'career'          => [],
                        'feature'         => [],
                    ];
                    $permissionsList[] = $newPermission;
                }
                    
                foreach ($featureAccess as $feature) {
                    $newPermission =
                    [
                        'system'          =>
                        [
                            'name'         => $system['name'],
                            'description'  => $system['description'],
                        ],
                        'action'          =>
                        [
                            'name'         => $action['name'],
                            'description'  => $action['description'],
                        ],
                        'feature'         =>
                        [
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

        foreach ($permissionsList as $permission) {
            $newKey           = $permission['system']['name'] . $permission['action']['name'];
            $newDescription   = $permission['system']['description'] . "-" . $permission['action']['description'];
         
            if (isset($permission['career']['name']) && !empty($permission['career']['name'])) {
                $newKey           .= $permission['career']['name'];
                $newDescription   .= "-" . $permission['career']['description'];
            }

            if (isset($permission['department']['name']) && !empty($permission['department']['name'])) {
                $newKey           .= $permission['department']['name'];
                $newDescription   .= "-" . $permission['department']['description'];
            }

            if (isset($permission['feature']['name']) && !empty($permission['feature']['name'])) {
                $newKey           .= $permission['feature']['name'];
                $newDescription   .= "-" . $permission['feature']['description'];
            }

            $newPerm = $this->_auth->createPermission($newKey);
            $newPerm->description = $newDescription;
      
            $this->_auth->add($newPerm);
         
            $newAuthItem = [
            'key'             => $newKey,
            'description'     => $newDescription,
            'permission'      => $newPerm,
         ];
         
            $permAuthList[$newKey] = $newAuthItem;
        }
 
        $roleAccess =
        [
            self::ROLE_ADMIN =>
            [
                'id'              =>self::ROLE_ADMIN,
                'name'            => 'Framework-Administrator',
                'description'     => 'Framework Administrator (10)',
                'allEverything'   => true,
            ],
            self::ROLE_GENERIC =>
            [
                'id'              =>self::ROLE_GENERIC,
                'name'            => 'Generic | Unknown User',
                'description'     => 'Unidentified User (0)',
                'allEverything'   => false,
                'permissions'     =>
                [
                ],
            ],
            self::ROLE_UGAD_STUDENT =>
            [
                'id'              => self::ROLE_UGAD_STUDENT,
                'name'            => 'Student-Undergraduate',
                'description'     => 'Undergraduate Student (1)',
                'allEverything'   => false,
                'permissions'     =>
                [
                    //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
                    $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $featureAccess[self::FEATURE_PERMIT]['key'],
    
                    //    2:  Student Self Serve                . 1: Access                         . 1:  UGAD
                    $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_UGAD]['key'],
                ],
            ],
            self::ROLE_GRAD_STUDENT =>
            [
                'id'              => self::ROLE_GRAD_STUDENT,
                'name'            => 'Student-Graduate',
                'description'     => 'Graduate Student (1)',
                'allEverything'   => false,
                'permissions'     =>
                [
                    //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
                    $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $featureAccess[self::FEATURE_PERMIT]['key'],
                    
                    //    2:  Student Self Serve                . 1: Access                         . 2:  GRAD
                    $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_GRAD]['key'],
                ],
            ],
            self::ROLE_PHD_STUDENT =>
            [
                'id'              => self::ROLE_PHD_STUDENT,
                'name'            => 'Student-Doctorate',
                'description'     => 'Doctorate Student (1)',
                'allEverything'   => false,
                'permissions'     =>
                [
                    //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
                    $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $featureAccess[self::FEATURE_PERMIT]['key'],
                    
                    //    2:  Student Self Serve                . 1: Access                         . 3:  PHD
                    $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_PHD]['key'],
                ],
            ],
         self::ROLE_UGAD_ADVISOR => [
            'id'              => self::ROLE_UGAD_ADVISOR,
            'name'            => 'Academic-Advisor-Undergraduate',
            'description'     => 'Undergraduate Advisor (2)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $featureAccess[self::FEATURE_PERMIT]['key'],

         //    2:  Student Self Serve                . 1: Access                         . 1:  UGAD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_UGAD]['key'],
                      
         //    2:  Student Self Serve                . 2: Create                         . 1:  UGAD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_CREATE]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_UGAD]['key'],
               
         //    2:  Student Self Serve                . 4: Update                         . 1:  UGAD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_UPDATE]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_UGAD]['key'],
            ],
         ],
         self::ROLE_GRAD_ADVISOR => [
            'id'              => self::ROLE_GRAD_ADVISOR,
            'name'            => 'Academic-Advisor-Graduate',
            'description'     => 'Graduate Advisor (2)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $featureAccess[self::FEATURE_PERMIT]['key'],
       
         //    2:  Student Self Serve                . 1:  Access                        . 2:  GRAD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_GRAD]['key'],
               
         //    2:  Student Self Serve                . 2: Create                         . 2:  GRAD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_CREATE]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_GRAD]['key'],
               
         //    2:  Student Self Serve                . 4: Update                         . 2:  GRAD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_UPDATE]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_GRAD]['key'],
            ],
         ],
         self::ROLE_PHD_ADVISOR => [
            'id'              => self::ROLE_PHD_ADVISOR,
            'name'            => 'Academic-Advisor-PhD',
            'description'     => 'PhD Advisor (2)',
            'allEverything'   => false,
            'permissions'     => [
         //    2:  Student Self Serve                . 1: Access                         . 1:  Permits
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $featureAccess[self::FEATURE_PERMIT]['key'],
       
         //    2:  Student Self Serve                . 1:  Access                        . 3:  PHD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_ACCESS]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_PHD]['key'],
               
         //    2:  Student Self Serve                . 2: Create                         . 3:  PHD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_CREATE]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_PHD]['key'],
               
         //    2:  Student Self Serve                . 4: Update                         . 3:  PHD
               $systemsAccess[self::SYS_STUDENTID]['key'] . $actionAccess[self::ACTION_UPDATE]['key'] . $careerLevelAccess[Consts::CODE_ITEM_CAREERLEVEL_PHD]['key'],
            ],
         ],
      ];
      
        
        $roleAuthList  = [];
        foreach ($roleAccess as $role) {
            $roleRole               = $this->_auth->createRole($role['name']);
            $roleRole->description  = $role['description'];

            $newRoleChild =
            [
                'role'      => $roleRole,
            ];
         
            $roleAuthList[] = $newRoleChild;
         
            $this->_auth->add($roleRole);

            /**
             *    All permissions for all systems, features, careers, departments for this role
             **/
            if (isset($role['allEverything']) && !empty($role['allEverything'])) {
                if ($role['allEverything']) {
                    foreach ($permAuthList as $permAuth) {
                        $this->_auth->addChild($roleRole, $permAuth['permission']);
                    }
                }
            } else {
                foreach ($role['permissions'] as $permItem) {
                    $this->_auth->addChild($roleRole, $permAuthList[$permItem]['permission']);
                }
            }
        }

        $frameworkRole = $this->_auth->getRole('Framework-Administrator');
        
        $this->_auth->assign($this->_auth->getRole('Framework-Administrator'), 7);
        
        $this->_auth->assign($this->_auth->getRole('Student-Undergraduate'), 1);
        $this->_auth->assign($this->_auth->getRole('Student-Graduate'), 2);
        $this->_auth->assign($this->_auth->getRole('Academic-Advisor-Undergraduate'), 3);
        $this->_auth->assign($this->_auth->getRole('Academic-Advisor-Graduate'), 5);
    }

   
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /**
         * The tables used in this migration are found at:  @yii/rbac/migrations/
         **/
    
        $this->_auth->removeAll();
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
