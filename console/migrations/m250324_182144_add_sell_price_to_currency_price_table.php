<?php

use yii\db\Migration;

class m250324_182144_add_sell_price_to_currency_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("currency_price","sell_price",$this->decimal(12,2)->defaultValue(0)->notNull());
        $this->addColumn("currency_price","buy_price",$this->decimal(12,2)->defaultValue(0)->notNull());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_182144_add_sell_price_to_currency_price_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_182144_add_sell_price_to_currency_price_table cannot be reverted.\n";

        return false;
    }
    */
}
