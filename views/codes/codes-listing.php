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
         This is the <?php print($this->title); ?> page. You may modify the following file to customize its content: <?php print($data['filterForm']['paginationCount']); ?>
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
                     'is_visible'          => $data['filterForm']['is_visible'],
                     'pagination_count'   => $data['filterForm']['paginationCount']
                  ]); ?>   
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add System Codes</h2>
               <div id='systemcodes-add-form'>      
                  <?= $this->render('_codes-listing-add', ['model' => $model, 'filterForm' => $data['filterForm'] ]); ?>  
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
            'attribute' => 'type_str',
            'label' => 'Type',
            'format' => 'raw',
            'value' => function ($data) {
                $strValue = "";
                if ($data['type'] == "1") {
                    $strValue = "Permit";
                } elseif ($data['type'] == "2") {
                    $strValue = "Departments";
                } elseif ($data['type'] == "3") {
                    $strValue = "Career-Levels";
                } elseif ($data['type'] == "4") {
                    $strValue = "Masters";
                } elseif ($data['type'] == "5") {
                    $strValue = "Faculty-Rank";
                } elseif ($data['type'] == "6") {
                    $strValue = "Employee-Class";
                } elseif ($data['type'] == "7") {
                    $strValue = "Departments-School";
                } elseif ($data['type'] == "8") {
                    $strValue = "Departments-University";
                } 
                
                else {
                    $strValue = $data['type'] ;
                }
               
                return HTML::a($strValue, Url::toRoute(['codes/view', 'id' => $data['id'] ], true));
            },
         ],
         [
            'attribute' => 'code_str',
            'label' => 'Code',
            'format' => 'raw',
            'value' => function ($data) {
                return HTML::a($data['code_str'], Url::toRoute(['codes/view', 'id' => $data['id']  ], true));
            },
         ],
         [
            'attribute' => 'description',
            'label' => 'Description',
            'format' => 'raw',
            'value' => function ($data) {
                return HTML::a($data['description'], Url::toRoute(['codes/view', 'id' => $data['id']  ], true));
            },
         ],
         
         'created_at:datetime',
         'updated_at:datetime',
         
         [
            'attribute' => 'order_by',
            'label' => 'Ordering',
         ],


        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Ordering',            
            'template' => '{top} {up} {down} {bottom}',  // the default buttons + your custom button
            'buttons' => [
                'top' => function($url, $model, $key) {     // render your custom button                                   
                    return HTML::a("<span class='glyphicon glyphicon-chevron-up'></span>", Url::toRoute(['codes/first', 'id' => $model['id'], ], true));
                },     
                'up' => function($url, $model, $key) {     // render your custom button                
                    return HTML::a("<span class='glyphicon glyphicon-arrow-up'></span>", Url::toRoute(['codes/up', 'id' => $model['id'] ], true));
                },
                'down' => function($url, $model, $key) {     // render your custom button                                   
                    return HTML::a("<span class='glyphicon glyphicon-arrow-down'></span>", Url::toRoute(['codes/down', 'id' => $model['id']  ], true));
                },
                'bottom' => function($url, $model, $key) {     // render your custom button                                   
                    return HTML::a("<span class='glyphicon glyphicon-chevron-down'></span>", Url::toRoute(['codes/last', 'id' => $model['id']  ], true));
                }                
            ]
        ],         
      
      ],
//       'showFooter' => false,
//       'placeFooterAfterBody' => false,
   ]);
?>  
         </div>       

         <code><?= __FILE__ ?></code>
         
      </div>
   </div>

