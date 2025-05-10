<?php

use yii\db\Migration;

class m250420_123309_add_donor_id_to_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('recurring_items', 'donor_id', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250420_123309_add_donor_id_to_recurring_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_123309_add_donor_id_to_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
