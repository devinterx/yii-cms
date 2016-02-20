<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 */
$this->title = Yii::t('acp', 'Routes');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-success auth-item-view panel-box-widget">

                <?php if (Yii::$app->user->can('BCreateRoutes')): ?>
                    <div class="col-lg-12" style="margin-top: 10px">
                        <p>
                            <?= Html::a(Yii::t('acp', 'Create route'), ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                    </div>
                <?php endif ?>

                <div class="col-lg-5">
                    <?= Yii::t('acp', 'Avaliable') ?>:
                    <?php
                    echo Html::textInput('search_av', '', ['class' => 'role-search', 'data-target' => 'new']) . ' ';
                    echo Html::a('<span class="glyphicon glyphicon-refresh"></span>', '', ['id' => 'btn-refresh']);
                    echo '<br>';
                    echo Html::listBox('routes', '', $new, [
                        'id' => 'new',
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
                    echo Html::textInput('search_asgn', '', ['class' => 'role-search', 'data-target' => 'exists']) . '<br>';
                    echo Html::listBox('routes', '', $exists, [
                        'id' => 'exists',
                        'multiple' => true,
                        'size' => 20,
                        'style' => 'width:100%',
                        'options' => $existsOptions]);
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->render('_script');
