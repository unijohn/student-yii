<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $item_name = [];
   foreach( $model as $role )
   {
//      print_r($role );
      $item_name[$role->item_name] = $role->item_name; 
   }  
?>

<div class="users-search">
   <?php $form = ActiveForm::begin([
         'action' => ['save'],
         'method' => 'post',
      ]); ?>

   <div class="form-group field-authassignment-item_name">
      <?= Html::dropDownList('authassignment[item_name]', null, $item_name, [
            'id'     => 'authassignment-item_name',
            'prompt' => 'Select Role', 
            'class'  => 'form-control'
         ]) 
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group">
      <?= Html::submitButton('Drop Role', ['class' => 'btn btn-primary']) ?>
      <?= Html::hiddenInput('dropRole',   'dropRole') ?>
      <?= Html::hiddenInput('uuid',       $data['uuid']) ?>      
   </div>
   
   <?php ActiveForm::end(); ?>
</div>
