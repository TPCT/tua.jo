<?php

use yii\db\Migration;

class m250408_131408_add_has_goal_to_donation_programs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs}}', 'has_goal', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250408_131408_add_has_goal_to_donation_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_131408_add_has_goal_to_donation_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
