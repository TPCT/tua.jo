<?php

use yii\db\Migration;

class m250409_094024_add_donation_type_id_to_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transactions}}', 'donation_type_id', $this->integer()->null());
        $this->addColumn('{{%transactions}}', 'campaign_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_094024_add_donation_type_id_to_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_094024_add_donation_type_id_to_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
