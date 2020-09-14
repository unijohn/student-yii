<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

$cookies = Yii::$app->request->cookies;
$session = Yii::$app->session;

$this->title = "FCBE Workdesk";

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>

<?php

    if( isset($this->params['title']) && !empty($this->params['title'])){
 ?>
    <title><?= Html::encode($this->params['title']) ?></title>
<?php
    }else{
 ?>
    <title><?= Html::encode($this->title) ?></title>
<?php
    }
?>
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
   
      if (Yii::$app->user->isGuest) {
          $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
      } else {
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
      
      if (isset($this->params['data']) && !empty($this->params['data'])) {
          if (isset($this->params['data']['errors']) && !empty($this->params['data']['errors'])) {
              $data['errors'] = $this->params['data']['errors'];

              print("<div class='alert alert-danger' role='alert'> " . PHP_EOL);
              print("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>");
                
              foreach ($data['errors'] as $key => $value) {
                  $htmlTagOpen   = "";
                  $htmlTagClose  = "<br />";
            
                  $errorName = $key;

                  /**
                   *  Example of using Yii's built-in Alert widget
                   *
                   *
                                 Yii::$app->session->setFlash('error', 'This is the message');

                                 echo Alert::widget([
                                    'options' => ['class' => 'error'],
                                 ]);
                   **/

                  if (isset($data['errors'][$key]['htmlTag']) && !empty($data['errors'][$key]['htmlTag'])) {
                      $htmlTagOpen   = "<"    . $data['errors'][$key]['htmlTag'] . ">";
                      $htmlTagClose  = "</"   . $data['errors'][$key]['htmlTag'] . ">";
                  }
       
                  print($htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['errors'][$key]['value'] . $htmlTagClose . PHP_EOL);
              }

              print("</div> " . PHP_EOL);
          }
      
          if (isset($this->params['data']['success']) && !empty($this->params['data']['success'])) {
              $data['success'] = $this->params['data']['success'];
         
              print("<div class='alert alert-success' role='alert'> " . PHP_EOL);
              print("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>");
                
              foreach ($data['success'] as $key => $value) {
                  $htmlTagOpen   = "";
                  $htmlTagClose  = "<br />";
            
                  $errorName = $key;
      
                  if (isset($data['success'][$key]['htmlTag']) && !empty($data['success'][$key]['htmlTag'])) {
                      $htmlTagOpen   = "<"    . $data['success'][$key]['htmlTag'] . ">";
                      $htmlTagClose  = "</"   . $data['success'][$key]['htmlTag'] . ">";
                  }
               
                  print($htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['success'][$key]['value'] . $htmlTagClose . PHP_EOL);
              }
            
              print("</div> " . PHP_EOL);
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
    if( ENV_SHOW_ENV_VALUES ) {
//        print_r( $_ENV );
	print( "DW_USE: " . $_ENV['DW_USE'] . PHP_EOL );

	$serverName = $_ENV['DW_DB_HOST'];  
	$connectionInfo =
	[
	  "Database" => $_ENV['DW_DB_NAME'],
	  "UID" => $_ENV['DW_DB_USER'],
	  "PWD" => $_ENV['DW_DB_PASS'],
	  "CharacterSet" => "UTF-8",
	];
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

	if( $conn ) {
		print( "DW Status:  <strong>Connected</strong>" . PHP_EOL );
	}else{
		print( "DW Status:  <span style='color: red;'>Error Detected</span>" . PHP_EOL );
		print( "DW_DB_HOST: " . $_ENV['DW_DB_HOST'] . PHP_EOL );
		print( "DW_DB_USER: " . $_ENV['DW_DB_USER'] . PHP_EOL );
		print( "DW_DB_NAME: " . $_ENV['DW_DB_NAME'] . PHP_EOL );

		print_r( sqlsrv_errors() );
	}
    }
    
    if( ENV_SHOW_COOKIE_VALUES ) {
        $cookies = Yii::$app->request->cookies;
        print_r( $cookies );    
    }
    
    if( ENV_SHOW_SESSION_VALUES ) {
        $session = Yii::$app->session;
        print_r( $session );    
    }

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
