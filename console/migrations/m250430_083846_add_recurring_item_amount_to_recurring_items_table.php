<?php

use yii\db\Migration;

class m250430_083846_add_recurring_item_amount_to_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('recurring_items', 'amount');
        $this->addColumn('recurring_items', 'amount_jod', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('recurring_items', 'amount_usd', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('recurring_items', 'quantity', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('recurring_items', 'total_jod', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('recurring_items', 'total_usd', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250430_083846_add_recurring_item_amount_to_recurring_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250430_083846_add_recurring_item_amount_to_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
