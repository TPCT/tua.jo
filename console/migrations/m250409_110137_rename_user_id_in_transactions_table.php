<?php

use yii\db\Migration;

class m250409_110137_rename_user_id_in_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%transactions}}', 'user_id', 'client_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_110137_rename_user_id_in_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_110137_rename_user_id_in_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
