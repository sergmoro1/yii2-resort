<?php

use yii\db\Migration;

class m170526_085644_create_fund extends Migration
{
    private const TABLE_FUND = '{{%fund}}';
    
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(static::TABLE_FUND, [
            'id'            => $this->primaryKey(),
            'hotel_id'      => $this->integer(),
            'category'      => $this->integer(),
            'caption'       => $this->string(128)->notNull(),
            'slug'          => $this->string(128)->notNull()->unique(),
            'room'          => $this->integer()->defaultValue(1),
            'person'        => $this->integer()->defaultValue(2),
            'size'          => $this->integer()->notNull(),
            'price_like'    => $this->integer()->defaultValue(null),
            'description'   => $this->text(),

            'tv'            => $this->boolean()->defaultValue(1),
            'restroom'      => $this->boolean()->defaultValue(1),
            'sauna'         => $this->boolean()->defaultValue(0),
            'minibar'       => $this->boolean()->defaultValue(0),
            'kettle'        => $this->boolean()->defaultValue(0),
            'wifi'          => $this->boolean()->defaultValue(0),
            'room_service'  => $this->boolean()->defaultValue(0),
            'room_cleaning' => $this->boolean()->defaultValue(0),

            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ], $tableOptions);

		$this->addCommentOnColumn(static::TABLE_FUND, 'hotel_id',       'Hotel ID');
		$this->addCommentOnColumn(static::TABLE_FUND, 'category',       'Fund category');
		$this->addCommentOnColumn(static::TABLE_FUND, 'caption',        'Caption');
		$this->addCommentOnColumn(static::TABLE_FUND, 'room',           'Room count');
		$this->addCommentOnColumn(static::TABLE_FUND, 'person',         'Max persons count');
		$this->addCommentOnColumn(static::TABLE_FUND, 'size',           'Room size in m2');
		$this->addCommentOnColumn(static::TABLE_FUND, 'price_like',     'fund_id with the same price');
		$this->addCommentOnColumn(static::TABLE_FUND, 'description',    'Fund description');
    }

    public function safeDown()
    {
        $this->dropTable(static::TABLE_FUND);
    }
}
