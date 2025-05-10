<?php

use yii\db\Migration;

/**
 * Class m241019_121909_add_active_header_url_to_menu_table
 */
class m241019_121909_add_active_header_url_to_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("menu", "active_header_url", $this->string(255)->after("category_slug")->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241019_121909_add_active_header_url_to_menu_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241019_121909_add_active_header_url_to_menu_table cannot be reverted.\n";

        return false;
    }
    */
}
