<?php

use yii\db\Migration;

/**
 * Class m241013_075426_create_discussion_papers_table
 */
class m241013_075426_create_discussion_papers_table extends Migration
{
    /**
     * {@inheritdoc}a
     */
    public function safeUp()
    {
        // Create 'discussion_papers' table
        $this->createTable('discussion_papers', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255),
            'city_id' => $this->integer(),
            'weight_order' => $this->tinyInteger()->defaultValue(10),
            'published_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'revision' => $this->integer()->notNull()->defaultValue(0),
            'changed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'reject_note' => $this->string(255),
        ]);
    
        // Create foreign keys for 'discussion_papers' table
        $this->addForeignKey(
            'fk-discussion_papers-city_id',
            'discussion_papers',
            'city_id',
            'city',
            'id',
            'SET NULL'
        );
        $this->addForeignKey(
            'fk-discussion_papers-created_by',
            'discussion_papers',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-discussion_papers-updated_by',
            'discussion_papers',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Create 'discussion_papers_lang' table
        $this->createTable('discussion_papers_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'language' => $this->string(6),
            'slug' => $this->string(255)->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'promote_to_our_story' => $this->tinyInteger(1)->defaultValue(0),
            'title' => $this->string(255),
            'content' => $this->text(),
            'content_2' => $this->text(),
            'pdf_file' => $this->string(255),
            'brief' => $this->string(255),
        ]);
    
        // Create foreign keys for 'discussion_papers_lang' table
        $this->addForeignKey(
            'fk-discussion_papers_lang-parent_id',
            'discussion_papers_lang',
            'parent_id',
            'discussion_papers',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Add unique index for 'slug' in 'discussion_papers_lang' table
        $this->createIndex(
            'idx-discussion_papers_lang-slug',
            'discussion_papers_lang',
            'slug',
            true
        );
    
        // Add indexes for 'discussion_papers_lang'
        $this->createIndex(
            'idx-discussion_papers_lang-parent_id',
            'discussion_papers_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-discussion_papers_lang-language',
            'discussion_papers_lang',
            'language'
        );
        $this->createIndex(
            'idx-discussion_papers_lang-status',
            'discussion_papers_lang',
            'status'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241013_075426_create_discussion_papers_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241013_075426_create_discussion_papers_table cannot be reverted.\n";

        return false;
    }
    */
}
