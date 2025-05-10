<?php

use yii\db\Migration;

class m250327_042603_create_campaigns_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('campaigns', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),

            'guid' => $this->string(255)->defaultValue(null),
            'donation_type_id' => $this->integer()->defaultValue(null),
            'start_date' => $this->integer()->defaultValue(null),
            'end_date' => $this->integer()->defaultValue(null),
            'estimated_amount' => $this->integer(11),

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
            'idx-campaigns-donation_type_id',
            'campaigns',
            'donation_type_id'
        );


        $this->addForeignKey(
            'fk-campaigns-donation_type_id',
            'campaigns',
            'donation_type_id',
            'donation_types',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex('idx-campaigns-updated_by', 'campaigns', 'updated_by');
        $this->createIndex('idx-campaigns-weight_order', 'campaigns', 'weight');



        $this->addForeignKey(
            'fk-campaigns-created_by',
            'campaigns',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-campaigns-updated_by',
            'campaigns',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('campaigns_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),

            'title' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),
            'reason' => $this->string(255)->defaultValue(null),

            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);

        $this->createIndex('idx-campaigns_lang-parent_id', 'campaigns_lang', 'parent_id');
        $this->createIndex('idx-campaigns_lang-language', 'campaigns_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-campaigns_lang-parent_id',
            'campaigns_lang',
            'parent_id',
            'campaigns',
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
        echo "m250327_042603_create_campaigns_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250327_042603_create_campaigns_table cannot be reverted.\n";

        return false;
    }
    */
}
