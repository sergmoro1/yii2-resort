<?php
namespace sergmoro1\resort\components;

use yii\helpers\Url;
use yii\validators\Validator;
use sergmoro1\resort\Module;
use sergmoro1\resort\models\Price;

/**
 * Check uniqueness by multiple values. 
 * If the values have not changed, we believe that the uniqueness is preserved. 
 * If one or more values have changed, we looking for a combination in the table. 
 * Error if exists.
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
        $old = $model->getOldAttributes();
        // Let's check if any key attributes have been changed.
        if($old && (
            $old['type'] != $model->type || 
            $old['fund_id'] != $model->fund_id || 
            $old['accommodation'] != $model->accommodation || 
            $old['food'] != $model->food || 
            $old['treatment'] != $model->treatment
        )) {
            // Is there any entity with a new values?
            if(Price::find()->where([
                'type' => $model->type, 
                'fund_id' => $model->fund_id, 
                'accommodation' => $model->accommodation, 
                'food' => $model->food, 
                'treatment' => $model->treatment,
            ])->exists()) {
                // An error pushed if entity exists.
                $model->addError($attribute, $this->message);
            }
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $url = json_encode(Url::to(['price/entity-exists']));
        $old = json_encode($model->getOldAttributes());
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
var entity = {};
entity.url = $url;
entity.old = $old;
entity.new = {
    type: $('#price-type').val(),
    fund_id: $('#price-fund_id').val(),
    accommodation: $('#price-accommodation').val(),
    food: $('#price-food').val(),
    treatment: $('#price-treatment').val()
};
// Let's check if any key attributes have been changed.
if(
    entity.new.type != entity.old.type ||
    entity.new.fund_id != entity.old.fund_id ||
    entity.new.accommodation != entity.old.accommodation ||
    entity.new.food != entity.old.food ||
    entity.new.treatment != entity.old.treatment
) {
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
}
JS;
    }
}
