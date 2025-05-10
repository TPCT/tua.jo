<?php

use yii\db\Migration;

/**
 * Class m241008_090205_make_interviews_table
 */
class m241008_090205_make_interviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('interviews', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255),
            'video' => $this->string(255),
            'youtube_link' => $this->string(255),
            'city_id' => $this->integer(),
            'trailer' => $this->string()->defaultValue('Via teleconference'),
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
    
        // Create foreign keys for 'interviews' table
        $this->addForeignKey(
            'fk-interviews-city_id',
            'interviews',
            'city_id',
            'city',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-interviews-created_by',
            'interviews',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-interviews-updated_by',
            'interviews',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Create 'interviews_lang' table
        $this->createTable('interviews_lang', [
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
            'interviewer' => $this->string(255),
        ]);
    
        // Create foreign keys for 'interviews_lang' table
        $this->addForeignKey(
            'fk-interviews_lang-parent_id',
            'interviews_lang',
            'parent_id',
            'interviews',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Add unique index for 'slug' in 'interviews_lang' table
        $this->createIndex(
            'idx-interviews_lang-slug',
            'interviews_lang',
            'slug',
            true
        );
    
        // Add indexes for 'interviews_lang'
        $this->createIndex(
            'idx-interviews_lang-parent_id',
            'interviews_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-interviews_lang-language',
            'interviews_lang',
            'language'
        );
        $this->createIndex(
            'idx-interviews_lang-status',
            'interviews_lang',
            'status'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241008_090205_make_interviews_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241008_090205_make_interviews_table cannot be reverted.\n";

        return false;
    }
    */
}
