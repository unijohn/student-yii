<?php

    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
    use yii\helpers\Url;
    
    use yii\bootstrap\ActiveForm;
    
    use app\controllers\UsersController;
    
    use app\models\BaseModel;
    use app\models\FormFields;    

   $formatter = \Yii::$app->formatter;

    $usCitizen      = FormFields::getSelectOptions(-1, 'US-Citizen',    false);           
    $citizenOther   = FormFields::getSelectOptions(-1, 'Citizen-Other', false);              
    $visaType       = FormFields::getSelectOptions(-1, 'Visa-Type',     false);           

    $class = 'form-control col-lg-4';
    $style = 'width: 80%;float:right;';

    $formFields = 
    [
        'uNbr' => [
            'id'            => 'txt_uNbr',        
            'class'         => $class,
            'style'         => $style,
            'placeholder'   => "U Number"
        ],
        'firstNm' => [
            'id'            => 'txt_firstNm',        
            'class'         => $class,
            'style'         => $style,
            'placeholder'   => "First Name"
        ],
        'middleNm' => [
            'id'            => 'txt_middleNm',        
            'class'         => $class,
            'style'         => $style,
            'placeholder'   => "Middle Name(s)"
        ],
        'lastNm' => [
            'id'            => 'ddb_us_citizen',
            'class'         => $class,
            'style'         => $style,
            'placeholder'   => "Last Name"
        ],
        'us_citizen' => [
            'id'            => 'ddb_us_citizen',
            'class'         => $class,
            'style'         => $style,
        ],
        'citizen_other' => [
            'id'            => 'ddb_citizen_other',
            'class'         => $class,
            'style'         => $style,
        ],
        'visa_type' => [
            'id'            => 'ddb_visa_type',     
            'class'         => $class,
            'style'         => $style,
        ],                              
    ];    
    
    if( $model->us_citizen == BaseModel::CITIZEN_US_YES ) {
        $formFields['citizen_other']['disabled']    = true;
        $formFields['visa_type']['disabled']        = true;        
    }

?>

<div class="users-add-new-user">
    <?php $form = ActiveForm::begin([
        'action' => ['users-personal/save'],
        'method' => 'post',
    ]); ?>

    <?= Html::hiddenInput('UsersPersonal[uuid]', $model->uuid) ?>

    <?=  $form->field($model, 'uNbr')->textInput( $formFields['uNbr'] ); ?>

    <?=  $form->field($model, 'firstNm')->textInput( $formFields['firstNm'] ); ?>
    <?=  $form->field($model, 'middleNm')->textInput( $formFields['middleNm'] ); ?>
    <?=  $form->field($model, 'lastNm')->textInput( $formFields['lastNm'] ); ?>
    
     <div class="form-group field-is_active">
     <label class="control-label" for="us_citizen">US Citizen</label>
        <?= Html::dropDownList(
                'UsersPersonal[us_citizen]',
                $model->us_citizen,
                $usCitizen,
                $formFields['us_citizen'] 
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
                $formFields['citizen_other'] 
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
                $formFields['visa_type'] 
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
