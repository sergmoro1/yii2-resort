<?php
/* @var $this yii\web\View */
/* @var $model common\models\Fund */

use yii\helpers\Html;
use sergmoro1\resort\Module;

$this->title = Module::t('core', 'Update');
$this->params['breadcrumbs'][] = ['label' => Module::t('core', 'Funds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
