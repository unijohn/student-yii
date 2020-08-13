<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   

   $this->title = 'Framework | System Codes | Index';
   $this->params['breadcrumbs'][] = $this->title;  
   
   /*
    * Revisit issue where cookie times out
    */
?>

   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      
      <?= $this->render('/common/_alert', ['data' => $data]); ?>
      
      <p>
         This is the <?php print( $this->title ); ?> page. You may modify the following file to customize its content: <? print( $data['filterForm']['paginationCount'] ); ?>
      </p>
    
      <div class="body-content">
         <div class="row">      
            <div class="col-lg-4">
               <h2>Find System Codes</h2>
               <div id='systemcodes-search-form'>      
                  <?= $this->render('_codes-search', [
                     'model'              => $model, 
                     'type'               => $data['filterForm']['type'],
                     'is_active'          => $data['filterForm']['is_active'], 
                     'is_hidden'          => $data['filterForm']['is_hidden'], 
                     'pagination_count'   => $data['filterForm']['paginationCount'] 
                  ]); ?>   
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add System Codes</h2>
               <div id='systemcodes-add-form'>      
                  <?= $this->render('_codes-listing-add', ['model' => $model, ]); ?>  
               </div>
            </div>
            <div class="col-lg-4">
               <h2>[System Codes TBD]</h2>
               <div id='systemcodes-tbd-form'>      
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
/**
         [
            'attribute' => 'id',
            'label'     => 'ID',
         ],
 **/
         [
            'attribute' => 'type',
            'label' => 'Type',
            'format' => 'raw',
            'value' => function( $data ){
               $strValue = "";
               if( $data['type'] == "1" ) $strValue = "Permit";
               else if( $data['type'] == "2" ) $strValue = "Department";
               else if( $data['type'] == "3" ) $strValue = "CareerLevel";
               else if( $data['type'] == "4" ) $strValue = "Masters";
                              
               else $strValue = $data['type'] ;          
               
               return HTML::a( $strValue, Url::toRoute( ['codes/view', 'id' => $data['id'] ], true) );
            },
         ],
         [
            'attribute' => 'code',
            'label' => 'Code',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['code'], Url::toRoute( ['codes/view', 'id' => $data['id']  ], true) );
            },
         ],
         [
            'attribute' => 'description',
            'label' => 'Description',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['description'], Url::toRoute( ['codes/view', 'id' => $data['id']  ], true) );
            },
         ],   
         
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

