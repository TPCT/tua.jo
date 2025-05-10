<?php

use yii\db\Migration;

/**
 * Class m230329_125339_delete_permissions_and_permission_group
 */
class m230329_125339_delete_permissions_and_permission_group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete("auth_item",["type"=>3]);
        //$this->delete("auth_item",["type"=>2]);
        $this->delete("auth_item",["type"=>1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230329_125339_delete_permissions_and_permission_group cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230329_125339_delete_permissions_and_permission_group cannot be reverted.\n";

        return false;
    }
    */
}
