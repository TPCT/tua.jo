<?php

use yii\db\Migration;

class m250504_110108_add_currency_to_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('recurring_items', 'currency', $this->string()->after('type'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250504_110108_add_currency_to_recurring_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250504_110108_add_currency_to_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
