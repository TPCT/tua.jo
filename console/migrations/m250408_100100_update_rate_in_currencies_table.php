<?php

use yii\db\Migration;

class m250408_100100_update_rate_in_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('currency', 'rate', $this->decimal(10,2)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250408_100100_update_rate_in_currencies_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_100100_update_rate_in_currencies_table cannot be reverted.\n";

        return false;
    }
    */
}
