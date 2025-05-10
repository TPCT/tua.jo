<?php

use yii\db\Migration;

class m250327_052555_create_sponsorship_request_visits_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sponsorship_request_visits}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'sponsorship_family_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'date' => $this->integer()->notNull(),
            'message' => $this->string()->notNull(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);

        $this->createIndex('idx-sponsorship_request_visits-client_id', '{{%sponsorship_request_visits}}', 'client_id');
        $this->addForeignKey(
            'fk-sponsorship_request_visits-client_id',
            '{{%sponsorship_request_visits}}',
            'client_id',
            'clients',
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-sponsorship_request_visits-sponsorship_family_id', '{{%sponsorship_request_visits}}', 'sponsorship_family_id');
        $this->addForeignKey(
            'fk-sponsorship_request_visits-sponsorship_family_id',
            '{{%sponsorship_request_visits}}',
            'sponsorship_family_id',
            'sponsorship_families',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250327_052555_create_sponsorship_request_visits_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250327_052555_create_sponsorship_request_visits_table cannot be reverted.\n";

        return false;
    }
    */
}
