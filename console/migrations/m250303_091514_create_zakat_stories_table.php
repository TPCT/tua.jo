<?php

use yii\db\Migration;

class m250303_091514_create_zakat_stories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('zakat_stories', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),
            'object_fit' => $this->string(50)->defaultValue('contain'),
            'object_position' => $this->string(50)->defaultValue('50% 50%'),
            'status' => $this->tinyInteger(1)->defaultValue(null),
            'category_id' => $this->integer(11)->defaultValue(null),
            'weight' => $this->tinyInteger()->defaultValue(10),
            'revision' => $this->integer()->notNull()->defaultValue(0),
            'changed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'reject_note' => $this->string(255)->defaultValue(null),
            'published_at' => $this->integer()->defaultValue(null),
            'sitemap_priority' => $this->decimal(1)->defaultValue(null), // Added sitemap_priority
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
            'created_by' => $this->integer()->defaultValue(null),
            'updated_by' => $this->integer()->defaultValue(null),
        ]);

        $this->createIndex('idx-zakat_stories-updated_by', 'zakat_stories', 'updated_by');
        $this->createIndex('idx-zakat_stories-weight_order', 'zakat_stories', 'weight');
        $this->createIndex(
            'idx-zakat_stories-category_id',
            'zakat_stories',
            'category_id'
        );


        $this->addForeignKey(
            'fk-zakat_stories-category_id',
            'zakat_stories',
            'category_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk-zakat_stories-created_by',
            'zakat_stories',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-zakat_stories-updated_by',
            'zakat_stories',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('zakat_stories_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),
            'second_title' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),
            'content' => $this->text(),
            'brief' => $this->text(),

            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);


        $this->createIndex('idx-zakat_stories_lang-parent_id', 'zakat_stories_lang', 'parent_id');
        $this->createIndex('idx-zakat_stories_lang-language', 'zakat_stories_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-zakat_stories_lang-parent_id',
            'zakat_stories_lang',
            'parent_id',
            'zakat_stories',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250303_091514_create_zakat_stories_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250303_091514_create_zakat_stories_table cannot be reverted.\n";

        return false;
    }
    */
}
