<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   

   $this->title = 'Framework | User | View | Update';
   $this->params['breadcrumbs'][] = $this->title;
   
   $formatter = \Yii::$app->formatter;   
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>

<?php
   print( "<P> id: " . $model->id . "</p>" );
   print( "<P> UUID: " . $model->uuid . "</p>" );
   print( "<P> name: " . $model->name . "</p>" );   
   print( "<P> is_active: " . $model->is_active . "</p>" );
   print( "<P> access_token: " . $model->access_token . "</p>" );
   print( "<P> created_at: " . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
   print( "<P> updated_at: " . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );    
 ?>
 
   <h2>Assigned Roles</h2>
   
<?php
    
   foreach( $model->roles as $role )
      print( "<P>" . $role->item_name . "</p>" );
   
   print( "<pre>" );
   foreach( $allRoles as $role )
      print( "<p>" . $role->name. "</p>" );
   print( "</pre>" );
         

/*   
   print( "<pre>" );
   print_r( $allRoles );     
   print( "</pre>" );
 */
 
?>

      <h3>[Inside] _users-role-add</h3>
      <div id='users-roles-add-form'>      
         <?= $this->render('_users-roles-add', ['model' => $allRoles]); ?>      
      </div>
      <h3>[Eo] _users-role-add</h3>

      <code><?= __FILE__ ?></code>
         
   </div>
