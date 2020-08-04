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

<?php
/**
   print( "<P> id: "          . $model->id . "</p>" );
   print( "<P> code: "        . $model->code . "</p>" );
   print( "<P> description: " . $model->description . "</p>" );   
   print( "<P> is_active: "   . $model->is_active . "</p>" );
   print( "<P> created_at: "  . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
   print( "<P> updated_at: "  . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );    
   print( "<P> deleted_at: "  . $formatter->asDate( $model->deleted_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );    
 **/
 ?>
 
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
          
         <?= Html::hiddenInput('Courses[id]', $model->id) ?>
         <?= Html::hiddenInput('id', $model->id) ?>

         <div class="form-group form-inline field-subject_area">
            <label class="control-label" for="Courses[subject_area]">Subject</label>
            <?= Html::input('text', 'Courses[subject_area]', $model->subject_area, 
               [
                  'id'     => 'code',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-description">
            <label class="control-label" for="Courses[course_number]">Course</label>
            <?= Html::input('text', 'Courses[course_number]', $model->course_number, 
               [
                  'id'     => 'course_number',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-description">
            <label class="control-label" for="Courses[section_number]">Course</label>
            <?= Html::input('text', 'Courses[section_number]', $model->section_number, 
               [
                  'id'     => 'section_number', 
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>         
            
         <div class="form-group form-inline field-is_active">
         <label class="control-label" for="is_active">Is Active</label>
            <?= Html::dropDownList('Courses[is_active]', $model->is_active, 
               $isActive,
               [
                  'id'     => 'is_active',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]) 
            ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-is_hidden">
         <label class="control-label" for="is_hidden">Is Visible</label>
            <?= Html::dropDownList('Courses[is_hidden]', $model->is_hidden, 
               $isHidden,
               [
                  'id'     => 'is_hidden',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
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
               'id'     => 'saveCourseBtn',
               'name'   => 'Course[saveCourse]',
               'value'  => 'saveCourse'
            ]) ?>
         </div>
         
         <?php ActiveForm::end(); ?> 
      </div>
 
      <h3>Drop Permit Tag</h3>
      <div id='permits-tags-drop-form'>      

      </div>  

      <h3>Add Permit Tag</h3>
      <div id='permits-tags-add-form'>      

      </div>

      <code><?= __FILE__ ?></code>
         
   </div>
