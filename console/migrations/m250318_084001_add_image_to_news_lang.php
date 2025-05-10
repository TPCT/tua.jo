<?php

use yii\db\Migration;

class m250318_084001_add_image_to_news_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("news_lang", "image", $this->string(255)->after("title")->null());

        $this->execute("
            UPDATE news_lang
            JOIN news ON news_lang.parent_id = news.id
            SET news_lang.image = news.image;
        ");

        $this->dropColumn("news", "image");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250318_084001_add_image_to_news_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250318_084001_add_image_to_news_lang cannot be reverted.\n";

        return false;
    }
    */
}
