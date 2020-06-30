<?php

/* Change this to your own namespace */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class TestController extends Controller
{
    public function actionIndex()
    {
        $provider = new ArrayDataProvider([
            'allModels' => $this->getFakedModels(),
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'attributes' => ['id'],
            ],
        ]);

        return $this->render('index', ['listDataProvider' => $provider]);
    }

    private function getFakedModels()
    {
        $fakedModels = [];

        for ($i = 1; $i < 18; $i++) {
            $fakedItem = [
                'id' => $i,
                'title' => 'Title ' . $i,
                'image' => 'http://placehold.it/300x200'
            ];

            $fakedModels[] = $fakedItem;
        }

        return $fakedModels;
    }
}
