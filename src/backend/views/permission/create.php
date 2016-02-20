<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = Yii::t('acp', 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('acp', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
