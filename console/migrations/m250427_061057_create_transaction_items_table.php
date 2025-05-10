<?php

use yii\db\Migration;

class m250427_061057_create_transaction_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction_items}}', [
            'id' => $this->primaryKey(),
            'transaction_id' => $this->integer()->notNull(),
            'donation_id' => $this->string()->notNull(),
            'donor_id' => $this->string()->notNull(),
            'donation_type' => $this->string(),
            'campaign_id' => $this->integer(),
            'amount' => $this->integer(),
            'amount_usd' => $this->integer(),
            'quantity' => $this->integer(),
            'currency' => $this->string(),
            'order_id' => $this->string(),
            'transaction_type' => $this->integer(),
            'receipt_type' => $this->integer(),
            'recipient_name' => $this->string(),
            'recipient_email' => $this->string(),
            'recipient_phone' => $this->string(),
            'api_transaction_id' => $this->string()->null(),
            'status' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-transaction_items-transaction_id', '{{%transaction_items}}', 'transaction_id');
        $this->addForeignKey(
            'fk-transaction_items-transaction_id',
            'transaction_items',
            'transaction_id',
            'transactions',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250427_061057_create_transaction_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250427_061057_create_transaction_items_table cannot be reverted.\n";

        return false;
    }
    */
}
