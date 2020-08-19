<?php

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;
   
   use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $item_name = [];
   foreach ($model as $role) {
       $item_name[$role->item_name] = $role->item_name;
   }
?>

<?php
/**
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
 **/
 ?>

<div id="users-roles-drop-div" style="margin-bottom: 12px;min-height: 45px;">
<?php

   foreach ($model as $role) {
       $form = ActiveForm::begin([
            'action' => ['save'],
            'method' => 'post',
         ]); ?>
      
   <?= Html::hiddenInput('uuid', $data['uuid'])        ?>      
   <?= Html::hiddenInput('authassignment[item_name]', $role['item_name'])   ?>
   <?= Html::hiddenInput('dropRole', 'dropRole')            ?>         

   <div id="field-tag-code" class="form-group field-tag-code" style="float: left; margin-right: 12px;">
      <?= Html::submitButton($role['item_name'] . '  [&times;]', ['class' => 'btn btn-primary', 'value' => $role['item_name']]) ?>
      
      <div id="field-tag-code-help-block-<?php echo($role['item_name']); ?>" class="help-block"></div>
   </div>
   
   <?php ActiveForm::end(); ?>
   
<?php
   }
?>
</div>
