<?php

use yii\db\Migration;

class m250325_001803_add_otp_counts_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'otp_counts', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250325_001803_add_otp_counts_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250325_001803_add_otp_counts_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
