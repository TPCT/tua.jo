<?php

use yii\db\Migration;

class m250416_083619_remove_city_and_street_from_accounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%clients}}', 'city_id');
        $this->dropColumn('{{%clients}}', 'street');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250416_083619_remove_city_and_street_from_accounts_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250416_083619_remove_city_and_street_from_accounts_table cannot be reverted.\n";

        return false;
    }
    */
}
