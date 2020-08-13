<?php

/* @var $this yii\web\View */

   use yii\grid\GridView;   

   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   

   $this->title = 'Framework | Courses | Index';
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
               <h2>Find Courses</h2>
               <div id='courses-search-form'>      
                  <?= $this->render('_courses-search', [
                     'model'              => $model, 
                     'model_subjects'     => $modelSubjects,
                     'course_number'      => $data['filterForm']['course_number'],                     
                     'is_active'          => $data['filterForm']['is_active'], 
                     'is_hidden'          => $data['filterForm']['is_hidden'], 
                     'pagination_count'   => $data['filterForm']['paginationCount'],
                     'subject_area'       => $data['filterForm']['subject_area'],
                  ]); ?>    
               </div>
            </div>
            <div class="col-lg-4">
               <h2>Add Courses</h2>
               <div id='courses-add-form'>      
                  <?= $this->render('_courses-listing-add', ['model' => $model, ]); ?>  
               </div>
            </div>
            <div class="col-lg-4">
               <h2>[Courses TBD]</h2>
               <div id='courses-tbd-form'>      
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
            'attribute' => 'subject_area',
            'label' => 'Subject',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['subject_area'], Url::toRoute( ['courses/view', 'id' => $data['id'] ], true) );
            },
         ],
         [
            'attribute' => 'course_number',
            'label' => 'Course',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['course_number'], Url::toRoute( ['courses/view', 'id' => $data['id']  ], true) );
            },
         ],
         [
            'attribute' => 'section_number',
            'label' => 'Section',
            'format' => 'raw',
            'value' => function( $data ){
               return HTML::a( $data['section_number'], Url::toRoute( ['courses/view', 'id' => $data['id']  ], true) );
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

