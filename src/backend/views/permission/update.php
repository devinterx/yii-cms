<?php

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = Yii::t('acp', 'Update Permission') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('acp', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('acp', 'Update');
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
