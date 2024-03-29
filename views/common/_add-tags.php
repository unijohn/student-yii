<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    use app\models\BaseModel;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

    $tags = [];
   
    if( $model ){
        foreach ($model as $tag) {
            $tags[$tag['id']] = $tag['code_str'] . ' : ' . $tag['description'];
        }
    }        
?>

<div id="codes-tags-add-div" name="codes-tags-add-div">
   <?php $form = ActiveForm::begin([
         'action' => ['save'],
         'method' => 'post',
      ]); ?>
   <?= Html::hiddenInput('id', $data['id']) ?>
   
   <div id="field-tag-code" class="form-group field-tag-code">
      <?= Html::dropDownList('tagid', null, $tags, [
            'id'     => 'tag-code',
            'prompt' => 'Select Tag',
            'class'  => 'form-control'
         ])
      ?>
      <div id="field-tag-code-help-block" class="help-block"></div>
   </div>

   <div class="form-group">      
      <?= Html::submitButton('Add Tag', ['class' => 'btn btn-primary']) ?>
      <?= Html::hiddenInput('addTag', 'addTag') ?>    
   </div>
   
   <?php ActiveForm::end(); ?>
</div>
