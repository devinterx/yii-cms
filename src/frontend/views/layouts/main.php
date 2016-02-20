<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?= Yii::$app->charset ?>" dir="ltr" loc="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="<?= Yii::$app->charset ?>" dir="ltr" loc="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="<?= Yii::$app->charset ?>" dir="ltr" loc="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="<?= Yii::$app->language ?>" loc="en" dir="ltr" class="no-js" > <!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Playfair+Display:400italic'
          rel='stylesheet' type='text/css'/>
    <?php $this->head() ?>
    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <?php $this->beginBody() ?>
    <nav>
        <div class="large-12 columns header_nav">
            <div class="row">
                <div class="large-9 columns">
                    <ul id="menu-header" class="nav-bar horizontal">
                        <li class="active"><a href="/">Home</a></li>
                        <li><a href="/acp/">ACP</a></li>
                    </ul>
                </div>
                <div class="large-3 columns">
                    <ul id="language" class="lang-bar horizontal">
                        <li class="active" lang="en"><a i18n="lang_en">Eng</a></li>
                        <li lang="ru"><a i18n="lang_ru">Рус</a></li>
                        <li lang="ua"><a i18n="lang_ua">Укр</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <?= Alert::widget() ?>
    <?= $content ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
