<?php

use yii\db\Migration;

class m250409_161538_change_created_at_and_updated_at_on_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%recurring_items}}', 'created_at', $this->integer()->null());
        $this->alterColumn('{{%recurring_items}}', 'updated_at', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_161538_change_created_at_and_updated_at_on_recurring_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_161538_change_created_at_and_updated_at_on_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
