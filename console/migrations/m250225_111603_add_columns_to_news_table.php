<?php

use yii\db\Migration;

class m250225_111603_add_columns_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'status', $this->tinyInteger(1)->defaultValue(1)->notNull());

        $this->addColumn('news_lang', 'header_mobile_image', $this->string(255)->defaultValue(null));
        $this->addColumn('news_lang', 'header_image_title', $this->string(255)->defaultValue(null));
        $this->addColumn('news_lang', 'header_image_brief', $this->string(255)->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250225_111603_add_columns_to_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_111603_add_columns_to_news_table cannot be reverted.\n";

        return false;
    }
    */
}
