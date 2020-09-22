<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\controllers\CodesController;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $pageCount  = CodesController::getDropDownOpts('pageCount');
   $codeType   = CodesController::getDropDownOpts('type', true);
   $isActive   = CodesController::getDropDownOpts(CodesController::IS_ACTIVE_TYPE_STR, true);
   $isVisible  = CodesController::getDropDownOpts(CodesController::IS_VISIBLE_TYPE_STR, true);
?>


<div class="courses-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
      
   <div class="form-group form-inline field-type" style="!white-space:nowrap;">
   <label class="control-label" for="SystemCodes[type]">Type</label>
   
<?php
   /**
      $type == value passed from view
      $codeType == list options
    **/
 ?>   
   
      <?= Html::dropDownList(
     'SystemCodes[type]',
     $type,
     $codeType,
     [
            'id'     => 'type',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
 )
      ?>
      <div class="help-block"></div>
   </div>      
         
   <div class="form-group form-inline field-is_active" style="!white-space:nowrap;">
   <label class="control-label" for="SystemCodes[is_active]">Is Active</label>
      <?= Html::dropDownList(
          'SystemCodes[is_active]',
          $is_active,
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
   
   <div class="form-group form-inline field-is_hidden" style="!white-space:nowrap;">
   <label class="control-label" for="SystemCodes[is_visible]">Is Visible</label>
      <?= Html::dropDownList(
          'SystemCodes[is_visible]',
          $is_visible,
          $isVisible,
          [
            'id'     => 'is_visible',
            'class'  => 'form-control',
            'style'  => 'width: 60%;float:right;',
         ]
      )
      ?>
      <div class="help-block"></div>
   </div>

   <div class="form-group form-inline field-pagination_count">
   <label class="control-label" for="pagination_count"># per Page</label>
      <?= Html::dropDownList(
          'SystemCodes[pagination_count]',
          $pagination_count,
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
        <?= Html::a('Reset', ['/codes/index'], ['class'=>'btn btn-default', 'style' => 'width: 95px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
