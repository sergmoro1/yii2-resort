<?php

namespace common\models;

use sergmoro1\comment\models\BaseComment;

/**
 * Comment model.
 *
 * @author Sergey Morozov <sergey@vorst.ru>
 */
class Comment extends BaseComment
{
    // register models that can be commented.
    private static $commentFor = [1 => 'post', 2 => 'fund'];

    /**
     * Post getter.
     * 
     * @return mixed
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'parent_id']);
    }

    /**
     * Fund getter.
     * 
     * @return mixed
     */
    public function getFund()
    {
        return $this->hasOne(Fund::className(), ['id' => 'parent_id']);
    }

    /**
     * Get parent model name by code. 
     * 
     * @return string
     */
    public static function parentModelName($model) {
        return self::$commentFor[$model];
    }
}
