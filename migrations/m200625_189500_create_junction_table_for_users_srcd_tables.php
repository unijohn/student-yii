<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_srcd`.
 * Has foreign keys to the tables:
 *
 * - `tbl_systems`
 * - `tbl_roles`
 */
class m200625_189500_create_junction_table_for_users_srcd_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('junction_users_srcd', [
            'id'              => $this->primaryKey(),
            'users_id'        => $this->integer(),
            'srcd_id'         => $this->integer(),
            'created_at'      => $this->dateTime(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            'idx-users_id',
            'junction_users_srcd',
            'users_id'
        );

        // add foreign key for table `tbl_Users`
/**        
        $this->addForeignKey(
            'fk-users_id',
            'junction_users_srcd',
            'users_id',
            'tbl_Users',
            'id',
            'CASCADE'
        );
 **/

        // creates index for column `srcd_id`
        $this->createIndex(
            'idx-srcd_id',
            'junction_users_srcd',
            'srcd_id'
        );

/**
        // add foreign key for table `tbl_Roles`
        $this->addForeignKey(
            'fk-srcd_id',
            'junction_users_srcd',
            'srcd_id',
            'systems_roles_careerlevels_departments',
            'id',
            'CASCADE'
        );
 **/
 
         $columns = [ 'users_id', 'srcd_id', 'created_at'];

         $query_users = (new \yii\db\Query())
            ->select([ 'id', 'uuid' ])
            ->from( 'tbl_Users' )
            ->where( 'uuid=:uuid' )
               ->addParams( [':uuid' => 'adminusr'] );

         $query_roles = (new \yii\db\Query())
            ->select([ 'srcd.id' ])
            ->from( 'junction_systems_roles_careerlevels_departments srcd' )
            ->innerJoin( 'tbl_Roles', 'tbl_Roles.id = srcd.roles_id' )
            ->where( 'tbl_Roles.name=:name' )
               ->addParams( ['name' => 'Administrator'] );

/**               
         $query_careerlevels = (new \yii\db\Query())
            ->select([ 'id', 'code' ])
            ->from( 'tbl_CareerLevel' );       
            
         $query_departments = (new \yii\db\Query())
            ->select([ 'id', 'code' ])
            ->from( 'tbl_Departments' );                         
 **/
 
         $rows = [];

/**
         foreach( $query_users->each() as $row_user )
         {
            foreach( $query_roles->each() as $row_role )
            {
               foreach( $query_careerlevels->each() as $row_careerlevel )
               {
                  foreach( $query_departments->each() as $row_department )
                  {
                     $data = [ $row_system['id'], $row_careerlevel['id'], $row_department['id'], $row_role['id'], date("Y-m-d H:i:s") ];
                     $rows[] = $data;
                  }
               }
            }
         }
 **/

         foreach( $query_users->each() as $row_user )
         {
            foreach( $query_roles->each() as $row_role )
            {
               $data = [ $row_user['id'], $row_role['id'], date("Y-m-d H:i:s") ];
               $rows[] = $data;
            }
         }
  
         $this->batchInsert( 'junction_users_srcd', $columns, $rows );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
/**    
        // drops foreign key for table `tbl_Systems`
        $this->dropForeignKey(
            'fk-users_id',
            'junction_users_srcd'
        );
 **/

        // drops index for column `systems_id`
        $this->dropIndex(
            'idx-srcd_id',
            'junction_users_srcd'
        );

/**
        // drops foreign key for table `tbl_Roles`
        $this->dropForeignKey(
            'fk-srcd_id',
            'junction_users_srcd'
        );
 **/

        // drops index for column `systems_id`
        $this->dropIndex(
            'idx-srcd_id',
            'junction_users_srcd'
        );   

        $this->dropTable('junction_users_srcd');
    }
}
