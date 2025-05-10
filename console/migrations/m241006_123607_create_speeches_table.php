<?php

use yii\db\Migration;

/**
 * Class m241006_123607_create_speeches_table
 */
class m241006_123607_create_speeches_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create 'speeches' table
        $this->createTable('speeches', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255),
            'video' => $this->string(255),
            'youtube_link' => $this->string(255),
            'city_id' => $this->integer(),
            'pre_title_id' => $this->integer()->notNull(),
            'speech_type_id' => $this->integer()->notNull(),
            'trailer' => $this->string()->defaultValue('Translated from Arabic'),
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
    
        // Create foreign keys for 'speeches' table
        $this->addForeignKey(
            'fk-speeches-city_id',
            'speeches',
            'city_id',
            'city',
            'id',
            'SET NULL'
        );
        $this->addForeignKey(
            'fk-speeches-pre_title_id',
            'speeches',
            'pre_title_id',
            'dropdown_list',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-speeches-speech_type_id',
            'speeches',
            'speech_type_id',
            'dropdown_list',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-speeches-created_by',
            'speeches',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-speeches-updated_by',
            'speeches',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Create 'speeches_lang' table
        $this->createTable('speeches_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'language' => $this->string(6),
            'slug' => $this->string(255)->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'promote_to_our_story' => $this->tinyInteger(1)->defaultValue(0),
            'selected_speech' => $this->tinyInteger(1)->defaultValue(0),
            'title' => $this->string(255),
            'content' => $this->text(),
            'content_2' => $this->text(),
            'pdf_file' => $this->string(255),
            'brief' => $this->string(255),
        ]);
    
        // Create foreign keys for 'speeches_lang' table
        $this->addForeignKey(
            'fk-speeches_lang-parent_id',
            'speeches_lang',
            'parent_id',
            'speeches',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Add unique index for 'slug' in 'speeches_lang' table
        $this->createIndex(
            'idx-speeches_lang-slug',
            'speeches_lang',
            'slug',
            true
        );
    
        // Add indexes for 'speeches_lang'
        $this->createIndex(
            'idx-speeches_lang-parent_id',
            'speeches_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-speeches_lang-language',
            'speeches_lang',
            'language'
        );
        $this->createIndex(
            'idx-speeches_lang-status',
            'speeches_lang',
            'status'
        );
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241006_123607_create_speeches_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241006_123607_create_speeches_table cannot be reverted.\n";

        return false;
    }
    */
}
