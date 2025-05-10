<?php

use yii\db\Migration;

class m250413_064705_add_remove_username_from_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%transactions}}', 'username');
        $this->addColumn('{{%transactions}}', 'first_name', $this->string());
        $this->addColumn('{{%transactions}}', 'last_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_064705_add_remove_username_from_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_064705_add_remove_username_from_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
