<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   

   $this->title = 'Permits | Manage-Admin | Index';
   $this->params['breadcrumbs'][] = $this->title;  
   
   /*
    * Revisit issue where cookie times out
    */
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      
<?php
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

/**      
         foreach( $data['errors'][$key1] as $key2 => $value2 )
         {
            $htmlTagOpen   = "";
            $htmlTagClose  = "";
               
            if( strcmp( $key2, 'htmlTag' ) == 0 )
            {
               $htmlTagOpen   = "<"    . $data['errors'][$key2] . ">";
               $htmlTagClose  = "</"   . $data['errors'][$key2] . ">";          
            }
         
            print( "<h4>" . $key2  . "</h4>" );          
 **/         
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

/**      
         foreach( $data['errors'][$key1] as $key2 => $value2 )
         {
            $htmlTagOpen   = "";
            $htmlTagClose  = "";
               
            if( strcmp( $key2, 'htmlTag' ) == 0 )
            {
               $htmlTagOpen   = "<"    . $data['errors'][$key2] . ">";
               $htmlTagClose  = "</"   . $data['errors'][$key2] . ">";          
            }
         
            print( "<h4>" . $key2  . "</h4>" );          
 **/         
            print( $htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['success'][$key]['value'] . $htmlTagClose . PHP_EOL);
      }
      
      print( "</div> " . PHP_EOL );      
   }   
 ?>
      
      <p>
         This is the <?php print( $this->title ); ?> page. You may modify the following file to customize its content:
      </p>
    
      <div class="body-content">
         <div class="row">      
            <div class="col-lg-4">
               <h2>Find Permits</h2>
               <div id='permits-search-form'>      
               
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add Permits</h2>
               <div id='permits-add-form'>      

               </div>
            </div>
            <div class="col-lg-4">
               <h2>[Permits TBD]</h2>
               <div id='permits-tbd-form'>      
                  &nbsp;
               </div>
            </div>
         </div>            

         <div class="row">
            &nbsp;
         </div>      
      
         <div class="row">
         
<?=
   GridView::widget([
       'dataProvider'   => $dataProvider,
       'columns' => [
//         [ 'class' => 'yii\grid\CheckboxColumn' ],
         [
            'attribute' => 'id',
            'label'     => 'ID',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['id'], Url::toRoute( ['permits/manage-admin/view', 'id' => $data['id'] ], true) );
            },
         ],
         'code',
         'description',
         
         'created_at:datetime',
         'updated_at:datetime',
       
       ],
//       'showFooter' => false,
//       'placeFooterAfterBody' => false,
   ]); 
?>  
         </div>       

         <code><?= __FILE__ ?></code>
         
      </div>
   </div>

