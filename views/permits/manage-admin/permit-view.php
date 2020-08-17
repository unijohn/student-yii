<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   

   use yii\widgets\ActiveForm;
   
   $this->title = 'Permits | Manage-Admin | View | Update';
   $this->params['breadcrumbs'][] = [ 'label' => $this->title, 'url' =>['index']];
   
   $formatter = \Yii::$app->formatter;
   
//   $isActive['-1']   = 'Select Status';
   $isActive['1']    = 'Active';
   $isActive['0']    = 'Inactive';   
   
//   $isHidden['-1']   = 'Select Status';
   $isHidden['1']    = 'Visible';
   $isHidden['0']    = 'Hidden';   
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>

      <?= $this->render('/common/_alert', ['data' => $data]); ?>
      
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>
 
      <div class="permits-edit">
          <?php $form = ActiveForm::begin([
              'action' => ['save'],
              'method' => 'post',
          ]); ?>

<?php
   /**
    *    Cludgy and possibly insecure way to handle passing row ID between form and controllers.
    *    To be revisited.
    **/
 ?>
          
         <?= Html::hiddenInput('SystemCodes[id]', $model->id) ?>
         <?= Html::hiddenInput('id', $model->id) ?>

         <div class="form-group field-code">
            <label class="control-label" for="SystemCodes[code]">Code</label>
            <?= Html::input('text', 'SystemCodes[code]', $model->code, ['id' => 'code', 'class' => 'form-control']) ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group field-description">
            <label class="control-label" for="SystemCodes[description]">Description</label>
            <?= Html::input('text', 'SystemCodes[description]', $model->description, ['id' => 'description', 'class' => 'form-control']) ?>   
            <div class="help-block"></div>
         </div>
            
         <div class="form-group field-is_active">
         <label class="control-label" for="is_active">Is Active</label>
            <?= Html::dropDownList('SystemCodes[is_active]', $model->is_active, 
               $isActive,
               [
                  'id'     => 'is_active',
                  'class'  => 'form-control',
               ]) 
            ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group field-is_hidden">
         <label class="control-label" for="is_hidden">Is Visible</label>
            <?= Html::dropDownList('SystemCodes[is_hidden]', $model->is_hidden, 
               $isHidden,
               [
                  'id'     => 'is_hidden',
                  'class'  => 'form-control',
               ]) 
            ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group field-dates">
            <div>
               <?php echo( "created_at: "  . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
            </div>
            <div>
               <?php echo( "updated_at: "  . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
            </div>
            <div>
               <?php echo( "deleted_at: "  . $formatter->asDate( $model->deleted_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
            </div>            
         </div>
    
         <div class="form-group">
            <?= Html::submitButton('Save Changes', [
               'class'  => 'btn btn-primary',
               'id'     => 'savePermitBtn',
               'name'   => 'Permit[savePermit]',
               'value'  => 'savePermit'
            ]) ?>
         </div>
         
         <?php ActiveForm::end(); ?> 
      </div>
 
      <h3>Drop Permit Tag</h3>
      <div id='permits-tags-drop-form'>      
         <?= $this->render('_permits-tags-drop', ['data' => $data, 'model' => $tags]); ?>
      </div>  

      <h3>Add Permit Tag</h3>
      <div id='permits-tags-add-form'>      
         <?= $this->render('_permits-tags-add', ['data' => $data, 'model' => $allTags]); ?>
      </div>

      <code><?= __FILE__ ?></code>
         
   </div>
