<?php

use yii\db\Migration;

class m250407_061535_add_missing_donation_programs_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs}}', 'raised', $this->integer());
        $this->addColumn('{{%donation_programs}}', 'goal', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250407_061535_add_missing_donation_programs_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_061535_add_missing_donation_programs_columns cannot be reverted.\n";

        return false;
    }
    */
}
