<?php

use yii\db\Migration;

class m250408_171646_create_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'username' => $this->string()->null(),
            'email' => $this->string()->null(),
            'phone' => $this->string()->null(),
            'transaction_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->null(),
            'type' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'error_message' => $this->string()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transactions}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_171646_create_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
