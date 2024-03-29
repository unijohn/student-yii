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
      
      <?= $this->render('/common/_alert', ['data' => $data]); ?>
      
      <p>
         This is the <?php print($this->title); ?> page. You may modify the following file to customize its content:
      </p>
    
      <div class="body-content">
         <div class="row">      
            <div class="col-lg-4">
               <h2>Find Users</h2>
               <div id='users-search-form'>      
                  <?= $this->render('_users-search', ['model' => $model, 'filterForm' => $data['filterForm'] ]); ?>      
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add Users</h2>
               <div id='users-add-form'>      
                  <?= $this->render('_users-listing-add', ['model' => $model, ]); ?>  
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
            'value' => function ($data) {
                return HTML::a($data['uuid'], Url::toRoute(['users/view', 'uuid' => $data['uuid'] ], true));
            },
         ],
//         'name',
         
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

