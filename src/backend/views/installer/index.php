<?php

/* @var $this yii\web\View */
use backend\models\InstalledModules;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $test */

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\search\InstalledModulesSearch */

$this->title = Yii::t('acp', 'Installer');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '36px',
                    'header' => '',
                    'headerOptions' => ['class' => 'kartik-sheet-style']
                ],
                'title',
                'version',
                'status',
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'created_at',
                    'value' => function (InstalledModules $data) {
                        return $data->created_at->format("Y-m-d H:i:s");
                    },
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'width' => '30%',
                    'headerOptions' => ['class' => 'kv-sticky-column'],
                    'contentOptions' => ['class' => 'kv-sticky-column'],
                    'readonly' => true,
                    'editableOptions' => [
                        'header' => 'Created at',
                        'size' => 'md',
                        'inputType' => \kartik\editable\Editable::INPUT_WIDGET,
                        'widgetClass' => 'kartik\datecontrol\DateControl',
                        'options' => [
                            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                            'displayFormat' => 'dd.MM.yyyy',
                            'saveFormat' => 'php:Y-m-d',
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]
                    ],
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'value' => date('Y-M-d', strtotime('+2 days')),
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'visible' => (
                        Yii::$app->user->can('BUpdateAssignments') ||
                        Yii::$app->user->can('BUpdateUsers') ||
                        Yii::$app->user->can('BDeleteUsers')
                    ),
                    'template' => '{view}{edit}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            if (!Yii::$app->user->can('BUpdateAssignments')) return null;
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                Url::toRoute(['assignment/view', 'id' => $model->id]),
                                [
                                    'title' => Yii::t('acp', 'View'),
                                ]
                            );
                        },
                        'edit' => function ($url, $model) {
                            if (!Yii::$app->user->can('BUpdateUsers')) return null;
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                Url::toRoute(['edit', 'id' => $model->id]),
                                [
                                    'title' => Yii::t('acp', 'Edit'),
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            if (!Yii::$app->user->can('BDeleteUsers')) return null;
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                Url::to('#'),
                                [
                                    'title' => Yii::t('acp', 'Delete'),
                                    'onClick' => 'bootbox.confirm("Are you sure?", function(result) {if(result) {window.location.href="' . Url::toRoute(['delete', 'id' => $model->id]) . '";} });'
                                ]
                            );
                        }
                    ],
                ],
            ],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true,
            'toolbar' => [
                ['content' =>
                    ((Yii::$app->user->can('BCreateUsers')) ?
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
                'heading' => Yii::t('acp', 'Modules')
            ],

            'persistResize' => false
        ]) ?>

    </div>
</div>
