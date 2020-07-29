<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

//print( "<pre>" );

   $tags = [];
   foreach( $model as $tag )
   {
      $tags[$tag['id']] = $tag['code'] . ' : ' . $tag['description']; 
//      print_r( $tag );
   }  
   
//die();
?>

<div class="permits-tags-drop-div">
   <?php $form = ActiveForm::begin([
         'action' => ['save'],
         'method' => 'post',
      ]); ?>

   <div class="form-group field-tag-code">
      <?= Html::dropDownList('tag[id]', null, $tags, [
            'id'     => 'tag-code',
            'prompt' => 'Select Tag', 
            'class'  => 'form-control'
         ]) 
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group">
      <?= Html::submitButton('Drop Tag', ['class' => 'btn btn-primary']) ?>
      <?= Html::hiddenInput('dropTag',   'dropTag') ?>   
   </div>
   
   <?php ActiveForm::end(); ?>
</div>
