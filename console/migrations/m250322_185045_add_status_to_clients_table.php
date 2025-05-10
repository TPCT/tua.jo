<?php

use yii\db\Migration;

class m250322_185045_add_status_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%clients}}", 'status', $this->integer(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250322_185045_add_status_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250322_185045_add_status_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
