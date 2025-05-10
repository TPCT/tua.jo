<?php

use yii\db\Migration;

class m250423_141957_add_site_map_to_modules extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $this->addColumn('faq', 'sitemap_priority', $this->decimal(1));
        // $this->addColumn('annual_report', 'sitemap_priority', $this->decimal(1));
        // $this->addColumn('testimonial', 'sitemap_priority', $this->decimal(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250423_141957_add_site_map_to_modules cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250423_141957_add_site_map_to_modules cannot be reverted.\n";

        return false;
    }
    */
}
