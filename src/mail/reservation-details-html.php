<?php
use yii\helpers\Html;
use sergmoro1\resort\Module;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReservationForm */

?>

<h3><?= \Module::t('core', 'Reservation details') ?></h3>

<p><?= $choice ?></p>
<ol>
	<li><?= \Module::t('core', 'Arrival date') ?>: <?= $model->check_in ?></li>
	<li><?= \Module::t('core', 'Departure date') ?>: <?= $model->check_out ?></li>
	<li><?= \Module::t('core', 'Days amount') ?>: <?= $model->days ?></li>
	<li><?= \Module::t('core', 'Adults') ?>: <?= $model->adults ?></li>
	<?php if($model->children > 0): ?>
	<li><?= \Module::t('core', 'Children') ?>: <?= $model->children ?></li>
	<?php endif; ?>
	<li><?= \Module::t('core', 'Name') ?>: <?= $model->first_name ?> <?= $model->last_name ?></li>
	<li><?= \Module::t('core', 'Phone') ?>: <?= $model->phone ?></li>
	<?php if($model->email): ?>
	<li><?= \Module::t('core', 'Email') ?>: <?= $model->email ?></li>
	<?php endif; ?>
	<li><?= \Module::t('core', 'Location') ?>: <?= $model->location ?></li>
	<?php if($model->requirements): ?>
	<li><?= \Module::t('core', 'Special requirements') ?>: <p> <?= $model->requirements ?> </p></li>
	<?php endif; ?>
</ol>

