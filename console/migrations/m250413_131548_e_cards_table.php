<?php

use yii\db\Migration;

class m250413_131548_e_cards_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('e_cards', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),

            'weight_order' => $this->tinyInteger()->defaultValue(10),
            'published_at' => $this->integer(),
            'sitemap_priority' => $this->decimal(1)->defaultValue(null), 
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'revision' => $this->integer()->notNull()->defaultValue(0),
            'changed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'reject_note' => $this->string(255),
        ]);

        $this->addForeignKey(
            'fk-e_cards-created_by',
            'e_cards',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-e_cards-updated_by',
            'e_cards',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Create 'e_cards_lang' table
        $this->createTable('e_cards_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(255)->defaultValue(null),
            'image' => $this->string(500)->defaultValue(null),

        ]);

        // Create foreign keys for 'e_cards_lang' table
        $this->addForeignKey(
            'fk-e_cards_lang-parent_id',
            'e_cards_lang',
            'parent_id',
            'e_cards',
            'id',
            'CASCADE',
            'CASCADE'
        );


        // Add indexes for 'e_cards_lang'
        $this->createIndex(
            'idx-e_cards_lang-parent_id',
            'e_cards_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-e_cards_lang-language',
            'e_cards_lang',
            'language'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_131548_e_cards_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_131548_e_cards_table cannot be reverted.\n";

        return false;
    }
    */
}
