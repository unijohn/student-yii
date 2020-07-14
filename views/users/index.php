<?php
   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   
   use yii\grid\GridView;   

/* @var $this yii\web\View */

$this->title = 'Framework | Users | Placeholder';

$auth = Yii::$app->authManager;
?>
   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      <p>
         This is the <?php print( $this->title ); ?> page. You may modify the following file to customize its content:
      </p>

      <code><?= __FILE__ ?></code>
         
      </div>
   </div>

