<?php

use yii\db\Migration;

/**
 * Class m230329_122108_add_new_columns_to_auth_item_table
 */
class m230329_122108_add_new_columns_to_auth_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("auth_item","module",$this->string(255)->null()->after("type"));
        $this->addColumn("auth_item","action",$this->string(255)->null()->after("module"));

        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn("auth_item","module");
        $this->dropColumn("auth_item","action");

        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230329_122108_add_new_columns_to_auth_item_table cannot be reverted.\n";

        return false;
    }
    */
}
