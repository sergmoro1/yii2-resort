<?php
/* @var $this yii\web\View */
/* @var $model common\models\Post */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\bootstrap\Carousel;
use yii\widgets\DetailView;

use sergmoro1\resort\Module;

$this->title = Module::t('core', 'View');
$this->params['breadcrumbs'][] = ['label' => Module::t('core', 'Funds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->getTitle();

?>

<div class='fund-view'>

    <div class='fund-actions row'>
        <div class='col-sm-6'>
            <?= Html::a(Module::t('core', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php if($model->fileCount): ?>

                <?php Modal::begin([
                    'header' => Module::t('core', 'Pictures connected with the post'),
                    'toggleButton' => ['label' => Module::t('core', 'Pictures'), 'tag' => 'a', 'class' => 'btn btn-default'],
                ]); ?>

                    <?= Carousel::widget([
                        'items' => $model->prepareSlider(), 
                        'options' => ['data-interval' => ''],
                        'controls' => [
                            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                            '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
                        ]
                    ]); ?>

                <?php Modal::end(); ?>

            <?php endif; ?>
        </div>
        <div class='col-sm-6 text-right'>
            <?= Html::a(Module::t('core', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Module::t('core', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class='post-preview'>

        <h2><?= $model->getTitle() ?></h2>

        <div class='post-meta'>
            <span class='glyphicon glyphicon-calendar'></span> <?= $model->fullDate('created_at'); ?>
            <?php if($thumb = $model->getImage('thumb')): ?>
                <a href="<?= Url::to(['post/update', 'id' => $model->id]) ?>">
                    <img src="<?= $thumb ?>" alt="<?= $model->getFileDescription(); ?>">
                </a>
            <?php endif; ?>
        </div>

        <p>
            <span class='glyphicon glyphicon-th-large'></span> <?= $model->room ?> комнатный,
            <span class='glyphicon glyphicon-user'></span> <?= $model->person . ' местный' ?>,
            <span class='glyphicon glyphicon-stop'></span> <?= $model->size ?> м2
        </p>
        <p>
            <?php if($model->minibar): ?>
                <span class='glyphicon glyphicon-glass'></span> минибар<?= $model->kettle ? ',' : '' ?>
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
