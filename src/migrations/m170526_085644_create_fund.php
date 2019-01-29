<?php

use yii\db\Migration;

class m170526_085644_create_fund extends Migration
{
    const FUND = '{{%fund}}';
    
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::FUND, [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'category' => $this->integer(),
            'caption' => $this->string(128)->notNull(),
            'slug' => $this->string(128)->notNull()->unique(),
            'room' => $this->integer()->defaultValue(1),
            'person' => $this->integer()->defaultValue(2),
            'size' => $this->integer()->notNull(),
            'price_like' => $this->integer()->defaultValue(null),
            'description' => $this->text(),

            'tv' => $this->boolean()->defaultValue(1),
            'restroom' => $this->boolean()->defaultValue(1),
            'sauna' => $this->boolean()->defaultValue(0),
            'minibar' => $this->boolean()->defaultValue(0),
            'kettle' => $this->boolean()->defaultValue(0),
            'wifi' => $this->boolean()->defaultValue(0),
            'room_service' => $this->boolean()->defaultValue(0),
            'room_cleaning' => $this->boolean()->defaultValue(0),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(self::FUND);
    }
}
