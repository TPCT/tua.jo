<?php

use yii\db\Migration;

/**
 * Class m241002_103805_update_news_table
 */
class m241002_103805_update_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('news_lang', 'content_2', $this->text()->after('content'));

        $this->addColumn('news', 'city_id', $this->integer()->after('image'));

        $this->addForeignKey(
            'fk-news-city_id', 
            'news',             
            'city_id',         
            'city',           
            'id',              
            'SET NULL',         
            'NO ACTION'          
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241002_103805_update_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241002_103805_update_news_table cannot be reverted.\n";

        return false;
    }
    */
}
