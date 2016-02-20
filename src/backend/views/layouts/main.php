<?php
use backend\assets\AppAsset;
use common\models\User;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

/** @var User $user */
$user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet"
          type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-yellow">

<!-- Site wrapper -->
<div class="wrapper">
    <?php $this->beginBody() ?>
    <div class="alert-container">
        <?= Alert::widget() ?>
    </div>
    <header class="main-header">
        <a href="<?= Url::to('/') ?>" class="logo"><b><?= Yii::$app->name ?></b></a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?= $this->render('//menu/top-menu') ?>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/noavatar.jpg" class="user-image" alt="User Image"/>
                            <span class="hidden-xs"><?= $user->getUsername() ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="/img/noavatar.jpg" class="img-circle" alt="User Image"/>
                                <p>
                                    <?= $user->getUsername() ?>
                                    <small>Member since <?= $user->created_at->format("M. Y") ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <?= Html::a(Yii::t('acp', 'Sign out'), Url::toRoute('security/logout'), [
                                        'data-method' => 'post',
                                        'class' => "btn btn-default btn-flat"
                                    ]) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <?= $this->render('//menu/sidebar-menu') ?>
        </section>
    </aside>

    <!-- =============================================== -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </section>
        <section class="content">
            <?= $content ?>
        </section>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
