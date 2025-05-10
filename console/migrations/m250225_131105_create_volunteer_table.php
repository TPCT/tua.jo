<?php

use yii\db\Migration;

class m250225_131105_create_volunteer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('volunteer', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),
            'object_fit' => $this->string(50)->defaultValue('contain'),
            'object_position' => $this->string(50)->defaultValue('50% 50%'),
            'status' => $this->tinyInteger(1)->defaultValue(null),
            'promoted_to_volunteer' => $this->tinyInteger(0)->defaultValue(null),
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

        $this->createIndex('idx-volunteer-updated_by', 'volunteer', 'updated_by');
        $this->createIndex('idx-volunteer-weight_order', 'volunteer', 'weight');

        
        $this->addForeignKey(
            'fk-volunteer-created_by',
            'volunteer',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-volunteer-updated_by',
            'volunteer',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );


        $this->createTable('volunteer_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),
            'brief' => $this->text(),
            'content' => $this->text(),

            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);


        $this->createIndex('idx-volunteer_lang-parent_id', 'volunteer_lang', 'parent_id');
        $this->createIndex('idx-volunteer_lang-language', 'volunteer_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-volunteer_lang-parent_id',
            'volunteer_lang',
            'parent_id',
            'volunteer',
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
        echo "m250225_131105_create_volunteer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_131105_create_volunteer_table cannot be reverted.\n";

        return false;
    }
    */
}
