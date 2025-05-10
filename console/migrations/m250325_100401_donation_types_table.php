<?php

use yii\db\Migration;

class m250325_100401_donation_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('donation_types', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),


            'guid' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),
            'amount_jod' => $this->string(255)->defaultValue(null),
            'amount_usd' => $this->string(255)->defaultValue(null),



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

        $this->createIndex('idx-donation_types-updated_by', 'donation_types', 'updated_by');
        $this->createIndex('idx-donation_types-weight_order', 'donation_types', 'weight');


        
        $this->addForeignKey(
            'fk-donation_types-created_by',
            'donation_types',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation_types-updated_by',
            'donation_types',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('donation_types_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),



            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);

        $this->createIndex('idx-donation_types_lang-parent_id', 'donation_types_lang', 'parent_id');
        $this->createIndex('idx-donation_types_lang-language', 'donation_types_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-donation_types_lang-parent_id',
            'donation_types_lang',
            'parent_id',
            'donation_types',
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
        echo "m250325_100401_donation_types_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250325_100401_donation_types_table cannot be reverted.\n";

        return false;
    }
    */
}
