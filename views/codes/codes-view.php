<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;

   use yii\widgets\ActiveForm;
   
   use app\controllers\CodesController;
   
   $this->title = 'Framework | System Codes | View | Update';
   $this->params['breadcrumbs'][] = [ 'label' => $this->title, 'url' =>['index']];
   
   $formatter = \Yii::$app->formatter;
  
   $codeType   = CodesController::getDropDownOpts('type', true);
   $isActive   = CodesController::getDropDownOpts(CodesController::IS_ACTIVE_TYPE_STR, true);
   $isVisible  = CodesController::getDropDownOpts(CodesController::IS_VISIBLE_TYPE_STR, true);
   $isBanner   = CodesController::getDropDownOpts(CodesController::IS_BANNER_DATA_TYPE_STR, true);   
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>

      <?= $this->render('/common/_alert', ['data' => $data]); ?>
      
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>

<?php
/**
   print( "<P> id: "          . $model->id . "</p>" );
   print( "<P> code: "        . $model->code . "</p>" );
   print( "<P> description: " . $model->description . "</p>" );
   print( "<P> is_active: "   . $model->is_active . "</p>" );
   print( "<P> created_at: "  . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
   print( "<P> updated_at: "  . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
   print( "<P> deleted_at: "  . $formatter->asDate( $model->deleted_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
 **/
 ?>
  
      <div class="codes-edit">
          <?php $form = ActiveForm::begin([
               'id'     => 'codes-view-form',
               'action' => ['save'],
               'method' => 'post',
          ]); ?>

<?php
   /**
    *    Cludgy and possibly insecure way to handle passing row ID between form and controllers.
    *    To be revisited.
    **/
 ?>
          
         <?= Html::hiddenInput('SystemCodes[id]', $model->id) ?>
         <?= Html::hiddenInput('id', $model->id) ?>

         <div class="form-group form-inline field-type">
         <label class="control-label" for="SystemCodes[type]"><?php print( $model->getAttributeLabel('type') ); ?></label>
            <?= Html::dropDownList(
     'SystemCodes[type]',
     $model->type,
     $codeType,
     [
                  'id'     => 'type',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
 )
            ?>
            <div class="help-block"></div>
         </div>         
         
         <div class="form-group form-inline field-code">
            <label class="control-label" for="SystemCodes[code]"><?php print( $model->getAttributeLabel('code') ); ?></label>
            <?= Html::input(
                'text',
                'SystemCodes[code]',
                $model->code,
                [
                  'id'     => 'code',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-code_str">
            <label class="control-label" for="SystemCodes[code_str]"><?php print( $model->getAttributeLabel('code_str') ); ?></label>
            <?= Html::input(
                'text',
                'SystemCodes[code_str]',
                $model->code_str,
                [
                  'id'     => 'code_str',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>         
         
         <div class="form-group form-inline field-description">
            <label class="control-label" for="SystemCodes[description]"><?php print( $model->getAttributeLabel('description') ); ?></label>
            <?= Html::input(
                'text',
                'SystemCodes[description]',
                $model->description,
                [
                  'id'     => 'description',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>         
            
         <div class="form-group form-inline field-is_active">
         <label class="control-label" for="SystemCodes[is_active]"><?php print( $model->getAttributeLabel('is_active') ); ?></label>
            <?= Html::dropDownList(
                'SystemCodes[is_active]',
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
         <label class="control-label" for="SystemCodes[is_visible]"><?php print( $model->getAttributeLabel('is_visible') ); ?></label>
            <?= Html::dropDownList(
                'SystemCodes[is_visible]',
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

         <div class="form-group form-inline field-is_banner_data">
         <label class="control-label" for="SystemCodes[is_visible]"><?php print( $model->getAttributeLabel('is_banner_data') ); ?></label>
            <?= Html::dropDownList(
                'SystemCodes[is_banner_data]',
                $model->is_banner_data,
                $isBanner,
                [
                    'id'        => 'is_banner_data',
                    'class'     => 'form-control',
                    'style'     => 'width: 80%;float:right;',
                    'disabled'  => 'disabled',         
                    'title'     => 'This value is set by the system',
               ]
            )
            ?>
            <div class="help-block"></div>
         </div>         
         
         
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
    
         <div class="form-group">
            <?= Html::submitButton('Save Changes', [
               'class'  => 'btn btn-primary',
               'id'     => 'saveSystemCodesBtn',
               'name'   => 'SystemCodes[update]',
               'value'  => 'update'
            ]) ?>
         </div>
         
         <?php ActiveForm::end(); ?> 
      </div>
 
      <h3>Drop System Code Tag</h3>
      <div id='system-codes-drop-form'>      
         <?= $this->render('/common/_remove-tags', ['data' => $data, 'model' => $tags]); ?>
      </div>  

      <h3>Add System Code Tag</h3>
      <div id='system-codes-add-form'>      
         <?= $this->render('/common/_add-tags', ['data' => $data, 'model' => $allTags]); ?>
      </div>

      <code><?= __FILE__ ?></code>
         
   </div>
