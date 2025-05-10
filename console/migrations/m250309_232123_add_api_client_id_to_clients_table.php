<?php

use yii\db\Migration;

class m250309_232123_add_api_client_id_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250309_232123_add_api_client_id_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_232123_add_api_client_id_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
