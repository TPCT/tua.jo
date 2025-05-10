<?php

use yii\db\Migration;

class m250303_085810_add_auth_key_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'auth_key', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250303_085810_add_auth_key_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250303_085810_add_auth_key_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
