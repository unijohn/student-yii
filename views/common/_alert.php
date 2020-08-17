<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
      
   $formatter = \Yii::$app->formatter;   
?>

<?php
   if( isset( $data['errors'] ) && !empty( $data['errors'] ) )
   {
      print( "<div class='alert alert-danger' role='alert'> " . PHP_EOL );
      print( "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" );
          
      foreach( $data['errors'] as $key => $value )
      {
         $htmlTagOpen   = "";
         $htmlTagClose  = "<br />";

         if( isset( $data['errors'][$key]['htmlTag'] ) && !empty( $data['errors'][$key]['htmlTag'] ) )
         {
            $htmlTagOpen   = "<"    . $data['errors'][$key]['htmlTag'] . ">";
            $htmlTagClose  = "</"   . $data['errors'][$key]['htmlTag'] . ">";             
         } 
         
         $errorName = str_replace( "_", " ", $key );
         $errorName = str_replace( "-", " ", $errorName );

         print( $htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['errors'][$key]['value'] . $htmlTagClose . PHP_EOL);
      }
      
      print( "</div> " . PHP_EOL );      
   }
   
   if( isset( $data['success'] ) && !empty( $data['success'] ) )
   {
      print( "<div class='alert alert-success' role='alert'> " . PHP_EOL );
      print( "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" );
          
      foreach( $data['success'] as $key => $value )
      {
         $htmlTagOpen   = "";
         $htmlTagClose  = "<br />";
      
         if( isset( $data['success'][$key]['htmlTag'] ) && !empty( $data['success'][$key]['htmlTag'] ) )
         {
            $htmlTagOpen   = "<"    . $data['success'][$key]['htmlTag'] . ">";
            $htmlTagClose  = "</"   . $data['success'][$key]['htmlTag'] . ">";             
         }
         
         $successName = str_replace( "_", " ", $key );
         $successName = str_replace( "-", " ", $successName );
         
         print( $htmlTagOpen . "<strong>" . $successName . " </strong> " . $data['success'][$key]['value'] . $htmlTagClose . PHP_EOL);
      }
      
      print( "</div> " . PHP_EOL );      
   }   
 ?>