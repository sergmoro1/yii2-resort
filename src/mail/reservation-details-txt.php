<?php
use sergmoro1\resort\Module;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReservationForm */

?>

<?= \Module::t('core', 'Reservation details') ?>

<?= $choice ?>

<?= \Module::t('core', 'Arrival date') ?>: <?= $model->check_in ?>
<?= \Module::t('core', 'Departure date') ?>: <?= $model->check_out ?>
<?= \Module::t('core', 'Days amount') ?>: <?= $model->days ?>
<?= \Module::t('core', 'Adults') ?>: <?= $model->adults ?>
<?php if($model->children > 0): ?>
<?= \Module::t('core', 'Children') ?>: <?= $model->children ?>
<?php endif; ?>
<?= \Module::t('core', 'Name') ?>: <?= $model->first_name ?> <?= $model->last_name ?>
<?= \Module::t('core', 'Phone') ?>: <?= $model->phone ?>
<?php if($model->email): ?>
<?= \Module::t('core', 'Email') ?>: <?= $model->email ?>
<?php endif; ?>
<?= \Module::t('core', 'Location') ?>: <?= $model->location ?>
<?php if($model->requirements): ?>
<?= \Module::t('core', 'Special requirements') ?>: <?= $model->requirements ?>
<?php endif; ?>


