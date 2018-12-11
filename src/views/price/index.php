<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

use sergmoro1\resort\Module;
use sergmoro1\resort\models\Price;
use sergmoro1\lookup\models\Lookup;

$this->registerJs('var popUp = {"id": "price", "actions": ["update", "delete"]};', yii\web\View::POS_HEAD);
sergmoro1\modal\assets\PopUpAsset::register($this);

$this->title = Module::t('core', 'Prices');
$this->params['breadcrumbs'][] = $this->title;;

echo Modal::widget([
    'id' => 'price-win',
    'toggleButton' => false,
    'header' => $this->title,
    'size' => 'modal-lg',
    'footer' => 
        '<button type="button" class="btn btn-default" data-dismiss="modal">'. Module::t('core', 'Cancel') .'</button>' . 
        '<button type="button" class="btn btn-primary">'. Module::t('core', 'Save') .'</button>', 
]);

?>

<div class="price-index">

<div class='row'>
<div class='col-sm-8'>
    
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Module::t('core', 'Add'), ['create'], [
            'id' => 'price-add',
            'data-toggle' => 'modal',
            'data-target' => '#price-win',
            'class' => 'btn btn-success',
        ]) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['style' => 'width:4%;'],
            ],
            [
                'attribute' => 'type',
                'filter' => Lookup::items('PriceType'),
                'value' => function($data) {
                    return mb_substr(Lookup::item('PriceType', $data->type), 0, 2, 'UTF-8');
                }
            ],
            [
                'attribute' => 'fund_id',
                'header' => 'Номер',
                'filter' => Price::items(),
                'value' => function($data) {
                    return $data->fund->getItem();
                }
            ],
            [
                'attribute' => 'accommodation',
                'filter' => Lookup::items('Accommodation'),
                'value' => function($data) {
                    return Lookup::item('Accommodation', $data->accommodation);
                }
            ],
            [
                'attribute' => 'food',
                'header' => '<span class="glyphicon glyphicon-cutlery"></span>',
                'options' => ['style' => 'width:10%;'],
                'filter' => Lookup::items('Food'),
                'value' => function($data) {
                    return Lookup::item('Food', $data->food);
                }
            ],
            [
                'attribute' => 'treatment',
                'header' => '<span class="glyphicon glyphicon-heart"></span>',
                'options' => ['style' => 'width:8%;'],
                'filter' => [0 => '-', 1 => '+'],
                'value' => function($data) {
                    return $data->treatment ? '+' : '-';
                }
            ],
            'position:integer:#',
            [
                'attribute' => 'value',
                'format' => 'html',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($data) {
                    $v = number_format($data->value, 0, '', ' ');
                    return $data->show ? "<b>$v</b>" : $v;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width:10%;'],
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            \Yii::$app->params['icons']['pencil'], 
                            $url, [
                                'class' => 'update',
                                'data-toggle' => 'modal',
                                'data-target' => '#price-win',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>

<div class='col-sm-4'>
    <?= $this->render('help') ?>
</div>

</div> <!-- ./row -->
</div> <!-- ./tag-index -->
