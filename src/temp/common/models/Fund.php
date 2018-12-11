<?php
/**
 * Fund model.
 *
 */

namespace common\models;

use yii\helpers\Html;

use sergmoro1\resort\models\BaseFund;
use sergmoro1\uploader\FilePath;
use sergmoro1\uploader\models\OneFile;
use notgosu\yii2\modules\metaTag\components\MetaTagBehavior;

class Fund extends BaseFund
{
    public $sizes = [
        'original' => ['width' => 1024, 'height' => 678, 'catalog' => 'original'],
        'main' => ['width' => 900, 'height' => 600, 'catalog' => ''],
        'thumb' => ['width' => 135, 'height' => 90, 'catalog' => 'thumb'],
    ];

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'FilePath' => [
                'class' => FilePath::className(),
                'file_path' => '/files/fund/',
            ],
            'seo' => [
                'class' => MetaTagBehavior::className(),
                'languages' => ['ru'],
            ],
        ]);
    }

    public function getFiles()
    {
        return $this->hasMany(OneFile::className(), ['parent_id' => 'id'])
            ->where('model=:model', [':model' => 'common\models\Fund'])
            ->orderBy('created_at');
    }
}
        
