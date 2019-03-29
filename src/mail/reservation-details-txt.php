<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\ReservationForm */

?>

<?= \Yii::t('app', 'Reservation details') ?>

<?= $choice ?>

<?= \Yii::t('app', 'Arrival date') ?>: <?= $model->check_in ?>
<?= \Yii::t('app', 'Departure date') ?>: <?= $model->check_out ?>
<?= \Yii::t('app', 'Days amount') ?>: <?= $model->days ?>
<?= \Yii::t('app', 'Adults') ?>: <?= $model->adults ?>
<?php if(isset($model->retiree)): ?>
<?= \Yii::t('app', 'Retiree') ?>: <?= $model->retiree ?>
<?php endif; ?>
<?php if($model->children > 0): ?>
<?= \Yii::t('app', 'Children') ?>: <?= $model->children ?>
	<?php if(isset($model->age1)): ?>
	<?= \Yii::t('app', 'Age') ?>: 
		<?= $model->age1 ?>
		<?php if($model->children > 1 && isset($model->age2)): ?>
			, <?= $model->age2 ?>
			<?php if($model->children > 2 && isset($model->age3)): ?>
				, <?= $model->age3 ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
<?= \Yii::t('app', 'Name') ?>: <?= $model->first_name ?> <?= $model->last_name ?>
<?= \Yii::t('app', 'Phone') ?>: <?= $model->phone ?>
<?php if($model->email): ?>
<?= \Yii::t('app', 'Email') ?>: <?= $model->email ?>
<?php endif; ?>
<?= \Yii::t('app', 'Location') ?>: <?= $model->location ?>
<?php if($model->requirements): ?>
<?= \Yii::t('app', 'Special requirements') ?>: <?= $model->requirements ?>
<?php endif; ?>


