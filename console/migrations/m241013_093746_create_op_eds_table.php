<?php

use yii\db\Migration;

/**
 * Class m241013_093746_create_op_eds_table
 */
class m241013_093746_create_op_eds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create 'op_eds' table
        $this->createTable('op_eds', [
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
    
        // Create foreign keys for 'op_eds' table
        $this->addForeignKey(
            'fk-op_eds-city_id',
            'op_eds',
            'city_id',
            'city',
            'id',
            'SET NULL'
        );
        $this->addForeignKey(
            'fk-op_eds-created_by',
            'op_eds',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-op_eds-updated_by',
            'op_eds',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Create 'op_eds_lang' table
        $this->createTable('op_eds_lang', [
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
    
        // Create foreign keys for 'op_eds_lang' table
        $this->addForeignKey(
            'fk-op_eds_lang-parent_id',
            'op_eds_lang',
            'parent_id',
            'op_eds',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Add unique index for 'slug' in 'op_eds_lang' table
        $this->createIndex(
            'idx-op_eds_lang-slug',
            'op_eds_lang',
            'slug',
            true
        );
    
        // Add indexes for 'op_eds_lang'
        $this->createIndex(
            'idx-op_eds_lang-parent_id',
            'op_eds_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-op_eds_lang-language',
            'op_eds_lang',
            'language'
        );
        $this->createIndex(
            'idx-op_eds_lang-status',
            'op_eds_lang',
            'status'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241013_093746_create_op_eds_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241013_093746_create_op_eds_table cannot be reverted.\n";

        return false;
    }
    */
}
