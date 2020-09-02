<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [

   /**
    *    Basic site configurations
    **/

    'id' => 'basic',
    'name' => 'FCBE Workdesk',
    'language' => 'en-US',
    'charset' => 'UTF-8',    
    'timeZone' => 'America/Chicago',    
    
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    
    'controllerMap' => [
        // declares "users" controller using a class name
        'users' => 'app\controllers\UsersController',
    ],    

    'components' => [
        'assetManager' => 
        [
            'appendTimestamp' => true,
            'bundles' => 
            [
                'yii\web\JqueryAsset' => 
                [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => 
                    [
                        YII_ENV_DEV ? '//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js' : '//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
                        YII_ENV_DEV ? '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js' : '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js',
//                        YII_ENV_DEV ? '//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.js' : '//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js',
                    ]
                ],
            ],
        ],    
        'user' => [
            'class' => 'yii\web\User',
            
            // User must implement the IdentityInterface
            'identityClass' => 'app\models\User',
            
            // Whether to enable cookie-based login
            'enableAutoLogin' => false,

            // The number of seconds in which the user will be logged out automatically if session remains inactive. 
            // If this property is not set, the user will be logged out after the current session expires (c.f. yii\web\Session::$timeout). 
            //
            // Note that this will not work if $enableAutoLogin is true.
            'authTimeout'           => 60 * 30,
            'authTimeoutParam'      => '__frameworkExpire',
            'absoluteAuthTimeout'   => 60 * 60 * 4,

            'enableSession'      => true,
                       
            // Whether to automatically renew the identity cookie each time a page is requested.
            'autoRenewCookie'    => false,

        ],
        
        'session' => [
            'class'        => 'yii\web\Session',
            'cookieParams' => [
               'httponly'  => true,
               'lifetime'  => 60 * 60 * 2
            ],
            
            // Session expire
            'timeout'      => 60 * 60 * 2,
            'useCookies'   => true,            
        ],
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            'cache' => 'cache',
        ],        
        
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'FTPxMj00QKgfj_Vkomgxvb6sw2JtRZT3',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            
            // dev:         showScriptName => true
            // test/prod:   showScriptName => false
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
//               'home' => '/site/index',
                'login'     => 'site/login',
                'users'     => 'users/index',
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['components']['urlManager']['showScriptName'] = true;
    
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
