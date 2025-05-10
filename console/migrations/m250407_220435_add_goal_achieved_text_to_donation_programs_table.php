<?php

use yii\db\Migration;

class m250407_220435_add_goal_achieved_text_to_donation_programs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs_lang}}', 'goal_achieved', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250407_220435_add_goal_achieved_text_to_donation_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_220435_add_goal_achieved_text_to_donation_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
