<?php

use yii\db\Migration;

class m250306_092736_make_category_id_nullable_at_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('news', 'category_id', $this->integer()->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250306_092736_make_category_id_nullable_at_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250306_092736_make_category_id_nullable_at_news_table cannot be reverted.\n";

        return false;
    }
    */
}
