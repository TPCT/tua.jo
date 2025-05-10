<?php

use yii\db\Migration;

/**
 * Class m230306_071853_add_national_currency_column_to_currency_price_table
 */
class m230306_071853_add_national_currency_column_to_currency_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn("currency_price","national_currency",$this->integer(1)->defaultValue(0)->notNull());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("currency_price","national_currency");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230306_071853_add_national_currency_column_to_currency_price_table cannot be reverted.\n";

        return false;
    }
    */
}
