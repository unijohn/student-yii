<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\controllers\CodesController;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

$codeType   = CodesController::getDropDownOpts( 'type', true );

?>

<div class="codes-add-new-code">
    <?php $form = ActiveForm::begin([
        'action' => ['add'],
        'method' => 'post',
    ]); ?>

    <?=  $form->field($model, 'type' )
            ->dropdownList( $codeType,
            [
               'id'     => 'type', 
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;', 
            ] 
         ) 
    ?>
         
    <?=  $form->field($model, 'code' )
            ->textInput( 
            [
               'id'     => 'code', 
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;', 
            ] 
         ) 
    ?>
         
    <?=  $form->field($model, 'description' )
            ->textInput( 
            [
               'id'     => 'description', 
               'class'  => 'form-control',
               'style'  => 'width: 60%;float:right;', 
            ] 
         ) ?>     

   <div class="form-group">
      <?= Html::submitButton('Add System Code', [
         'class'  => 'btn btn-primary',
         'id'     => 'addSystemCodesBtn',
         'name'   => 'SystemCodes[insert]',
         'value'  => 'insert',
         'style'  => 'width: 60%;float:right;',     
      ]) ?>

<!--        
        <?= Html::a('Reset', ['/users/index'],  ['class'=>'btn btn-default']) ?>
  -->
    </div>

    <?php ActiveForm::end(); ?>
</div>
