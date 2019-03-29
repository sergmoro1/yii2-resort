<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\ReservationForm */

?>

<?= \Yii::t('core', 'Reservation details') ?>

<?= $choice ?>

<?= \Yii::t('core', 'Arrival date') ?>: <?= $model->check_in ?>
<?= \Yii::t('core', 'Departure date') ?>: <?= $model->check_out ?>
<?= \Yii::t('core', 'Days amount') ?>: <?= $model->days ?>
<?= \Yii::t('core', 'Adults') ?>: <?= $model->adults ?>
<?php if($model->children > 0): ?>
<?= \Yii::t('core', 'Children') ?>: <?= $model->children ?>
<?php endif; ?>
<?= \Yii::t('core', 'Name') ?>: <?= $model->first_name ?> <?= $model->last_name ?>
<?= \Yii::t('core', 'Phone') ?>: <?= $model->phone ?>
<?php if($model->email): ?>
<?= \Yii::t('core', 'Email') ?>: <?= $model->email ?>
<?php endif; ?>
<?= \Yii::t('core', 'Location') ?>: <?= $model->location ?>
<?php if($model->requirements): ?>
<?= \Yii::t('core', 'Special requirements') ?>: <?= $model->requirements ?>
<?php endif; ?>


