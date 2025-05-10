<?php

use yii\db\Migration;

class m250409_204155_change_frequency_to_string_in_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%recurring_items}}', 'frequency', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_204155_change_frequency_to_string_in_recurring_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_204155_change_frequency_to_string_in_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
