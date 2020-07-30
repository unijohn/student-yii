<?php

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   
   use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="permits-tags-drop-div" style="margin-bottom: 12px;min-height: 45px;">
<?php
   foreach( $model as $tag )
   {
      $form = ActiveForm::begin([
            'action' => ['save'],
            'method' => 'post',
         ]); 
?>
      
      
   <?= Html::hiddenInput('id',      $data['id']) ?>
   <?= Html::hiddenInput('tagid',   $tag['id'])  ?>
   <?= Html::hiddenInput('dropTag', 'dropTag')   ?>         

   <div id="field-tag-code" class="form-group field-tag-code" style="float: left; margin-right: 12px;">
      <?= Html::submitButton($tag['description'] . '  [&times;]', ['class' => 'btn btn-primary', 'value' => $tag['id']], ) ?>
      
      <div id="field-tag-code-help-block<?php echo( $tag['id'] ); ?>" class="help-block"></div>
   </div>
   
   <?php ActiveForm::end(); ?>
   
<?php
   }
?>
</div>