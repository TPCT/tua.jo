<?php

use yii\db\Migration;

class m250409_155122_remove_unused_columns_from_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%transactions}}', 'donation_type_id');
        $this->dropColumn('{{%transactions}}', 'campaign_id');
        $this->dropColumn('{{%transactions}}', 'donation_id');
        $this->dropColumn('{{%transactions}}', 'recurrence');
        $this->dropColumn('{{%transactions}}', 'registration_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_155122_remove_unused_columns_from_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_155122_remove_unused_columns_from_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
