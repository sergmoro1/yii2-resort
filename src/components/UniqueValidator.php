<?php
namespace sergmoro1\resort\components;

use yii\helpers\Url;
use yii\validators\Validator;
use sergmoro1\resort\Module;
use sergmoro1\resort\models\Price;

/**
 * Check uniqueness by multiple values. 
 * If one or more values have changed, the full combination is searched for 
 * among all entities except the current model. Error if exists.
 */
class UniqueValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = Module::t('core', 'Duplicate entry.');
    }

    public function validateAttribute($model, $attribute)
    {
        // Is there any entity with a new values?
        if(Price::find()->where([
            'type' => $model->type, 
            'fund_id' => $model->fund_id, 
            'accommodation' => $model->accommodation, 
            'food' => $model->food, 
            'treatment' => $model->treatment,
        ])->andWhere(['<>', 'id', $model->id])->exists())
            // An error pushed if entity exists.
            $model->addError($attribute, $this->message);
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $url = json_encode(Url::to(['price/entity-exists']));
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
var entity = {};
entity.url = $url;
entity.new = {
    id: {$model->id},
    type: $('#price-type').val(),
    fund_id: $('#price-fund_id').val(),
    accommodation: $('#price-accommodation').val(),
    food: $('#price-food').val(),
    treatment: $('#price-treatment').val()
};
// Is there any entity with a new values?
entity.exists = false;
$.ajax({
    url: entity.url, 
    data: entity.new,
    dataType: "json",
    // Very important parameter. Without it entity.exists will be false in any case.
    async:false
}).done(function(response) {
    entity.exists = response;
});
// An error pushed if entity exists.
if(entity.exists)
    messages.push($message);
JS;
    }
}
