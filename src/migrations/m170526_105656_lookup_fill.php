<?php

use yii\db\Migration;

class m170526_105656_lookup_fill extends Migration
{
	const LOOKUP = '{{%lookup}}';
	const PROPERTY = '{{%property}}';
    // Property
    const COMMENT_FOR = 5;

	const HOTEL_NAME = 10;
	const ROOM_CATEGORY = 11;
	const PRICE_TYPE = 12;
	const ACCOMMODATION = 13;
	const FOOD = 14;

    public function up()
    {
        $this->insert(self::PROPERTY, ['id' =>  self::HOTEL_NAME, 'name' => 'HotelName']);
        $this->insert(self::PROPERTY, ['id' =>  self::ROOM_CATEGORY, 'name' => 'RoomCategory']);
        $this->insert(self::PROPERTY, ['id' =>  self::PRICE_TYPE, 'name' => 'PriceType']);
        $this->insert(self::PROPERTY, ['id' =>  self::ACCOMMODATION, 'name' => 'Accommodation']);
        $this->insert(self::PROPERTY, ['id' =>  self::FOOD, 'name' => 'Food']);

        $this->insert(self::LOOKUP, ['name' => 'Номера', 'code' => 2, 'property_id' => self::COMMENT_FOR, 'position' => 2]);
    }

    public function down()
    {
        $this->delete(self::PROPERTY, 'id=' . self::HOTEL_NAME);
        $this->delete(self::PROPERTY, 'id=' . self::ROOM_CATEGORY);
        $this->delete(self::PROPERTY, 'id=' . self::PRICE_TYPE);
        $this->delete(self::PROPERTY, 'id=' . self::ACCOMMODATION);
        $this->delete(self::PROPERTY, 'id=' . self::FOOD);

        $this->delete(self::LOOKUP, 'code=2 AND property_id=' . self::COMMENT_FOR);
    }
}
