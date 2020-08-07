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
  
   $codeType   = CodesController::getDropDownOpts( 'type'      );
   $isActive   = CodesController::getDropDownOpts( 'is_active' );
   $isHidden   = CodesController::getDropDownOpts( 'is_hidden' );   
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
         <label class="control-label" for="SystemCodes[type]">Type</label>
            <?= Html::dropDownList('SystemCodes[type]', $model->type, 
               $codeType,
               [
                  'id'     => 'type',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]) 
            ?>
            <div class="help-block"></div>
         </div>         
         
         <div class="form-group form-inline field-code">
            <label class="control-label" for="SystemCodes[code]">Code</label>
            <?= Html::input('text', 'SystemCodes[code]', $model->code, 
               [
                  'id'     => 'code',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-description">
            <label class="control-label" for="SystemCodes[description]">Section</label>
            <?= Html::input('text', 'SystemCodes[description]', $model->description, 
               [
                  'id'     => 'description', 
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]
            ) ?>   
            <div class="help-block"></div>
         </div>         
            
         <div class="form-group form-inline field-is_active">
         <label class="control-label" for="SystemCodes[is_active]">Is Active</label>
            <?= Html::dropDownList('SystemCodes[is_active]', $model->is_active, 
               $isActive,
               [
                  'id'     => 'is_active',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]) 
            ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group form-inline field-is_hidden">
         <label class="control-label" for="SystemCodes[is_hidden]">Is Visible</label>
            <?= Html::dropDownList('SystemCodes[is_hidden]', $model->is_hidden, 
               $isHidden,
               [
                  'id'     => 'is_hidden',
                  'class'  => 'form-control',
                  'style'  => 'width: 80%;float:right;',
               ]) 
            ?>
            <div class="help-block"></div>
         </div>
         
         <div class="form-group field-dates">
            <div>
               <?php echo( "created_at: "  . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
            </div>
            <div>
               <?php echo( "updated_at: "  . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
            </div>
            <div>
               <?php echo( "deleted_at: "  . $formatter->asDate( $model->deleted_at, 'MM-dd-yyyy HH:mm:ss' ) ); ?>
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

      </div>  

      <h3>Add System Code Tag</h3>
      <div id='system-codes-add-form'>      

      </div>

      <code><?= __FILE__ ?></code>
         
   </div>
