<?php

use yii\db\Migration;

class m250420_123851_add_missing_billing_data_to_recurring_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('recurring_items', 'country', $this->string());
        $this->addColumn('recurring_items', 'city', $this->string());
        $this->addColumn('recurring_items', 'street', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_123851_add_missing_billing_data_to_recurring_items cannot be reverted.\n";

        return false;
    }
    */
}
