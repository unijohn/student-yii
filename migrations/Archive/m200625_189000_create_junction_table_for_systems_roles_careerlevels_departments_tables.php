<?php

use yii\db\Migration;

/**
 * Handles the creation of table `systems_roles_careerlevels_departments`.
 * Has foreign keys to the tables:
 *
 * - `tbl_systems`
 * - `tbl_roles`
 */
class m200625_189000_create_junction_table_for_systems_roles_careerlevels_departments_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('junction_systems_roles_careerlevels_departments', [
            'id'              => $this->primaryKey(),
            'systems_id'      => $this->integer(),
            'careerlevels_id' => $this->integer(),
            'departments_id'  => $this->integer(),
            'roles_id'        => $this->integer(),
            'created_at'      => $this->dateTime(),
        ]);

        // creates index for column `systems_id`
        $this->createIndex(
            'idx-systems_id',
            'junction_systems_roles_careerlevels_departments',
            'systems_id'
        );

        // add foreign key for table `tbl_Systems`
        /**
                $this->addForeignKey(
                    'fk-systems_roles_id',
                    'junction_systems_roles_careerlevels_departments',
                    'systems_id',
                    'tbl_Systems',
                    'id',
                    'CASCADE'
                );
         **/

        // creates index for column `roles_id`
        $this->createIndex(
            'idx-roles_id',
            'junction_systems_roles_careerlevels_departments',
            'roles_id'
        );

        /**
                // add foreign key for table `tbl_Roles`
                $this->addForeignKey(
                    'fk-roles_id',
                    'junction_systems_roles_careerlevels_departments',
                    'roles_id',
                    'tbl_Roles',
                    'id',
                    'CASCADE'
                );
         **/
 
        // creates index for column `careerlevels_id`
        $this->createIndex(
            'idx-careerlevels_id',
            'junction_systems_roles_careerlevels_departments',
            'careerlevels_id'
        );

        /**
                // add foreign key for table `careerlevels_id`
                $this->addForeignKey(
                    'fk-careerlevels_id',
                    'junction_systems_roles_careerlevels_departments',
                    'careerlevels_id',
                    'tbl_CareerLevels',
                    'id',
                    'CASCADE'
                );
         **/
 
        // creates index for column `careerlevels_id`
        $this->createIndex(
            'idx-departments_id',
            'junction_systems_roles_careerlevels_departments',
            'departments_id'
        );

        /**
                // add foreign key for table `departments_id`
                $this->addForeignKey(
                    'fk-departments_id',
                    'systems_roles_careerlevels_departments',
                    'departments_id',
                    'tbl_Departments',
                    'id',
                    'CASCADE'
                );
         **/
 
        $columns = [ 'systems_id', 'careerlevels_id', 'departments_id', 'roles_id', 'created_at'];
              
        $query_systems = (new \yii\db\Query())
            ->select([ 'id', 'code' ])
            ->from('tbl_Systems');
            
        $query_roles = (new \yii\db\Query())
            ->select([ 'id', 'role' ])
            ->from('tbl_Roles');
            
        $query_careerlevels = (new \yii\db\Query())
            ->select([ 'id', 'code' ])
            ->from('tbl_CareerLevel');
            
        $query_departments = (new \yii\db\Query())
            ->select([ 'id', 'code' ])
            ->from('tbl_Departments');

        $rows = [];
         
//         print_r($query_systems->all());
//         print_r($query_roles->all());

        foreach ($query_systems->each() as $row_system) {
            foreach ($query_roles->each() as $row_role) {
                foreach ($query_careerlevels->each() as $row_careerlevel) {
                    foreach ($query_departments->each() as $row_department) {
                        $data = [ $row_system['id'], $row_careerlevel['id'], $row_department['id'], $row_role['id'], date("Y-m-d H:i:s") ];
                        $rows[] = $data;
                    }
                }
            }
        }
         
//         print_r( $rows );
 
        $this->batchInsert('junction_systems_roles_careerlevels_departments', $columns, $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /**
                // drops foreign key for table `tbl_Systems`
                $this->dropForeignKey(
                    'fk-systems_id',
                    'junction_systems_roles_careerlevels_departments'
                );
         **/

        // drops index for column `systems_id`
        $this->dropIndex(
            'idx-systems_id',
            'junction_systems_roles_careerlevels_departments'
        );

        /**
                // drops foreign key for table `tbl_Roles`
                $this->dropForeignKey(
                    'fk-roles_id',
                    'junction_systems_roles_careerlevels_departments'
                );
         **/

        // drops index for column `systems_id`
        $this->dropIndex(
            'idx-systems_id',
            'junction_systems_roles_careerlevels_departments'
        );

        /**
                // drops foreign key for table `tbl_CareerLevels`
                $this->dropForeignKey(
                    'fk-careerlevels_id',
                    'junction_systems_roles_careerlevels_departments'
                );
         **/

        // drops index for column `roles_id`
        $this->dropIndex(
            'idx-careerlevels_id',
            'junction_systems_roles_careerlevels_departments'
        );
        
        /**
                // drops foreign key for table `tbl_Departments`
                $this->dropForeignKey(
                    'fk-departments_id',
                    'junction_systems_roles_careerlevels_departments'
                );
         **/

        // drops index for column `departments_id`
        $this->dropIndex(
            'idx-departments_id',
            'junction_systems_roles_careerlevels_departments'
        );

        $this->dropTable('junction_systems_roles_careerlevels_departments');
    }
}
