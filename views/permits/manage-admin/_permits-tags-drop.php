<?php

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;
   
   use yii\widgets\ActiveForm;
   
   use app\models\BaseModel;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="codes-tags-drop-div" name="codes_tags-drop-div" style="margin-bottom: 12px;min-height: 45px;">
<?php
   foreach ($model as $tag) {
       $form = ActiveForm::begin([
            'action' => ['save'],
            'method' => 'post',
         ]);
         
       if ($tag['is_active'] == BaseModel::STATUS_ACTIVE) {
           $options =
            [
                'class'     => 'btn btn-primary',
                'value'     => $tag['id'],
                'title'     => 'Click this button to remove the ' . $tag['description'] . ' tag'
            ];
       } else {
           $options =
            [
                'class'     => 'btn btn-light',
                'value'     => $tag['id'],
                'disabled'  => 'disabled',
                'title'     => 'This code is currently inactive'
            ];
       } ?>
      
      
    <?= Html::hiddenInput('id', $data['id']) ?>
    <?= Html::hiddenInput('tagid', $tag['id'])  ?>
    <?= Html::hiddenInput('dropTag', 'dropTag')   ?>         
    
    <div id="field-tag-code" class="form-group field-tag-code" style="float: left; margin-right: 12px;">
    
        <?= Html::submitButton($tag['description'] . '  [&times;]', $options) ?>
    
        <div id="field-tag-code-help-block<?php echo($tag['id']); ?>" class="help-block"></div>
    </div>
    
    <?php ActiveForm::end(); ?>
   
<?php
   }
?>
</div>
