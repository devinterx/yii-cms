<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-success auth-item-view panel-box-widget">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'description:ntext',
                        'ruleName',
                        'data:ntext',
                    ],
                ]);
                ?>
                <div class="col-lg-5">
                    <?= Yii::t('acp', 'Avaliable') ?>:
                    <?php
                    echo Html::textInput('search_av', '', ['class' => 'role-search', 'data-target' => 'available']) . '<br>';
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
<?php
$this->render('_script', ['name' => $model->name]);
