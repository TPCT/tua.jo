<?php

use yii\db\Migration;

/**
 * Class m230306_091058_alter_price_at_currency_price_table
 */
class m230306_091058_alter_price_at_currency_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("currency_price","price",$this->decimal(18,6)->notNull()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn("currency_price","price",$this->decimal(12,2)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230306_091058_alter_price_at_currency_price_table cannot be reverted.\n";

        return false;
    }
    */
}
