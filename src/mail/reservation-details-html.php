<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReservationForm */

?>

<h3><?= \Yii::t('core', 'Reservation details') ?></h3>

<p><?= $choice ?></p>
<ol>
	<li><?= \Yii::t('core', 'Arrival date') ?>: <?= $model->check_in ?></li>
	<li><?= \Yii::t('core', 'Departure date') ?>: <?= $model->check_out ?></li>
	<li><?= \Yii::t('core', 'Days amount') ?>: <?= $model->days ?></li>
	<li><?= \Yii::t('core', 'Adults') ?>: <?= $model->adults ?></li>
	<?php if($model->children > 0): ?>
	<li><?= \Yii::t('core', 'Children') ?>: <?= $model->children ?></li>
	<?php endif; ?>
	<li><?= \Yii::t('core', 'Name') ?>: <?= $model->first_name ?> <?= $model->last_name ?></li>
	<li><?= \Yii::t('core', 'Phone') ?>: <?= $model->phone ?></li>
	<?php if($model->email): ?>
	<li><?= \Yii::t('core', 'Email') ?>: <?= $model->email ?></li>
	<?php endif; ?>
	<li><?= \Yii::t('core', 'Location') ?>: <?= $model->location ?></li>
	<?php if($model->requirements): ?>
	<li><?= \Yii::t('core', 'Special requirements') ?>: <p> <?= $model->requirements ?> </p></li>
	<?php endif; ?>
</ol>

