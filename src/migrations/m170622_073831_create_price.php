<?php

use yii\db\Migration;

class m170622_073831_create_price extends Migration
{
    const TABLE_FUND  = '{{%fund}}';
    const TABLE_PRICE = '{{%price}}';
    
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_PRICE, [
            'id'            => $this->primaryKey(),
            'fund_id'       => $this->integer()->notNull(),
            'type'          => $this->integer()->defaultValue(1)->notNull(),
            'accommodation' => $this->integer()->notNull(),
            
            'food'          => $this->integer()->defaultValue(2)->notNull(),
            'treatment'     => $this->boolean()->defaultValue(1)->notNull(),
            'position'      => $this->integer()->defaultValue(0)->notNull(),
            'value'         => $this->integer()->defaultValue(0)->notNull(),
            'show'          => $this->boolean()->defaultValue(0)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-fund_id', self::TABLE_PRICE, 'fund_id');
        $this->createIndex('idx-type-fund_id-accommodation-food-treatment', self::TABLE_PRICE, 
            ['type', 'fund_id', 'accommodation', 'food', 'treatment'], true);
        $this->addForeignKey ('fk-price-fund', self::TABLE_PRICE, 'fund_id', self::TABLE_FUND, 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_PRICE);
    }
}
