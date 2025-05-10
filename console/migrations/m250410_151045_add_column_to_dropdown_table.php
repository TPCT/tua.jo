<?php

use yii\db\Migration;

class m250410_151045_add_column_to_dropdown_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('dropdown_list', 'campaign_id', $this->integer()->null());
        $this->addColumn('dropdown_list', 'donation_type_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250410_151045_add_column_to_dropdown_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250410_151045_add_column_to_dropdown_table cannot be reverted.\n";

        return false;
    }
    */
}
