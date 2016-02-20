<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\RegisterForm */

$this->title = 'Signup';
?>

<div class="wrapper-simple register-page">
    <div class="register-box">
        <div class="login-logo">
            <a href="<?= Url::toRoute('dashboard/dashboard') ?>"><b><?= Yii::$app->name ?></b></a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Register a new membership</p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
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
            <div class="form-group has-feedback">
                <?= $form->field($model, 'retypePassword', [
                    'template' => "{label}\n{input}\n
                    <span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n
                    {hint}\n{error}"
                ])->passwordInput(['class' => 'form-control', 'placeholder' => Yii::t('acp', 'Retype password')]) ?>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> I agree to the <a href="<?= Url::to('#') ?>">terms</a>
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <?= Html::submitButton(Yii::t('acp', 'Signup'), [
                        'class' => 'btn btn-primary btn-block btn-flat',
                        'name' => 'signup-button'
                    ]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <!--
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign up using Google+</a>
            </div>
            -->

            <a href="<?= Url::toRoute('security/login') ?>"
               class="text-center"><?= Yii::t('acp', 'I already have a membership') ?></a>
        </div>
    </div>
</div>
