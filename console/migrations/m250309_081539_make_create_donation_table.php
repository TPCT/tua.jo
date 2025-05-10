<?php

use yii\db\Migration;

class m250309_081539_make_create_donation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('donation', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),
            'object_fit' => $this->string(50)->defaultValue('contain'),
            'object_position' => $this->string(50)->defaultValue('50% 50%'),
            'status' => $this->tinyInteger(1)->defaultValue(null),
            'weight' => $this->tinyInteger()->defaultValue(10),
            'color'=> $this->string(255)->defaultValue(null),
            'category' => $this->string(255)->defaultValue(null),
            'icon'=> $this->string(255)->defaultValue(null),
            'is_progress' => $this->tinyInteger(1)->defaultValue(null),
            'progress_value'=> $this->string(255)->defaultValue(null),
            'promoted_to_homepage'=> $this->tinyInteger()->defaultValue(0),
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

        $this->createIndex('idx-donation-updated_by', 'donation', 'updated_by');
        $this->createIndex('idx-donation-weight_order', 'donation', 'weight');


        
        $this->addForeignKey(
            'fk-donation-created_by',
            'donation',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation-updated_by',
            'donation',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('donation_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),
            'brief' => $this->string(500)->defaultValue(null),

            'tag' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),


            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);

        $this->createIndex('idx-donation_lang-parent_id', 'donation_lang', 'parent_id');
        $this->createIndex('idx-donation_lang-language', 'donation_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-donation_lang-parent_id',
            'donation_lang',
            'parent_id',
            'donation',
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
        echo "m250309_081539_make_create_donation_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_081539_make_create_donation_table cannot be reverted.\n";

        return false;
    }
    */
}
