<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;
   
   use yii\widgets\ActiveForm;

   $this->title = 'Framework | User | View | Update';
   $this->params['breadcrumbs'][] = [ 'label' => $this->title, 'url' =>['index']];
   
   
   $formatter = \Yii::$app->formatter;
   
//   $isActive['-1']   = 'Select Status';
   $isActive['1']    = 'Active';
   $isActive['0']    = 'Inactive';
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      
      <?= $this->render('/common/_alert', ['data' => $data]); ?>      
      
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>

<?php
//   print( "<P> id: " . $model->id . "</p>" );
   print( "<P> UUID: " . $model->uuid . "</p>" );
//   print( "<P> name: " . $model->name . "</p>" );   
//   print( "<P> is_active: " . $model->is_active . "</p>" );
//   print( "<P> access_token: " . $model->access_token . "</p>" );
//   print( "<P> created_at: " . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
//   print( "<P> updated_at: " . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );    
 ?>
 
<!-- NEW SECTION -->

      <div class="permits-edit">
         <?php $form = ActiveForm::begin([
               'action' => ['save'],
               'method' => 'post',
            ]);
         ?>

<?php
   /**
    *    Cludgy and possibly insecure way to handle passing row ID between form and controllers.
    *    To be revisited.
    **/
 ?>
          
         <?= Html::hiddenInput('User[uuid]', $model->uuid) ?>

         <div class="form-group field-code">
            <label class="control-label" for="User[access_token]">Access Token</label>
            <?= Html::input('text', 'User[access_token]', $model->access_token, ['id' => 'access_token', 'class' => 'form-control']) ?>
            <div class="help-block"></div>
         </div>

<!--         
         <div class="form-group field-description">
            <label class="control-label" for="SystemCodes[description]">Description</label>

            <div class="help-block"></div>
         </div>
 -->

         <div class="form-group field-is_active">
         <label class="control-label" for="is_active">Is Active</label>
            <?= Html::dropDownList('User[is_active]', $model->is_active, 
               $isActive,
               [
                  'id'     => 'is_active',
                  'class'  => 'form-control',
               ]) 
            ?>
            <div class="help-block"></div>
         </div>
       
<!--  
         <div class="form-group field-is_hidden">
         <label class="control-label" for="is_hidden">Is Visible</label>

            <div class="help-block"></div>
         </div>
 -->
         
         <div class="form-group field-dates">
            <div>
               <?php echo( "created_at: "  . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
            </div>
            <div>
               <?php echo( "updated_at: "  . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
            </div>
         </div>
    
         <div class="form-group">
            <?= Html::submitButton('Save Changes', [
               'class'  => 'btn btn-primary',
               'id'     => 'saveUserBtn',
               'name'   => 'User[saveUser]',
               'value'  => 'saveUser'
            ]) ?>
         </div>
         
         <?php ActiveForm::end(); ?> 
      </div>

      <h3>Drop User Roles</h3>
      <div id='users-roles-drop-form'>      
         <?= $this->render('_users-roles-drop', ['data' => $data, 'model' => $model->roles]); ?>      
      </div>  

      <h3>Add User Roles</h3>
      <div id='user-roles-add-form'>      
         <?= $this->render('_users-roles-add', ['data' => $data, 'model' => $allRoles]); ?>      
      </div>

      <code><?= __FILE__ ?></code>
         
   </div>
