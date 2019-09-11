<?php
namespace sergmoro1\resort\models;

use yii\db\ActiveRecord;

use sergmoro1\resort\Module;
use common\models\Fund;
use sergmoro1\lookup\models\Lookup;

class Price extends ActiveRecord
{
    /**
     * The followings are the available columns in table 'tbl_rubric':
     * @var integer $id
     * @var integer $fund_id
     * @var integer $type
     * @var integer $accommodation
     * @var integer $food
     * @var boolean $treatment
     * @car integer $position
     * @var integer $value
     * @var boolean $show
     */

    const HOTEL_NAME = 10;
    const ROOM_CATEGORY = 11;
    const PRICE_TYPE = 12;
    const ACCOMMODATION = 13;
    const FOOD = 14;

    private $_show;
    
    private static $_items;
    
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%price}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['position', 'type', 'fund_id', 'accommodation', 'food', 'value'], 'required'],
            ['treatment', 'default', 'value' => 1],
            ['show', 'default', 'value' => 0],
            [['fund_id', 'type', 'accommodation', 'position', 'food', 'value'], 'integer'],
            ['treatment', 'boolean'],
/*
            [['type', 'fund_id', 'accommodation', 'food', 'treatment'], 'unique', 
                'targetAttribute' => ['type', 'fund_id', 'accommodation', 'food', 'treatment'], 
                'message' => Module::t('core', 'Duplicate entry.'),
            ],
*/
            [['type', 'fund_id', 'accommodation', 'food', 'treatment'], 'sergmoro1\resort\components\UniqueValidator'], 
            [['treatment', 'show'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'fund_id' => Module::t('core', 'Room'),
            'type' => 'Тип',
            'accommodation' => Module::t('core', 'Accommodation'),
            'food' => Module::t('core', 'Food'),
            'treatment' => Module::t('core', 'Treatment'),
            'position' => Module::t('core', 'Position'),
            'value' => Module::t('core', 'Value'),
            'show' => Module::t('core', 'Show'),
        );
    }

    public function getFund()
    {
        return Fund::findOne($this->fund_id);
    }

    /**
     * This is invoked when a record is populated with data from a find() call.
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->_show = $this->show;
    }

    public static function items()
    {
        if(!self::$_items) {
            foreach(Fund::find()->all() as $fund)
                self::$_items[$fund->id] = $fund->getItem();
        }
        return self::$_items;
    }
    
    public function getAccommodations() {
        return Lookup::find()
            ->select(['code', 'position'])
            ->where(['property_id' => self::ACCOMMODATION])
            ->orderBy(['position' => SORT_ASC])
            ->all();
    }
    
    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord || ($this->_show <> $this->show))
            {
                // only one price value can be shown as a main, so clear previous flag before save
                \Yii::$app->db
                    ->createCommand("UPDATE {{price}} SET `show`=0 WHERE `type`={$this->type} AND fund_id={$this->fund_id} AND `show`=1")
                    ->execute();
            }
            return true;
        }
        else
            return false;
    }
}
