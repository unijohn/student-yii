<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   

   $this->title = 'Permits | Manage-Admin | View | Update';
   $this->params['breadcrumbs'][] = [ 'label' => $this->title, 'url' =>['index']];
   
   
   $formatter = \Yii::$app->formatter;   
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>

      <?= $this->render('/common/_alert', ['data' => $data]); ?>
      
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>

<?php
   print( "<P> id: "          . $model->id . "</p>" );
   print( "<P> code: "        . $model->code . "</p>" );
   print( "<P> description: " . $model->description . "</p>" );   
   print( "<P> is_active: "   . $model->is_active . "</p>" );
   print( "<P> created_at: "  . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
   print( "<P> updated_at: "  . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );    
   print( "<P> deleted_at: "  . $formatter->asDate( $model->deleted_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );    
 ?>
 
      <h3>Drop Permit Tag</h3>
      <div id='permits-tags-drop-form'>      
         <?= $this->render('_permits-tags-drop', ['data' => $data, 'model' => $tags]); ?>
      </div>  

      <h3>Add Permit Tag</h3>
      <div id='permits-tags-add-form'>      
         <?= $this->render('_permits-tags-add', ['data' => $data, 'model' => $allTags]); ?>
      </div>

      <code><?= __FILE__ ?></code>
         
   </div>
