<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\controllers\FieldsController;

use app\models\FormFields;


/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

   $pageCount   = FieldsController::getDropDownOpts('pageCount');
   $grouping    = FormFields::getDistinctGroupings();
   $isActive    = FormFields::getSelectOptions(-1, 'is_active',  false);
   $isVisible   = FormFields::getSelectOptions(-1, 'is_visible', false);
    
//  FieldsController::debug( $filterForm );   

?>


<div class="fields-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
      
   <div class="form-group form-inline field-type" style="!white-space:nowrap;">
   <label class="control-label" for="FormFields[grouping_name]">Grouping</label>
   
<?php
   /**
      $type == value passed from view
      $codeType == list options
    **/
 ?>   
   
    <?= Html::dropDownList(
        'FormFields[grouping]',
        $filterForm['grouping'],
        $grouping,
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
   <label class="control-label" for="FormFields[is_active]">Is Active</label>
      <?= Html::dropDownList(
          'FormFields[is_active]',
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
   
   <div class="form-group form-inline field-is_hidden" style="!white-space:nowrap;">
   <label class="control-label" for="FormFields[is_visible]">Is Visible</label>
      <?= Html::dropDownList(
          'FormFields[is_visible]',
          $filterForm['is_visible'],
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
          'FormFields[pagination_count]',
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

    <div class="form-group" style="float:right;">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'style' => 'margin-right: 20px; width: 95px;']) ?>
        <?= Html::a('Reset', ['/fields/index'], ['class'=>'btn btn-default', 'style' => 'width: 95px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
