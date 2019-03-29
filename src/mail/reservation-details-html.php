<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReservationForm */

?>

<h3><?= \Yii::t('app', 'Reservation details') ?></h3>

<p><?= $choice ?></p>
<ol>
	<li><?= \Yii::t('app', 'Arrival date') ?>: <?= $model->check_in ?></li>
	<li><?= \Yii::t('app', 'Departure date') ?>: <?= $model->check_out ?></li>
	<li><?= \Yii::t('app', 'Days amount') ?>: <?= $model->days ?></li>
	<li><?= \Yii::t('app', 'Adults') ?>: <?= $model->adults ?></li>
	<?php if(isset($model->retiree)): ?>
	<li><?= \Yii::t('app', 'Retiree') ?>: <?= $model->retiree ?></li>
	<?php endif; ?>
	<?php if($model->children > 0): ?>
	<li><?= \Yii::t('app', 'Children') ?>: <?= $model->children ?></li>
		<?php if(isset($model->age1)): ?>
		<li>
			<?= \Yii::t('app', 'Age') ?>: 
			<?= $model->age1 ?>
			<?php if($model->children > 1 && isset($model->age2)): ?>
				, <?= $model->age2 ?>
				<?php if($model->children > 2 && isset($model->age3)): ?>
					, <?= $model->age3 ?>
				<?php endif; ?>
			<?php endif; ?>
		</li>
		<?php endif; ?>
	<?php endif; ?>
	<li><?= \Yii::t('app', 'Name') ?>: <?= $model->first_name ?> <?= $model->last_name ?></li>
	<li><?= \Yii::t('app', 'Phone') ?>: <?= $model->phone ?></li>
	<?php if($model->email): ?>
	<li><?= \Yii::t('app', 'Email') ?>: <?= $model->email ?></li>
	<?php endif; ?>
	<li><?= \Yii::t('app', 'Location') ?>: <?= $model->location ?></li>
	<?php if($model->requirements): ?>
	<li><?= \Yii::t('app', 'Special requirements') ?>: <p> <?= $model->requirements ?> </p></li>
	<?php endif; ?>
</ol>

