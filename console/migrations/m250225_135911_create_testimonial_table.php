<?php

use yii\db\Migration;

class m250225_135911_create_testimonial_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('testimonial', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),
            'video_url' => $this->string(255)->defaultValue(null),
            'object_fit' => $this->string(50)->defaultValue('contain'),
            'object_position' => $this->string(50)->defaultValue('50% 50%'),
            'status' => $this->tinyInteger(1)->defaultValue(null),
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

        $this->createIndex('idx-testimonial-updated_by', 'testimonial', 'updated_by');
        $this->createIndex('idx-testimonial-weight_order', 'testimonial', 'weight');

        
        $this->addForeignKey(
            'fk-testimonial-created_by',
            'testimonial',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-testimonial-updated_by',
            'testimonial',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );


        $this->createTable('testimonial_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),
            'brief' => $this->string(500)->defaultValue(null),

        ]);


        $this->createIndex('idx-testimonial_lang-parent_id', 'testimonial_lang', 'parent_id');
        $this->createIndex('idx-testimonial_lang-language', 'testimonial_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-testimonial_lang-parent_id',
            'testimonial_lang',
            'parent_id',
            'testimonial',
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
        echo "m250225_135911_create_testimonial_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_135911_create_testimonial_table cannot be reverted.\n";

        return false;
    }
    */
}
