<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$cookies = Yii::$app->request->cookies;
$session = Yii::$app->session;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
       NavBar::begin([
           'brandLabel' => Yii::$app->name,
           'brandUrl' => Yii::$app->homeUrl,
           'options' => [
               'class' => 'navbar-inverse navbar-fixed-top',
           ],
       ]);
       
       $menuItems =
       [
         ['label' => 'Home', 'url' => ['/site/index']],
//         ['label' => 'About', 'url' => ['/site/about']],
//         ['label' => 'Contact', 'url' => ['/site/contact']],
//         ['label' => 'Permits', 'url' => ['/permits/index']],    
       ];
   
      if( Yii::$app->user->isGuest )
      {
         $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
      }
      else
      {  
         $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
               'Logout (' . Yii::$app->user->identity->uuid . ')',
               ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
      }   
    
      echo Nav::widget([
         'options' => ['class' => 'navbar-nav navbar-right'],
         'items' => $menuItems,
      ]);
      NavBar::end();
      
   ?>

   <div class="container">
      <?= Breadcrumbs::widget([
         'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
      
<?php
      
      if( isset( $this->params['data'] ) && !empty( $this->params['data']  ) )
      {
     
         if( isset( $this->params['data']['errors'] ) && !empty( $this->params['data']['errors'] ) )
         {
            $data['errors'] = $this->params['data']['errors'];
         
            print( "<div class='alert alert-danger' role='alert'> " . PHP_EOL );
                
            foreach( $data['errors'] as $key => $value )
            {
               $htmlTagOpen   = "";
               $htmlTagClose  = "<br />";
            
               $errorName = $key;
      
               if( isset( $data['errors'][$key]['htmlTag'] ) && !empty( $data['errors'][$key]['htmlTag'] ) )
               {
                  $htmlTagOpen   = "<"    . $data['errors'][$key]['htmlTag'] . ">";
                  $htmlTagClose  = "</"   . $data['errors'][$key]['htmlTag'] . ">";             
               }
       
               print( $htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['errors'][$key]['value'] . $htmlTagClose . PHP_EOL);
            }
            
            print( "</div> " . PHP_EOL );      
         }
      
         if( isset( $this->params['data']['success'] ) && !empty( $this->params['data']['success'] ) )
         {
            $data['success'] = $this->params['data']['success'];
         
            print( "<div class='alert alert-success' role='alert'> " . PHP_EOL );
                
            foreach( $data['success'] as $key => $value )
            {
               $htmlTagOpen   = "";
               $htmlTagClose  = "<br />";
            
               $errorName = $key;
      
               if( isset( $data['success'][$key]['htmlTag'] ) && !empty( $data['success'][$key]['htmlTag'] ) )
               {
                  $htmlTagOpen   = "<"    . $data['success'][$key]['htmlTag'] . ">";
                  $htmlTagClose  = "</"   . $data['success'][$key]['htmlTag'] . ">";             
               }
               
               print( $htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['success'][$key]['value'] . $htmlTagClose . PHP_EOL);
            }
            
            print( "</div> " . PHP_EOL );      
         } 
  
/*         
         print( "<pre>" );
         print_r( $this->params['data'] );
         print( "</pre>" );
*/             
      }
?>
   
   <?= $content ?>
   </div>


    <div>
      <h2>Scratchpad</h2>
      <pre>
<?php
//   print_r( $cookies );
 ?>

<?php
//   print_r( $session );
 ?>

      </pre>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; The University of Memphis <?= date('Y') ?> 

        </p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
