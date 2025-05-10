<?php

use yeesoft\models\User;
use yii\db\Migration;

class m250303_131425_add_timestamps_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%clients}}', 'status', $this->integer(2)->defaultValue(User::STATUS_ACTIVE));
        $this->addColumn('{{%clients}}', 'created_at', $this->integer(11));
        $this->addColumn('{{%clients}}', 'updated_at', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250303_131425_add_timestamps_to_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250303_131425_add_timestamps_to_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
