<?php

use yii\db\Migration;

/**
 * Class m241015_191658_alter_page_table_change_sitemap_priority
 */
class m241015_191658_alter_page_table_change_sitemap_priority extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('page', 'sitemap_priority', $this->decimal(2,1));
        $this->alterColumn('news', 'sitemap_priority', $this->decimal(2,1));
        $this->alterColumn('discussion_papers', 'sitemap_priority', $this->decimal(2,1));
        $this->alterColumn('interviews', 'sitemap_priority', $this->decimal(2,1));
        $this->alterColumn('letters', 'sitemap_priority', $this->decimal(2,1));
        $this->alterColumn('op_eds', 'sitemap_priority', $this->decimal(2,1));
        $this->alterColumn('speeches', 'sitemap_priority', $this->decimal(2,1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241015_191658_alter_page_table_change_sitemap_priority cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241015_191658_alter_page_table_change_sitemap_priority cannot be reverted.\n";

        return false;
    }
    */
}
