<?php

use yii\db\Migration;

class m250225_124043_create_annual_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('annual_report', [
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

        $this->createIndex('idx-annual_report-updated_by', 'annual_report', 'updated_by');
        $this->createIndex('idx-annual_report-weight_order', 'annual_report', 'weight');
        $this->createIndex(
            'idx-annual_report-category_id',
            'annual_report',
            'category_id'
        );


        $this->addForeignKey(
            'fk-annual_report-category_id',
            'annual_report',
            'category_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk-annual_report-created_by',
            'annual_report',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-annual_report-updated_by',
            'annual_report',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );






        $this->createTable('annual_report_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),
            'image' => $this->string(255)->defaultValue(null),
            'file' => $this->string(255)->defaultValue(null),

            'content' => $this->text(),
            'brief' => $this->text(),

            'header_image' => $this->string(255)->defaultValue(null),
            'header_mobile_image' => $this->string(255)->defaultValue(null),
            'header_image_title' => $this->string(255)->defaultValue(null),
            'header_image_brief' => $this->string(255)->defaultValue(null),
        ]);


        $this->createIndex('idx-annual_report_lang-parent_id', 'annual_report_lang', 'parent_id');
        $this->createIndex('idx-annual_report_lang-language', 'annual_report_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-annual_report_lang-parent_id',
            'annual_report_lang',
            'parent_id',
            'annual_report',
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
        echo "m250225_124043_create_annual_report_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_124043_create_annual_report_table cannot be reverted.\n";

        return false;
    }
    */
}
