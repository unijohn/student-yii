<?php

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;
   
   use yii\bootstrap\ActiveForm;

use app\controllers\UsersController;

   $formatter = \Yii::$app->formatter;

   $usCitizen       = UsersController::getDropDownOpts('us_citizen', false);
   $citizenOther    = UsersController::getDropDownOpts('citizen_other', false);
   $visaType        = UsersController::getDropDownOpts('visa_type', false);

?>

<div class="users-add-new-user">
    <?php $form = ActiveForm::begin([
        'action' => ['users-personal/save'],
        'method' => 'post',
    ]); ?>

    <?= Html::hiddenInput('UsersPersonal[uuid]', $model->uuid) ?>

    <?=  $form->field($model, 'uNbr')->textInput(
        [
            'class'         => 'form-control col-lg-4',
            'style'         => 'width: 80%;float:right;',
            'placeholder'   => "U Number"
         ]
    );
    ?>

    <?=  $form->field($model, 'firstNm')->textInput(
        [
            'class'         => 'form-control col-lg-4',
            'style'         => 'width: 80%;float:right;',
            'placeholder'   => "First Name"
         ]
    );
    ?>
    
    <?=  $form->field($model, 'middleNm')->textInput(
        [
            'class'         => 'form-control col-lg-4',
            'style'         => 'width: 80%;float:right;',
            'placeholder'   => "Middle Name(s)"
         ]
    );
    ?>  
    
    <?=  $form->field($model, 'lastNm')->textInput(
        [
            'class'         => 'form-control col-lg-4',
            'style'         => 'width: 80%;float:right;',
            'placeholder'   => "Last Name"
         ]
    );
    ?>
    
     <div class="form-group field-is_active">
     <label class="control-label" for="us_citizen">US Citizen</label>
        <?= Html::dropDownList(
            'UsersPersonal[us_citizen]',
            $model->us_citizen,
            $usCitizen,
            [
                'id'     => 'us_citizen',
                'class'  => 'form-control',
                'style'  => 'width: 80%;float:right;',
            ]
        )
        ?>
        <div class="help-block"></div>
     </div>

     <div class="form-group field-is_active">
     <label class="control-label" for="citizen_other">Foreign Citizenship</label>
        <?= Html::dropDownList(
            'UsersPersonal[citizen_other]',
            $model->citizen_other,
            $citizenOther,
            [
                'id'     => 'citizen_other',
                'class'  => 'form-control',
                'style'  => 'width: 80%;float:right;',
            ]
        )
        ?>
        <div class="help-block"></div>
     </div>
     
     <div class="form-group field-is_active">
     <label class="control-label" for="visa_type">Visa Type</label>
        <?= Html::dropDownList(
            'UsersPersonal[visa_type]',
            $model->visa_type,
            $visaType,
            [
                'id'     => 'visa_type',
                'class'  => 'form-control',
                'style'  => 'width: 80%;float:right;',
            ]
        )
        ?>
        <div class="help-block"></div>
     </div>


         <div class="form-group field-dates">
            <div>
               <?php echo("created_at: "  . $formatter->asDate($model->created_at, 'MM-dd-yyyy HH:mm:ss')); ?>
            </div>
            <div>
               <?php echo("updated_at: "  . $formatter->asDate($model->updated_at, 'MM-dd-yyyy HH:mm:ss')); ?>
            </div>
         </div>

    <div class="form-group">
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-primary',   'id' => 'SaveUserBtn',      'name' => 'UsersPersonal[saveUserPersonal]',    'value' => 'saveUserPersonal'    ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
