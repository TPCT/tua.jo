<?php

use yii\db\Migration;

class m250420_150334_add_city_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('volunteer_webform','city_name',$this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250420_150334_add_city_name cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_150334_add_city_name cannot be reverted.\n";

        return false;
    }
    */
}
