<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Framework | Roles | Action';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the <? print( $this->title ); ?> page. You may modify the following file to customize its content:
    </p>
    
<?php
   if( $data )
   {
      echo ( "<Pre>" );
      print_r( $data );
      echo ( "</Pre>" );

      echo ( "<Pre>" );      
      foreach( $data as $gRKey => $getRole )
      {
         foreach( $getRole as $rKey => $role )
         {
            print( $rKey . "] " . $role['type'] . " :: " . $role['description'] );
//            print_r( $role );
         }
      }      
      echo ( "</Pre>" );
   }
 ?>

    <code><?= __FILE__ ?></code>
</div>
