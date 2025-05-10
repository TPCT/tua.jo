<?php

use yii\db\Migration;

/**
 * Class m241110_122817_add_content_at_homepage_column_to_speech_lang
 */
class m241110_122817_add_content_at_homepage_column_to_speech_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("speeches_lang", "content_at_homepage", $this->text()->null()->after("content"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241110_122817_add_content_at_homepage_column_to_speech_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241110_122817_add_content_at_homepage_column_to_speech_lang cannot be reverted.\n";

        return false;
    }
    */
}
