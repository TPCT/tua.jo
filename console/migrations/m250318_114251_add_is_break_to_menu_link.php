<?php

use yii\db\Migration;

class m250318_114251_add_is_break_to_menu_link extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('menu_link', 'is_break', $this->tinyInteger(3)->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250318_114251_add_is_break_to_menu_link cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250318_114251_add_is_break_to_menu_link cannot be reverted.\n";

        return false;
    }
    */
}
