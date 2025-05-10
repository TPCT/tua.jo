<?php

use yii\db\Migration;

class m250504_071624_add_merchant_transaction_id_to_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transactions}}', 'merchant_transaction_id', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250504_071624_add_merchant_transaction_id_to_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250504_071624_add_merchant_transaction_id_to_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
