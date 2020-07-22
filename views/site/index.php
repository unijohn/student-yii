<?php
   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
   use yii\helpers\Url;   
   
   use yii\grid\GridView;
   
   use app\models\User; 

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

$auth = Yii::$app->authManager;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations! Site/Index</h1>

<!--
        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
 -->        
    </div>

<?php
   if( isset( $data ) && !empty( $data ) )
   {
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
            
            print( $htmlTagOpen . "<strong>" . $errorName . " </strong> " . $data['success'][$key]['value'] . $htmlTagClose . PHP_EOL);
         }
         
         print( "</div> " . PHP_EOL );      
      }   
/**
      echo ( "<Pre>" );
      print_r( $data );
      echo ( "</Pre>" );
 **/
   }
 ?>

    <div class="body-content">

        <div class="row">

<?php
   /**
    *  Framework section of the dashboard
    **/

   $userId = -1;
   $isFrameworkAdmin = false;
   $isAssignedRole   = false;


   /**
    *  Quick fix for cookie timeout
    **/
   if( !is_null( Yii::$app->user->identity ) )
   {
      $userId           = Yii::$app->user->identity->getId();
      $isFrameworkAdmin = Yii::$app->user->identity->isFrameworkAdministrator( $userId );
      $isAssignedRole   = Yii::$app->user->identity->isAssignedTemporaryRole( $userId );      
   }

   if (
      \Yii::$app->user->can('[Framework][Access][Permit]' )  ||
      \Yii::$app->user->can('[Framework][Access][GAApp]'  )  ||
      \Yii::$app->user->can('[Framework][Access][Sylla]'  )  ||
      
      $isFrameworkAdmin
   ) {
 ?>

            <div class="col-lg-4">
                <h2>System</h2>

<?php
   /****
    **  Framework section of the dashboard :: Action Access
    ****/
    
   print( "<ul>" );
    
   if (
      \Yii::$app->user->can('[Framework][Role][Permit]' )  ||
      \Yii::$app->user->can('[Framework][Role][GAApp]'  )  ||
      \Yii::$app->user->can('[Framework][Role][Sylla]'  )  ||
      
      $isFrameworkAdmin
   ) 
   {
      print( "<li>" );
      print( HTML::a( "User Management", Url::toRoute( ['users/index', ], true) ) );
      print( "</li>" );

      print( "<ul>" );
      print(   "<li>Switch Role Identity</li>" );
      print(   "<ul>" );
      
      if( $isAssignedRole )
      {
         print( "<li>" );
         print( HTML::a( 'Restore Role', Url::toRoute( ['roles/reset', 'reset' => 'reset',], true) ) );
         print( "</li>" );      
      }
      else
      {      
         foreach( $auth->getRoles() as $role )
         {
            if( strpos( $role->description, "(10)" ) === false )
            {
               print( "<li>" );
               print( HTML::a( $role->description, Url::toRoute( ['roles/switch', 'role' => $role->name,], true) ) );
               print( "</li>" );
            }
         }
      }
      
      print(   "</ul>" );
      print( "</ul>" );      
   }
   
   if (
      \Yii::$app->user->can('[Framework][Synch][Permit]' )  ||
      \Yii::$app->user->can('[Framework][Synch][GAApp]'  )  ||
      \Yii::$app->user->can('[Framework][Synch][Sylla]'  )  ||
      
      $isFrameworkAdmin
   ) 
   {
      print( "<li>" );   
      print( HTML::a( "Data Synchronization", Url::toRoute( ['framework/index', ], true) ) );   
      print( "</li>" );
   }   
   
   if (
      \Yii::$app->user->can('[Framework][Backup][Permit]' )  ||
      \Yii::$app->user->can('[Framework][Backup][GAApp]'  )  ||
      \Yii::$app->user->can('[Framework][Backup][Sylla]'  )  ||
      
      $isFrameworkAdmin
   ) 
   {
      print( "<li>" );
      print( HTML::a( "Data Backup", Url::toRoute( ['framework/index', ], true) ) );    
      print( "</li>" );
   }     
   
   print( "</ul>" );
   
   /****
    **  Eo Framework section of the dashboard :: Action Access
    ****/   
 ?>                

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
<?php
}    

   /**
    *  Eo Framework section of the dashboard
    **/
 ?>


