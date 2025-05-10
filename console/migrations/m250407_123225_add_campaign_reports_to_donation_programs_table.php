<?php

use yii\db\Migration;

class m250407_123225_add_campaign_reports_to_donation_programs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs_lang}}', 'campaign_report', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250407_123225_add_campagin_reports_to_donation_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_123225_add_campagin_reports_to_donation_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
