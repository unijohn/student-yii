<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   

   $this->title = 'Framework | Users | Index';
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

/**            
         }
 **/

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
               <h2>Find Users</h2>
               <div id='users-search-form'>      
                  <?= $this->render('_users-search', ['model' => $model, 'pagination_count' => $data['filterForm']['paginationCount'] ]); ?>      
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add Users</h2>
               <div id='users-add-form'>      
                  <?= $this->render('_users-view-add', ['model' => $model, ]); ?>  
               </div>
            </div>
            <div class="col-lg-4">
               <h2>[Users TBD]</h2>
               <div id='users-tbd-form'>      
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
         ],
         [
            'attribute' => 'uuid',
            'label' => 'UUID',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['uuid'], Url::toRoute( ['users/view', 'uuid' => $data['uuid'] ], true) );
            },
         ],
         'name',
         
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

