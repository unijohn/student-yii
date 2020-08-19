<?php
   use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
   
   use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Framework | Roles | Index';
$auth = Yii::$app->authManager;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations! <?php print($this->title); ?></h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

<?php
   if ($data) {
       if (isset($data['errors']) && !empty($data['errors'])) {
           print("<div class='alert alert-danger' role='alert'> " . PHP_EOL);
             
           foreach ($data['errors'] as $key => $value) {
               $htmlTagOpen   = "";
               $htmlTagClose  = "<br />";
         
               $errorName = $key;
   
               if (isset($data['errors'][$key]['htmlTag']) && !empty($data['errors'][$key]['htmlTag'])) {
                   $htmlTagOpen   = "<"    . $data['errors'][$key]['htmlTag'] . ">";
                   $htmlTagClose  = "</"   . $data['errors'][$key]['htmlTag'] . ">";
               }
    
               print($htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['errors'][$key]['value'] . $htmlTagClose . PHP_EOL);
           }
         
           print("</div> " . PHP_EOL);
       }
      
       if (isset($data['success']) && !empty($data['success'])) {
           print("<div class='alert alert-success' role='alert'> " . PHP_EOL);
             
           foreach ($data['success'] as $key => $value) {
               $htmlTagOpen   = "";
               $htmlTagClose  = "<br />";
         
               $errorName = $key;
   
               if (isset($data['success'][$key]['htmlTag']) && !empty($data['success'][$key]['htmlTag'])) {
                   $htmlTagOpen   = "<"    . $data['success'][$key]['htmlTag'] . ">";
                   $htmlTagClose  = "</"   . $data['success'][$key]['htmlTag'] . ">";
               }
            
               print($htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['success'][$key]['value'] . $htmlTagClose . PHP_EOL);
           }
         
           print("</div> " . PHP_EOL);
       }

       echo("<Pre>");
       print_r($data);
       echo("</Pre>");
   }
 ?>

    <div class="body-content">

        <div class="row">

            <div class="col-lg-4">
                <h2>Roles</h2>             

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>

            <div class="col-lg-4">
                <h2>Roles</h2>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>

            <div class="col-lg-4">
                <h2>Roles</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>

        </div>
    </div>
</div>
