<?php

use yii\db\Migration;

class m250409_151142_add_status_column_to_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%recurring_items}}', 'status', $this->tinyInteger(1)->notNull()->defaultValue(1));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_151142_add_status_column_to_recurring_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_151142_add_status_column_to_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
