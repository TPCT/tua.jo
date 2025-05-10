<?php

use yii\db\Migration;

class m250407_101438_add_parent_it_to_donation_programs_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs_items}}', 'parent_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250407_101438_add_parent_it_to_donation_programs_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_101438_add_parent_it_to_donation_programs_items_table cannot be reverted.\n";

        return false;
    }
    */
}
