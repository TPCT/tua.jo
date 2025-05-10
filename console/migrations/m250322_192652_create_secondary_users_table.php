<?php

use yii\db\Migration;

class m250322_192652_create_secondary_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%secondary_users}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-secondary_users-parent_id}}', '{{%secondary_users}}', 'parent_id');
        $this->addForeignKey(
            'fk-secondary_users-parent_id',
            'secondary_users',
            'parent_id',
            'clients',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250322_192652_create_secondary_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250322_192652_create_secondary_users_table cannot be reverted.\n";

        return false;
    }
    */
}
