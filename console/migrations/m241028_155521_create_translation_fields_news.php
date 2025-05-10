<?php

use yii\db\Migration;

/**
 * Class m241028_155521_create_translation_fields_news
 */
class m241028_155521_create_translation_fields_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('news_lang', 'header_line', $this->string(255));
        $this->addColumn('news_lang', 'source', $this->string(255));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241028_155521_create_translation_fields_news cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241028_155521_create_translation_fields_news cannot be reverted.\n";

        return false;
    }
    */
}
