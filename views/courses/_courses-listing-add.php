<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="courses-add-new-course">
    <?php $form = ActiveForm::begin([
        'action' => ['add'],
        'method' => 'post',
    ]); ?>

    <?=  $form->field($model, 'subject_area')
            ->textInput(
                [
               'id'     => 'subject_area',
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;',
            ]
            ) ?>
         
    <?=  $form->field($model, 'course_number')
            ->textInput(
                [
               'id'     => 'course_number',
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;',
            ]
            ) ?>
         
    <?=  $form->field($model, 'section_number')
            ->textInput(
                [
               'id'     => 'section_number',
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;',
            ]
            ) ?>     

   <div class="form-group">
      <?= Html::submitButton('Add Course', [
         'class'  => 'btn btn-primary',
         'id'     => 'addCourseBtn',
         'name'   => 'Course[addCourse]',
         'value'  => 'addCourse',
         'style'  => 'width: 60%;float:right;',
      ]) ?>

<!--        
        <?= Html::a('Reset', ['/users/index'], ['class'=>'btn btn-default']) ?>
  -->
    </div>

    <?php ActiveForm::end(); ?>
</div>
