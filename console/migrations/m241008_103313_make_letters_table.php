<?php

use yii\db\Migration;

/**
 * Class m241008_103313_make_letters_table
 */
class m241008_103313_make_letters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('letters', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255),
            'city_id' => $this->integer(),
            'category_id' => $this->integer()->notNull(),
            'trailer' => $this->string(255),
            'header_line' => $this->string()->defaultValue('من الملك عبد الله الثاني ملك الأردن'),
            'to' => $this->string(255),
            'occasion' => $this->string(255),
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
    
        // Create foreign keys for 'letters' table
        $this->addForeignKey(
            'fk-letters-city_id',
            'letters',
            'city_id',
            'city',
            'id',
            'SET NULL'
        );
        $this->addForeignKey(
            'fk-letters-category_id',
            'letters',
            'category_id',
            'dropdown_list',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-letters-created_by',
            'letters',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-letters-updated_by',
            'letters',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Create 'letters_lang' table
        $this->createTable('letters_lang', [
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
    
        // Create foreign keys for 'letters_lang' table
        $this->addForeignKey(
            'fk-letters_lang-parent_id',
            'letters_lang',
            'parent_id',
            'letters',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Add unique index for 'slug' in 'letters_lang' table
        $this->createIndex(
            'idx-letters_lang-slug',
            'letters_lang',
            'slug',
            true
        );
    
        // Add indexes for 'letters_lang'
        $this->createIndex(
            'idx-letters_lang-parent_id',
            'letters_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-letters_lang-language',
            'letters_lang',
            'language'
        );
        $this->createIndex(
            'idx-letters_lang-status',
            'letters_lang',
            'status'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241008_103313_make_letters_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241008_103313_make_letters_table cannot be reverted.\n";

        return false;
    }
    */
}
