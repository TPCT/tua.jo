<?php

use yii\db\Migration;

class m250413_065607_add_missing_columns_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'city_id', $this->integer()->null());
        $this->addColumn('{{%clients}}', 'street', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_065607_add_missing_columns_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_065607_add_missing_columns_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
