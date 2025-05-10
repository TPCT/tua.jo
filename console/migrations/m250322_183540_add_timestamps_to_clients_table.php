<?php

use yii\db\Migration;

class m250322_183540_add_timestamps_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'created_at', $this->integer(11));
        $this->addColumn('{{%clients}}', 'updated_at', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250322_183540_add_timestamps_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250322_183540_add_timestamps_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
