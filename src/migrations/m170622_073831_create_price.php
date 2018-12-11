<?php

use yii\db\Migration;

class m170622_073831_create_price extends Migration
{
	const FUND = '{{%fund}}';
	const PRICE = '{{%price}}';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(self::PRICE, [
            'id' => $this->primaryKey(),
            'fund_id' => $this->integer()->notNull(),
            'type' => $this->integer()->defaultValue(1)->notNull(),
            'accommodation' => $this->integer()->notNull(),
            'food' => $this->integer()->defaultValue(2)->notNull(),
            'treatment' => $this->boolean()->defaultValue(1)->notNull(),
            'position' => $this->integer()->defaultValue(0)->notNull(),
            'value' => $this->integer()->defaultValue(0)->notNull(),
            'show' => $this->boolean()->defaultValue(0)->notNull(),
        ], $tableOptions);

        $this->createIndex('fund_id', self::PRICE, 'fund_id');
        $this->createIndex('type-fund_id-accommodation-food-treatment', self::PRICE, ['type', 'fund_id', 'accommodation', 'food', 'treatment'], true);
        $this->addForeignKey ('FK_price_fund', self::PRICE, 'fund_id', self::FUND, 'id', 'CASCADE');
    }

    public function down()
    {
		$this->dropForeignKey('FK_price_fund', self::PRICE);
		$this->dropIndex('fund_id', self::PRICE);
        $this->dropIndex('type-fund_id-accommodation-food-treatment', self::PRICE);

        $this->dropTable(self::PRICE);
    }
}
