<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\controllers\UsersController;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $pageCount  = UsersController::getDropDownOpts( 'pageCount' );
   $isActive   = UsersController::getDropDownOpts( 'is_active',   true );
   
//   UsersController::debug( $filterForm );
   
?>

<div class="users-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?=  $form->field($model, 'uuid') ?>
         
   <div class="form-group field-is_active">
   <label class="control-label" for="pagination_count">Is Active</label>
      <?= Html::dropDownList('User[is_active]', $filterForm['is_active'], 
         $isActive,
         [
            'id'     => 'is_active',
            'class'  => 'form-control',
         ]) 
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group field-pagination_count">
   <label class="control-label" for="pagination_count"># per Page</label>
      <?= Html::dropDownList('User[pagination_count]', $filterForm['paginationCount'], 
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
