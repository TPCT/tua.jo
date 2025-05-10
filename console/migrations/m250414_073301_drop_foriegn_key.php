<?php

use yii\db\Migration;

class m250414_073301_drop_foriegn_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-city-country_id', '{{%city}}');
        $this->dropIndex('fk-city-country_id', '{{%city}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_073301_drop_foriegn_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_073301_drop_foriegn_key cannot be reverted.\n";

        return false;
    }
    */
}
