<?php

use yii\db\Migration;

class m250309_161650_make_create_add_columns_to_menu_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('menu_link', 'menu_color', $this->string()->defaultValue(null));
        $this->addColumn('menu_link', 'is_prime', $this->tinyInteger()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250309_161650_make_create_add_columns_to_menu_link_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_161650_make_create_add_columns_to_menu_link_table cannot be reverted.\n";

        return false;
    }
    */
}
