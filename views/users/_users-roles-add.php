<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $item_name = [];
   foreach( $model as $role )
   {
      $item_name[$role['name']] = $role['description']; 
   }  
?>

<div class="users-search">
   <?php $form = ActiveForm::begin([
         'action' => ['save'],
         'method' => 'post',
      ]); ?>
   
   <?=  $form->field($model[0], 'name')->dropdownList(
      $item_name, 
      ['prompt' => 'Select Role'] 
      ); 
   ?>
   
   <div class="form-group">
      <?= Html::submitButton('Add Role',  ['class' => 'btn btn-primary']) ?>
      <?= Html::hiddenInput('addRole',  'addRole') ?>
   </div>
   
   <?php ActiveForm::end(); ?>
</div>
