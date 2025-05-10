<?php

use yii\db\Migration;

/**
 * Class m241015_100001_update_page_table
 */
class m241015_100001_update_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('page', 'city_id', $this->integer()->after('video'));
        $this->addColumn('page', 'country_id', $this->integer()->after('city_id'));
        $this->addColumn('page_lang', 'second_title', $this->string()->after('title'));


        $this->addForeignKey(
            'fk-page-city_id',
            'page',
            'city_id',
            'city',
            'id',
            'SET NULL'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241015_100001_update_page_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241015_100001_update_page_table cannot be reverted.\n";

        return false;
    }
    */
}
