<?php

use yii\db\Migration;

class m250414_120908_add_background_color_to_donation_programs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs}}', 'background_color', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_120908_add_background_color_to_donation_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_120908_add_background_color_to_donation_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
