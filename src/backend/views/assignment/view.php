<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model User */

$this->title = Yii::t('acp', 'Assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $model->email;
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-success assignment-index panel-box-widget">
            <div class="col-lg-12">
                <h1><?= Yii::t('acp', 'User') ?>: <?= Html::encode($model->getUsername()) ?></h1>
            </div>

            <?= DetailView::widget([
                /** @var User $model */
                'model' => $model,
                'attributes' => [
                    'email',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'label' => 'Status',
                        'value' => $model->statusLabels[$model->status],
                    ],
                ],
            ]);
            ?>

            <div class="col-lg-5">
                <?= Yii::t('acp', 'Avaliable') ?>:
                <?php
                echo Html::textInput('search_av', '', ['class' => 'role-search', 'data-target' => 'avaliable']) . '<br>';
                echo Html::listBox('roles', '', $available, [
                    'id' => 'available',
                    'multiple' => true,
                    'size' => 20,
                    'style' => 'width:100%']);
                ?>
            </div>
            <div class="col-lg-1 arrows">
                &nbsp;<br><br>
                <?php
                echo Html::a('<i class="glyphicon glyphicon-arrow-right"></i>', '#', [
                        'class' => 'btn btn-success',
                        'data-action' => 'assign'
                    ]) . '<br>';
                echo Html::a('<i class="glyphicon glyphicon-arrow-left"></i>', '#', [
                        'class' => 'btn btn-success',
                        'data-action' => 'delete'
                    ]) . '<br>';
                ?>
            </div>
            <div class="col-lg-5">
                <?= Yii::t('acp', 'Assigned') ?>:
                <?php
                echo Html::textInput('search_asgn', '', ['class' => 'role-search', 'data-target' => 'assigned']) . '<br>';
                echo Html::listBox('roles', '', $assigned, [
                    'id' => 'assigned',
                    'multiple' => true,
                    'size' => 20,
                    'style' => 'width:100%']);
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->render('_script', ['id' => $model->{$idField}]) ?>

