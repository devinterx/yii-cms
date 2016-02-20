<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>

<header>
    <div id="logo" class="logo"></div>
</header>

<section class="section_light">
    <div class="row">
        <div class="large-12 columns">
            <h1><?= Html::encode($this->title) ?></h1>

            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>

            <p>
                The above error occurred while the Web server was processing your request.
            </p>
            <p>
                Please contact us if you think this is a server error. Thank you.
            </p>
        </div>
    </div>
</section>

<footer>
    <div class="row">
        <div class="large-12 columns footer">
            <a href="mailto::<?= Yii::$app->params['supportEmail'] ?>"><?= Yii::$app->params['supportEmail'] ?></a>
        </div>
    </div>
</footer>
