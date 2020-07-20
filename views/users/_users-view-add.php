<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="users-add-new-user">
    <?php $form = ActiveForm::begin([
        'action' => ['add'],
        'method' => 'post',
    ]); ?>

    <?=  $form->field($model, 'uuid') ?>

    <div class="form-group">
        <?= Html::submitButton('Add User',      ['class' => 'btn btn-primary',   'id' => 'addUserBtn',      'name' => 'User[addUser]',    'value' => 'addUser'    ]) ?>
        <?= Html::submitButton('Lookup User',   ['class' => 'btn btn-info',      'id' => 'lookupUserBtn',   'name' => 'User[lookupUser]', 'value' => 'lookupUser' ]) ?>        
        <?= Html::a('Reset', ['/users/index'],  ['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
