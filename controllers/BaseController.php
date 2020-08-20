<?php

namespace app\controllers;

use yii;

//use yii\data\ActiveDataProvider;
//use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;

//use app\models\AuthAssignment;
//use app\models\AuthItem;
use app\models\CoursesCodesChild;

use app\models\SystemCodes;
use app\models\SystemCodesChild;

//use app\models\User;


class BaseController extends Controller
{

   /**
    * Quick note:  to extend these values into controllers further down the line,
    *              make them `public`.  `private` will restrict them to the
    *              BaseController only.
    **/
    public $_auth;
    public $_cookies;
    public $_db;
    public $_data;
    public $_dataProvider;
    public $_request;
    public $_view;
    public $_user;

    private $_tbl_CoursesCodesChildName;

    private $_tbl_SystemCodesName;
    private $_tbl_SystemCodesChildName;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
      
        /**
         *  Quick fix for cookie timeout
         **/
        if (is_null(Yii::$app->user->identity)) {
            /* /site/index works but trying to learn named routes syntax */
            return $this->redirect(['/site/index']);
        }
      
        $this->_auth        = Yii::$app->authManager;
        $this->_cookies     = Yii::$app->response->cookies;
        $this->_db          = Yii::$app->db;
        $this->_request     = Yii::$app->request;
        $this->_view        = Yii::$app->view;
        $this->_user        = Yii::$app->user;

        $this->_data             = [];
        $this->_dataProvider     = [];
      
        /**
         *    Setting up values used within this class
         **/
        $this->_tbl_CoursesCodesChildName   = CoursesCodesChild::tableName();

        $this->_tbl_SystemCodesName         = SystemCodes::tableName();
        $this->_tbl_SystemCodesChildName    = SystemCodesChild::tableName();
      
        /**
         *    Capturing the possible post() variables used across all controllers
         **/
        $this->_data['id']      = $this->_request->post('id', '');
        $this->_data['uuid']    = $this->_request->post('uuid', '');
      
        $this->_data['errors']  = [];
        $this->_data['success'] = [];
        
        $_errors    = $this->_request->get('errors', '');
        $_success   = $this->_request->get('success', '');
        
        if (null !== $_errors && !empty($_errors)) {
            $this->_data['errors'] =  $_errors;
        }
        if (null !== $_success && !empty($_success)) {
            $this->_data['success'] =  $_success;
        }
    }


    /**
     * {@inheritdoc}
     */
 
    public function behaviors()
    {
        return [
/**
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
 **/
        ];
    }
   

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    

    public static function debug($msgObj, $willDie = true)
    {
        print("<pre> ++ BaseController ++" . PHP_EOL);
        var_dump($msgObj);
      
        if ($willDie) {
            die();
        }
    }


    /**
     * Addstag assigned to $tableNm
     *
     * @return bool if rows deleted are > 0
     */
    private function addTag($parentId, $childId, $tableNm)
    {
        /**
           Need to add error catching later or handle it in action before getting this far

                if ($this->isEmptyUserId($userId)) {
                    return false;
                }

                unset($this->_checkAccessAssignments[(string) $userId]);
         **/
        $created_at = time();
      
        /**
         *
         * I may be getting too clever for my own good.  Trying to overload this function to ensure
         * I have a single location for adding and removing tags
         *
         **/
      
        $parentIdIsNumeric   = is_numeric($parentId);
        $childIdIsNumeric    = is_numeric($childId);
      
        if (!$parentIdIsNumeric  && $childIdIsNumeric) {
            return $this->_db->createCommand()
            ->insert($tableNm, ['parent' => (string) $parentId, 'child' => (integer) $childId, 'created_at' => $created_at])
            ->execute() > 0;
        } elseif ($parentIdIsNumeric  && $childIdIsNumeric) {
            return $this->_db->createCommand()
            ->insert($tableNm, ['parent' => (integer) $parentId, 'child' => (integer) $childId, 'created_at' => $created_at])
            ->execute() > 0;
        } elseif (!$parentIdIsNumeric  && !$childIdIsNumeric) {
            return $this->_db->createCommand()
            ->insert($tableNm, ['parent' => (string) $parentId, 'child' => (string) $childId, 'created_at' => $created_at])
            ->execute() > 0;
        } else {
            return -1;
        }
    }


    /**
     * Removes tag assigned to $tableNm
     *
     * @return bool if rows deleted are > 0
     */
    private function removeTag($parentId, $childId, $tableNm)
    {
        /**
           Need to add error catching later or handle it in action before getting this far

                if ($this->isEmptyUserId($userId)) {
                    return false;
                }

                unset($this->_checkAccessAssignments[(string) $userId]);
         **/

        /**
         *
         * I may be getting too clever for my own good.  Trying to overload this function to ensure
         * I have a single location for adding and removing tags
         *
         **/
            
        $parentIdIsNumeric   = is_numeric($parentId);
        $childIdIsNumeric    = is_numeric($childId);
      
        if (!$parentIdIsNumeric  && $childIdIsNumeric) {
            return $this->_db->createCommand()
            ->delete($tableNm, ['parent' => (string) $parentId, 'child' => (integer) $childId])
            ->execute() > 0;
        } elseif ($parentIdIsNumeric  && $childIdIsNumeric) {
            return $this->_db->createCommand()
            ->delete($tableNm, ['parent' => (integer) $parentId, 'child' => (integer) $childId])
            ->execute() > 0;
        } elseif (!$parentIdIsNumeric  && !$childIdIsNumeric) {
            return $this->_db->createCommand()
            ->delete($tableNm, ['parent' => (string) $parentId, 'child' => (string) $childId])
            ->execute() > 0;
        } elseif (!$parentIdIsNumeric  && $childIdIsNumeric) {
            return $this->_db->createCommand()
            ->delete($tableNm, ['parent' => (integer) $parentId, 'child' => (string) $childId])
            ->execute() > 0;
        } else {
            return -100;
        }
    }


    /**
     * Adds tag assigned to Permit
     *
     * @return bool if rows deleted are > 0
     */
    public function addPermitTag($permitId, $tagId)
    {
        return $this->addTag($permitId, $tagId, $this->_tbl_SystemCodesChildName);
    }


    /**
     * Removes tag assigned to Permit
     *
     * @return bool if rows deleted are > 0
     */
    public function removePermitTag($permitId, $tagId)
    {
        return $this->removeTag($permitId, $tagId, $this->_tbl_SystemCodesChildName);
    }


    /**
     * Adds tag assigned to Permit
     *
     * @return bool if rows deleted are > 0
     */
    public function addCourseTag($courseId, $tagId)
    {
        return $this->addTag($courseId, $tagId, $this->_tbl_CoursesCodesChildName);
    }


    /**
     * Removes tag assigned to Permit
     *
     * @return bool if rows deleted are > 0
     */
    public function removeCourseTag($courseId, $tagId)
    {
        return $this->removeTag($courseId, $tagId, $this->_tbl_CoursesCodesChildName);
    }
}
