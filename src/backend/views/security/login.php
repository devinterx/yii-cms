<?php

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

$this->title = Yii::t('acp', 'Login');
?>
<div class="wrapper-simple login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= Url::toRoute('dashboard/dashboard') ?>"><b><?= Yii::$app->name ?></b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg"><?= Yii::t('acp', 'Sign in to start your session') ?></p>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnSubmit' => false,
            ]) ?>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'email', [
                    'template' => "{label}\n{input}\n
                    <span class=\"glyphicon glyphicon-envelope form-control-feedback\"></span>\n
                    {hint}\n{error}"
                ])->textInput(['class' => 'form-control', 'placeholder' => Yii::t('acp', 'example@gmail.com')]) ?>

            </div>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'password', [
                    'template' => "{label}\n{input}\n
                    <span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n
                    {hint}\n{error}"
                ])->passwordInput(['class' => 'form-control', 'placeholder' => Yii::t('acp', 'Password')]) ?>
            </div>
            <div class="form-group has-feedback has-captcha">
                <?php /* $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false])->widget(ReCaptcha::className(), [
                    'name' => 'reCaptcha',
                    'widgetOptions' => ['class' => 'captcha-login']
                ])->label(Yii::t('acp', 'Captcha')) */ ?>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <?= $form->field($model, 'rememberMe')->checkbox(['id' => 'auth-remember']) ?>
                    </div>
                </div>
                <div class="col-xs-4">
                    <?= Html::submitButton(Yii::t('acp', 'Sign In'), [
                        'class' => 'btn btn-primary btn-block btn-flat',
                        'name' => 'login-button'
                    ]) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>

            <!--
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
            </div>-->

            <a href="<?= Url::toRoute('security/request-password') ?>"><?= Yii::t('acp', 'I forgot my password') ?></a><br>
            <a href="<?= Url::toRoute('security/register') ?>"
               class="text-center"><?= Yii::t('acp', 'Register a new membership') ?></a>
        </div>
    </div>
</div>
