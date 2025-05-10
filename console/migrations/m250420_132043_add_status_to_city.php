<?php

use yii\db\Migration;

class m250420_132043_add_status_to_city extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('countries', 'status', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250420_132043_add_status_to_city cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_132043_add_status_to_city cannot be reverted.\n";

        return false;
    }
    */
}
