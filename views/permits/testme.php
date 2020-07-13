<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Test Me';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the Test Me page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
