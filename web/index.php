<?php
    require __DIR__ . '/../vendor/autoload.php';

    // comment out the following two lines when deployed to production
    defined('YII_DEBUG')                or define('YII_DEBUG', true);
    defined('YII_ENV')                  or define('YII_ENV', 'dev');
    defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', true);    
    
    if( YII_ENV == 'test' || YII_ENV == 'prod') {
        defined('CAS_ENABLED') or define('CAS_ENABLED', true);
    }
    else {
        defined('CAS_ENABLED') or define('CAS_ENABLED', false);
    }    
    
    // Load .env and then handle definitions
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    
    // Data Warehouse values here
    if( isset( $_ENV['DW_USE']) && !empty( $_ENV['DW_USE'] ) ){
        if( $_ENV['DW_USE'] ) {
            foreach( $_ENV as $key => $val ){
                if( $val === "false" ){
                    defined( "ENV_" . $key ) or define( "ENV_" . $key, false );
                } elseif( $val === "true" ){
                    defined( "ENV_" . $key ) or define( "ENV_" . $key, true );                    
                } else {
                    defined( "ENV_" . $key ) or define( "ENV_" . $key, $val );                    
                }
            }
        }
    }

    require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
    
    $config = require __DIR__ . '/../config/web.php';
    
    (new yii\web\Application($config))->run();
