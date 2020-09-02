<?php

namespace app\controllers;

use phpCAS;

use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\controllers\BaseController;

use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

use app\modules\Cas;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
    * @inheritdoc
    */
    public function actions()
    {
        $actions = parent::actions();
      
        $actions['captcha'] = [
          'class' => 'yii\captcha\CaptchaAction',
          'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ];
   
        return $actions;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!CAS_ENABLED) {    
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }
    
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login(Yii::$app->user, 3660)) {
                return $this->goBack();
            }
    
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        } else {
            $userModel = new User();
            $cas = new Cas('noideawtf');
        
            phpCAS::forceAuthentication();

		$uuid = phpCAS::getUser();

            $user = $userModel->findByUUID( $uuid);

            if (!isset($user) || empty($user)) {
                if( !$userModel->addUser( $uuid ) ) {
			print( "User: $uuid"  . PHP_EOL );
                    die( "Gotta figure this logic out" );
                }
                else{
                    $user = $userModel->findByUUID(phpCAS::getUser());
                }
            }

            Yii::$app->getUser()->login($user);
            return $this->goHome();
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if (!CAS_ENABLED) {
            Yii::$app->user->logout();
    
            return $this->goHome();
        } else {

		$cas = new Cas('noideawtf');

		// Logic To Be Determined
		// Logging out of phpCAS logs out across all UofM properties
		// Yii::$app->getUser()->logout() is for this application only
		Yii::$app->getUser()->logout();
//		phpCAS::logout(['url' => 'https://itfcbewebldev.memphis.edu/workdesk/web/' ]);

		return $this->redirect(['site/index']);
        }
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    
    /**
     * Displays about page.
     *
     * @return string

    public function actionTestme()
    {
        return $this->render('testme');
    }
    */
}
