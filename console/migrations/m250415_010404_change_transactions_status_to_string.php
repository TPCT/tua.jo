<?php

use yii\db\Migration;

class m250415_010404_change_transactions_status_to_string extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('transactions', 'status', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250415_010404_change_transactions_status_to_string cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_010404_change_transactions_status_to_string cannot be reverted.\n";

        return false;
    }
    */
}
