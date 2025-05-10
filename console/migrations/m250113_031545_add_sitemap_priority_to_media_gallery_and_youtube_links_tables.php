<?php

use yii\db\Migration;

class m250113_031545_add_sitemap_priority_to_media_gallery_and_youtube_links_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("media_gallery","sitemap_priority",$this->decimal(2,1)->defaultValue(0.8));
        $this->addColumn("youtube_links","sitemap_priority",$this->decimal(2,1)->defaultValue(0.8));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250113_031545_add_sitemap_priority_to_media_gallery_and_youtube_links_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250113_031545_add_sitemap_priority_to_media_gallery_and_youtube_links_tables cannot be reverted.\n";

        return false;
    }
    */
}
