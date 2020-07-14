<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
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

    <div class="form-group">
        <?= Html::submitButton('Search',  ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['/framework/users'], ['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
