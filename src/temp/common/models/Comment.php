<?php
/**
 * Comment model.
 *
 */

namespace common\models;

use sergmoro1\blog\models\BaseComment;

class Comment extends BaseComment
{
	private static $commentFor = [1 => 'post', 2 => 'fund'];

	public function getFund()
	{
		return $this->hasOne(Fund::className(), ['id' => 'parent_id']);
	}

    public static function parentModelName($model) {
        return self::$commentFor[$model];
    }
}
        
