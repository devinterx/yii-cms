<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\ResetPasswordForm */

$this->title = 'Reset password';
?>

<div class="wrapper-simple login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= Url::toRoute('dashboard/dashboard') ?>"><b><?= Yii::$app->name ?></b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg"><?= Yii::t('acp', 'Please choose your new password:') ?></p>
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']) ?>

            <div class="form-group has-feedback">
                <?= $form->field($model, 'password', [
                    'template' => "{label}\n{input}\n
                    <span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n
                    {hint}\n{error}"
                ])->passwordInput(['class' => 'form-control', 'placeholder' => Yii::t('acp', 'Password')]) ?>

            </div>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'retypePassword', [
                    'template' => "{label}\n{input}\n
                    <span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n
                    {hint}\n{error}"
                ])->passwordInput(['class' => 'form-control', 'placeholder' => Yii::t('acp', 'Retype password')]) ?>
            </div>

            <div class="row">
                <div class="col-xs-4 single-send-button">
                    <?= Html::submitButton(Yii::t('acp', 'Save'), [
                        'class' => 'btn btn-primary btn-block btn-flat',
                        'name' => 'reset-button'
                    ]) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
