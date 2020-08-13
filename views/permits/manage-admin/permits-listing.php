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
      
      <?= $this->render('/common/_alert', ['data' => $data]); ?>
      
      <p>
         This is the <?php print( $this->title ); ?> page. You may modify the following file to customize its content:
      </p>
    
      <div class="body-content">
         <div class="row">      
            <div class="col-lg-4">
               <h2>Find Permits</h2>
               <div id='permits-search-form'>      
                  <?= $this->render('_permits-search', [
                     'model'     => $model, 
                     'code'      => $data['filterForm']['code'],
                     'is_active' => $data['filterForm']['is_active'], 
                     'is_hidden' => $data['filterForm']['is_hidden'], 
                     'pagination_count' => $data['filterForm']['paginationCount'] 
                  ]); ?>      
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add Permits</h2>
               <div id='permits-add-form'>      
                  <?= $this->render('_permits-listing-add', ['model' => $model, ]); ?>  
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

         [
            'attribute' => 'code',
            'label'     => 'Code',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['code'], Url::toRoute( ['permits/manage-admin/view', 'id' => $data['id'] ], true) );
            },
         ],


         [
            'attribute' => 'description',
            'label'     => 'Description',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['description'], Url::toRoute( ['permits/manage-admin/view', 'id' => $data['id'] ], true) );
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

