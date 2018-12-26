<?php
/* @var $this yii\web\View */
/* @var $model common\models\Post */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
use yii\widgets\DetailView;

use sergmoro1\resort\Module;

$this->title = $model->caption;
$this->params['breadcrumbs'][] = ['label' => Module::t('core', 'Funds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->caption;
?>

<div class='fund-view'>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class='post-image row'>
        <div class='col-sm-6'>
            
        <?php if($model->files && count($model->files) > 1): ?>
        
            <?= Carousel::widget([
                'items' => $model->prepareSlider(), 
                'options' => ['data-interval' => ''],
                'controls' => [
                    '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                    '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
                ]
            ]) ?>
        
        <?php elseif($model->files && count($model->files) == 1): ?>

            <img src='<?= $model->getImage() ?>' width='100%' />

        <?php endif; ?>

        </div>
    </div>

    <div class='post-preview'>

        <div class='post-meta'>
            <?= $model->getFullDate('created_at'); ?>
        </div>

        <h3><small><span class='glyphicon glyphicon-home'></span></small> <?= $model->getTitle() ?></h3>
        <h4><?= $model->caption ?></h4>
        <p>
            <span class='glyphicon glyphicon-th-large'></span> <?= $model->room ?> комнатный,
            <span class='glyphicon glyphicon-user'></span> <?= $model->person . ' местный' ?>,
            <span class='glyphicon glyphicon-stop'></span> <?= $model->size ?> м2
        </p>
        <p>
            <?php if($model->minibar): ?>
                <span class='glyphicon glyphicon-asterisk'></span> минибар<?= $model->kettle ? ',' : '' ?>
            <?php endif; ?>

            <?php if($model->kettle): ?>
                <span class='glyphicon glyphicon-cutlery'></span> чайник
            <?php endif; ?>
        </p>
        <p>

            <?php if($model->wifi): ?>
                <span class='glyphicon glyphicon-phone'></span> wifi<?= $model->tv ? ',' : '' ?>
            <?php endif; ?>
            <?php if($model->tv): ?>
                <span class='glyphicon glyphicon-facetime-video'></span> телевизор
            <?php endif; ?>
        </p>
        <p>
            
            <?php if($model->restroom): ?>
                <span class='glyphicon glyphicon-tint'></span> санузел в ванной<?= $model->sauna ? ',' : '' ?>
            <?php endif; ?>
            <?php if($model->sauna): ?>
                <span class='glyphicon glyphicon-cloud'></span> сауна
            <?php endif; ?>
        </p>
        <p>
            
            <i><?= $model->getPrice() ?> <span class='glyphicon glyphicon-rub'></span>/чел

        </p>
        <hr>
        
        <p>
        <?php echo $model->description; ?>
        </p>
    </div>

</div>
