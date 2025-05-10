<?php

use yii\db\Migration;

/**
 * Class m241015_185654_sitemap_priority_field
 */
class m241015_185654_sitemap_priority_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('page', 'sitemap_priority', $this->decimal(1));
        $this->addColumn('news', 'sitemap_priority', $this->decimal(1));
        $this->addColumn('discussion_papers', 'sitemap_priority', $this->decimal(1));
        $this->addColumn('interviews', 'sitemap_priority', $this->decimal(1));
        $this->addColumn('letters', 'sitemap_priority', $this->decimal(1));
        $this->addColumn('op_eds', 'sitemap_priority', $this->decimal(1));
        $this->addColumn('speeches', 'sitemap_priority', $this->decimal(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241015_185654_sitemap_priority_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241015_185654_sitemap_priority_field cannot be reverted.\n";

        return false;
    }
    */
}
