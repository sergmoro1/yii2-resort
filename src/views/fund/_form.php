<?php
/* @var $this yii\web\View */
/* @var $model common\models\Fund */
/* @var $form yii\widgets\ActiveForm */

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use sergmoro1\resort\Module;
use common\models\Fund;
use sergmoro1\lookup\models\Lookup;
use vova07\imperavi\Widget;
use sergmoro1\uploader\widgets\Uploader;
?>

<?php $form = ActiveForm::begin(); ?>
<div class='row'>
<div class="col-lg-8">

    <div class="form-group">
        <?= Html::submitButton(Module::t('core', 'Save'), [
            'class' => 'btn btn-success',
        ]) ?>
    </div>

    <?= $form->field($model, 'caption')
        ->textInput(['maxlength' => true])
    ?>

    <?php echo $form->field($model, 'slug')
        ->textInput(['maxlength' => true])
    ?>

    <?= $form->field($model, 'hotel_id')
        ->dropdownList(Lookup::items('HotelName'), [
            'prompt' => Module::t('core', 'Select'),
    ]) ?>

    <?= $form->field($model, 'category')
        ->dropdownList(Lookup::items('RoomCategory'), [
            'prompt' => Module::t('core', 'Select'),
    ]) ?>

    <div class='row'>
        <div class="col-lg-6">
            <?= $form->field($model, 'room')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'person')->textInput() ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-6">
            <?= $form->field($model, 'size', [
                'template' => "{label}\n<div class='input-group'>{input}<span class='input-group-addon'>м2</span></div>\n{hint}\n{error}",
            ])->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'price_like')
                ->dropdownList(Fund::getItems($model->id), [
                    'prompt' => Module::t('core', 'Select'),
            ]) ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-6">
            <?= $form->field($model, 'minibar')->checkBox() ?>
            <?= $form->field($model, 'kettle')->checkBox() ?>
            <?= $form->field($model, 'tv')->checkBox() ?>
            <?= $form->field($model, 'wifi')->checkBox() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'restroom')->checkBox() ?>
            <?= $form->field($model, 'sauna')->checkBox() ?>
            <?= $form->field($model, 'room_service')->checkBox() ?>
            <?= $form->field($model, 'room_cleaning')->checkBox() ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]); ?>

    <?= sergmoro1\blog\widgets\metaTagForm\Widget::widget([
        'model' => $model,
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Module::t('core', 'Save'), [
            'class' => 'btn btn-success',
        ]) ?>
    </div>
</div>
<div class="post-files col-lg-4">
    <?= Uploader::widget([
        'model' => $model,
        'appendixView' => '/fund/appendix.php',
        'draggable' => true,
        'cropAllowed' => true,
    ]) ?>
    <hr>
</div>

</div>
<?php ActiveForm::end(); ?>
