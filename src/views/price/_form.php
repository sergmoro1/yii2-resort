<?php
/* @var $this yii\web\View */
/* @var $model common\models\Price */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use sergmoro1\resort\Module;
use common\models\Fund;
use sergmoro1\lookup\models\Lookup;

?>

<div class="price-form">

<?php $form = ActiveForm::begin([
	'id' => 'price-form',
	'layout' => 'horizontal',
	'enableAjaxValidation' => true,
	'validationUrl' => Url::toRoute(['price/validate']),		
	'fieldConfig' => [
		'horizontalCssClasses' => [
			'label' => 'col-sm-4',
			'offset' => 'col-sm-offset-4',
			'wrapper' => 'col-sm-6',
		],
	],
]); ?>
    <div class="row">
    <div class="col-sm-8">
        <?= $form->field($model, 'position')
            ->textInput()
        ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'food')->dropDownList(Lookup::items('Food'), [
            'prompt' => Module::t('core', 'Select'),
        ]) ?>
    </div>
    </div>

    <div class="row">
    <div class="col-sm-8">
        <?= $form->field($model, 'type')->dropDownList(Lookup::items('PriceType'), [
            'prompt' => Module::t('core', 'Select'),
        ]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'treatment')->checkbox() ?>
    </div>
    </div>

    <div class="row">
    <div class="col-sm-8">
        <?= $form->field($model, 'fund_id')->dropDownList(Fund::getItems(), [
            'prompt' => Module::t('core', 'Select'),
        ])->label('Номер') ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'show')->checkbox() ?>
    </div>
    </div>

    <div class="row">
    <div class="col-sm-8">
        <?= $form->field($model, 'accommodation')->dropDownList(Lookup::items('Accommodation'), [
            'prompt' => Module::t('core', 'Select'),
        ]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'value', [
            'template' => "{label}<div class='col-sm-6'><div class='input-group '>{input}<span class='input-group-addon'>руб</span></div>\n{hint}\n{error}</div>",
        ])->textInput() ?>
    </div>
    </div>

	<?= Html::submitButton('Submit', ['id' => 'submit-btn', 'style' => 'display: none']) ?>

<?php ActiveForm::end(); ?>

</div>
