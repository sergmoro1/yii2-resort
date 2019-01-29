<?php

use yii\db\Migration;

class m170526_105659_lookup_fill extends Migration
{
    const LOOKUP = '{{%lookup}}';
    // Property
    const COMMENT_FOR = 5;

    const HOTEL_NAME = 10;
    const ROOM_CATEGORY = 11;
    const PRICE_TYPE = 12;
    const ACCOMMODATION = 13;
    const FOOD = 14;

    public function up()
    {
        $this->insert(self::LOOKUP, ['name' => 'Корпус 1', 'code' => 1, 'property_id' => self::HOTEL_NAME, 'position' => 1]);

        $this->insert(self::LOOKUP, ['name' => 'Люкс', 'code' => 1, 'property_id' => self::ROOM_CATEGORY, 'position' => 1]);
        $this->insert(self::LOOKUP, ['name' => 'Полулюкс', 'code' => 2, 'property_id' => self::ROOM_CATEGORY, 'position' => 2]);
        $this->insert(self::LOOKUP, ['name' => 'Стандарт', 'code' => 3, 'property_id' => self::ROOM_CATEGORY, 'position' => 3]);

        $this->insert(self::LOOKUP, ['name' => 'ОС основной', 'code' => 1, 'property_id' => self::PRICE_TYPE, 'position' => 1]);
        $this->insert(self::LOOKUP, ['name' => 'ПФ профсоюзный', 'code' => 2, 'property_id' => self::PRICE_TYPE, 'position' => 2]);

        $this->insert(self::LOOKUP, ['name' => 'Одноместное', 'code' => 1, 'property_id' => self::ACCOMMODATION, 'position' => 1]);
        $this->insert(self::LOOKUP, ['name' => 'Двухместное', 'code' => 2, 'property_id' => self::ACCOMMODATION, 'position' => 2]);
        $this->insert(self::LOOKUP, ['name' => 'Дополнительное', 'code' => 3, 'property_id' => self::ACCOMMODATION, 'position' => 3]);
        $this->insert(self::LOOKUP, ['name' => 'Ребенок 3-7 лет', 'code' => 4, 'property_id' => self::ACCOMMODATION, 'position' => 4]);
        $this->insert(self::LOOKUP, ['name' => 'Ребенок 3-7 лет на доп. место', 'code' => 5, 'property_id' => self::ACCOMMODATION, 'position' => 5]);
        $this->insert(self::LOOKUP, ['name' => 'Ребенок 7-17 лет', 'code' => 6, 'property_id' => self::ACCOMMODATION, 'position' => 6]);
        $this->insert(self::LOOKUP, ['name' => 'Ребенок 7-17 лет на доп. место', 'code' => 7, 'property_id' => self::ACCOMMODATION, 'position' => 7]);

        $this->insert(self::LOOKUP, ['name' => '--', 'code' => 1, 'property_id' => self::FOOD, 'position' => 1]);
        $this->insert(self::LOOKUP, ['name' => 'ст', 'code' => 2, 'property_id' => self::FOOD, 'position' => 2]);
        $this->insert(self::LOOKUP, ['name' => 'шс', 'code' => 3, 'property_id' => self::FOOD, 'position' => 3]);
    }

    public function down()
    {
        $this->delete(self::LOOKUP, 'property_id=' . self::HOTEL_NAME);
        $this->delete(self::LOOKUP, 'property_id=' . self::ROOM_CATEGORY);
        $this->delete(self::LOOKUP, 'property_id=' . self::PRICE_TYPE);
        $this->delete(self::LOOKUP, 'property_id=' . self::ACCOMMODATION);
        $this->delete(self::LOOKUP, 'property_id=' . self::FOOD);
    }
}
