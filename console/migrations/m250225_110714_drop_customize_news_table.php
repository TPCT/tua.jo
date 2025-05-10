<?php

use yii\db\Migration;

class m250225_110714_drop_customize_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey('fk-news-city_id', 'news');

        $this->dropColumn('news', 'city_id');

        $this->dropColumn('news', 'country_id');

        $this->dropColumn('news_lang', 'promote_to_front');
        $this->dropColumn('news_lang', 'promote_to_our_story');
        $this->dropColumn('news_lang', 'status');
        $this->dropColumn('news_lang', 'slug');
        $this->dropColumn('news_lang', 'content_2');
        $this->dropColumn('news_lang', 'pdf_file');
        $this->dropColumn('news_lang', 'source');
        $this->dropColumn('news_lang', 'header_line');
        $this->dropColumn('news_lang', 'mobile_header_image');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250225_110714_drop_customize_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_110714_drop_customize_news_table cannot be reverted.\n";

        return false;
    }
    */
}
