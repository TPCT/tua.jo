<?php

use yii\db\Migration;

class m250414_075924_add_checkout_id_to_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transactions}}', 'checkout_id', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_075924_add_checkout_id_to_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_075924_add_checkout_id_to_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
