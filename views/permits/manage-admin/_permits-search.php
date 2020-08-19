<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\controllers\CodesController;
use app\controllers\permits\ManageAdminController;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
   
   $pageCount  = CodesController::getDropDownOpts('pageCount');
   $isActive   = CodesController::getDropDownOpts('is_active', true);
   $isHidden   = CodesController::getDropDownOpts('is_hidden', true);
   $isTagged   = ManageAdminController::getDropDownOpts('tags_permits', true);
?>

<div class="users-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
   <div class="form-group field-code">
      <label class="control-label" for="SystemCodes[code]">Code</label>
      <?= Html::input(
        'text',
        'SystemCodes[code]',
        $filterForm['code'],
        [
            'id'     => 'code',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
    )
      ?>   
      <div class="help-block"></div>
   </div>
         
   <div class="form-group field-is_active">
   <label class="control-label" for="is_active">Is Active</label>
      <?= Html::dropDownList(
          'SystemCodes[is_active]',
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
   
   <div class="form-group field-is_hidden">
   <label class="control-label" for="is_hidden">Is Hidden</label>
      <?= Html::dropDownList(
          'SystemCodes[is_hidden]',
          $filterForm['is_hidden'],
          $isHidden,
          [
            'id'     => 'is_hidden',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
      )
      ?>
      <div class="help-block"></div>
   </div>
   
   <div class="form-group field-is_tagged">
   <label class="control-label" for="is_tagged">Is Tagged</label>
      <?= Html::dropDownList(
          'SystemCodes[is_tagged]',
          $filterForm['is_tagged'],
          $isTagged,
          [
            'id'     => 'is_tagged',
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
          'SystemCodes[pagination_count]',
          $filterForm['pagination_count'],
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

    <div class="form-group" style="float:right;">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'style' => 'margin-right: 20px; width: 95px;']) ?>
        <?= Html::a('Reset', ['/permits/manage-admin/index'], ['class'=>'btn btn-default', 'style' => 'width: 95px;']) ?>        
    </div>

    <?php ActiveForm::end(); ?>
</div>
