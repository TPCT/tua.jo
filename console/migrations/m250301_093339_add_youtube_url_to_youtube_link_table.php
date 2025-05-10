<?php

use yii\db\Migration;

class m250301_093339_add_youtube_url_to_youtube_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("youtube_links", "video_url", $this->string()->after("status"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250301_093339_add_youtube_url_to_youtube_link_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250301_093339_add_youtube_url_to_youtube_link_table cannot be reverted.\n";

        return false;
    }
    */
}
