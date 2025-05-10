<?php

use yii\db\Migration;

class m250324_233501_add_otp_columns_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'otp', $this->string()->null());
        $this->addColumn('{{%clients}}', 'otp_send_at', $this->integer()->null());
        $this->addColumn('{{%clients}}', 'phone_changed_at', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_233501_add_otp_columns_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_233501_add_otp_columns_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
