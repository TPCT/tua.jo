<?php

use yii\db\Migration;

class m250325_102508_sponsorship_families_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sponsorship_families', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),

            'age' => $this->integer()->defaultValue(null),
            'gender' => $this->string(255)->defaultValue(null),

            'guid' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),

            'sponsorship_families_id' => $this->integer(11)->defaultValue(null),


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

        $this->createIndex(
            'idx-sponsorship_families-sponsorship_families_id',
            'sponsorship_families',
            'sponsorship_families_id'
        );


        $this->addForeignKey(
            'fk-sponsorship_families-sponsorship_families_id',
            'sponsorship_families',
            'sponsorship_families_id',
            'donation_types',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex('idx-sponsorship_families-updated_by', 'sponsorship_families', 'updated_by');
        $this->createIndex('idx-sponsorship_families-weight_order', 'sponsorship_families', 'weight');


        
        $this->addForeignKey(
            'fk-sponsorship_families-created_by',
            'sponsorship_families',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sponsorship_families-updated_by',
            'sponsorship_families',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('sponsorship_families_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),

            'title' => $this->string(255)->defaultValue(null),
            'story' => $this->string(255)->defaultValue(null),



            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);

        $this->createIndex('idx-sponsorship_families_lang-parent_id', 'sponsorship_families_lang', 'parent_id');
        $this->createIndex('idx-sponsorship_families_lang-language', 'sponsorship_families_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-sponsorship_families_lang-parent_id',
            'sponsorship_families_lang',
            'parent_id',
            'sponsorship_families',
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
        echo "m250325_102508_sponsorship_families_table cannot be reverted.\n";

        return false;
    }


}
