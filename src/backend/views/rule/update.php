<?php

/**
 * @var yii\web\View $this
 * @var common\models\AuthItem $model
 */
$this->title = Yii::t('acp', 'Update Rule') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('acp', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('acp', 'Update') . ' ' . $model->name;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success auth-item-update">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
