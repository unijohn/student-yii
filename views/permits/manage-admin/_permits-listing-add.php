<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="users-add-new-user">
    <?php $form = ActiveForm::begin([
        'action' => ['add'],
        'method' => 'post',
    ]); ?>

    <?=  $form->field($model, 'code') ?>

   <div class="form-group">
      <?= Html::submitButton('Add Permit', [
         'class'  => 'btn btn-primary',
         'id'     => 'addPermitBtn',
         'name'   => 'Permit[addPermit]',
         'value'  => 'addPermit'
      ]) ?>

<!--        
        <?= Html::a('Reset', ['/users/index'],  ['class'=>'btn btn-default']) ?>
  -->
    </div>

    <?php ActiveForm::end(); ?>
</div>
