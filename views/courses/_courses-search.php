<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\FormFields;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $pageCount['25']  = 25;
   $pageCount['50']  = 50;
   $pageCount['100'] = 100;
   $pageCount['200'] = 200;
   
   $isActive    = FormFields::getSelectOptions(-1, 'is_active',  false);
   $isVisible   = FormFields::getSelectOptions(-1, 'is_visible', false);   

   $subjectArea['ZZZZ']   = 'Select Subject';
   foreach ($model_subjects as $area) {
       $subjectArea[ $area['subject_area'] ] = $area['subject_area'];
   }
   
?>


<style>
.inline-label {
    white-space: nowrap;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    float:left;  
}
</style>

<div class="courses-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


   <div class="form-group form-inline field-subject_area" style="!white-space:nowrap;">
   <label class="control-label" for="Courses[subject_area]">Subject</label>
      <?= Html::dropDownList(
        'Courses[subject_area]',
        $data['subject_area'],
        $subjectArea,
        [
            'id'     => 'subject',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
    )
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group form-inline field-course_number">
      <label class="control-label" for="Courses[course_number]">Course</label>
      <?= Html::input(
          'text',
          'Courses[course_number]',
          $data['course_number'],
          [
            'id'     => 'course_number',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
            'value'  => $data['course_number'],
         ]
      )
      ?>   
      <div class="help-block"></div>
   </div>   
         
   <div class="form-group form-inline field-is_active" style="!white-space:nowrap;">
   <label class="control-label" for="Courses[is_active]">Is Active</label>
      <?= Html::dropDownList(
          'Courses[is_active]',
          $data['is_active'],
          $isActive,
          [
            'id'     => 'is_active',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
      )
      ?>
      <div class="help-block"></div>
   </div>
   
   <div class="form-group form-inline field-is_hidden" style="!white-space:nowrap;">
   <label class="control-label" for="Courses[is_visible]">Is Visible</label>
      <?= Html::dropDownList(
          'Courses[is_visible]',
          $data['is_visible'],
          $isVisible,
          [
            'id'     => 'is_hidden',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
      )
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group form-inline field-pagination_count">
   <label class="control-label" for="Courses[pagination_count]"># per Page</label>
      <?= Html::dropDownList(
          'Courses[pagination_count]',
          $data['pagination_count'],
          $pageCount,
          [
            'id'     => 'pagination_count',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
      )
      ?>
      <div class="help-block"></div>
   </div>

    <div class="form-group" style="float:right;">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'style' => 'margin-right: 20px; width: 95px;']) ?>
        <?= Html::a('Reset', ['/courses/index'], ['class'=>'btn btn-default', 'style' => 'width: 95px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
