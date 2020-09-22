<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;

   use yii\widgets\ActiveForm;
   
    use app\controllers\FieldsController;
    
    use app\models\FormFields;
   
   $this->title = 'Framework | Form Fields | View | Update';
   $this->params['breadcrumbs'][] = [ 'label' => $this->title, 'url' =>['index']];
   
   $formatter = \Yii::$app->formatter;

   
   $formField   = FormFields::getFormFieldOptions(-1, 'Form-Field', false);   
   $typeField   = FormFields::getDistinctGroupings();   
   
   $isActive    = FormFields::getSelectOptions(-1, 'Is-Active',  false);
   $isVisible   = FormFields::getSelectOptions(-1, 'Is-Visible', false);      
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>

      <?= $this->render('/common/_alert', ['data' => $data]); ?>
      
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>
 
      <div class="codes-edit">
          <?php $form = ActiveForm::begin([
               'id'     => 'fields-view-form',
               'action' => ['save'],
               'method' => 'post',
          ]); ?>

<?php
   /**
    *    Cludgy and possibly insecure way to handle passing row ID between form and controllers.
    *    To be revisited.
    **/
 ?>
          
         <?= Html::hiddenInput('FormFields[id]', $model->id) ?>
         <?= Html::hiddenInput('id', $model->id) ?>

         <div class="form-group form-inline field-form_field">
         <label class="control-label" for="FormFields[form_field]"> <?php print( $model->getAttributeLabel('form_field') ); ?></label>
            <?= Html::dropDownList(
                'FormFields[form_field]',
                $model->form_field,
                $formField,
                [
                    'id'     => 'form_field',
                    'class'  => 'form-control',
                    'style'  => 'width: 80%;float:right;',
                ]
            )
            ?>
            <div class="help-block"></div>
         </div>         
         
         <div class="form-group form-inline field-type">
            <label class="control-label" for="FormFields[type]"><?php print( $model->getAttributeLabel('type') ); ?></label>
            <?= Html::dropDownList(
                'FormFields[type]',
                $model->type,
                $typeField,
                [
                    'id'     => 'type',
                    'class'  => 'form-control',
                    'style'  => 'width: 80%;float:right;',
                ]
            )
            ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-description">
            <label class="control-label" for="FormFields[description]"><?php print( $model->getAttributeLabel('description') ); ?></label>
            <?= Html::input(
                'text',
                'FormFields[description]',
                $model->description,
                [
                  'id'     => 'description',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>

         <div class="form-group form-inline field-value">
            <label class="control-label" for="FormFields[value]"><?php print( $model->getAttributeLabel('value') ); ?></label>
            <?= Html::input(
                'text',
                'FormFields[value]',
                $model->value,
                [
                  'id'     => 'value',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div> 

         <div class="form-group form-inline field-value">
            <label class="control-label" for="FormFields[value_str]"><?php print( $model->getAttributeLabel('value_str') ); ?></label>
            <?= Html::input(
                'text',
                'FormFields[value_str]',
                $model->value_str,
                [
                  'id'     => 'value_str',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>     
            
         <div class="form-group form-inline field-is_active">
         <label class="control-label" for="FormFields[is_active]"><?php print( $model->getAttributeLabel('is_active') ); ?></label>
            <?= Html::dropDownList(
                'FormFields[is_active]',
                $model->is_active,
                $isActive,
                [
                  'id'     => 'is_active',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            )
            ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-is_visible">
         <label class="control-label" for="FormFields[is_visible]"><?php print( $model->getAttributeLabel('is_visible') ); ?></label>
            <?= Html::dropDownList(
                'FormFields[is_visible]',
                $model->is_visible,
                $isVisible,
                [
                  'id'     => 'is_visible',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            )
            ?>
            <div class="help-block"></div>
         </div>

<?php

    if( isset( $model->created_at ) || isset( $model->updated_at ) || isset( $model->deleted_at ) ) {
 ?>
         
         <div class="form-group field-dates">
            <div>
               <?php echo($model->getAttributeLabel('created_at') . ": " . $formatter->asDate($model->created_at, 'MM-dd-yyyy HH:mm:ss')); ?>
            </div>
            <div>
               <?php echo($model->getAttributeLabel('updated_at') . ": " . $formatter->asDate($model->updated_at, 'MM-dd-yyyy HH:mm:ss')); ?>
            </div>
            <div>
               <?php echo($model->getAttributeLabel('deleted_at') . ": " . $formatter->asDate($model->deleted_at, 'MM-dd-yyyy HH:mm:ss')); ?>
            </div>            
         </div>
<?php
    }
 ?>
    
         <div class="form-group">
            <?= Html::submitButton('Save Changes', [
               'class'  => 'btn btn-primary',
               'id'     => 'saveFormFieldsBtn',
               'name'   => 'FormFields[update]',
               'value'  => 'update'
            ]) ?>
         </div>
         
         <?php ActiveForm::end(); ?> 
      </div>

      <code><?= __FILE__ ?></code>
         
   </div>
