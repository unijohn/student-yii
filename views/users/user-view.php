<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   

   $this->title = 'Framework | User | View | Update';
   $this->params['breadcrumbs'][] = $this->title;
   
   $formatter = \Yii::$app->formatter;   
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      <p>
         This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content:
      </p>

<?php
   print( "<P> id: " . $model->id . "</p>" );
   print( "<P> UUID: " . $model->uuid . "</p>" );
   print( "<P> name: " . $model->name . "</p>" );   
   print( "<P> is_active: " . $model->is_active . "</p>" );
   print( "<P> access_token: " . $model->access_token . "</p>" );
   print( "<P> created_at: " . $formatter->asDate( $model->created_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );
   print( "<P> updated_at: " . $formatter->asDate( $model->updated_at, 'MM-dd-yyyy HH:mm:ss' ) . "</p>" );         

?>

      <code><?= __FILE__ ?></code>
         
   </div>
