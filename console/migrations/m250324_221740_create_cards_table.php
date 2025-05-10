<?php

use yii\db\Migration;

class m250324_221740_create_cards_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cards}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->null(),
            'token' => $this->string()->null(),
            'bin' => $this->string()->notNull(),
            'last_four_digits' => $this->string()->notNull(),
            'holder' => $this->string()->notNull(),
            'expiry_month' => $this->integer()->notNull(),
            'expiry_year' => $this->integer()->notNull(),
        ]);

        $this->createIndex("idx-cards-parent_id", "{{%cards}}", "parent_id");
        $this->addForeignKey("fk-cards-parent_id", "{{%cards}}", "parent_id", "clients", "id", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_221740_create_cards_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_221740_create_cards_table cannot be reverted.\n";

        return false;
    }
    */
}
