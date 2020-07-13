<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$pgTitle = 'About';

$this->title = $pgTitle . ' - ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($pgTitle) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
