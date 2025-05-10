<?php

use yii\db\Migration;

class m250406_045541_add_fix_donation_program_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_programs_items', 'model_class', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250406_045541_add_fix_donation_program_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_045541_add_fix_donation_program_items_table cannot be reverted.\n";

        return false;
    }
    */
}
