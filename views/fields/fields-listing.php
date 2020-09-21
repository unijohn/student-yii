<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;

    use app\controllers\FieldsController;

   $this->title = 'Framework | Form Fields | Index';
   $this->params['breadcrumbs'][] = $this->title;
   
   /*
    * Revisit issue where cookie times out
    */
    
//  FieldsController::debug( $data['filterForm'] );
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
               <h2>Find Form Fields</h2>
               <div id='formfields-search-form'>      
                  <?= $this->render('_fields-search', ['model' => $model, 'filterForm' => $data['filterForm'] ]); ?>  
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add Form Fields</h2>
               <div id='formfields-add-form'>      
                  <?= $this->render('_fields-listing-add', ['model' => $model, 'FormFields' => $data['FormFields'] ]); ?>  
               </div>
            </div>
            <div class="col-lg-4">
               <h2>[Form Fields TBD]</h2>
               <div id='formfields-tbd-form'>      
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
            'label' => 'ID',
            'format' => 'raw',
            'value' => function ($data) {
                return HTML::a($data['id'], Url::toRoute(['fields/view', 'id' => $data['id']  ], true));
            },
         ],
         [
            'attribute' => 'form_field',
            'label' => 'Type',
            'format' => 'raw',
            'value' => function ($data) {
                $strValue = "";
                if ($data['form_field'] == "0") {
                    $strValue = "Fields";
                }                
                elseif ($data['form_field'] == "1") {
                    $strValue = "Select";
                } elseif ($data['form_field'] == "2") {
                    $strValue = "Checkbox";
                } elseif ($data['form_field'] == "3") {
                    $strValue = "Radio";
                } else {
                    $strValue = $data['form_field'] ;
                }
               
                return HTML::a($strValue, Url::toRoute(['fields/view', 'id' => $data['id'] ], true));
            },
         ],
         [
            'attribute' => 'type_str',
            'label' => 'Grouping',
            'format' => 'raw',
            'value' => function ($data) {
                return HTML::a($data['type_str'], Url::toRoute(['fields/view', 'id' => $data['id']  ], true));
            },
         ],
         [
            'attribute' => 'description',
            'label' => 'Description',
            'format' => 'raw',
            'value' => function ($data) {
                return HTML::a($data['description'], Url::toRoute(['fields/view', 'id' => $data['id']  ], true));
            },
         ],
         [
            'attribute' => 'value',
            'label' => 'Value (Str)',
            'format' => 'raw',
            'value' => function ($data) {
                return HTML::a($data['value_str'], Url::toRoute(['fields/view', 'id' => $data['id']  ], true));
            },
         ],
         [
            'attribute' => 'value',
            'label' => 'Value (#)',
            'format' => 'raw',
            'value' => function ($data) {
                return HTML::a($data['value'], Url::toRoute(['fields/view', 'id' => $data['id']  ], true));
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
                    return HTML::a("<span class='glyphicon glyphicon-chevron-up'></span>", Url::toRoute(['fields/first', 'id' => $model['id'], ], true));
                },     
                'up' => function($url, $model, $key) {     // render your custom button                
                    return HTML::a("<span class='glyphicon glyphicon-arrow-up'></span>", Url::toRoute(['fields/up', 'id' => $model['id'] ], true));
                },
                'down' => function($url, $model, $key) {     // render your custom button                                   
                    return HTML::a("<span class='glyphicon glyphicon-arrow-down'></span>", Url::toRoute(['fields/down', 'id' => $model['id']  ], true));
                },
                'bottom' => function($url, $model, $key) {     // render your custom button                                   
                    return HTML::a("<span class='glyphicon glyphicon-chevron-down'></span>", Url::toRoute(['fields/last', 'id' => $model['id']  ], true));
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

