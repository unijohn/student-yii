<?php

namespace app\modules;

use phpCAS;

use Yii;
//use yii\base\BootstrapInterface;
use yii\base\Module;

class Cas extends Module //implements BootstrapInterface
{
//	public $controllerNamespace = 'app\modules\home\controllers';
	
	private $_user;
	
	public function init() {
        parent::init();   
        
        $this->_user = Yii::$app->user;
        
        $this->_startCAS();
        
//        if( !$this->_user->isGuest ) {
//            Yii::$app->getUser()->login( $this->_user->getUser() );
//        }
//        else {
//            Yii::$app->getUser()->logout(true);
//        }
    }
	    

/**
	public function bootstrap($app)
	{
		if ($app->hasModule('cas') && ($module = $app->getModule('cas')) instanceof Module)
		{
			$this->_startCAS();
			if (\Yii::$app->user->isGuest)
			{
				$this->_yiiAccess();
			}
		}
	}
 **/

	private function _yiiAccess()
	{
		if (!Yii::$app->casUser->isGuest)
		{
			$u = new CasInterface();
			$u->username = Yii::$app->casUser->getUser();

			\Yii::$app->getUser()->login($u);
		}
		else
		{
			\Yii::$app->getUser()->logout(true);
		}
	}

	private function _startCAS()
	{
		$params = Yii::$app->params['cas'];
		
		$host       = $params['host'];
		$port       = $params['port'];
		$uri        = $params['uri'];

		if( YII_ENV_DEV ) {
			$filename   = __DIR__ . '../../logs/phpCas.log';
		}
		else {
			$filename   = '/var/www/itfcbewebldev.edu/html/workdesk/logs/phpCas.log';
		}

/*
		if( file_exists( $filename ) ) {

		}
		else {
			if( touch( $filename ) ){
				echo "Yes";
			}
			else {
				die( "no" );
			}
		}
 */

		// Enable debugging
		phpCAS::setDebug($filename);

/*
        print( "<pre>" );

		print( 'Client configuration' . PHP_EOL );
        phpCAS::log ('Client configuration');		
 */

		// Initialize phpCAS
		phpCAS::client(CAS_VERSION_2_0, $host, $port, $uri);
		phpCAS::setNoCasServerValidation();
	}

}
