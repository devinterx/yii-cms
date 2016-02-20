<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body sm-input-4">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'new_password')->passwordInput()->label(Yii::t('app', 'Password')) ?>
    <?= $form->field($model, 'status')->dropDownList([
        User::STATUS_ACTIVE => Yii::t('acp', 'Active'),
        User::STATUS_DELETED => Yii::t('acp', 'Deleted')
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
