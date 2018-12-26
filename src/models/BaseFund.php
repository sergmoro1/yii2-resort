<?php
/**
 * Fund types of rooms model.
 *
 */
namespace sergmoro1\resort\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Link;

use sergmoro1\resort\Module;
use sergmoro1\blog\models\Comment;
use sergmoro1\blog\models\CanComment;
use sergmoro1\rudate\RuDate;
use mrssoft\sitemap\SitemapInterface;
use sergmoro1\blog\components\RuSlug;
use sergmoro1\lookup\models\Lookup;

class BaseFund extends ActiveRecord implements SitemapInterface
{
    use CanComment;

    const HOTEL_NAME = 10;
    const ROOM_CATEGORY = 11;

    const HOTEL_BUILDING1 = 1;
    
    const CATEGORY_SUITE = 1;
    const CATEGORY_HALFSUITE = 2;
    const CATEGORY_STANDARD = 3;

    const COMMENT_FOR = 2;

    public $_comments = [];
    public $thread = false;
    
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%fund}}';
    }

    public function behaviors()
    {
        return [
            'RuDate' => ['class' => RuDate::className()],
            'RuSlug' => [
                'class' => RuSlug::className(),
                'attribute' => 'caption',
            ],
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['hotel_id', 'category', 'room', 'person', 'size'], 'required'],
            [['hotel_id', 'category', 'room', 'person', 'size', 'price_like'], 'integer'],
            ['category', 'default', 'value' => self::CATEGORY_STANDARD],
            [['caption', 'slug'], 'string', 'max'=>128],
            ['slug', 'unique'],
            ['slug', 'match', 'pattern' => '/^[0-9a-z-]+$/u', 'message' => Module::t('core', 'Slug may consists a-z, numbers and minus only.')],
            [['tv', 'restroom', 'sauna', 'minibar', 'kettle', 'wifi', 'room_service', 'room_cleaning'], 'boolean'],
            ['room', 'default', 'value' => 1],
            ['person', 'default', 'value' => 2],
            [['tv', 'restroom', 'room_service', 'room_cleaning'], 'default', 'value' => true],
            [['description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function getPrice()
    {
        return ($price = Price::findOne(['fund_id' => $this->id, 'show' => 1])) ? $price->value : 0;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'hotel_id' => Module::t('core', 'Hotel'),
            'category' => Module::t('core', 'Category'),
            'caption' => Module::t('core', 'Caption'),
            'slug' => Module::t('core', 'Slug'),
            'room' => Module::t('core', 'Rooms count'),
            'person' => Module::t('core', 'Person'),
            'size' => Module::t('core', 'Size'),
            'price_like' => Module::t('core', 'Price is the same as a room'),

            'tv' => Module::t('core', 'TV'),
            'restroom' => Module::t('core', 'Restroom'),
            'sauna' => Module::t('core', 'Sauna'),
            'minibar' => Module::t('core', 'Minibar'),
            'kettle' => Module::t('core', 'Kettle'),
            'wifi' => Module::t('core', 'WiFi'),
            'room_service' => Module::t('core', 'Room Service'),
            'room_cleaning' => Module::t('core', 'Room Cleaning'),

            'description' => Module::t('core', 'Description'),

            'created_at' => Module::t('core', 'Created'),
            'updated_at' => Module::t('core', 'Modified'),
        ];
    }

    /**
     * Retrieves the list of posts based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the needed posts.
     */
    public function search($params)
    {
        $query = static::find()->where(
            'hotel_id=:hotel_id and category=:category', 
            [
                ':hotel_id' => $this->hotel_id,
                ':category' => $this->category,
            ]
        );

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::app()->params['itemsPerPage'],
            ],
            'sort' => [
                'defaultOrder'=>['hotel_id' => SORT_ASC, 'category' => SORT_ASC]
            ],
        ]);
    }

    public function getTitle($hotel = true)
    {
        // for backend Title is a Caption only
        $p = isset(Yii::$app->params['fundTitle']) ? Yii::$app->params['fundTitle'] : false;
        if(!$p || $p['caption'])
            return $this->caption;
        return ($hotel ? Lookup::item('HotelName', $this->hotel_id) . ', ' : '') . 
            ($this->room . $p['room'] . ', ') . 
            ($this->person . $p['person']);
    }

    /**
     * @return string the URL that shows the detail of the post
     */
    public function getUrl()
    {
        return Url::to(['fund/view', 'slug' => $this->slug, 'caption' => $this->caption]);
    }

    /**
     * @return string $field useed as a link
     */
    public function getFieldLink($field = 'id')
    {
        return Html::a($this->$field, $this->getUrl());
    }

    public function getTitleLink()
    {
        return $this->getFieldLink('title');
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            $this->updated_at = time();
            $this->translit();
            if($this->isNewRecord)
            {
                $this->created_at = $this->updated_at;
            }
            return true;
        }
        else
            return false;
    }

    /**
     * This is invoked after the record is deleted.
     */
    public function afterDelete()
    {
        parent::afterDelete();
        Comment::deleteAll(['model' => self::COMMENT_FOR, 'parent_id' => $this->id]);
    }

    public static function getRooms($limit = 5, $category = self::CATEGORY_SUITE)
    {
        return self::find()
            ->where('category=' . $category)
            ->limit($limit)
            ->all();
    }

    public static function getItems($except = false)
    {
        $a = [];
        $funds = $except
            ? self::find()->where('id<>:this_id', ['this_id' => $except])->all()
            : self::find()->all();
        foreach($funds as $fund)
            $a[$fund->id] = $fund->getItem();
        return $a;
    }

    public function getItem() {
        return $this->caption.' '. 
            Lookup::item('HotelName', $this->hotel_id).' '. 
            Lookup::item('RoomCategory', $this->category);
    }
    
    public static function getRoomsWithTheSamePrice($id)
    {
        return self::findAll(['price_like' => $id]);
    }

    /**
     * @return Yii\db\ActiveQuery
     */        
    public static function sitemap()
    {
        return self::find();
    }

    /**
     * @return string
     */
    public function getSitemapUrl()
    {
        return Url::toRoute(['fund/view', 'slug' => $this->slug, 'title' => $this->getTitle()], true);
    }    


    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['fund/view', 'slug' => $this->slug], true),
        ];
    }
}
        
