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
   //     ['label' => 'About', 'url' => ['/site/about']],
   //     ['label' => 'Contact', 'url' => ['/site/contact']],
         ['label' => 'Permits', 'url' => ['/permits/index']],    
       ];
   
      if( Yii::$app->user->isGuest )
      {
         $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
      }
      else
      {
         if( Yii::$app->user->identity->isAdministrator( Yii::$app->user->identity->getId() ) )
         {
            $menuItems[] = ['label' => 'Users', 'url' => ['/users/index']];
         }   
         
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
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>


    <div>
      <pre>

      <?php
         if( !Yii::$app->user->isGuest )
         {      
/**         
            $record = Yii::$app->user->identity->canInsertById( Yii::$app->user->identity->getId());            
            if( $record )
            {
               print( "<br />Can Insert: " . $record['name'] . "<br />" );
//               print_r( $record ); 
            }                
                   
            $record = Yii::$app->user->identity->canUpdateById( Yii::$app->user->identity->getId());            
            if( $record )
            {
               print( "<br />Can Update: " . $record['name'] . "<br />" );
//               print_r( $record ); 
            }               
            
            $record = Yii::$app->user->identity->canSoftDeleteById( Yii::$app->user->identity->getId());            
            if( $record )
            {
               print( "<br />Can SoftDelete: " . $record['name'] . "<br />" );
//               print_r( $record ); 
            }                   
            
            $record = Yii::$app->user->identity->canHardDeleteById( Yii::$app->user->identity->getId());            
            if( $record )
            {
               print( "<br />Can HardDelete: " . $record['name'] . "<br />" );
//               print_r( $record ); 
            }                
            
            $record = Yii::$app->user->identity->isAdministrator( Yii::$app->user->identity->getId());            
            if( $record )
            {
               print( "<br />Is Administrator: " . $record['name'] . "<br />" );               
//               print_r( $record ); 
            }                           
 **/
         }
      ?>
      
<!--      
      <?= print_r( Yii::$app->user->identity ); ?>
 -->
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
