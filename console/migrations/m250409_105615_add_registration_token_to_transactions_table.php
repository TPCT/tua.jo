<?php

use yii\db\Migration;

class m250409_105615_add_registration_token_to_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transactions}}', 'registration_token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_105615_add_registration_token_to_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_105615_add_registration_token_to_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
