<?php

use yii\db\Migration;

class m250112_175948_create_seo_lang_table_and_update_seo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create 'seo_lang' table
        $this->createTable('seo_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(255),
            'description' => $this->string(1000),
            'author' => $this->string(255),
            'keywords' => $this->string(1000),
        ]);
    
        // Create foreign keys for 'seo_lang' table
        $this->addForeignKey(
            'fk-seo_lang-parent_id',
            'seo_lang',
            'parent_id',
            'seo',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        // Add indexes for 'seo_lang'
        $this->createIndex(
            'idx-seo_lang-parent_id',
            'seo_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-seo_lang-language',
            'seo_lang',
            'language'
        );

        $this->dropColumn("seo", "title");
        $this->dropColumn("seo", "author");
        $this->dropColumn("seo", "keywords");
        $this->dropColumn("seo", "description");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250112_175948_create_seo_lang_table_and_update_seo_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250112_175948_create_seo_lang_table_and_update_seo_table cannot be reverted.\n";

        return false;
    }
    */
}
