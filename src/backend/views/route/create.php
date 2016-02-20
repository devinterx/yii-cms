<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Route $model
 * @var ActiveForm $form
 */

$this->title = Yii::t('acp', 'Create Route');
$this->params['breadcrumbs'][] = ['label' => Yii::t('acp', 'Routes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Yii::t('acp', 'Create Route') ?></h1>

<div class="create">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'route') ?>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('acp', 'Create'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- create -->
