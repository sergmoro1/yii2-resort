<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use sergmoro1\resort\Module;
use sergmoro1\lookup\models\Lookup;

$this->title = Module::t('core', 'Funds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-index">
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> '. 
            Module::t('core', 'Add'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}",
        'options' => ['class' => false],
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['style' => 'width:60px;'],
                'format' => 'html',
                'value' => function($data) {
                    return $data->getFieldLink();
                }
            ],
            [
                'header' => Module::t('core', 'Image'),
                'format' => 'html',
                'value' => function($data) {
                    return Html::img($data->getImage('thumb'));
                },
            ],
            'caption',
            [
                'attribute' => 'hotel_id',
                'filter' => Lookup::items('HotelName'),
                'value' => function($data) {
                    return Lookup::item('HotelName', $data->hotel_id);
                }
            ],
            [
                'attribute' => 'category',
                'filter' => Lookup::items('RoomCategory'),
                'value' => function($data) {
                    return Lookup::item('RoomCategory', $data->category);
                }
            ],
            'room',
            'person',
            'size',
            [
                'header' => Module::t('core', 'Price'),
                'value' => function($data) {
                    return $data->getPrice();
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}', 
                'options' => ['style' => 'width:8%;'],
            ],
        ],
    ]); ?>

</div>
