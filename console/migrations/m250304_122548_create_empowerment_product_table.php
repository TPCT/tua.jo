<?php

use yii\db\Migration;

class m250304_122548_create_empowerment_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('empowerment_product', [
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

        $this->createIndex('idx-empowerment_product-updated_by', 'empowerment_product', 'updated_by');
        $this->createIndex('idx-empowerment_product-weight_order', 'empowerment_product', 'weight');
        $this->createIndex(
            'idx-empowerment_product-category_id',
            'empowerment_product',
            'category_id'
        );


        $this->addForeignKey(
            'fk-empowerment_product-category_id',
            'empowerment_product',
            'category_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk-empowerment_product-created_by',
            'empowerment_product',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-empowerment_product-updated_by',
            'empowerment_product',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('empowerment_product_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),
            'content' => $this->text(),
            'brief' => $this->text(),

            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);


        $this->createIndex('idx-empowerment_product_lang-parent_id', 'empowerment_product_lang', 'parent_id');
        $this->createIndex('idx-empowerment_product_lang-language', 'empowerment_product_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-empowerment_product_lang-parent_id',
            'empowerment_product_lang',
            'parent_id',
            'empowerment_product',
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
        echo "m250304_122548_create_empowerment_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250304_122548_create_empowerment_product_table cannot be reverted.\n";

        return false;
    }
    */
}
