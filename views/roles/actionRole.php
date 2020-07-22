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
   if( $data )
   {
      if( isset( $data['errors'] ) && !empty( $data['errors'] ) )
      {
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
      
      if( isset( $data['success'] ) && !empty( $data['success'] ) )
      {
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

      echo ( "<Pre>" );
      print_r( $data );
      echo ( "</Pre>" );
   }
 ?>

    <code><?= __FILE__ ?></code>
</div>
