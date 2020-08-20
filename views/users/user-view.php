<?php

/* @var $this yii\web\View */

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;
   
   use yii\widgets\ActiveForm;

   use app\controllers\CodesController;   

   $this->title = 'Framework | User | View | Update';
   
   $this->params['title']           = Yii::$app->name . " :: " . $this->title;   
   $this->params['breadcrumbs'][] = [ 'label' => $this->title, 'url' =>['index']];
   
   $formatter = \Yii::$app->formatter;
   
   $isActive   = CodesController::getDropDownOpts('is_active');
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      
      <?= $this->render('/common/_alert', ['data' => $data]); ?>      
      
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>

<?php
//   print( "<P> id: " . $model->id . "</p>" );
   print("<div style='display:inline-block; margin: auto; width: 20%;'> <strong>UUID</strong></div>" . PHP_EOL);
   print("<div style='display:inline;'>" . $model->uuid . "</div>" );
//   print( "<P> name: " . $model->name . "</p>" );
//   print( "<P> is_active: " . $model->is_active . "</p>" );
//   print( "<P> access_token: " . $model->access_token . "</p>" );
//   print( "<P> created_at: " . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
//   print( "<P> updated_at: " . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
 ?>
 
<!-- NEW SECTION -->

      <div class="user-edit">
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
            <?= Html::input(
                'text', 
                'User[access_token]', 
                $model->access_token, 
                [
                    'id'    => 'access_token', 
                    'class' => 'form-control',
                    'style' => 'width: 80%;float:right;'
                ]
            ) ?>
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
            <?= Html::dropDownList(
                'User[is_active]',
                $model->is_active,
                $isActive,
                [
                    'id'     => 'is_active',
                    'class'  => 'form-control',
                    'style' => 'width: 80%;float:right;'
               ]
            ) ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group field-dates">
            <div>
               <?php echo("created_at: "  . $formatter->asDate($model->created_at, 'MM-dd-yyyy HH:mm:ss')); ?>
            </div>
            <div>
               <?php echo("updated_at: "  . $formatter->asDate($model->updated_at, 'MM-dd-yyyy HH:mm:ss')); ?>
            </div>
         </div>
    
         <div class="form-group">
            <?= Html::submitButton('Save Changes', 
                [
                   'class'  => 'btn btn-primary',
                   'id'     => 'saveUserBtn',
                   'name'   => 'User[saveUser]',
                   'value'  => 'saveUser'
                ]
            ) ?>
         </div>
         
         <?php ActiveForm::end(); ?> 
      </div>

      <div class="row">
          <div class="col-lg-6">
              <h3>Drop User Roles</h3>
              <div id='users-roles-drop-form'>      
                 <?= $this->render('_users-roles-drop', ['data' => $data, 'model' => $model->roles]); ?>      
              </div>  
          </div>
          <div class="col-lg-6">
              <h3>Add User Roles</h3>
              <div id='user-roles-add-form'>      
                 <?= $this->render('_users-roles-add', ['data' => $data, 'model' => $allRoles]); ?>
              </div>
          </div>
      </div>

      <h3>Personal Information</h3>
      <div id='user-personal-edit-form'>      
          <?= $this->render('_users-personal-viewadd', ['data' => $data, 'model' => $userPersonal]); ?>
      </div>               
      

      <p>
          <code><?= __FILE__ ?></code>
      </p>
         
   </div>
