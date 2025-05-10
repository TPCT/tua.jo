<?php

use yii\db\Migration;

class m250409_103832_change_donation_type_id_and_campagin_id_to_guid_in_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%transactions}}', 'donation_type_id', $this->string()->null());
        $this->alterColumn('{{%transactions}}', 'campaign_id', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_103832_change_donation_type_id_and_campagin_id_to_guid_in_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_103832_change_donation_type_id_and_campagin_id_to_guid_in_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
