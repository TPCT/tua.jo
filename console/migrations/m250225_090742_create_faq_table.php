<?php

use yii\db\Migration;

class m250225_090742_create_faq_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create 'faq' table
        $this->createTable('faq', [
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
            'fk-faq-created_by',
            'faq',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-faq-updated_by',
            'faq',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Create 'faq_lang' table
        $this->createTable('faq_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(255)->defaultValue(null),
            'brief' => $this->string(500)->defaultValue(null),
            'content' => $this->text()->defaultValue(null),

        ]);

        // Create foreign keys for 'faq_lang' table
        $this->addForeignKey(
            'fk-faq_lang-parent_id',
            'faq_lang',
            'parent_id',
            'faq',
            'id',
            'CASCADE',
            'CASCADE'
        );


        // Add indexes for 'faq_lang'
        $this->createIndex(
            'idx-faq_lang-parent_id',
            'faq_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-faq_lang-language',
            'faq_lang',
            'language'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250225_090742_create_faq_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_090742_create_faq_table cannot be reverted.\n";

        return false;
    }
    */
}
