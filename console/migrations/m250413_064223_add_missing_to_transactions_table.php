<?php

use yii\db\Migration;

class m250413_064223_add_missing_to_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('transactions', 'country', $this->string());
        $this->addColumn('transactions', 'city', $this->string());
        $this->addColumn('transactions', 'street', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_064223_add_missing_to_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_064223_add_missing_to_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
