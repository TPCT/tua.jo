<?php

use yii\db\Migration;

class m250408_131846_remove_donation_type_id_and_campaign_id_from_donation_programs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%donation_programs}}', 'donation_type_id');
        $this->dropColumn('{{%donation_programs}}', 'campaign_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250408_131846_remove_donation_type_id_and_campaign_id_from_donation_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_131846_remove_donation_type_id_and_campaign_id_from_donation_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
