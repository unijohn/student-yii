<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */


   $item_name = [];
   
   foreach ($model as $role) {
//      print_r( $role);
       $item_name[$role['name']] = $role['description'];
   }
?>

<div class="users-search">
   <?php $form = ActiveForm::begin([
         'action' => ['save'],
         'method' => 'post',
      ]); ?>
   
   <div class="form-group field-authitem-name">
      <?= Html::dropDownList('authitem[name]', null, $item_name, [
            'id'     => 'authitem-name',
            'prompt' => 'Select Role',
            'class'  => 'form-control'
         ])
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group">      
      <?= Html::submitButton('Add Role', ['class' => 'btn btn-primary']) ?>
      <?= Html::hiddenInput('addRole', 'addRole') ?>
      <?= Html::hiddenInput('uuid', $data['uuid']) ?>          
   </div>
   
   <?php ActiveForm::end(); ?>
</div>
