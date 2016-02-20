<?php
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\PasswordResetRequestForm */

$this->title = 'Request password reset';
?>

<div class="wrapper-simple login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= Url::toRoute('dashboard/dashboard') ?>"><b><?= Yii::$app->name ?></b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg"><?= Yii::t('acp', 'Please fill out your email. A link to reset password will be sent there.') ?></p>
            <?php $form = ActiveForm::begin([
                'id' => 'request-password-form',
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
            <div class="form-group has-feedback has-captcha">
                <?php /* $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false])->widget(ReCaptcha::className(), [
                    'name' => 'reCaptcha',
                    'widgetOptions' => ['class' => 'captcha-login']
                ])->label(Yii::t('acp', 'Captcha')) */ ?>
            </div>
            <div class="row">
                <div class="col-xs-4 single-send-button">
                    <?= Html::submitButton(Yii::t('acp', 'Send'), [
                        'class' => 'btn btn-primary btn-block btn-flat',
                        'name' => 'request-button'
                    ]) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>

            <a href="<?= Url::toRoute('security/login') ?>"
               class="text-center"><?= Yii::t('acp', 'Back to login page') ?></a>
        </div>
    </div>
</div>
