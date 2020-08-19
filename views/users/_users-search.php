<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\controllers\UsersController;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $pageCount  = UsersController::getDropDownOpts('pageCount');
   $isActive   = UsersController::getDropDownOpts('is_active', true);
   
//   UsersController::debug( $filterForm );
   
?>

<style>
.inline-label {
    white-space: nowrap;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    float:left;  
}
</style>

<div class="users-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
   <div class="form-group field-code">
      <label class="control-label" for="User[uuid]">UUID</label>
      <?= Html::input(
        'text',
        'User[uuid]',
        $filterForm['uuid'],
        [
            'id'     => 'uuid',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
    )
      ?>   
      <div class="help-block"></div>
   </div>
         
   <div class="form-group field-is_active">
   <label class="control-label" for="pagination_count">Is Active</label>
      <?= Html::dropDownList(
          'User[is_active]',
          $filterForm['is_active'],
          $isActive,
          [
            'id'     => 'is_active',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
      )
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group field-pagination_count">
   <label class="control-label" for="pagination_count"># per Page</label>
      <?= Html::dropDownList(
          'User[pagination_count]',
          $filterForm['paginationCount'],
          $pageCount,
          [
            'id'     => 'pagination_count',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
      )
      ?>
      <div class="help-block"></div>
   </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['/users/index'], ['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
