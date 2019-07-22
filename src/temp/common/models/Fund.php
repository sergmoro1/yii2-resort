<?php

namespace common\models;

use yii\helpers\Html;

use sergmoro1\resort\models\BaseFund;
use sergmoro1\comment\models\CanComment;
use sergmoro1\uploader\FilePath;
use sergmoro1\uploader\models\OneFile;
use notgosu\yii2\modules\metaTag\components\MetaTagBehavior;

/**
 * Fund model.
 *
 * @author Sergey Morozov <sergey@vorst.ru>
 */

class Fund extends BaseFund
{
    use CanComment;
    const COMMENT_FOR = 2;

    // sizes and subdirs of uploaded images
	public $sizes = [
		'original'  => ['width' => 1024, 'height' => 678, 'catalog' => 'original'],
		'main'      => ['width' => 900,  'height' => 600, 'catalog' => ''],
		'thumb'     => ['width' => 135,  'height' => 90,  'catalog' => 'thumb'],
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

    /**
     * @return array all files linked with the model
     */
	public function getFiles()
	{
        return $this->hasMany(OneFile::className(), ['parent_id' => 'id'])
            ->where('model=:model', [':model' => 'common\models\Fund'])
            ->orderBy('created_at');
	}

    /**
     * This is invoked after the record is deleted.
     */
    public function afterDelete()
    {
        parent::afterDelete();
        Comment::deleteAll(['model' => self::COMMENT_FOR, 'parent_id' => $this->id]);
    }
}
		