<?php
   /**
    *  Permit section of the dashboard
    **/

   if (
      \Yii::$app->user->can('[Framework][Access][Permit]'   )  ||
      \Yii::$app->user->can('[Student][Access][Permit]'     )
   ) {
 ?>

            <div class="col-lg-4">
                <h2>Permits</h2>
                
<?php
   if (\Yii::$app->user->can('[Framework][Access][Permit]')  )
   {
      print( "<h3>Administrator [10]</h3>" );
   } 
 ?>

<?php
   /****
    **  Permit section of the dashboard :: Action Access
    ****/
    
   print( "<ul>" );

   if (
      \Yii::$app->user->can('[Framework][Access][Permit]' )  ||
      \Yii::$app->user->can('[Student][Access][Permit]'   ) 
   ) 
   {
      print( "<li>" );
      print( HTML::a( "Request a Permit", Url::toRoute( ['permits/index', ], true) ) );
      print( "</li>" );      
   }
    
   if (
      \Yii::$app->user->can('[Framework][Create][Permit]'   )  ||
      \Yii::$app->user->can('[Student][Create][UGAD]'       )  ||
      \Yii::$app->user->can('[Student][Create][GRAD]'       )  ||
      \Yii::$app->user->can('[Student][Create][PHD]'        ) 
   ) 
   {
      print( "<li>" );
      print( HTML::a( "Create a Permit Request", Url::toRoute( ['permits/index', ], true) ) );
      print( "</li>" );      
   }
   
   if (
      \Yii::$app->user->can('[Framework][Update][Permit]'   )  ||
      \Yii::$app->user->can('[Framework][Update][Permit]'   )  ||
      \Yii::$app->user->can('[Student][Update][UGAD]'       )  ||
      \Yii::$app->user->can('[Student][Update][GRAD]'       )  ||
      \Yii::$app->user->can('[Student][Update][PHD]'        )       
   ) 
   {
      print( "<li>" );   
      print( HTML::a( "Review / Approve Permit Requests", Url::toRoute( ['permits/index', ], true) ) );   
      print( "</li>" );
   }

   if (
      \Yii::$app->user->can('[Framework][Role][Permit]'  )  ||
      \Yii::$app->user->can('[Student][Role][Permit]'    )    
   ) 
   {
      print( "<li>" );
      print( HTML::a( "User Management", Url::toRoute( ['permits/index', ], true) ) );
      print( "</li>" );      
   }   
   
   if (
      \Yii::$app->user->can('[Framework][Backup][Permit]'   )  ||
      \Yii::$app->user->can('[Student][Backup][Permit]'     )   
   ) 
   {
      print( "<li>" );
      print( HTML::a( "Data Backup", Url::toRoute( ['permits/index', ], true) ) );    
      print( "</li>" );
   }     
   
   print( "</ul>" );
   
   /****
    **  Eo Permit section of the dashboard :: Action Access
    ****/   
 ?>   


                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
<?php
}    

   /**
    *  Eo Permit section of the dashboard
    **/
 ?>
 
 <?php
   /**
    *  GAApp section of the dashboard
    **/

   if (
      \Yii::$app->user->can('[Framework][Access][Permit]'   )  ||
      \Yii::$app->user->can('[Student][Access][Permit]'     )
   ) {
 ?>

            <div class="col-lg-4">
                <h2>Graduate Assistant Applications</h2>
                
<?php
   if (\Yii::$app->user->can('[Framework][Access][Permit]')  )
   {
      print( "<h3>Administrator [10]</h3>" );
   } 
 ?>

<?php
   /****
    **  GAApp section of the dashboard :: Action Access
    ****/
    
   print( "<ul>" );

   if (
      \Yii::$app->user->can('[Framework][Access][GRAD]' )  ||
      \Yii::$app->user->can('[Student][Access][GRAD]'   ) 
   ) 
   {
      print( "<li>" );
      print( HTML::a( "Submit an Application", Url::toRoute( ['gaapps/index', ], true) ) );
      print( "</li>" );      
   }

/**    
   if (
      \Yii::$app->user->can('[Framework][Create][GRAD]' )  ||
      \Yii::$app->user->can('[Student][Create][GRAD]'   ) 
   ) 
   {
      print( "<li>" );
      print( HTML::a( "Create a Permit Request", Url::toRoute( ['permits/index', ], true) ) );
      print( "</li>" );      
   }
 **/
   
   if (
      \Yii::$app->user->can('[Framework][Update][GRAD]'   )  ||
      \Yii::$app->user->can('[Student][Update][GRAD]'     ) 
   ) 
   {
      print( "<li>" );   
      print( HTML::a( "Review Application", Url::toRoute( ['gaapps/index', ], true) ) );   
      print( "</li>" );
   }

   if (
      \Yii::$app->user->can('[Framework][Role][GRAD]'  )  ||
      \Yii::$app->user->can('[Student][Role][GRAD]'    )
   ) 
   {
      print( "<li>" );
      print( HTML::a( "User Management", Url::toRoute( ['gaapps/index', ], true) ) );
      print( "</li>" );      
   }   
   
   if (
      \Yii::$app->user->can('[Framework][Backup][GRAD]'   )  ||
      \Yii::$app->user->can('[Student][Backup][GRAD]'     )   
   ) 
   {
      print( "<li>" );
      print( HTML::a( "Data Backup", Url::toRoute( ['gaapps/index', ], true) ) );    
      print( "</li>" );
   }     
   
   print( "</ul>" );
   
   /****
    **  Eo GAApp section of the dashboard :: Action Access
    ****/   
 ?>   


                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
<?php
}    

   /**
    *  Eo GAApp section of the dashboard
    **/
 ?>
 



        </div>

    </div>
</div>
