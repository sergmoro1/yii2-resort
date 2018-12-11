<?php
/* @var $this yii\web\View */
/* @var $model common\models\Price */

use yii\helpers\Html;
use sergmoro1\resort\Module;

$this->title = Module::t('core', 'Update');
$this->params['breadcrumbs'][] = ['label' => Module::t('core', 'Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="price-update">
	<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
