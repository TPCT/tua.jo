<?php

use yii\db\Migration;

class m250420_144727_drop_column_city_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-volunteer_webform-city_id', '{{%volunteer_webform}}');
        $this->dropColumn('volunteer_webform', 'city_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250420_144727_drop_column_city_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_144727_drop_column_city_id cannot be reverted.\n";

        return false;
    }
    */
}
