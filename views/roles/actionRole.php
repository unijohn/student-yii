<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Framework | Roles | Action';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the <?php print( $this->title ); ?> page. You may modify the following file to customize its content:
    </p>
    
<?php
   if( isset( $data ) && !empty( $data ) )
   {
/**
      echo ( "<Pre>" );
      print_r( $data );
      echo ( "</Pre>" );
 **/
   }
 ?>

    <code><?= __FILE__ ?></code>
</div>
