<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\AuthItem $model
 */
$this->title = Yii::t('acp', 'Update Role') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('acp', 'Update');
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
