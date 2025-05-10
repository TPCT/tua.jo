<?php

use yii\db\Migration;

class m250322_181520_add_authentication_columns_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'auth_key', $this->string()->notNull());
        $this->addColumn('{{%clients}}', 'access_token', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250322_181520_add_authentication_columns_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250322_181520_add_authentication_columns_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
