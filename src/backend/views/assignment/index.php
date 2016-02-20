<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\search\Assignment */

$this->title = Yii::t('acp', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 assignment-index">
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

                'email:email',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'template' => '{view}',
                    'visible' => Yii::$app->user->can('BUpdateAssignments'),
                    'buttons' => [
                        'view' => function ($url, $model) {
                            if(!Yii::$app->user->can('BUpdateAssignments')) return null;
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                Url::toRoute(['view', 'id' => $model->id]),
                                [
                                    'title' => Yii::t('acp', 'View'),
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
