<?php

use yii\db\Migration;

class m250303_084933_add_status_and_access_token_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'access_token', $this->string());
        $this->addColumn('{{%clients}}', 'status', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250303_084933_add_status_and_access_token_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250303_084933_add_status_and_access_token_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
