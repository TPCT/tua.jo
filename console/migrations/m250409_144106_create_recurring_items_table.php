<?php

use yii\db\Migration;

class m250409_144106_create_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%recurring_items}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->null(),
            'name' => $this->string()->null(),
            'email' => $this->string()->null(),
            'phone' => $this->string()->null(),
            'registration_token' => $this->string()->notNull(),
            'frequency' => $this->integer()->notNull(),
            'amount' => $this->float()->notNull(),
            'next_due_at' => $this->integer()->notNull(),
            'donation_type_id' => $this->string()->notNull(),
            'campaign_id' => $this->string()->null(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%recurring_items}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_144106_create_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
