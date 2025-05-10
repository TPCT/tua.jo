<?php

use yii\db\Migration;

class m250420_124943_change_transactions_nationality_to_string extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('transactions', 'nationality', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250420_124943_change_transactions_nationality_to_string cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_124943_change_transactions_nationality_to_string cannot be reverted.\n";

        return false;
    }
    */
}
