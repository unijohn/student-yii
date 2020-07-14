<?php
   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   
   use yii\grid\GridView;   

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

$auth = Yii::$app->authManager;
?>
   <div class="site-about">
      <h1><?= Html::encode($this->title) ?></h1>
      <p>
         This is the Framework | Users page. You may modify the following file to customize its content:
      </p>

      <div id=users-search-form'>      
<?= $this->render('_users-search', ['model' => $model]); ?>      
      </div>
    
      <div class="body-content">
         <div class="row">
         
<?= 
GridView::widget([
    'dataProvider'   => $dataProvider,
    'columns' => [
//      [ 'class' => 'yii\grid\CheckboxColumn' ],
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
//    'showFooter' => false,
//    'placeFooterAfterBody' => false,
]); 
?>  
         </div>       

         <code><?= __FILE__ ?></code>
         
      </div>
   </div>

