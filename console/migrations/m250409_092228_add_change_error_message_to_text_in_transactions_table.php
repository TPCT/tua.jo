<?php

use yii\db\Migration;

class m250409_092228_add_change_error_message_to_text_in_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%transactions}}', 'error_message', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_092228_add_change_error_message_to_text_in_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_092228_add_change_error_message_to_text_in_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
