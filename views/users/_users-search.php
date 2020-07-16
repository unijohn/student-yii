<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */


   $pageCount['10']  = 10;
   $pageCount['25']  = 25;
   $pageCount['50']  = 50;
   $pageCount['100'] = 100;         

?>

<div class="users-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?=  $form->field($model, 'uuid') ?>

    <?=  $form->field($model, 'is_active')->dropdownList([
               1 => 'Active',
               0 => 'Inactive',
            ],
            ['prompt' => 'Select Status']
         ); ?>

   <div class="form-group field-pagination_count">
   <label class="control-label" for="pagination_count"># per Page</label>
      <?= Html::dropDownList('pagination_count', $pagination_count, 
         $pageCount,
         [
            'id'     => 'pagination_count',
            'class'  => 'form-control',
         ]) 
      ?>
      <div class="help-block"></div>
   </div>

    <div class="form-group">
        <?= Html::submitButton('Search',  ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['/users/index'], ['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
