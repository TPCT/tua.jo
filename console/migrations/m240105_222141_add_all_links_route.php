<?php

use yii\db\Migration;

/**
 * Class m240105_222141_add_all_links_route
 */
class m240105_222141_add_all_links_route extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $this->insert("auth_item",["name"=>"/*", "type"=>3, "action"=>"all links"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240105_222141_add_all_links_route cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240105_222141_add_all_links_route cannot be reverted.\n";

        return false;
    }
    */
}
