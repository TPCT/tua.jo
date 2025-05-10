<?php

use yii\db\Migration;

class m250409_104423_add_recurrence_to_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transactions}}', 'recurrence', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_104423_add_recurrence_to_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_104423_add_recurrence_to_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
