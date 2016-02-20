<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\AuthItem $searchModel
 */
$this->title = Yii::t('acp', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 role-index">
        <?= GridView::widget([
            'tableOptions' => ['class' => 'with-left-pad-16'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'name',
                    'label' => Yii::t('acp', 'Name')
                ],
                [
                    'attribute' => 'description',
                    'label' => Yii::t('acp', 'Description')
                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'visible' => (
                        Yii::$app->user->can('BDeleteRoles') ||
                        Yii::$app->user->can('BUpdateRoles')
                    ),
                    'template' => '{view}{edit}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            if (!Yii::$app->user->can('BUpdateRoles')) return null;
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                Url::toRoute(['view', 'id' => $model->name]),
                                [
                                    'title' => Yii::t('acp', 'View'),
                                ]
                            );
                        },
                        'edit' => function ($url, $model) {
                            if (!Yii::$app->user->can('BUpdateRoles')) return null;
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                Url::toRoute(['update', 'id' => $model->name]),
                                [
                                    'title' => Yii::t('acp', 'Edit'),
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            if (!Yii::$app->user->can('BDeleteRoles')) return null;
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                Url::to('#'),
                                [
                                    'title' => Yii::t('acp', 'Delete'),
                                    'onClick' => 'bootbox.confirm("Are you sure?", function(result) {if(result) {window.location.href="' . Url::toRoute(['delete', 'id' => $model->name]) . '";} });'
                                ]
                            );
                        }
                    ],
                ]
            ],
            //'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true,
            'toolbar' => [
                ['content' =>
                    ((Yii::$app->user->can('BCreateRoles')) ?
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                            'data-pjax' => 0,
                            'class' => 'btn btn-success',
                            'title' => Yii::t('acp', 'Add')
                        ]) : '') .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'data-pjax' => 0,
                        'class' => 'btn btn-default',
                        'title' => Yii::t('acp', 'Reset')
                    ])
                ],
                '{export}',
                '{toggleData}',
            ],
            'export' => false,
            'bordered' => true,
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'showPageSummary' => false,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => Yii::t('acp', $this->title)
            ],
            'persistResize' => false,
        ]) ?>
    </div>
</div>
