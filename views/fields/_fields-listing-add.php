<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\controllers\FieldsController;

use app\models\FormFields;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $formField   = FormFields::getFormFieldOptions(-1, 'Form-Field', true);  
   $typeField   = FormFields::getDistinctGroupings();
   
//FormFields::debug( $fieldType );   

?>

<div class="fields-add-new-code">
    <?php $form = ActiveForm::begin([
        'action' => ['add'],
        'method' => 'post',
    ]); ?>

    <?= $form->field($model, 'form_field')
            ->dropdownList(
                $formField,
                [
                   'id'     => 'form_field',
                   'class'  => 'form-control',
                   'style'  => 'width: 60%;float:right;',
                   'value'  => $FormFields['form_field'],
                ]
        )
    ?>
    
    <?= $form->field($model, 'type')
            ->dropdownList(
                $typeField,
                [
                   'id'     => 'type',
                   'class'  => 'form-control',
                   'style'  => 'width: 60%;float:right;',
                   'value'  => $FormFields['type'],
                ]
        )
    ?>
         
    <?=  $form->field($model, 'description')
            ->textInput(
                [
               'id'     => 'description',
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;',
            ]
            ) ?>   
            
    <?=  $form->field($model, 'value_str')
            ->textInput(
                [
               'id'     => 'value_str',
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;',
            ]
            ) ?>     
            
    <?=  $form->field($model, 'value')
            ->textInput(
                [
               'id'     => 'value',
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;',
            ]
            ) ?>                               

   <div class="form-group">
      <?= Html::submitButton('Add Form Field', [
         'class'  => 'btn btn-primary',
         'id'     => 'addFormFieldsBtn',
         'name'   => 'FormFields[insert]',
         'value'  => 'insert',
         'style'  => 'width: 60%;float:right;',
      ]) ?>

<!--        
        <?= Html::a('Reset', ['/users/index'], ['class'=>'btn btn-default']) ?>
  -->
    </div>

    <?php ActiveForm::end(); ?>
</div>
