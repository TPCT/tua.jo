<?php

use yii\db\Migration;

/**
 * Class m241015_211836_create_hashemites_table
 */
class m241015_211836_create_hashemites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          // Create 'hashemites' table
          $this->createTable('hashemites', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255),
            'city_id' => $this->integer(),
            'country_id' => $this->integer(),
            'hashemites_type_id' => $this->integer()->notNull(),
            'weight_order' => $this->tinyInteger()->defaultValue(10),
            'published_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'revision' => $this->integer()->notNull()->defaultValue(0),
            'changed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'reject_note' => $this->string(255),
            'sitemap_priority'=>$this->decimal(2,1),
        ]);
    
        // Create foreign keys for 'hashemites' table
        $this->addForeignKey(
            'fk-hashemites-city_id',
            'hashemites',
            'city_id',
            'city',
            'id',
            'SET NULL'
        );
        $this->addForeignKey(
            'fk-hashemites-created_by',
            'hashemites',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-hashemites-updated_by',
            'hashemites',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-hashemites-hashemites_type_id',
            'hashemites',
            'hashemites_type_id',
            'dropdown_list',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Create 'hashemites_lang' table
        $this->createTable('hashemites_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'language' => $this->string(6),
            'slug' => $this->string(255)->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'promote_to_our_story' => $this->tinyInteger(1)->defaultValue(0),
            'title' => $this->string(255),
            'content' => $this->text(),
            'pdf_file' => $this->string(255),
            'brief' => $this->string(255),
        ]);
    
        // Create foreign keys for 'hashemites_lang' table
        $this->addForeignKey(
            'fk-hashemites_lang-parent_id',
            'hashemites_lang',
            'parent_id',
            'hashemites',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Add unique index for 'slug' in 'hashemites_lang' table
        $this->createIndex(
            'idx-hashemites_lang-slug',
            'hashemites_lang',
            'slug',
            true
        );
    
        // Add indexes for 'hashemites_lang'
        $this->createIndex(
            'idx-hashemites_lang-parent_id',
            'hashemites_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-hashemites_lang-language',
            'hashemites_lang',
            'language'
        );
        $this->createIndex(
            'idx-hashemites_lang-status',
            'hashemites_lang',
            'status'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241015_211836_create_hashemites_table cannot be reverted.\n";

        return false;
    }

}
